# Coffee entity test

require "minitest/autorun"
require "json"
require_relative "../GithubProjectIssues_sdk"
require_relative "runner"

class CoffeeEntityTest < Minitest::Test
  def test_create_instance
    testsdk = GithubProjectIssuesSDK.test(nil, nil)
    ent = testsdk.Coffee(nil)
    assert !ent.nil?
  end

  # Feature #4: the entity stream(action, ...) method runs the op pipeline and
  # returns an Enumerator over result items. With the streaming feature active
  # it yields the feature's incremental output; otherwise it falls back to the
  # materialised list so stream always yields.
  def test_stream
    seed = {
      "entity" => {
        "coffee" => {
          "s1" => { "id" => "s1" },
          "s2" => { "id" => "s2" },
          "s3" => { "id" => "s3" },
        },
      },
    }

    # Fallback: streaming inactive -> yields the materialised list items.
    base = GithubProjectIssuesSDK.test(seed, nil)
    seen = base.Coffee(nil).stream("list", nil, nil).to_a
    assert_equal 3, seen.length

    # Inbound: streaming active -> yields each item from the feature.
    cfg = GithubProjectIssuesConfig.make_config
    if cfg["feature"].is_a?(Hash) && cfg["feature"].key?("streaming")
      sdk = GithubProjectIssuesSDK.test(seed, { "feature" => { "streaming" => { "active" => true } } })
      got = []
      sdk.Coffee(nil).stream("list", nil, nil).each do |item|
        if item.is_a?(Array)
          got.concat(item)
        else
          got << item
        end
      end
      assert_equal 3, got.length
    end
  end

  def test_basic_flow
    setup = coffee_basic_setup(nil)
    # Per-op sdk-test-control.json skip.
    _live = setup[:live] || false
    ["list", "update"].each do |_op|
      _should_skip, _reason = Runner.is_control_skipped("entityOp", "coffee." + _op, _live ? "live" : "unit")
      if _should_skip
        skip(_reason || "skipped via sdk-test-control.json")
        return
      end
    end
    # The basic flow consumes synthetic IDs from the fixture. In live mode
    # without an *_ENTID env override, those IDs hit the live API and 4xx.
    if setup[:synthetic_only]
      skip "live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_COFFEE_ENTID JSON to run live"
      return
    end
    client = setup[:client]

    # Bootstrap entity data from existing test data.
    coffee_ref01_data_raw = Vs.items(Helpers.to_map(
      Vs.getpath(setup[:data], "existing.coffee")))
    coffee_ref01_data = nil
    if coffee_ref01_data_raw.length > 0
      coffee_ref01_data = Helpers.to_map(coffee_ref01_data_raw[0][1])
    end

    # LIST
    coffee_ref01_ent = client.Coffee(nil)
    coffee_ref01_match = {}

    coffee_ref01_list_result = coffee_ref01_ent.list(coffee_ref01_match, nil)
    assert coffee_ref01_list_result.is_a?(Array)

    # UPDATE
    coffee_ref01_data_up0_up = {
      "id" => coffee_ref01_data["id"],
    }

    coffee_ref01_markdef_up0_name = "description"
    coffee_ref01_markdef_up0_value = "Mark01-coffee_ref01_#{setup[:now]}"
    coffee_ref01_data_up0_up[coffee_ref01_markdef_up0_name] = coffee_ref01_markdef_up0_value

    coffee_ref01_resdata_up0_result = coffee_ref01_ent.update(coffee_ref01_data_up0_up, nil)
    coffee_ref01_resdata_up0 = Helpers.to_map(coffee_ref01_resdata_up0_result)
    assert !coffee_ref01_resdata_up0.nil?
    assert_equal coffee_ref01_resdata_up0["id"], coffee_ref01_data_up0_up["id"]
    assert_equal coffee_ref01_resdata_up0[coffee_ref01_markdef_up0_name], coffee_ref01_markdef_up0_value

  end
end

def coffee_basic_setup(extra)
  Runner.load_env_local

  entity_data_file = File.join(__dir__, "..", "..", ".sdk", "test", "entity", "coffee", "CoffeeTestData.json")
  entity_data_source = File.read(entity_data_file)
  entity_data = JSON.parse(entity_data_source)

  options = {}
  options["entity"] = entity_data["existing"]

  client = GithubProjectIssuesSDK.test(options, extra)

  # Generate idmap via transform.
  idmap = Vs.transform(
    ["coffee01", "coffee02", "coffee03"],
    {
      "`$PACK`" => ["", {
        "`$KEY`" => "`$COPY`",
        "`$VAL`" => ["`$FORMAT`", "upper", "`$COPY`"],
      }],
    }
  )

  # Detect ENTID env override before envOverride consumes it. When live
  # mode is on without a real override, the basic test runs against synthetic
  # IDs from the fixture and 4xx's. Surface this so the test can skip.
  entid_env_raw = ENV["GITHUBPROJECTISSUES_TEST_COFFEE_ENTID"]
  idmap_overridden = !entid_env_raw.nil? && entid_env_raw.strip.start_with?("{")

  env = Runner.env_override({
    "GITHUBPROJECTISSUES_TEST_COFFEE_ENTID" => idmap,
    "GITHUBPROJECTISSUES_TEST_LIVE" => "FALSE",
    "GITHUBPROJECTISSUES_TEST_EXPLAIN" => "FALSE",
  })

  idmap_resolved = Helpers.to_map(
    env["GITHUBPROJECTISSUES_TEST_COFFEE_ENTID"])
  if idmap_resolved.nil?
    idmap_resolved = Helpers.to_map(idmap)
  end

  if env["GITHUBPROJECTISSUES_TEST_LIVE"] == "TRUE"
    merged_opts = Vs.merge([
      {
      },
      extra || {},
    ])
    client = GithubProjectIssuesSDK.new(Helpers.to_map(merged_opts))
  end

  live = env["GITHUBPROJECTISSUES_TEST_LIVE"] == "TRUE"
  {
    client: client,
    data: entity_data,
    idmap: idmap_resolved,
    env: env,
    explain: env["GITHUBPROJECTISSUES_TEST_EXPLAIN"] == "TRUE",
    live: live,
    synthetic_only: live && !idmap_overridden,
    now: (Time.now.to_f * 1000).to_i,
  }
end
