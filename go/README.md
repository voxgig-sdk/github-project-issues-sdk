# GithubProjectIssues Golang SDK



The Golang SDK for the GithubProjectIssues API — an entity-oriented client using standard Go conventions. No generics required; data flows as `map[string]any`.

It exposes the API as capitalised, semantic **Entities** — e.g. `client.Coffee(nil)` — each with the same small set of operations (`List`, `Load`, `Update`) instead of raw URL paths and query strings. You call meaning, not endpoints, which keeps the cognitive load low.

> Other languages, the CLI, and MCP server live alongside this one — see
> the [top-level README](../README.md).


## Install
```bash
go get github.com/voxgig-sdk/github-project-issues-sdk/go@latest
```

The Go module proxy resolves the version from the `go/vX.Y.Z` GitHub
release tag — see [Releases](https://github.com/voxgig-sdk/github-project-issues-sdk/releases) for the available versions.

To vendor from a local checkout instead, clone this repo alongside your
project and add a `replace` directive pointing at the checked-out
`go/` directory:

```bash
go mod edit -replace github.com/voxgig-sdk/github-project-issues-sdk/go=../github-project-issues-sdk/go
```


## Tutorial: your first API call

This tutorial walks through creating a client, listing entities, and
loading a specific record.

### Quickstart

A complete program: create a client, then call the entity operations.
Each operation returns `(value, error)` — the value is the data itself
(there is no `{ok, data}` wrapper), so check `err` and use the value
directly.

```go
package main

import (
    "fmt"
    sdk "github.com/voxgig-sdk/github-project-issues-sdk/go"
)

func main() {
    client := sdk.New()

    // List coffee records — the value is the array of records itself.
    coffees, err := client.Coffee(nil).List(nil, nil)
    if err != nil {
        panic(err)
    }
    for _, item := range coffees.([]any) {
        fmt.Println(item)
    }

    // Update a coffee.
    updated, err := client.Coffee(nil).Update(map[string]any{"description": "example", "image": "example"}, nil)
    if err != nil {
        panic(err)
    }
    fmt.Println(updated)
}
```


## Error handling

Every entity operation returns `(value, error)`. Check `err` before
using the value — there is no exception to catch:

```go
coffees, err := client.Coffee(nil).List(nil, nil)
if err != nil {
    // handle err
    return
}
_ = coffees
```

`Direct` follows the same `(value, error)` convention:

```go
result, err := client.Direct(map[string]any{
    "path":   "/api/resource/{id}",
    "method": "GET",
    "params": map[string]any{"id": "example_id"},
})
if err != nil {
    // handle err
}
_ = result
```


## How-to guides

### Make a direct HTTP request

For endpoints not covered by entity methods:

```go
result, err := client.Direct(map[string]any{
    "path":   "/api/resource/{id}",
    "method": "GET",
    "params": map[string]any{"id": "example"},
})
if err != nil {
    panic(err)
}

if result["ok"] == true {
    fmt.Println(result["status"]) // 200
    fmt.Println(result["data"])   // response body
}
```

### Prepare a request without sending it

```go
fetchdef, err := client.Prepare(map[string]any{
    "path":   "/api/resource/{id}",
    "method": "DELETE",
    "params": map[string]any{"id": "example"},
})
if err != nil {
    panic(err)
}

fmt.Println(fetchdef["url"])
fmt.Println(fetchdef["method"])
fmt.Println(fetchdef["headers"])
```

### Use test mode

Create a mock client for unit testing — no server required:

```go
client := sdk.Test()

coffee, err := client.Coffee(nil).List(
    nil, nil,
)
if err != nil {
    panic(err)
}
fmt.Println(coffee) // the returned mock data
```

### Use a custom fetch function

Replace the HTTP transport with your own function:

```go
mockFetch := func(url string, init map[string]any) (map[string]any, error) {
    return map[string]any{
        "status":     200,
        "statusText": "OK",
        "headers":    map[string]any{},
        "json": (func() any)(func() any {
            return map[string]any{"id": "mock01"}
        }),
    }, nil
}

client := sdk.NewGithubProjectIssuesSDK(map[string]any{
    "base": "http://localhost:8080",
    "system": map[string]any{
        "fetch": (func(string, map[string]any) (map[string]any, error))(mockFetch),
    },
})
```

### Run live tests

Create a `.env.local` file at the project root:

```
GITHUB_PROJECT_ISSUES_TEST_LIVE=TRUE
```

Then run:

```bash
cd go && go test ./test/...
```


## Reference

### NewGithubProjectIssuesSDK

```go
func NewGithubProjectIssuesSDK(options map[string]any) *GithubProjectIssuesSDK
```

Creates a new SDK client.

| Option | Type | Description |
| --- | --- | --- |
| `"base"` | `string` | Base URL of the API server. |
| `"prefix"` | `string` | URL path prefix prepended to all requests. |
| `"suffix"` | `string` | URL path suffix appended to all requests. |
| `"feature"` | `map[string]any` | Feature activation flags. |
| `"extend"` | `[]any` | Additional Feature instances to load. |
| `"system"` | `map[string]any` | System overrides (e.g. custom `"fetch"` function). |

### TestSDK

```go
func TestSDK(testopts map[string]any, sdkopts map[string]any) *GithubProjectIssuesSDK
```

Creates a test-mode client with mock transport. Both arguments may be `nil`.

### GithubProjectIssuesSDK methods

| Method | Signature | Description |
| --- | --- | --- |
| `OptionsMap` | `() map[string]any` | Deep copy of current SDK options. |
| `GetUtility` | `() *Utility` | Copy of the SDK utility object. |
| `Prepare` | `(fetchargs map[string]any) (map[string]any, error)` | Build an HTTP request definition without sending. |
| `Direct` | `(fetchargs map[string]any) (map[string]any, error)` | Build and send an HTTP request. |
| `Coffee` | `(data map[string]any) GithubProjectIssuesEntity` | Create a Coffee entity instance. |
| `CoffeeDomain` | `(data map[string]any) GithubProjectIssuesEntity` | Create a CoffeeDomain entity instance. |
| `DonateRestController` | `(data map[string]any) GithubProjectIssuesEntity` | Create a DonateRestController entity instance. |
| `PortfolioController` | `(data map[string]any) GithubProjectIssuesEntity` | Create a PortfolioController entity instance. |
| `RepositoryDetailDomain` | `(data map[string]any) GithubProjectIssuesEntity` | Create a RepositoryDetailDomain entity instance. |
| `RepositoryIssueDomain` | `(data map[string]any) GithubProjectIssuesEntity` | Create a RepositoryIssueDomain entity instance. |
| `Version` | `(data map[string]any) GithubProjectIssuesEntity` | Create a Version entity instance. |

### Entity interface (GithubProjectIssuesEntity)

All entities implement the `GithubProjectIssuesEntity` interface.

| Method | Signature | Description |
| --- | --- | --- |
| `Load` | `(reqmatch, ctrl map[string]any) (any, error)` | Load a single entity by match criteria. |
| `List` | `(reqmatch, ctrl map[string]any) (any, error)` | List entities matching the criteria. |
| `Update` | `(reqdata, ctrl map[string]any) (any, error)` | Update an existing entity. |
| `Data` | `(args ...any) any` | Get or set entity data. |
| `Match` | `(args ...any) any` | Get or set entity match criteria. |
| `Make` | `() Entity` | Create a new instance with the same options. |
| `GetName` | `() string` | Return the entity name. |

### Result shape

Entity operations return `(value, error)`. The `value` is the
operation's data **directly** — there is no wrapper:

| Operation | `value` |
| --- | --- |
| `Load` / `Update` | the entity record (`map[string]any`) |
| `List` | a `[]any` of entity records |

Check `err` first, then use the value directly (or the typed
`...Typed` variants, which return the entity's model struct and a typed
slice):

    coffee, err := client.Coffee(nil).List(map[string]any{/* fields */}, nil)
    if err != nil { /* handle */ }
    // coffee is the returned record

Only `Direct()` returns a response envelope — a `map[string]any` with
`"ok"`, `"status"`, `"headers"`, and `"data"` keys.

### Entities

#### Coffee

| Field | Description |
| --- | --- |
| `"description"` |  |
| `"id"` |  |
| `"image"` |  |
| `"ingredient"` |  |
| `"title"` |  |

Operations: List, Update.

API path: `/api/coffees`

#### CoffeeDomain

| Field | Description |
| --- | --- |
| `"description"` |  |
| `"id"` |  |
| `"image"` |  |
| `"ingredient"` |  |
| `"title"` |  |

Operations: List.

API path: `/api/coffees-graph-ql`

#### DonateRestController

| Field | Description |
| --- | --- |

Operations: List.

API path: `/api/donate-items`

#### PortfolioController

| Field | Description |
| --- | --- |

Operations: List.

API path: `/api/portfolio-items`

#### RepositoryDetailDomain

| Field | Description |
| --- | --- |
| `"app_home"` |  |
| `"description"` |  |
| `"full_name"` |  |
| `"issue_count"` |  |
| `"name"` |  |
| `"repo_url"` |  |
| `"topic"` |  |

Operations: List, Load.

API path: `/api/get-repo-detail`

#### RepositoryIssueDomain

| Field | Description |
| --- | --- |
| `"body"` |  |
| `"label"` |  |
| `"number"` |  |
| `"state"` |  |
| `"title"` |  |

Operations: List.

API path: `/api/get-repo-issue/{username}/{repository}/`

#### Version

| Field | Description |
| --- | --- |

Operations: Load.

API path: `/api/application/version`



## Entities


### Coffee

Create an instance: `coffee := client.Coffee(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |
| `Update(data, ctrl)` | Update an existing entity. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `string` |  |
| `id` | `int` |  |
| `image` | `string` |  |
| `ingredient` | `[]any` |  |
| `title` | `string` |  |

#### Example: List

```go
coffees, err := client.Coffee(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(coffees) // the array of records
```


### CoffeeDomain

Create an instance: `coffee_domain := client.CoffeeDomain(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `string` |  |
| `id` | `int` |  |
| `image` | `string` |  |
| `ingredient` | `[]any` |  |
| `title` | `string` |  |

#### Example: List

```go
coffee_domains, err := client.CoffeeDomain(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(coffee_domains) // the array of records
```


### DonateRestController

Create an instance: `donate_rest_controller := client.DonateRestController(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Example: List

```go
donate_rest_controllers, err := client.DonateRestController(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(donate_rest_controllers) // the array of records
```


### PortfolioController

Create an instance: `portfolio_controller := client.PortfolioController(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Example: List

```go
portfolio_controllers, err := client.PortfolioController(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(portfolio_controllers) // the array of records
```


### RepositoryDetailDomain

Create an instance: `repository_detail_domain := client.RepositoryDetailDomain(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |
| `Load(match, ctrl)` | Load a single entity by match criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `app_home` | `string` |  |
| `description` | `string` |  |
| `full_name` | `string` |  |
| `issue_count` | `int` |  |
| `name` | `string` |  |
| `repo_url` | `string` |  |
| `topic` | `string` |  |

#### Example: Load

```go
repository_detail_domain, err := client.RepositoryDetailDomain(nil).Load(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(repository_detail_domain) // the loaded record
```

#### Example: List

```go
repository_detail_domains, err := client.RepositoryDetailDomain(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(repository_detail_domains) // the array of records
```


### RepositoryIssueDomain

Create an instance: `repository_issue_domain := client.RepositoryIssueDomain(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `body` | `string` |  |
| `label` | `[]any` |  |
| `number` | `string` |  |
| `state` | `string` |  |
| `title` | `string` |  |

#### Example: List

```go
repository_issue_domains, err := client.RepositoryIssueDomain(nil).List(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(repository_issue_domains) // the array of records
```


### Version

Create an instance: `version := client.Version(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `Load(match, ctrl)` | Load a single entity by match criteria. |

#### Example: Load

```go
version, err := client.Version(nil).Load(nil, nil)
if err != nil {
    panic(err)
}
fmt.Println(version) // the loaded record
```


## Advanced

> The sections above cover everyday use. The material below explains the
> SDK's internals — useful when extending it with custom features, but not
> needed for normal use.

### The operation pipeline

Every entity operation follows a six-stage pipeline. Each stage fires a
feature hook before executing:

```
PrePoint → PreSpec → PreRequest → PreResponse → PreResult → PreDone
```

- **PrePoint**: Resolves which API endpoint to call based on the
  operation name and entity configuration.
- **PreSpec**: Builds the HTTP spec — URL, method, headers, body —
  from the resolved point and the caller's parameters.
- **PreRequest**: Sends the HTTP request. Features can intercept here
  to replace the transport (as TestFeature does with mocks).
- **PreResponse**: Parses the raw HTTP response.
- **PreResult**: Extracts the business data from the parsed response.
- **PreDone**: Final stage before returning to the caller. Entity
  state (match, data) is updated here.

If any stage errors, the pipeline short-circuits and the error surfaces
to the caller — see [Error handling](#error-handling) for how that looks
in this language.

### Features and hooks

Features are the extension mechanism. A feature implements the
`Feature` interface and provides hooks — functions keyed by pipeline
stage names.

The SDK ships with built-in features:

- **TestFeature**: In-memory mock transport for testing without a live server

Features are initialized in order. Hooks fire in the order features
were added, so later features can override earlier ones.

### Data as maps

The Go SDK uses `map[string]any` throughout rather than typed structs.
This mirrors the dynamic nature of the API and keeps the SDK
flexible — no code generation is needed when the API schema changes.

Use `core.ToMapAny()` to safely cast results and nested data.

### Package structure

```
github.com/voxgig-sdk/github-project-issues-sdk/go/
├── github-project-issues.go        # Root package — type aliases and constructors
├── core/               # SDK core — client, types, pipeline
├── entity/             # Entity implementations
├── feature/            # Built-in features (Base, Test, Log)
├── utility/            # Utility functions and struct library
└── test/               # Test suites
```

The root package (`github.com/voxgig-sdk/github-project-issues-sdk/go`) re-exports everything needed
for normal use. Import sub-packages only when you need specific types
like `core.ToMapAny`.

### Entity state

Entity instances are stateful. After a successful `List`, the entity
stores the returned data and match criteria internally.

```go
coffee := client.Coffee(nil)
coffee.List(nil, nil)

// coffee.Data() now returns the coffee data from the last list
// coffee.Match() returns the last match criteria
```

Call `Make()` to create a fresh instance with the same configuration
but no stored state.

### Direct vs entity access

The entity interface handles URL construction, parameter placement,
and response parsing automatically. Use it for standard CRUD operations.

`Direct()` gives full control over the HTTP request. Use it for
non-standard endpoints, bulk operations, or any path not modelled as
an entity. `Prepare()` builds the request without sending it — useful
for debugging or custom transport.


## Full Reference

See [REFERENCE.md](REFERENCE.md) for complete API reference
documentation including all method signatures, entity field schemas,
and detailed usage examples.
