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

func TestRepositoryDetailDomainEntity(t *testing.T) {
	t.Run("instance", func(t *testing.T) {
		testsdk := sdk.TestSDK(nil, nil)
		ent := testsdk.RepositoryDetailDomain(nil)
		if ent == nil {
			t.Fatal("expected non-nil RepositoryDetailDomainEntity")
		}
	})

	t.Run("basic", func(t *testing.T) {
		setup := repository_detail_domainBasicSetup(nil)
		// Per-op sdk-test-control.json skip — basic test exercises a flow
		// with multiple ops; skipping any op skips the whole flow.
		_mode := "unit"
		if setup.live {
			_mode = "live"
		}
		for _, _op := range []string{"list", "load"} {
			if _shouldSkip, _reason := isControlSkipped("entityOp", "repository_detail_domain." + _op, _mode); _shouldSkip {
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
			t.Skip("live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID JSON to run live")
			return
		}
		client := setup.client

		// Bootstrap entity data from existing test data (no create step in flow).
		repositoryDetailDomainRef01DataRaw := vs.Items(core.ToMapAny(vs.GetPath("existing.repository_detail_domain", setup.data)))
		var repositoryDetailDomainRef01Data map[string]any
		if len(repositoryDetailDomainRef01DataRaw) > 0 {
			repositoryDetailDomainRef01Data = core.ToMapAny(repositoryDetailDomainRef01DataRaw[0][1])
		}
		// Discard guards against Go's unused-var check when the flow's steps
		// happen not to consume the bootstrap data (e.g. list-only flows).
		_ = repositoryDetailDomainRef01Data

		// LIST
		repositoryDetailDomainRef01Ent := client.RepositoryDetailDomain(nil)
		repositoryDetailDomainRef01Match := map[string]any{}

		repositoryDetailDomainRef01ListResult, err := repositoryDetailDomainRef01Ent.List(repositoryDetailDomainRef01Match, nil)
		if err != nil {
			t.Fatalf("list failed: %v", err)
		}
		_, repositoryDetailDomainRef01ListOk := repositoryDetailDomainRef01ListResult.([]any)
		if !repositoryDetailDomainRef01ListOk {
			t.Fatalf("expected list result to be an array, got %T", repositoryDetailDomainRef01ListResult)
		}

		// LOAD
		repositoryDetailDomainRef01MatchDt0 := map[string]any{}
		repositoryDetailDomainRef01DataDt0Loaded, err := repositoryDetailDomainRef01Ent.Load(repositoryDetailDomainRef01MatchDt0, nil)
		if err != nil {
			t.Fatalf("load failed: %v", err)
		}
		if repositoryDetailDomainRef01DataDt0Loaded == nil {
			t.Fatal("expected load result to be non-nil")
		}

	})
}

func repository_detail_domainBasicSetup(extra map[string]any) *entityTestSetup {
	loadEnvLocal()

	_, filename, _, _ := runtime.Caller(0)
	dir := filepath.Dir(filename)

	entityDataFile := filepath.Join(dir, "..", "..", ".sdk", "test", "entity", "repository_detail_domain", "RepositoryDetailDomainTestData.json")

	entityDataSource, err := os.ReadFile(entityDataFile)
	if err != nil {
		panic("failed to read repository_detail_domain test data: " + err.Error())
	}

	var entityData map[string]any
	if err := json.Unmarshal(entityDataSource, &entityData); err != nil {
		panic("failed to parse repository_detail_domain test data: " + err.Error())
	}

	options := map[string]any{}
	options["entity"] = entityData["existing"]

	client := sdk.TestSDK(options, extra)

	// Generate idmap via transform, matching TS pattern.
	idmap := vs.Transform(
		[]any{"repository_detail_domain01", "repository_detail_domain02", "repository_detail_domain03", "get_repo_detail01", "get_repo_detail02", "get_repo_detail03"},
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
	entidEnvRaw := os.Getenv("GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID")
	idmapOverridden := entidEnvRaw != "" && strings.HasPrefix(strings.TrimSpace(entidEnvRaw), "{")

	env := envOverride(map[string]any{
		"GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID": idmap,
		"GITHUBPROJECTISSUES_TEST_LIVE":      "FALSE",
		"GITHUBPROJECTISSUES_TEST_EXPLAIN":   "FALSE",
		"GITHUBPROJECTISSUES_APIKEY":         "NONE",
	})

	idmapResolved := core.ToMapAny(env["GITHUBPROJECTISSUES_TEST_REPOSITORY_DETAIL_DOMAIN_ENTID"])
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
