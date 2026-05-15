package sdktest

import (
	"encoding/json"
	"fmt"
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

func TestCoffeeEntity(t *testing.T) {
	t.Run("instance", func(t *testing.T) {
		testsdk := sdk.TestSDK(nil, nil)
		ent := testsdk.Coffee(nil)
		if ent == nil {
			t.Fatal("expected non-nil CoffeeEntity")
		}
	})

	t.Run("basic", func(t *testing.T) {
		setup := coffeeBasicSetup(nil)
		// Per-op sdk-test-control.json skip — basic test exercises a flow
		// with multiple ops; skipping any op skips the whole flow.
		_mode := "unit"
		if setup.live {
			_mode = "live"
		}
		for _, _op := range []string{"list", "update"} {
			if _shouldSkip, _reason := isControlSkipped("entityOp", "coffee." + _op, _mode); _shouldSkip {
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
			t.Skip("live entity test uses synthetic IDs from fixture — set GITHUBPROJECTISSUES_TEST_COFFEE_ENTID JSON to run live")
			return
		}
		client := setup.client

		// Bootstrap entity data from existing test data (no create step in flow).
		coffeeRef01DataRaw := vs.Items(core.ToMapAny(vs.GetPath("existing.coffee", setup.data)))
		var coffeeRef01Data map[string]any
		if len(coffeeRef01DataRaw) > 0 {
			coffeeRef01Data = core.ToMapAny(coffeeRef01DataRaw[0][1])
		}
		// Discard guards against Go's unused-var check when the flow's steps
		// happen not to consume the bootstrap data (e.g. list-only flows).
		_ = coffeeRef01Data

		// LIST
		coffeeRef01Ent := client.Coffee(nil)
		coffeeRef01Match := map[string]any{}

		coffeeRef01ListResult, err := coffeeRef01Ent.List(coffeeRef01Match, nil)
		if err != nil {
			t.Fatalf("list failed: %v", err)
		}
		_, coffeeRef01ListOk := coffeeRef01ListResult.([]any)
		if !coffeeRef01ListOk {
			t.Fatalf("expected list result to be an array, got %T", coffeeRef01ListResult)
		}

		// UPDATE
		coffeeRef01DataUp0Up := map[string]any{
			"id": coffeeRef01Data["id"],
		}

		coffeeRef01MarkdefUp0Name := "description"
		coffeeRef01MarkdefUp0Value := fmt.Sprintf("Mark01-coffee_ref01_%d", setup.now)
		coffeeRef01DataUp0Up[coffeeRef01MarkdefUp0Name] = coffeeRef01MarkdefUp0Value

		coffeeRef01ResdataUp0Result, err := coffeeRef01Ent.Update(coffeeRef01DataUp0Up, nil)
		if err != nil {
			t.Fatalf("update failed: %v", err)
		}
		coffeeRef01ResdataUp0 := core.ToMapAny(coffeeRef01ResdataUp0Result)
		if coffeeRef01ResdataUp0 == nil {
			t.Fatal("expected update result to be a map")
		}
		if coffeeRef01ResdataUp0["id"] != coffeeRef01DataUp0Up["id"] {
			t.Fatal("expected update result id to match")
		}
		if coffeeRef01ResdataUp0[coffeeRef01MarkdefUp0Name] != coffeeRef01MarkdefUp0Value {
			t.Fatalf("expected %s to be updated, got %v", coffeeRef01MarkdefUp0Name, coffeeRef01ResdataUp0[coffeeRef01MarkdefUp0Name])
		}

	})
}

func coffeeBasicSetup(extra map[string]any) *entityTestSetup {
	loadEnvLocal()

	_, filename, _, _ := runtime.Caller(0)
	dir := filepath.Dir(filename)

	entityDataFile := filepath.Join(dir, "..", "..", ".sdk", "test", "entity", "coffee", "CoffeeTestData.json")

	entityDataSource, err := os.ReadFile(entityDataFile)
	if err != nil {
		panic("failed to read coffee test data: " + err.Error())
	}

	var entityData map[string]any
	if err := json.Unmarshal(entityDataSource, &entityData); err != nil {
		panic("failed to parse coffee test data: " + err.Error())
	}

	options := map[string]any{}
	options["entity"] = entityData["existing"]

	client := sdk.TestSDK(options, extra)

	// Generate idmap via transform, matching TS pattern.
	idmap := vs.Transform(
		[]any{"coffee01", "coffee02", "coffee03"},
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
	entidEnvRaw := os.Getenv("GITHUBPROJECTISSUES_TEST_COFFEE_ENTID")
	idmapOverridden := entidEnvRaw != "" && strings.HasPrefix(strings.TrimSpace(entidEnvRaw), "{")

	env := envOverride(map[string]any{
		"GITHUBPROJECTISSUES_TEST_COFFEE_ENTID": idmap,
		"GITHUBPROJECTISSUES_TEST_LIVE":      "FALSE",
		"GITHUBPROJECTISSUES_TEST_EXPLAIN":   "FALSE",
		"GITHUBPROJECTISSUES_APIKEY":         "NONE",
	})

	idmapResolved := core.ToMapAny(env["GITHUBPROJECTISSUES_TEST_COFFEE_ENTID"])
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
