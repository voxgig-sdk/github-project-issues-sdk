<?php
declare(strict_types=1);

// RepositoryIssueDomain direct test

require_once __DIR__ . '/../githubprojectissues_sdk.php';
require_once __DIR__ . '/Runner.php';

use PHPUnit\Framework\TestCase;

class RepositoryIssueDomainDirectTest extends TestCase
{
    public function test_direct_list_repository_issue_domain(): void
    {
        $setup = repository_issue_domain_direct_setup([
            ["id" => "direct01"],
            ["id" => "direct02"],
        ]);
        [$_shouldSkip, $_reason] = Runner::is_control_skipped("direct", "direct-list-repository_issue_domain", $setup["live"] ? "live" : "unit");
        if ($_shouldSkip) {
            $this->markTestSkipped($_reason ?? "skipped via sdk-test-control.json");
            return;
        }
        if ($setup["live"]) {
            foreach (["repository01", "username01"] as $_liveKey) {
                if (!isset($setup["idmap"][$_liveKey]) || $setup["idmap"][$_liveKey] === null) {
                    $this->markTestSkipped("live test needs $_liveKey via *_ENTID env var (synthetic IDs only)");
                    return;
                }
            }
        }
        $client = $setup["client"];

        $params = [];
        if ($setup["live"]) {
            $params["repository"] = $setup["idmap"]["repository01"];
        } else {
            $params["repository"] = "direct01";
        }
        if ($setup["live"]) {
            $params["username"] = $setup["idmap"]["username01"];
        } else {
            $params["username"] = "direct01";
        }

        [$result, $err] = $client->direct([
            "path" => "api/get-repo-issue/{username}/{repository}",
            "method" => "GET",
            "params" => $params,
        ]);
        if ($setup["live"]) {
            // Live mode is lenient: synthetic IDs frequently 4xx and the
            // list-response shape varies wildly across public APIs. Skip
            // rather than fail when the call doesn't return a usable list.
            if ($err !== null) {
                $this->markTestSkipped("list call failed (likely synthetic IDs against live API): " . (string)$err);
                return;
            }
            if (empty($result["ok"])) {
                $this->markTestSkipped("list call not ok (likely synthetic IDs against live API)");
                return;
            }
            $status = Helpers::to_int($result["status"]);
            if ($status < 200 || $status >= 300) {
                $this->markTestSkipped("expected 2xx status, got " . $status);
                return;
            }
        } else {
            $this->assertNull($err);
            $this->assertTrue($result["ok"]);
            $this->assertEquals(200, Helpers::to_int($result["status"]));
            $this->assertIsArray($result["data"]);
            $this->assertCount(2, $result["data"]);
            $this->assertCount(1, $setup["calls"]);
        }
    }

}


function repository_issue_domain_direct_setup($mockres)
{
    Runner::load_env_local();

    $calls = new \ArrayObject();

    $env = Runner::env_override([
        "GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID" => [],
        "GITHUBPROJECTISSUES_TEST_LIVE" => "FALSE",
        "GITHUBPROJECTISSUES_APIKEY" => "NONE",
    ]);

    $live = $env["GITHUBPROJECTISSUES_TEST_LIVE"] === "TRUE";

    if ($live) {
        $merged_opts = [
            "apikey" => $env["GITHUBPROJECTISSUES_APIKEY"],
        ];
        $client = new GithubProjectIssuesSDK($merged_opts);
        return [
            "client" => $client,
            "calls" => $calls,
            "live" => true,
            "idmap" => [],
        ];
    }

    $mock_fetch = function ($url, $init) use ($calls, $mockres) {
        $calls[] = ["url" => $url, "init" => $init];
        return [
            [
                "status" => 200,
                "statusText" => "OK",
                "headers" => [],
                "json" => function () use ($mockres) {
                    if ($mockres !== null) {
                        return $mockres;
                    }
                    return ["id" => "direct01"];
                },
                "body" => "mock",
            ],
            null,
        ];
    };

    $client = new GithubProjectIssuesSDK([
        "base" => "http://localhost:8080",
        "system" => [
            "fetch" => $mock_fetch,
        ],
    ]);

    return [
        "client" => $client,
        "calls" => $calls,
        "live" => false,
        "idmap" => [],
    ];
}
