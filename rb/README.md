# GithubProjectIssues Ruby SDK



The Ruby SDK for the GithubProjectIssues API — an entity-oriented client using idiomatic Ruby conventions.

The SDK exposes the API as capitalised, semantic **Entities** — for example `client.Coffee` — with named operations (`list`/`load`/`update`) instead of raw URL paths and query strings. Working with resources and verbs keeps call sites self-describing and reduces cognitive load.

> Other languages, the CLI, and MCP server live alongside this one — see
> the [top-level README](../README.md).


## Install
This package is not yet published to RubyGems. Install it from the
GitHub release tag (`rb/vX.Y.Z`):

- Releases: [https://github.com/voxgig-sdk/github-project-issues-sdk/releases](https://github.com/voxgig-sdk/github-project-issues-sdk/releases)


## Tutorial: your first API call

This tutorial walks through creating a client, listing entities, and
loading a specific record.

### 1. Create a client

```ruby
require_relative "GithubProjectIssues_sdk"

client = GithubProjectIssuesSDK.new
```

### 2. List coffee records

```ruby
begin
  # list returns an Array of Coffee records — iterate directly.
  coffees = client.Coffee.list
  coffees.each do |item|
    puts "#{item["id"]} #{item["description"]}"
  end
rescue => err
  warn "list failed: #{err}"
end
```

### 4. Create, update, and remove

```ruby
# Update
client.Coffee.update({ "description" => "example", "image" => "example" })

```


## Error handling

Entity operations raise on failure, so rescue them:

```ruby
begin
  coffees = client.Coffee.list()
rescue => err
  warn "list failed: #{err}"
end
```

`direct` does **not** raise — it returns the result hash. Branch on
`ok`; on failure `status` holds the HTTP status (for error responses) and
`err` holds a transport error, so read both defensively:

```ruby
result = client.direct({
  "path" => "/api/resource/{id}",
  "method" => "GET",
  "params" => { "id" => "example_id" },
})

warn "request failed: #{result["err"] || "HTTP #{result["status"]}"}" unless result["ok"]
```


## How-to guides

### Make a direct HTTP request

For endpoints not covered by entity methods:

```ruby
result = client.direct({
  "path" => "/api/resource/{id}",
  "method" => "GET",
  "params" => { "id" => "example" },
})

if result["ok"]
  puts result["status"]  # 200
  puts result["data"]    # response body
else
  # On an HTTP error status there is no err (only a transport failure sets
  # it), so fall back to the status code.
  warn(result["err"] || "HTTP #{result["status"]}")
end
```

### Prepare a request without sending it

```ruby
begin
  fetchdef = client.prepare({
    "path" => "/api/resource/{id}",
    "method" => "DELETE",
    "params" => { "id" => "example" },
  })
  puts fetchdef["url"]
  puts fetchdef["method"]
  puts fetchdef["headers"]
rescue => err
  warn "prepare failed: #{err}"
end
```

### Use test mode

Create a mock client for unit testing — no server required:

```ruby
client = GithubProjectIssuesSDK.test

# Entity ops return the bare mock record (raises on error).
coffee = client.Coffee.list()
puts coffee
```

### Use a custom fetch function

Replace the HTTP transport with your own function:

```ruby
mock_fetch = ->(url, init) {
  return {
    "status" => 200,
    "statusText" => "OK",
    "headers" => {},
    "json" => ->() { { "id" => "mock01" } },
  }, nil
}

client = GithubProjectIssuesSDK.new({
  "base" => "http://localhost:8080",
  "system" => {
    "fetch" => mock_fetch,
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
cd rb && ruby -Itest -e "Dir['test/*_test.rb'].each { |f| require_relative f }"
```


## Reference

### GithubProjectIssuesSDK

```ruby
require_relative "GithubProjectIssues_sdk"
client = GithubProjectIssuesSDK.new(options)
```

Creates a new SDK client.

| Option | Type | Description |
| --- | --- | --- |
| `base` | `String` | Base URL of the API server. |
| `prefix` | `String` | URL path prefix prepended to all requests. |
| `suffix` | `String` | URL path suffix appended to all requests. |
| `feature` | `Hash` | Feature activation flags. |
| `extend` | `Hash` | Additional Feature instances to load. |
| `system` | `Hash` | System overrides (e.g. custom `fetch` lambda). |

### test

```ruby
client = GithubProjectIssuesSDK.test(testopts, sdkopts)
```

Creates a test-mode client with mock transport. Both arguments may be `nil`.

### GithubProjectIssuesSDK methods

| Method | Signature | Description |
| --- | --- | --- |
| `options_map` | `() -> Hash` | Deep copy of current SDK options. |
| `get_utility` | `() -> Utility` | Copy of the SDK utility object. |
| `prepare` | `(fetchargs) -> Hash` | Build an HTTP request definition without sending. Raises on error. |
| `direct` | `(fetchargs) -> Hash` | Build and send an HTTP request. Returns a result hash (`result["ok"]`); does not raise. |
| `Coffee` | `(data) -> CoffeeEntity` | Create a Coffee entity instance. |
| `CoffeeDomain` | `(data) -> CoffeeDomainEntity` | Create a CoffeeDomain entity instance. |
| `DonateRestController` | `(data) -> DonateRestControllerEntity` | Create a DonateRestController entity instance. |
| `PortfolioController` | `(data) -> PortfolioControllerEntity` | Create a PortfolioController entity instance. |
| `RepositoryDetailDomain` | `(data) -> RepositoryDetailDomainEntity` | Create a RepositoryDetailDomain entity instance. |
| `RepositoryIssueDomain` | `(data) -> RepositoryIssueDomainEntity` | Create a RepositoryIssueDomain entity instance. |
| `Version` | `(data) -> VersionEntity` | Create a Version entity instance. |

### Entity interface

All entities share the same interface.

| Method | Signature | Description |
| --- | --- | --- |
| `load` | `(reqmatch, ctrl) -> any` | Load a single entity by match criteria. Raises on error. |
| `list` | `(reqmatch = nil, ctrl) -> Array` | List entities matching the criteria (call with no argument to list all). Raises on error. |
| `update` | `(reqdata, ctrl) -> any` | Update an existing entity. Raises on error. |
| `data_get` | `() -> Hash` | Get entity data. |
| `data_set` | `(data)` | Set entity data. |
| `match_get` | `() -> Hash` | Get entity match criteria. |
| `match_set` | `(match)` | Set entity match criteria. |
| `make` | `() -> Entity` | Create a new instance with the same options. |
| `get_name` | `() -> String` | Return the entity name. |

### Result shape

Entity operations return the result data directly. On failure they
raise a `GithubProjectIssuesError` (a `StandardError` subclass), so wrap
calls in `begin`/`rescue` where you need to handle errors.

The `direct` escape hatch is the exception: it never raises and instead
returns a result `Hash` with these keys:

| Key | Type | Description |
| --- | --- | --- |
| `ok` | `Boolean` | `true` if the HTTP status is 2xx. |
| `status` | `Integer` | HTTP status code. |
| `headers` | `Hash` | Response headers. |
| `data` | `any` | Parsed JSON response body. |
| `err` | `Error` | Present when `ok` is `false`. |

### Entities

#### Coffee

| Field | Description |
| --- | --- |
| `description` |  |
| `id` |  |
| `image` |  |
| `ingredient` |  |
| `title` |  |

Operations: List, Update.

API path: `/api/coffees`

#### CoffeeDomain

| Field | Description |
| --- | --- |
| `description` |  |
| `id` |  |
| `image` |  |
| `ingredient` |  |
| `title` |  |

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
| `app_home` |  |
| `description` |  |
| `full_name` |  |
| `issue_count` |  |
| `name` |  |
| `repo_url` |  |
| `topic` |  |

Operations: List, Load.

API path: `/api/get-repo-detail`

#### RepositoryIssueDomain

| Field | Description |
| --- | --- |
| `body` |  |
| `label` |  |
| `number` |  |
| `state` |  |
| `title` |  |

Operations: List.

API path: `/api/get-repo-issue/{username}/{repository}/`

#### Version

| Field | Description |
| --- | --- |

Operations: Load.

API path: `/api/application/version`



## Entities


### Coffee

Create an instance: `coffee = client.Coffee`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |
| `update(data)` | Update an existing entity. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `String` |  |
| `id` | `Integer` |  |
| `image` | `String` |  |
| `ingredient` | `Array` |  |
| `title` | `String` |  |

#### Example: List

```ruby
# list returns an Array of Coffee records (raises on error).
coffees = client.Coffee.list
```


### CoffeeDomain

Create an instance: `coffee_domain = client.CoffeeDomain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `String` |  |
| `id` | `Integer` |  |
| `image` | `String` |  |
| `ingredient` | `Array` |  |
| `title` | `String` |  |

#### Example: List

```ruby
# list returns an Array of CoffeeDomain records (raises on error).
coffee_domains = client.CoffeeDomain.list
```


### DonateRestController

Create an instance: `donate_rest_controller = client.DonateRestController`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Example: List

```ruby
# list returns an Array of DonateRestController records (raises on error).
donate_rest_controllers = client.DonateRestController.list
```


### PortfolioController

Create an instance: `portfolio_controller = client.PortfolioController`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Example: List

```ruby
# list returns an Array of PortfolioController records (raises on error).
portfolio_controllers = client.PortfolioController.list
```


### RepositoryDetailDomain

Create an instance: `repository_detail_domain = client.RepositoryDetailDomain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |
| `load(match)` | Load a single entity by match criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `app_home` | `String` |  |
| `description` | `String` |  |
| `full_name` | `String` |  |
| `issue_count` | `Integer` |  |
| `name` | `String` |  |
| `repo_url` | `String` |  |
| `topic` | `String` |  |

#### Example: Load

```ruby
# load returns the bare RepositoryDetailDomain record (raises on error).
repository_detail_domain = client.RepositoryDetailDomain.load()
```

#### Example: List

```ruby
# list returns an Array of RepositoryDetailDomain records (raises on error).
repository_detail_domains = client.RepositoryDetailDomain.list
```


### RepositoryIssueDomain

Create an instance: `repository_issue_domain = client.RepositoryIssueDomain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `body` | `String` |  |
| `label` | `Array` |  |
| `number` | `String` |  |
| `state` | `String` |  |
| `title` | `String` |  |

#### Example: List

```ruby
# list returns an Array of RepositoryIssueDomain records (raises on error).
repository_issue_domains = client.RepositoryIssueDomain.list
```


### Version

Create an instance: `version = client.Version`

#### Operations

| Method | Description |
| --- | --- |
| `load(match)` | Load a single entity by match criteria. |

#### Example: Load

```ruby
# load returns the bare Version record (raises on error).
version = client.Version.load()
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

Features are the extension mechanism. A feature is a Ruby class
with hook methods named after pipeline stages (e.g. `PrePoint`,
`PreSpec`). Each method receives the context.

The SDK ships with built-in features:

- **TestFeature**: In-memory mock transport for testing without a live server

Features are initialized in order. Hooks fire in the order features
were added, so later features can override earlier ones.

### Data as hashes

The Ruby SDK uses plain Ruby hashes throughout rather than typed
objects. This mirrors the dynamic nature of the API and keeps the
SDK flexible — no code generation is needed when the API schema
changes.

Use `Helpers.to_map()` to safely validate that a value is a hash.

### Module structure

```
rb/
├── GithubProjectIssues_sdk.rb       -- Main SDK module
├── config.rb                  -- Configuration
├── features.rb                -- Feature factory
├── core/                      -- Core types and context
├── entity/                    -- Entity implementations
├── feature/                   -- Built-in features (Base, Test, Log)
├── utility/                   -- Utility functions and struct library
└── test/                      -- Test suites
```

The main module (`GithubProjectIssues_sdk`) exports the SDK class
and test helper. Import entity or utility modules directly only
when needed.

### Entity state

Entity instances are stateful. After a successful `list`, the entity
stores the returned data and match criteria internally.

```ruby
coffee = client.Coffee
coffee.list()

# coffee.data_get now returns the coffee data from the last list
# coffee.match_get returns the last match criteria
```

Call `make` to create a fresh instance with the same configuration
but no stored state.

### Direct vs entity access

The entity interface handles URL construction, parameter placement,
and response parsing automatically. Use it for standard CRUD operations.

`direct` gives full control over the HTTP request. Use it for
non-standard endpoints, bulk operations, or any path not modelled as
an entity. `prepare` builds the request without sending it — useful
for debugging or custom transport.


## Full Reference

See [REFERENCE.md](REFERENCE.md) for complete API reference
documentation including all method signatures, entity field schemas,
and detailed usage examples.
