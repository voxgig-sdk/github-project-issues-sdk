# RepositoryIssueDomain entity test

require "minitest/autorun"
require "json"
require_relative "../GithubProjectIssues_sdk"
require_relative "runner"

class RepositoryIssueDomainEntityTest < Minitest::Test
  def test_create_instance
    testsdk = GithubProjectIssuesSDK.test(nil, nil)
    ent = testsdk.RepositoryIssueDomain(nil)
    assert !ent.nil?
  end

  def test_basic_flow
    setup = repository_issue_domain_basic_setup(nil)
    # Per-op sdk-test-control.json skip.
    _live = setup[:live] || false
    ["list"].each do |_op|
      _should_skip, _reason = Runner.is_control_skipped("entityOp", "repository_issue_domain." + _op, _live ? "live" : "unit")
      if _should_skip
        skip(_reason || "skipped via sdk-test-control.json")
        return
      end
    end
    # The basic flow consumes synthetic IDs from the fixture. In live mode
    # without an *_ENTID env override, those IDs hit the live API and 4xx.
    if setup[:synthetic_only]
      skip "live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID JSON to run live"
      return
    end
    client = setup[:client]

    # Bootstrap entity data from existing test data.
    repository_issue_domain_ref01_data_raw = Vs.items(Helpers.to_map(
      Vs.getpath(setup[:data], "existing.repository_issue_domain")))
    repository_issue_domain_ref01_data = nil
    if repository_issue_domain_ref01_data_raw.length > 0
      repository_issue_domain_ref01_data = Helpers.to_map(repository_issue_domain_ref01_data_raw[0][1])
    end

    # LIST
    repository_issue_domain_ref01_ent = client.RepositoryIssueDomain(nil)
    repository_issue_domain_ref01_match = {
      "repository" => setup[:idmap]["repository01"],
      "username" => setup[:idmap]["username01"],
    }

    repository_issue_domain_ref01_list_result, err = repository_issue_domain_ref01_ent.list(repository_issue_domain_ref01_match, nil)
    assert_nil err
    assert repository_issue_domain_ref01_list_result.is_a?(Array)

  end
end

def repository_issue_domain_basic_setup(extra)
  Runner.load_env_local

  entity_data_file = File.join(__dir__, "..", "..", ".sdk", "test", "entity", "repository_issue_domain", "RepositoryIssueDomainTestData.json")
  entity_data_source = File.read(entity_data_file)
  entity_data = JSON.parse(entity_data_source)

  options = {}
  options["entity"] = entity_data["existing"]

  client = GithubProjectIssuesSDK.test(options, extra)

  # Generate idmap via transform.
  idmap = Vs.transform(
    ["repository_issue_domain01", "repository_issue_domain02", "repository_issue_domain03", "get_repo_issue01", "get_repo_issue02", "get_repo_issue03", "repository01", "username01"],
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
  entid_env_raw = ENV["GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID"]
  idmap_overridden = !entid_env_raw.nil? && entid_env_raw.strip.start_with?("{")

  env = Runner.env_override({
    "GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID" => idmap,
    "GITHUBPROJECTISSUES_TEST_LIVE" => "FALSE",
    "GITHUBPROJECTISSUES_TEST_EXPLAIN" => "FALSE",
    "GITHUBPROJECTISSUES_APIKEY" => "NONE",
  })

  idmap_resolved = Helpers.to_map(
    env["GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID"])
  if idmap_resolved.nil?
    idmap_resolved = Helpers.to_map(idmap)
  end

  if env["GITHUBPROJECTISSUES_TEST_LIVE"] == "TRUE"
    merged_opts = Vs.merge([
      {
        "apikey" => env["GITHUBPROJECTISSUES_APIKEY"],
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
