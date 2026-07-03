<?php
declare(strict_types=1);

// RepositoryIssueDomain entity test

require_once __DIR__ . '/../githubprojectissues_sdk.php';
require_once __DIR__ . '/Runner.php';

use PHPUnit\Framework\TestCase;
use Voxgig\Struct\Struct as Vs;

class RepositoryIssueDomainEntityTest extends TestCase
{
    public function test_create_instance(): void
    {
        $testsdk = GithubProjectIssuesSDK::test(null, null);
        $ent = $testsdk->RepositoryIssueDomain(null);
        $this->assertNotNull($ent);
    }

    public function test_basic_flow(): void
    {
        $setup = repository_issue_domain_basic_setup(null);
        // Per-op sdk-test-control.json skip.
        $_live = !empty($setup["live"]);
        foreach (["list"] as $_op) {
            [$_shouldSkip, $_reason] = Runner::is_control_skipped("entityOp", "repository_issue_domain." . $_op, $_live ? "live" : "unit");
            if ($_shouldSkip) {
                $this->markTestSkipped($_reason ?? "skipped via sdk-test-control.json");
                return;
            }
        }
        // The basic flow consumes synthetic IDs from the fixture. In live mode
        // without an *_ENTID env override, those IDs hit the live API and 4xx.
        if (!empty($setup["synthetic_only"])) {
            $this->markTestSkipped("live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID JSON to run live");
            return;
        }
        $client = $setup["client"];

        // Bootstrap entity data from existing test data.
        $repository_issue_domain_ref01_data_raw = Vs::items(Helpers::to_map(
            Vs::getpath($setup["data"], "existing.repository_issue_domain")));
        $repository_issue_domain_ref01_data = null;
        if (count($repository_issue_domain_ref01_data_raw) > 0) {
            $repository_issue_domain_ref01_data = Helpers::to_map($repository_issue_domain_ref01_data_raw[0][1]);
        }

        // LIST
        $repository_issue_domain_ref01_ent = $client->RepositoryIssueDomain(null);
        $repository_issue_domain_ref01_match = [
            "repository" => $setup["idmap"]["repository01"],
            "username" => $setup["idmap"]["username01"],
        ];

        [$repository_issue_domain_ref01_list_result, $err] = $repository_issue_domain_ref01_ent->list($repository_issue_domain_ref01_match, null);
        $this->assertNull($err);
        $this->assertIsArray($repository_issue_domain_ref01_list_result);

    }
}

function repository_issue_domain_basic_setup($extra)
{
    Runner::load_env_local();

    $entity_data_file = __DIR__ . '/../../.sdk/test/entity/repository_issue_domain/RepositoryIssueDomainTestData.json';
    $entity_data_source = file_get_contents($entity_data_file);
    $entity_data = json_decode($entity_data_source, true);

    $options = [];
    $options["entity"] = $entity_data["existing"];

    $client = GithubProjectIssuesSDK::test($options, $extra);

    // Generate idmap.
    $idmap = [];
    foreach (["repository_issue_domain01", "repository_issue_domain02", "repository_issue_domain03", "get_repo_issue01", "get_repo_issue02", "get_repo_issue03", "repository01", "username01"] as $k) {
        $idmap[$k] = strtoupper($k);
    }

    // Detect ENTID env override before envOverride consumes it. When live
    // mode is on without a real override, the basic test runs against synthetic
    // IDs from the fixture and 4xx's. Surface this so the test can skip.
    $entid_env_raw = getenv("GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID");
    $idmap_overridden = $entid_env_raw !== false && str_starts_with(trim($entid_env_raw), "{");

    $env = Runner::env_override([
        "GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID" => $idmap,
        "GITHUBPROJECTISSUES_TEST_LIVE" => "FALSE",
        "GITHUBPROJECTISSUES_TEST_EXPLAIN" => "FALSE",
        "GITHUBPROJECTISSUES_APIKEY" => "NONE",
    ]);

    $idmap_resolved = Helpers::to_map(
        $env["GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID"]);
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
