# GithubProjectIssues Lua SDK Reference

Complete API reference for the GithubProjectIssues Lua SDK.


## GithubProjectIssuesSDK

### Constructor

```lua
local sdk = require("github-project-issues_sdk")
local client = sdk.new(options)
```

Create a new SDK client instance.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `options` | `table` | SDK configuration options. |
| `options.apikey` | `string` | API key for authentication. |
| `options.base` | `string` | Base URL for API requests. |
| `options.prefix` | `string` | URL prefix appended after base. |
| `options.suffix` | `string` | URL suffix appended after path. |
| `options.headers` | `table` | Custom headers for all requests. |
| `options.feature` | `table` | Feature configuration. |
| `options.system` | `table` | System overrides (e.g. custom fetch). |


### Static Methods

#### `sdk.test(testopts, sdkopts)`

Create a test client with mock features active. Both arguments may be `nil`.

```lua
local client = sdk.test(nil, nil)
```


### Instance Methods

#### `Coffee(data)`

Create a new `Coffee` entity instance. Pass `nil` for no initial data.

#### `CoffeeDomain(data)`

Create a new `CoffeeDomain` entity instance. Pass `nil` for no initial data.

#### `DonateRestController(data)`

Create a new `DonateRestController` entity instance. Pass `nil` for no initial data.

#### `PortfolioController(data)`

Create a new `PortfolioController` entity instance. Pass `nil` for no initial data.

#### `RepositoryDetailDomain(data)`

Create a new `RepositoryDetailDomain` entity instance. Pass `nil` for no initial data.

#### `RepositoryIssueDomain(data)`

Create a new `RepositoryIssueDomain` entity instance. Pass `nil` for no initial data.

#### `Version(data)`

Create a new `Version` entity instance. Pass `nil` for no initial data.

#### `options_map() -> table`

Return a deep copy of the current SDK options.

#### `get_utility() -> Utility`

Return a copy of the SDK utility object.

#### `direct(fetchargs) -> table, err`

Make a direct HTTP request to any API endpoint.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `fetchargs.path` | `string` | URL path with optional `{param}` placeholders. |
| `fetchargs.method` | `string` | HTTP method (default: `"GET"`). |
| `fetchargs.params` | `table` | Path parameter values for `{param}` substitution. |
| `fetchargs.query` | `table` | Query string parameters. |
| `fetchargs.headers` | `table` | Request headers (merged with defaults). |
| `fetchargs.body` | `any` | Request body (tables are JSON-serialized). |
| `fetchargs.ctrl` | `table` | Control options (e.g. `{ explain = true }`). |

**Returns:** `table, err`

#### `prepare(fetchargs) -> table, err`

Prepare a fetch definition without sending the request. Accepts the
same parameters as `direct()`.

**Returns:** `table, err`


---

## CoffeeEntity

```lua
local coffee = client:Coffee(nil)
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | ``$STRING`` | No |  |
| `id` | ``$INTEGER`` | No |  |
| `image` | ``$STRING`` | Yes |  |
| `ingredient` | ``$ARRAY`` | Yes |  |
| `title` | ``$STRING`` | Yes |  |

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:Coffee(nil):list(nil, nil)
```

#### `update(reqdata, ctrl) -> any, err`

Update an existing entity. The data must include the entity `id`.

```lua
local result, err = client:Coffee(nil):update({
  id = "coffee_id",
  -- Fields to update
}, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `CoffeeEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## CoffeeDomainEntity

```lua
local coffee_domain = client:CoffeeDomain(nil)
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | ``$STRING`` | No |  |
| `id` | ``$INTEGER`` | No |  |
| `image` | ``$STRING`` | Yes |  |
| `ingredient` | ``$ARRAY`` | Yes |  |
| `title` | ``$STRING`` | Yes |  |

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:CoffeeDomain(nil):list(nil, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `CoffeeDomainEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## DonateRestControllerEntity

```lua
local donate_rest_controller = client:DonateRestController(nil)
```

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:DonateRestController(nil):list(nil, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `DonateRestControllerEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## PortfolioControllerEntity

```lua
local portfolio_controller = client:PortfolioController(nil)
```

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:PortfolioController(nil):list(nil, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `PortfolioControllerEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## RepositoryDetailDomainEntity

```lua
local repository_detail_domain = client:RepositoryDetailDomain(nil)
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `app_home` | ``$STRING`` | No |  |
| `description` | ``$STRING`` | No |  |
| `full_name` | ``$STRING`` | Yes |  |
| `issue_count` | ``$INTEGER`` | No |  |
| `name` | ``$STRING`` | Yes |  |
| `repo_url` | ``$STRING`` | Yes |  |
| `topic` | ``$STRING`` | No |  |

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:RepositoryDetailDomain(nil):list(nil, nil)
```

#### `load(reqmatch, ctrl) -> any, err`

Load a single entity matching the given criteria.

```lua
local result, err = client:RepositoryDetailDomain(nil):load({ id = "repository_detail_domain_id" }, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `RepositoryDetailDomainEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## RepositoryIssueDomainEntity

```lua
local repository_issue_domain = client:RepositoryIssueDomain(nil)
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `body` | ``$STRING`` | No |  |
| `label` | ``$ARRAY`` | No |  |
| `number` | ``$STRING`` | Yes |  |
| `state` | ``$STRING`` | No |  |
| `title` | ``$STRING`` | Yes |  |

### Operations

#### `list(reqmatch, ctrl) -> any, err`

List entities matching the given criteria. Returns an array.

```lua
local results, err = client:RepositoryIssueDomain(nil):list(nil, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `RepositoryIssueDomainEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## VersionEntity

```lua
local version = client:Version(nil)
```

### Operations

#### `load(reqmatch, ctrl) -> any, err`

Load a single entity matching the given criteria.

```lua
local result, err = client:Version(nil):load({ id = "version_id" }, nil)
```

### Common Methods

#### `data_get() -> table`

Get the entity data. Returns a copy of the current data.

#### `data_set(data)`

Set the entity data.

#### `match_get() -> table`

Get the entity match criteria.

#### `match_set(match)`

Set the entity match criteria.

#### `make() -> Entity`

Create a new `VersionEntity` instance with the same client and
options.

#### `get_name() -> string`

Return the entity name.


---

## Features

| Feature | Version | Description |
| --- | --- | --- |
| `test` | 0.0.1 | In-memory mock transport for testing without a live server |


Features are activated via the `feature` option:

```lua
local client = sdk.new({
  feature = {
    test = { active = true },
  },
})
```

