# GithubProjectIssues Golang SDK

The Golang SDK for the GithubProjectIssues API. Provides an entity-oriented interface using standard Go conventions — no generics required, data flows as `map[string]any`.


## Install
```bash
go get github.com/voxgig-sdk/github-project-issues-sdk
```

If the module is not yet published to a registry, use a `replace` directive
in your `go.mod` to point to a local checkout:

```bash
go mod edit -replace github.com/voxgig-sdk/github-project-issues-sdk=../path/to/github.com/voxgig-sdk/github-project-issues-sdk
```


## Tutorial: your first API call

This tutorial walks through creating a client, listing entities, and
loading a specific record.

### 1. Create a client

```go
package main

import (
    "fmt"
    "os"

    sdk "github.com/voxgig-sdk/github-project-issues-sdk"
    "github.com/voxgig-sdk/github-project-issues-sdk/core"
)

func main() {
    client := sdk.NewGithubProjectIssuesSDK(map[string]any{
        "apikey": os.Getenv("GITHUB-PROJECT-ISSUES_APIKEY"),
    })
```

### 2. List coffees

```go
    result, err := client.Coffee(nil).List(nil, nil)
    if err != nil {
        panic(err)
    }

    rm := core.ToMapAny(result)
    if rm["ok"] == true {
        for _, item := range rm["data"].([]any) {
            p := core.ToMapAny(item)
            fmt.Println(p["id"], p["name"])
        }
    }
```

### 4. Create, update, and remove

```go
// Update
client.Coffee(nil).Update(
    map[string]any{"id": newID, "name": "Example-Renamed"}, nil,
)

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
client := sdk.TestSDK(nil, nil)

result, err := client.Planet(nil).Load(
    map[string]any{"id": "test01"}, nil,
)
// result contains mock response data
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
GITHUB-PROJECT-ISSUES_TEST_LIVE=TRUE
GITHUB-PROJECT-ISSUES_APIKEY=<your-key>
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
| `"apikey"` | `string` | API key for authentication. |
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
| `Create` | `(reqdata, ctrl map[string]any) (any, error)` | Create a new entity. |
| `Update` | `(reqdata, ctrl map[string]any) (any, error)` | Update an existing entity. |
| `Remove` | `(reqmatch, ctrl map[string]any) (any, error)` | Remove an entity. |
| `Data` | `(args ...any) any` | Get or set entity data. |
| `Match` | `(args ...any) any` | Get or set entity match criteria. |
| `Make` | `() Entity` | Create a new instance with the same options. |
| `GetName` | `() string` | Return the entity name. |

### Result shape

Entity operations return `(any, error)`. The `any` value is a
`map[string]any` with these keys:

| Key | Type | Description |
| --- | --- | --- |
| `"ok"` | `bool` | `true` if the HTTP status is 2xx. |
| `"status"` | `int` | HTTP status code. |
| `"headers"` | `map[string]any` | Response headers. |
| `"data"` | `any` | Parsed JSON response body. |

On error, `"ok"` is `false` and `"err"` contains the error value.

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
| `description` | ``$STRING`` |  |
| `id` | ``$INTEGER`` |  |
| `image` | ``$STRING`` |  |
| `ingredient` | ``$ARRAY`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```go
results, err := client.Coffee(nil).List(nil, nil)
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
| `description` | ``$STRING`` |  |
| `id` | ``$INTEGER`` |  |
| `image` | ``$STRING`` |  |
| `ingredient` | ``$ARRAY`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```go
results, err := client.CoffeeDomain(nil).List(nil, nil)
```


### DonateRestController

Create an instance: `donate_rest_controller := client.DonateRestController(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Example: List

```go
results, err := client.DonateRestController(nil).List(nil, nil)
```


### PortfolioController

Create an instance: `portfolio_controller := client.PortfolioController(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `List(match, ctrl)` | List entities matching the criteria. |

#### Example: List

```go
results, err := client.PortfolioController(nil).List(nil, nil)
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
| `app_home` | ``$STRING`` |  |
| `description` | ``$STRING`` |  |
| `full_name` | ``$STRING`` |  |
| `issue_count` | ``$INTEGER`` |  |
| `name` | ``$STRING`` |  |
| `repo_url` | ``$STRING`` |  |
| `topic` | ``$STRING`` |  |

#### Example: Load

```go
result, err := client.RepositoryDetailDomain(nil).Load(map[string]any{"id": "repository_detail_domain_id"}, nil)
```

#### Example: List

```go
results, err := client.RepositoryDetailDomain(nil).List(nil, nil)
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
| `body` | ``$STRING`` |  |
| `label` | ``$ARRAY`` |  |
| `number` | ``$STRING`` |  |
| `state` | ``$STRING`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```go
results, err := client.RepositoryIssueDomain(nil).List(nil, nil)
```


### Version

Create an instance: `version := client.Version(nil)`

#### Operations

| Method | Description |
| --- | --- |
| `Load(match, ctrl)` | Load a single entity by match criteria. |

#### Example: Load

```go
result, err := client.Version(nil).Load(map[string]any{"id": "version_id"}, nil)
```


## Explanation

### The operation pipeline

Every entity operation (load, list, create, update, remove) follows a
six-stage pipeline. Each stage fires a feature hook before executing:

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

If any stage returns an error, the pipeline short-circuits and the
error is returned to the caller. An unexpected panic triggers the
`PreUnexpected` hook.

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
github.com/voxgig-sdk/github-project-issues-sdk/
├── github-project-issues.go        # Root package — type aliases and constructors
├── core/               # SDK core — client, types, pipeline
├── entity/             # Entity implementations
├── feature/            # Built-in features (Base, Test, Log)
├── utility/            # Utility functions and struct library
└── test/               # Test suites
```

The root package (`github.com/voxgig-sdk/github-project-issues-sdk`) re-exports everything needed
for normal use. Import sub-packages only when you need specific types
like `core.ToMapAny`.

### Entity state

Entity instances are stateful. After a successful `Load`, the entity
stores the returned data and match criteria internally.

```go
moon := client.Moon(nil)
moon.Load(map[string]any{"planet_id": "earth", "id": "luna"}, nil)

// moon.Data() now returns the loaded moon data
// moon.Match() returns the last match criteria
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
