# GithubProjectIssues Ruby SDK Reference

Complete API reference for the GithubProjectIssues Ruby SDK.


## GithubProjectIssuesSDK

### Constructor

```ruby
require_relative 'GithubProjectIssues_sdk'

client = GithubProjectIssuesSDK.new(options)
```

Create a new SDK client instance.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `options` | `Hash` | SDK configuration options. |
| `options["base"]` | `String` | Base URL for API requests. |
| `options["prefix"]` | `String` | URL prefix appended after base. |
| `options["suffix"]` | `String` | URL suffix appended after path. |
| `options["headers"]` | `Hash` | Custom headers for all requests. |
| `options["feature"]` | `Hash` | Feature configuration. |
| `options["system"]` | `Hash` | System overrides (e.g. custom fetch). |


### Static Methods

#### `GithubProjectIssuesSDK.test(testopts = nil, sdkopts = nil)`

Create a test client with mock features active. Both arguments may be `nil`.

```ruby
client = GithubProjectIssuesSDK.test
```


### Instance Methods

#### `Coffee(data = nil)`

Create a new `Coffee` entity instance. Pass `nil` for no initial data.

#### `CoffeeDomain(data = nil)`

Create a new `CoffeeDomain` entity instance. Pass `nil` for no initial data.

#### `DonateRestController(data = nil)`

Create a new `DonateRestController` entity instance. Pass `nil` for no initial data.

#### `PortfolioController(data = nil)`

Create a new `PortfolioController` entity instance. Pass `nil` for no initial data.

#### `RepositoryDetailDomain(data = nil)`

Create a new `RepositoryDetailDomain` entity instance. Pass `nil` for no initial data.

#### `RepositoryIssueDomain(data = nil)`

Create a new `RepositoryIssueDomain` entity instance. Pass `nil` for no initial data.

#### `Version(data = nil)`

Create a new `Version` entity instance. Pass `nil` for no initial data.

#### `options_map -> Hash`

Return a deep copy of the current SDK options.

#### `get_utility -> Utility`

Return a copy of the SDK utility object.

#### `direct(fetchargs = {}) -> Hash`

Make a direct HTTP request to any API endpoint. Returns a result hash
(`{ "ok" => ..., "status" => ..., "data" => ..., "err" => ... }`); it
does not raise — inspect `result["ok"]`.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `fetchargs["path"]` | `String` | URL path with optional `{param}` placeholders. |
| `fetchargs["method"]` | `String` | HTTP method (default: `"GET"`). |
| `fetchargs["params"]` | `Hash` | Path parameter values for `{param}` substitution. |
| `fetchargs["query"]` | `Hash` | Query string parameters. |
| `fetchargs["headers"]` | `Hash` | Request headers (merged with defaults). |
| `fetchargs["body"]` | `any` | Request body (hashes are JSON-serialized). |
| `fetchargs["ctrl"]` | `Hash` | Control options (e.g. `{ "explain" => true }`). |

**Returns:** `Hash`

#### `prepare(fetchargs = {}) -> Hash`

Prepare a fetch definition without sending the request. Accepts the
same parameters as `direct()`. Raises on error.

**Returns:** `Hash` (the fetch definition; raises on error)


---

## CoffeeEntity

```ruby
coffee = client.Coffee
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | `String` | No |  |
| `id` | `Integer` | No |  |
| `image` | `String` | Yes |  |
| `ingredient` | `Array` | Yes |  |
| `title` | `String` | Yes |  |

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.Coffee.list
```

#### `update(reqdata, ctrl = nil) -> result`

Update an existing entity. The data must include the entity `id`. Raises on error.

```ruby
result = client.Coffee.update({
  # Fields to update
})
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `CoffeeEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## CoffeeDomainEntity

```ruby
coffee_domain = client.CoffeeDomain
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | `String` | No |  |
| `id` | `Integer` | No |  |
| `image` | `String` | Yes |  |
| `ingredient` | `Array` | Yes |  |
| `title` | `String` | Yes |  |

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.CoffeeDomain.list
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `CoffeeDomainEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## DonateRestControllerEntity

```ruby
donate_rest_controller = client.DonateRestController
```

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.DonateRestController.list
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `DonateRestControllerEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## PortfolioControllerEntity

```ruby
portfolio_controller = client.PortfolioController
```

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.PortfolioController.list
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `PortfolioControllerEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## RepositoryDetailDomainEntity

```ruby
repository_detail_domain = client.RepositoryDetailDomain
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `app_home` | `String` | No |  |
| `description` | `String` | No |  |
| `full_name` | `String` | Yes |  |
| `issue_count` | `Integer` | No |  |
| `name` | `String` | Yes |  |
| `repo_url` | `String` | Yes |  |
| `topic` | `String` | No |  |

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.RepositoryDetailDomain.list
```

#### `load(reqmatch, ctrl = nil) -> result`

Load a single entity matching the given criteria. Raises on error.

```ruby
result = client.RepositoryDetailDomain.load()
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `RepositoryDetailDomainEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## RepositoryIssueDomainEntity

```ruby
repository_issue_domain = client.RepositoryIssueDomain
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `body` | `String` | No |  |
| `label` | `Array` | No |  |
| `number` | `String` | Yes |  |
| `state` | `String` | No |  |
| `title` | `String` | Yes |  |

### Operations

#### `list(reqmatch = nil, ctrl = nil) -> Array`

List entities matching the given criteria (call with no argument to list all). Returns an array. Raises on error.

```ruby
results = client.RepositoryIssueDomain.list
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `RepositoryIssueDomainEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## VersionEntity

```ruby
version = client.Version
```

### Operations

#### `load(reqmatch, ctrl = nil) -> result`

Load a single entity matching the given criteria. Raises on error.

```ruby
result = client.Version.load()
```

### Common Methods

#### `data_get -> Hash`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get -> Hash`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make -> Entity`

Create a new `VersionEntity` instance with the same client and
options.

#### `get_name -> String`

Return the entity name.


---

## Features

| Feature | Version | Description |
| --- | --- | --- |
| `test` | 0.0.1 | In-memory mock transport for testing without a live server |


Features are activated via the `feature` option:

```ruby
client = GithubProjectIssuesSDK.new({
  "feature" => {
    "test" => { "active" => true },
  },
})
```

