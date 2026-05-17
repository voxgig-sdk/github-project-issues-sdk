# GithubProjectIssues PHP SDK Reference

Complete API reference for the GithubProjectIssues PHP SDK.


## GithubProjectIssuesSDK

### Constructor

```php
require_once __DIR__ . '/github-project-issues_sdk.php';

$client = new GithubProjectIssuesSDK($options);
```

Create a new SDK client instance.

**Parameters:**

| Name | Type | Description |
| --- | --- | --- |
| `$options` | `array` | SDK configuration options. |
| `$options["apikey"]` | `string` | API key for authentication. |
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

#### `optionsMap(): array`

Return a deep copy of the current SDK options.

#### `getUtility(): ProjectNameUtility`

Return a copy of the SDK utility object.

#### `direct(array $fetchargs = []): array`

Make a direct HTTP request to any API endpoint. Returns `[$result, $err]`.

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

**Returns:** `array [$result, $err]`

#### `prepare(array $fetchargs = []): array`

Prepare a fetch definition without sending the request. Returns `[$fetchdef, $err]`.


---

## CoffeeEntity

```php
$coffee = $client->Coffee();
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

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->Coffee()->list([]);
```

#### `update(array $reqdata, ?array $ctrl = null): array`

Update an existing entity. The data must include the entity `id`.

```php
[$result, $err] = $client->Coffee()->update([
  "id" => "coffee_id",
  // Fields to update
]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): CoffeeEntity`

Create a new `CoffeeEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## CoffeeDomainEntity

```php
$coffee_domain = $client->CoffeeDomain();
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

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->CoffeeDomain()->list([]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): CoffeeDomainEntity`

Create a new `CoffeeDomainEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## DonateRestControllerEntity

```php
$donate_rest_controller = $client->DonateRestController();
```

### Operations

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->DonateRestController()->list([]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): DonateRestControllerEntity`

Create a new `DonateRestControllerEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## PortfolioControllerEntity

```php
$portfolio_controller = $client->PortfolioController();
```

### Operations

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->PortfolioController()->list([]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): PortfolioControllerEntity`

Create a new `PortfolioControllerEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## RepositoryDetailDomainEntity

```php
$repository_detail_domain = $client->RepositoryDetailDomain();
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

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->RepositoryDetailDomain()->list([]);
```

#### `load(array $reqmatch, ?array $ctrl = null): array`

Load a single entity matching the given criteria.

```php
[$result, $err] = $client->RepositoryDetailDomain()->load(["id" => "repository_detail_domain_id"]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): RepositoryDetailDomainEntity`

Create a new `RepositoryDetailDomainEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## RepositoryIssueDomainEntity

```php
$repository_issue_domain = $client->RepositoryIssueDomain();
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

#### `list(array $reqmatch, ?array $ctrl = null): array`

List entities matching the given criteria. Returns an array.

```php
[$results, $err] = $client->RepositoryIssueDomain()->list([]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): RepositoryIssueDomainEntity`

Create a new `RepositoryIssueDomainEntity` instance with the same client and
options.

#### `getName(): string`

Return the entity name.


---

## VersionEntity

```php
$version = $client->Version();
```

### Operations

#### `load(array $reqmatch, ?array $ctrl = null): array`

Load a single entity matching the given criteria.

```php
[$result, $err] = $client->Version()->load(["id" => "version_id"]);
```

### Common Methods

#### `dataGet(): array`

Get the entity data. Returns a copy of the current data.

#### `dataSet($data): void`

Set the entity data.

#### `matchGet(): array`

Get the entity match criteria.

#### `matchSet($match): void`

Set the entity match criteria.

#### `make(): VersionEntity`

Create a new `VersionEntity` instance with the same client and
options.

#### `getName(): string`

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

