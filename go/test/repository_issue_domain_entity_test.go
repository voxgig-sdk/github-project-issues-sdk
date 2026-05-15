package sdktest

import (
	"encoding/json"
	"os"
	"path/filepath"
	"runtime"
	"strings"
	"testing"
	"time"

	sdk "github.com/voxgig-sdk/github-project-issues-sdk"
	"github.com/voxgig-sdk/github-project-issues-sdk/core"

	vs "github.com/voxgig/struct"
)

func TestRepositoryIssueDomainEntity(t *testing.T) {
	t.Run("instance", func(t *testing.T) {
		testsdk := sdk.TestSDK(nil, nil)
		ent := testsdk.RepositoryIssueDomain(nil)
		if ent == nil {
			t.Fatal("expected non-nil RepositoryIssueDomainEntity")
		}
	})

	t.Run("basic", func(t *testing.T) {
		setup := repository_issue_domainBasicSetup(nil)
		// Per-op sdk-test-control.json skip — basic test exercises a flow
		// with multiple ops; skipping any op skips the whole flow.
		_mode := "unit"
		if setup.live {
			_mode = "live"
		}
		for _, _op := range []string{"list"} {
			if _shouldSkip, _reason := isControlSkipped("entityOp", "repository_issue_domain." + _op, _mode); _shouldSkip {
				if _reason == "" {
					_reason = "skipped via sdk-test-control.json"
				}
				t.Skip(_reason)
				return
			}
		}
		// The basic flow consumes synthetic IDs from the fixture. In live mode
		// without an *_ENTID env override, those IDs hit the live API and 4xx.
		if setup.syntheticOnly {
			t.Skip("live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID JSON to run live")
			return
		}
		client := setup.client

		// Bootstrap entity data from existing test data (no create step in flow).
		repositoryIssueDomainRef01DataRaw := vs.Items(core.ToMapAny(vs.GetPath("existing.repository_issue_domain", setup.data)))
		var repositoryIssueDomainRef01Data map[string]any
		if len(repositoryIssueDomainRef01DataRaw) > 0 {
			repositoryIssueDomainRef01Data = core.ToMapAny(repositoryIssueDomainRef01DataRaw[0][1])
		}
		// Discard guards against Go's unused-var check when the flow's steps
		// happen not to consume the bootstrap data (e.g. list-only flows).
		_ = repositoryIssueDomainRef01Data

		// LIST
		repositoryIssueDomainRef01Ent := client.RepositoryIssueDomain(nil)
		repositoryIssueDomainRef01Match := map[string]any{
			"repository": setup.idmap["repository01"],
			"username": setup.idmap["username01"],
		}

		repositoryIssueDomainRef01ListResult, err := repositoryIssueDomainRef01Ent.List(repositoryIssueDomainRef01Match, nil)
		if err != nil {
			t.Fatalf("list failed: %v", err)
		}
		_, repositoryIssueDomainRef01ListOk := repositoryIssueDomainRef01ListResult.([]any)
		if !repositoryIssueDomainRef01ListOk {
			t.Fatalf("expected list result to be an array, got %T", repositoryIssueDomainRef01ListResult)
		}

	})
}

func repository_issue_domainBasicSetup(extra map[string]any) *entityTestSetup {
	loadEnvLocal()

	_, filename, _, _ := runtime.Caller(0)
	dir := filepath.Dir(filename)

	entityDataFile := filepath.Join(dir, "..", "..", ".sdk", "test", "entity", "repository_issue_domain", "RepositoryIssueDomainTestData.json")

	entityDataSource, err := os.ReadFile(entityDataFile)
	if err != nil {
		panic("failed to read repository_issue_domain test data: " + err.Error())
	}

	var entityData map[string]any
	if err := json.Unmarshal(entityDataSource, &entityData); err != nil {
		panic("failed to parse repository_issue_domain test data: " + err.Error())
	}

	options := map[string]any{}
	options["entity"] = entityData["existing"]

	client := sdk.TestSDK(options, extra)

	// Generate idmap via transform, matching TS pattern.
	idmap := vs.Transform(
		[]any{"repository_issue_domain01", "repository_issue_domain02", "repository_issue_domain03", "get_repo_issue01", "get_repo_issue02", "get_repo_issue03", "repository01", "username01"},
		map[string]any{
			"`$PACK`": []any{"", map[string]any{
				"`$KEY`": "`$COPY`",
				"`$VAL`": []any{"`$FORMAT`", "upper", "`$COPY`"},
			}},
		},
	)

	// Detect ENTID env override before envOverride consumes it. When live
	// mode is on without a real override, the basic test runs against synthetic
	// IDs from the fixture and 4xx's. Surface this so the test can skip.
	entidEnvRaw := os.Getenv("GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID")
	idmapOverridden := entidEnvRaw != "" && strings.HasPrefix(strings.TrimSpace(entidEnvRaw), "{")

	env := envOverride(map[string]any{
		"GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID": idmap,
		"GITHUBPROJECTISSUES_TEST_LIVE":      "FALSE",
		"GITHUBPROJECTISSUES_TEST_EXPLAIN":   "FALSE",
		"GITHUBPROJECTISSUES_APIKEY":         "NONE",
	})

	idmapResolved := core.ToMapAny(env["GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID"])
	if idmapResolved == nil {
		idmapResolved = core.ToMapAny(idmap)
	}

	if env["GITHUBPROJECTISSUES_TEST_LIVE"] == "TRUE" {
		mergedOpts := vs.Merge([]any{
			map[string]any{
				"apikey": env["GITHUBPROJECTISSUES_APIKEY"],
			},
			extra,
		})
		client = sdk.NewGithubProjectIssuesSDK(core.ToMapAny(mergedOpts))
	}

	live := env["GITHUBPROJECTISSUES_TEST_LIVE"] == "TRUE"
	return &entityTestSetup{
		client:        client,
		data:          entityData,
		idmap:         idmapResolved,
		env:           env,
		explain:       env["GITHUBPROJECTISSUES_TEST_EXPLAIN"] == "TRUE",
		live:          live,
		syntheticOnly: live && !idmapOverridden,
		now:           time.Now().UnixMilli(),
	}
}
