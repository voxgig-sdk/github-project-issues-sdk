# GithubProjectIssues PHP SDK Reference

Complete API reference for the GithubProjectIssues PHP SDK.


## GithubProjectIssuesSDK

### Constructor

```php
require_once __DIR__ . '/githubprojectissues_sdk.php';

$client = new GithubProjectIssuesSDK($options);
```

Create a new SDK client instance.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `$options` | `array` | SDK configuration options. |
| `$options["base"]` | `string` | Base URL for API requests. |
| `$options["prefix"]` | `string` | URL prefix appended after base. |
| `$options["suffix"]` | `string` | URL suffix appended after path. |
| `$options["headers"]` | `array` | Custom headers for all requests. |
| `$options["feature"]` | `array` | Feature configuration. |
| `$options["system"]` | `array` | System overrides (e.g. custom fetch). |


### Static Methods

#### `GithubProjectIssuesSDK::test($testopts = null, $sdkopts = null)`

Create a test client with mock features active. Both arguments may be `null`.

```php
$client = GithubProjectIssuesSDK::test();
```


### Instance Methods

#### `Coffee($data = null)`

Create a new `CoffeeEntity` instance. Pass `null` for no initial data.

#### `CoffeeDomain($data = null)`

Create a new `CoffeeDomainEntity` instance. Pass `null` for no initial data.

#### `DonateRestController($data = null)`

Create a new `DonateRestControllerEntity` instance. Pass `null` for no initial data.

#### `PortfolioController($data = null)`

Create a new `PortfolioControllerEntity` instance. Pass `null` for no initial data.

#### `RepositoryDetailDomain($data = null)`

Create a new `RepositoryDetailDomainEntity` instance. Pass `null` for no initial data.

#### `RepositoryIssueDomain($data = null)`

Create a new `RepositoryIssueDomainEntity` instance. Pass `null` for no initial data.

#### `Version($data = null)`

Create a new `VersionEntity` instance. Pass `null` for no initial data.

#### `options_map(): array`

Return a deep copy of the current SDK options.

#### `get_utility(): GithubProjectIssuesUtility`

Return a copy of the SDK utility object.

#### `direct(array $fetchargs = []): array`

Make a direct HTTP request to any API endpoint. This is the raw-HTTP escape
hatch: it does **not** throw. It returns a result array
`["ok" => bool, "status" => int, "headers" => array, "data" => mixed]`, or
`["ok" => false, "err" => \Exception]` on failure. Branch on `$result["ok"]`.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `$fetchargs["path"]` | `string` | URL path with optional `{param}` placeholders. |
| `$fetchargs["method"]` | `string` | HTTP method (default: `"GET"`). |
| `$fetchargs["params"]` | `array` | Path parameter values for `{param}` substitution. |
| `$fetchargs["query"]` | `array` | Query string parameters. |
| `$fetchargs["headers"]` | `array` | Request headers (merged with defaults). |
| `$fetchargs["body"]` | `mixed` | Request body (arrays are JSON-serialized). |
| `$fetchargs["ctrl"]` | `array` | Control options. |

**Returns:** `array` — the result dict (see above); never throws.

#### `prepare(array $fetchargs = []): mixed`

Prepare a fetch definition without sending the request. Returns the
`$fetchdef` array. Throws on error.


---

## CoffeeEntity

```php
$coffee = $client->Coffee();
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | `string` | No |  |
| `id` | `int` | No |  |
| `image` | `string` | Yes |  |
| `ingredient` | `array` | Yes |  |
| `title` | `string` | Yes |  |

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->Coffee()->list();
```

#### `update(array $reqdata, ?array $ctrl = null): mixed`

Update an existing entity. The data must include the entity `id`. Throws on error.

```php
$result = $client->Coffee()->update([
  // Fields to update
]);
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): CoffeeEntity`

Create a new `CoffeeEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## CoffeeDomainEntity

```php
$coffee_domain = $client->CoffeeDomain();
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `description` | `string` | No |  |
| `id` | `int` | No |  |
| `image` | `string` | Yes |  |
| `ingredient` | `array` | Yes |  |
| `title` | `string` | Yes |  |

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->CoffeeDomain()->list();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): CoffeeDomainEntity`

Create a new `CoffeeDomainEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## DonateRestControllerEntity

```php
$donate_rest_controller = $client->DonateRestController();
```

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->DonateRestController()->list();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): DonateRestControllerEntity`

Create a new `DonateRestControllerEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## PortfolioControllerEntity

```php
$portfolio_controller = $client->PortfolioController();
```

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->PortfolioController()->list();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): PortfolioControllerEntity`

Create a new `PortfolioControllerEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## RepositoryDetailDomainEntity

```php
$repository_detail_domain = $client->RepositoryDetailDomain();
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `app_home` | `string` | No |  |
| `description` | `string` | No |  |
| `full_name` | `string` | Yes |  |
| `issue_count` | `int` | No |  |
| `name` | `string` | Yes |  |
| `repo_url` | `string` | Yes |  |
| `topic` | `string` | No |  |

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->RepositoryDetailDomain()->list();
```

#### `load(array $reqmatch, ?array $ctrl = null): mixed`

Load a single entity matching the given criteria. Throws on error.

```php
$result = $client->RepositoryDetailDomain()->load();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): RepositoryDetailDomainEntity`

Create a new `RepositoryDetailDomainEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## RepositoryIssueDomainEntity

```php
$repository_issue_domain = $client->RepositoryIssueDomain();
```

### Fields

| Field | Type | Required | Description |
| --- | --- | --- | --- |
| `body` | `string` | No |  |
| `label` | `array` | No |  |
| `number` | `string` | Yes |  |
| `state` | `string` | No |  |
| `title` | `string` | Yes |  |

### Operations

#### `list(?array $reqmatch = null, ?array $ctrl = null): mixed`

List entities matching the given criteria (call with no argument to list all). Returns an array. Throws on error.

```php
$results = $client->RepositoryIssueDomain()->list();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): RepositoryIssueDomainEntity`

Create a new `RepositoryIssueDomainEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## VersionEntity

```php
$version = $client->Version();
```

### Operations

#### `load(array $reqmatch, ?array $ctrl = null): mixed`

Load a single entity matching the given criteria. Throws on error.

```php
$result = $client->Version()->load();
```

### Common Methods

#### `data_get(): array`

Get the entity data. Returns a copy of the current data.

#### `data_set($data): void`

Set the entity data.

#### `match_get(): array`

Get the entity match criteria.

#### `match_set($match): void`

Set the entity match criteria.

#### `make(): VersionEntity`

Create a new `VersionEntity` instance with the same client and
options.

#### `get_name(): string`

Return the entity name.


---

## Features

| Feature | Version | Description |
| --- | --- | --- |
| `test` | 0.0.1 | In-memory mock transport for testing without a live server |


Features are activated via the `feature` option:

```php
$client = new GithubProjectIssuesSDK([
  "feature" => [
    "test" => ["active" => true],
  ],
]);
```

