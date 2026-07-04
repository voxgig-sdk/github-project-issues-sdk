# GithubProjectIssues Ruby SDK



The Ruby SDK for the GithubProjectIssues API — an entity-oriented client using idiomatic Ruby conventions.

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

### 2. List coffees

```ruby
begin
  result = client.coffee.list
  if result.is_a?(Array)
    result.each do |item|
      d = item.data_get
      puts "#{d["id"]} #{d["name"]}"
    end
  end
rescue => err
  warn "list failed: #{err}"
end
```

### 4. Create, update, and remove

```ruby
# Update
client.coffee.update({ "id" => created["id"], "name" => "Example-Renamed" })

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
  warn result["err"]
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

result = client.coffee.load({ "id" => "test01" })
# result contains mock response data
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
| `list` | `(reqmatch, ctrl) -> Array` | List entities matching the criteria. Raises on error. |
| `create` | `(reqdata, ctrl) -> any` | Create a new entity. Raises on error. |
| `update` | `(reqdata, ctrl) -> any` | Update an existing entity. Raises on error. |
| `remove` | `(reqmatch, ctrl) -> any` | Remove an entity. Raises on error. |
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

Create an instance: `const coffee = client.coffee`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |
| `update(data)` | Update an existing entity. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | ``$STRING`` |  |
| `id` | ``$INTEGER`` |  |
| `image` | ``$STRING`` |  |
| `ingredient` | ``$ARRAY`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```ts
const coffees = await client.coffee.list()
```


### CoffeeDomain

Create an instance: `const coffee_domain = client.coffee_domain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | ``$STRING`` |  |
| `id` | ``$INTEGER`` |  |
| `image` | ``$STRING`` |  |
| `ingredient` | ``$ARRAY`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```ts
const coffee_domains = await client.coffee_domain.list()
```


### DonateRestController

Create an instance: `const donate_rest_controller = client.donate_rest_controller`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Example: List

```ts
const donate_rest_controllers = await client.donate_rest_controller.list()
```


### PortfolioController

Create an instance: `const portfolio_controller = client.portfolio_controller`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Example: List

```ts
const portfolio_controllers = await client.portfolio_controller.list()
```


### RepositoryDetailDomain

Create an instance: `const repository_detail_domain = client.repository_detail_domain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |
| `load(match)` | Load a single entity by match criteria. |

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

```ts
const repository_detail_domain = await client.repository_detail_domain.load({ id: 'repository_detail_domain_id' })
```

#### Example: List

```ts
const repository_detail_domains = await client.repository_detail_domain.list()
```


### RepositoryIssueDomain

Create an instance: `const repository_issue_domain = client.repository_issue_domain`

#### Operations

| Method | Description |
| --- | --- |
| `list(match)` | List entities matching the criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `body` | ``$STRING`` |  |
| `label` | ``$ARRAY`` |  |
| `number` | ``$STRING`` |  |
| `state` | ``$STRING`` |  |
| `title` | ``$STRING`` |  |

#### Example: List

```ts
const repository_issue_domains = await client.repository_issue_domain.list()
```


### Version

Create an instance: `const version = client.version`

#### Operations

| Method | Description |
| --- | --- |
| `load(match)` | Load a single entity by match criteria. |

#### Example: Load

```ts
const version = await client.version.load({ id: 'version_id' })
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
error is returned to the caller as a second return value.

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

Entity instances are stateful. After a successful `load`, the entity
stores the returned data and match criteria internally.

```ruby
coffee = client.coffee
coffee.load({ "id" => "example_id" })

# coffee.data_get now returns the loaded coffee data
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
