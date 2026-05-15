<?php
declare(strict_types=1);

// RepositoryDetailDomain entity test

require_once __DIR__ . '/../githubprojectissues_sdk.php';
require_once __DIR__ . '/Runner.php';

use PHPUnit\Framework\TestCase;
use Voxgig\Struct\Struct as Vs;

class RepositoryDetailDomainEntityTest extends TestCase
{
    public function test_create_instance(): void
    {
        $testsdk = GithubProjectIssuesSDK::test(null, null);
        $ent = $testsdk->RepositoryDetailDomain(null);
        $this->assertNotNull($ent);
    }

    public function test_basic_flow(): void
    {
        $setup = repository_detail_domain_basic_setup(null);
        // Per-op sdk-test-control.json skip.
        $_live = !empty($setup["live"]);
        foreach (["list", "load"] as $_op) {
            [$_shouldSkip, $_reason] = Runner::is_control_skipped("entityOp", "repository_detail_domain." . $_op, $_live ? "live" : "unit");
            if ($_shouldSkip) {
                $this->markTestSkipped($_reason ?? "skipped via sdk-test-control.json");
                return;
            }
        }
        // The basic flow consumes synthetic IDs from the fixture. In live mode
        // without an *_ENTID env override, those IDs hit the live API and 4xx.
        if (!empty($setup["synthetic_only"])) {
            $this->markTestSkipped("live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID JSON to run live");
            return;
        }
        $client = $setup["client"];

        // Bootstrap entity data from existing test data.
        $repository_detail_domain_ref01_data_raw = Vs::items(Helpers::to_map(
            Vs::getpath($setup["data"], "existing.repository_detail_domain")));
        $repository_detail_domain_ref01_data = null;
        if (count($repository_detail_domain_ref01_data_raw) > 0) {
            $repository_detail_domain_ref01_data = Helpers::to_map($repository_detail_domain_ref01_data_raw[0][1]);
        }

        // LIST
        $repository_detail_domain_ref01_ent = $client->RepositoryDetailDomain(null);
        $repository_detail_domain_ref01_match = [];

        [$repository_detail_domain_ref01_list_result, $err] = $repository_detail_domain_ref01_ent->list($repository_detail_domain_ref01_match, null);
        $this->assertNull($err);
        $this->assertIsArray($repository_detail_domain_ref01_list_result);

        // LOAD
        $repository_detail_domain_ref01_match_dt0 = [];
        [$repository_detail_domain_ref01_data_dt0_loaded, $err] = $repository_detail_domain_ref01_ent->load($repository_detail_domain_ref01_match_dt0, null);
        $this->assertNull($err);
        $this->assertNotNull($repository_detail_domain_ref01_data_dt0_loaded);

    }
}

function repository_detail_domain_basic_setup($extra)
{
    Runner::load_env_local();

    $entity_data_file = __DIR__ . '/../../.sdk/test/entity/repository_detail_domain/RepositoryDetailDomainTestData.json';
    $entity_data_source = file_get_contents($entity_data_file);
    $entity_data = json_decode($entity_data_source, true);

    $options = [];
    $options["entity"] = $entity_data["existing"];

    $client = GithubProjectIssuesSDK::test($options, $extra);

    // Generate idmap.
    $idmap = [];
    foreach (["repository_detail_domain01", "repository_detail_domain02", "repository_detail_domain03", "get_repo_detail01", "get_repo_detail02", "get_repo_detail03"] as $k) {
        $idmap[$k] = strtoupper($k);
    }

    // Detect ENTID env override before envOverride consumes it. When live
    // mode is on without a real override, the basic test runs against synthetic
    // IDs from the fixture and 4xx's. Surface this so the test can skip.
    $entid_env_raw = getenv("GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID");
    $idmap_overridden = $entid_env_raw !== false && str_starts_with(trim($entid_env_raw), "{");

    $env = Runner::env_override([
        "GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID" => $idmap,
        "GITHUBPROJECTISSUES_TEST_LIVE" => "FALSE",
        "GITHUBPROJECTISSUES_TEST_EXPLAIN" => "FALSE",
        "GITHUBPROJECTISSUES_APIKEY" => "NONE",
    ]);

    $idmap_resolved = Helpers::to_map(
        $env["GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID"]);
    if ($idmap_resolved === null) {
        $idmap_resolved = Helpers::to_map($idmap);
    }

    if ($env["GITHUBPROJECTISSUES_TEST_LIVE"] === "TRUE") {
        $merged_opts = Vs::merge([
            [
                "apikey" => $env["GITHUBPROJECTISSUES_APIKEY"],
            ],
            $extra ?? [],
        ]);
        $client = new GithubProjectIssuesSDK(Helpers::to_map($merged_opts));
    }

    $live = $env["GITHUBPROJECTISSUES_TEST_LIVE"] === "TRUE";
    return [
        "client" => $client,
        "data" => $entity_data,
        "idmap" => $idmap_resolved,
        "env" => $env,
        "explain" => $env["GITHUBPROJECTISSUES_TEST_EXPLAIN"] === "TRUE",
        "live" => $live,
        "synthetic_only" => $live && !$idmap_overridden,
        "now" => (int)(microtime(true) * 1000),
    ];
}
