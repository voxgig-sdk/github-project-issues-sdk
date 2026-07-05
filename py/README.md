# GithubProjectIssues Python SDK



The Python SDK for the GithubProjectIssues API — an entity-oriented client following Pythonic conventions.

The SDK exposes the API as capitalised, semantic **Entities** — for example `client.Coffee()` — each
carrying a small, uniform set of operations (`list`, `load`, `update`) instead of raw URL
paths and query strings. You work with named resources and verbs, which
keeps the cognitive load low.

> Other languages, the CLI, and MCP server live alongside this one — see
> the [top-level README](../README.md).


## Install
This package is not yet published to PyPI. Install it from the GitHub
release tag (`py/vX.Y.Z`, see [Releases](https://github.com/voxgig-sdk/github-project-issues-sdk/releases)) or
from a source checkout:

```bash
pip install -e .
```


## Tutorial: your first API call

This tutorial walks through creating a client, listing entities, and
loading a specific record.

### 1. Create a client

```python
from githubprojectissues_sdk import GithubProjectIssuesSDK

client = GithubProjectIssuesSDK()
```

### 2. List coffee records

`list()` returns a `list` of records (each a `dict`) and raises on
error — iterate it directly.

```python
try:
    coffees = client.Coffee().list()
    for coffee in coffees:
        print(coffee)
except Exception as err:
    print(f"list failed: {err}")
```

### 4. Create, update, and remove

```python
# Update
client.Coffee().update({"description": "example", "image": "example"})

```


## Error handling

Entity operations raise on failure, so wrap them in `try` / `except`:

```python
try:
    coffees = client.Coffee().list()
    print(coffees)
except Exception as err:
    print(f"list failed: {err}")
```

`direct()` does **not** raise — it returns the result envelope. Branch
on `ok`; on failure `status` holds the HTTP status (for error responses)
and `err` holds a transport error, so read both defensively:

```python
result = client.direct({
    "path": "/api/resource/{id}",
    "method": "GET",
    "params": {"id": "example_id"},
})

if not result["ok"]:
    print("request failed:", result.get("status"), result.get("err"))
```


## How-to guides

### Make a direct HTTP request

For endpoints not covered by entity methods:

```python
result = client.direct({
    "path": "/api/resource/{id}",
    "method": "GET",
    "params": {"id": "example"},
})

if result["ok"]:
    print(result["status"])  # 200
    print(result["data"])    # response body
else:
    # A non-2xx response carries status + data (the error body); a
    # transport-level failure carries err instead. Only one is present, so
    # read both with .get() rather than indexing a key that may be absent.
    print(result.get("status"), result.get("err"))
```

### Prepare a request without sending it

```python
# prepare() returns the fetch definition and raises on error.
fetchdef = client.prepare({
    "path": "/api/resource/{id}",
    "method": "DELETE",
    "params": {"id": "example"},
})

print(fetchdef["url"])
print(fetchdef["method"])
print(fetchdef["headers"])
```

### Use test mode

Create a mock client for unit testing — no server required:

```python
client = GithubProjectIssuesSDK.test()

# Entity ops return the bare record and raise on error.
coffee = client.Coffee().list()
# coffee contains the mock response record
```

### Use a custom fetch function

Replace the HTTP transport with your own function:

```python
def mock_fetch(url, init):
    return {
        "status": 200,
        "statusText": "OK",
        "headers": {},
        "json": lambda: {"id": "mock01"},
    }, None

client = GithubProjectIssuesSDK({
    "base": "http://localhost:8080",
    "system": {
        "fetch": mock_fetch,
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
cd py && pytest test/
```


## Reference

### GithubProjectIssuesSDK

```python
from githubprojectissues_sdk import GithubProjectIssuesSDK

client = GithubProjectIssuesSDK(options)
```

Creates a new SDK client.

| Option | Type | Description |
| --- | --- | --- |
| `base` | `str` | Base URL of the API server. |
| `prefix` | `str` | URL path prefix prepended to all requests. |
| `suffix` | `str` | URL path suffix appended to all requests. |
| `feature` | `dict` | Feature activation flags. |
| `extend` | `list` | Additional Feature instances to load. |
| `system` | `dict` | System overrides (e.g. custom `fetch` function). |

### test

```python
client = GithubProjectIssuesSDK.test(testopts, sdkopts)
```

Creates a test-mode client with mock transport. Both arguments may be `None`.

### GithubProjectIssuesSDK methods

| Method | Signature | Description |
| --- | --- | --- |
| `options_map` | `() -> dict` | Deep copy of current SDK options. |
| `get_utility` | `() -> Utility` | Copy of the SDK utility object. |
| `prepare` | `(fetchargs) -> dict` | Build an HTTP request definition without sending. Raises on error. |
| `direct` | `(fetchargs) -> dict` | Build and send an HTTP request. Returns a result dict (branch on `ok`). |
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
| `list` | `(reqmatch, ctrl) -> list` | List entities matching the criteria. Raises on error. |
| `update` | `(reqdata, ctrl) -> any` | Update an existing entity. Raises on error. |
| `data_get` | `() -> dict` | Get entity data. |
| `data_set` | `(data)` | Set entity data. |
| `match_get` | `() -> dict` | Get entity match criteria. |
| `match_set` | `(match)` | Set entity match criteria. |
| `make` | `() -> Entity` | Create a new instance with the same options. |
| `get_name` | `() -> str` | Return the entity name. |

### Result shape

Entity operations return the bare result data (a `dict` for single-entity
ops, a `list` for `list`) and raise on error. Wrap calls in
`try`/`except` to handle failures.

The `direct()` escape hatch never raises — it returns a result `dict`
you branch on via `result["ok"]`:

| Key | Type | Description |
| --- | --- | --- |
| `ok` | `bool` | `True` if the HTTP status is 2xx. |
| `status` | `int` | HTTP status code. |
| `headers` | `dict` | Response headers. |
| `data` | `any` | Parsed JSON response body. |

On error, `ok` is `False` and `err` contains the error value.

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

Create an instance: `coffee = client.Coffee()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |
| `update(data)` | Update an existing entity. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `str` |  |
| `id` | `int` |  |
| `image` | `str` |  |
| `ingredient` | `list` |  |
| `title` | `str` |  |

#### Example: List

```python
coffees = client.Coffee().list()
```


### CoffeeDomain

Create an instance: `coffee_domain = client.CoffeeDomain()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `description` | `str` |  |
| `id` | `int` |  |
| `image` | `str` |  |
| `ingredient` | `list` |  |
| `title` | `str` |  |

#### Example: List

```python
coffee_domains = client.CoffeeDomain().list()
```


### DonateRestController

Create an instance: `donate_rest_controller = client.DonateRestController()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |

#### Example: List

```python
donate_rest_controllers = client.DonateRestController().list()
```


### PortfolioController

Create an instance: `portfolio_controller = client.PortfolioController()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |

#### Example: List

```python
portfolio_controllers = client.PortfolioController().list()
```


### RepositoryDetailDomain

Create an instance: `repository_detail_domain = client.RepositoryDetailDomain()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |
| `load(match)` | Load a single entity by match criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `app_home` | `str` |  |
| `description` | `str` |  |
| `full_name` | `str` |  |
| `issue_count` | `int` |  |
| `name` | `str` |  |
| `repo_url` | `str` |  |
| `topic` | `str` |  |

#### Example: Load

```python
repository_detail_domain = client.RepositoryDetailDomain().load()
```

#### Example: List

```python
repository_detail_domains = client.RepositoryDetailDomain().list()
```


### RepositoryIssueDomain

Create an instance: `repository_issue_domain = client.RepositoryIssueDomain()`

#### Operations

| Method | Description |
| --- | --- |
| `list()` | List entities, optionally matching the given criteria. |

#### Fields

| Field | Type | Description |
| --- | --- | --- |
| `body` | `str` |  |
| `label` | `list` |  |
| `number` | `str` |  |
| `state` | `str` |  |
| `title` | `str` |  |

#### Example: List

```python
repository_issue_domains = client.RepositoryIssueDomain().list()
```


### Version

Create an instance: `version = client.Version()`

#### Operations

| Method | Description |
| --- | --- |
| `load(match)` | Load a single entity by match criteria. |

#### Example: Load

```python
version = client.Version().load()
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

Features are the extension mechanism. A feature is a Python class
with hook methods named after pipeline stages (e.g. `PrePoint`,
`PreSpec`). Each method receives the context.

The SDK ships with built-in features:

- **TestFeature**: In-memory mock transport for testing without a live server

Features are initialized in order. Hooks fire in the order features
were added, so later features can override earlier ones.

### Data as dicts

The Python SDK uses plain dicts throughout rather than typed
objects. This mirrors the dynamic nature of the API and keeps the
SDK flexible — no code generation is needed when the API schema
changes.

Use `helpers.to_map()` to safely validate that a value is a dict.

### Module structure

```
py/
├── githubprojectissues_sdk.py         -- Main SDK module
├── config.py                    -- Configuration
├── features.py                  -- Feature factory
├── core/                        -- Core types and context
├── entity/                      -- Entity implementations
├── feature/                     -- Built-in features (Base, Test, Log)
├── utility/                     -- Utility functions and struct library
└── test/                        -- Test suites
```

The main module (`githubprojectissues_sdk`) exports the SDK class.
Import entity or utility modules directly only when needed.

### Entity state

Entity instances are stateful. After a successful `list`, the entity
stores the returned data and match criteria internally.

```python
coffee = client.Coffee()
coffee.list()

# coffee.data_get() now returns the coffee data from the last list
# coffee.match_get() returns the last match criteria
```

Call `make()` to create a fresh instance with the same configuration
but no stored state.

### Direct vs entity access

The entity interface handles URL construction, parameter placement,
and response parsing automatically. Use it for standard CRUD operations.

`direct()` gives full control over the HTTP request. Use it for
non-standard endpoints, bulk operations, or any path not modelled as
an entity. `prepare()` builds the request without sending it — useful
for debugging or custom transport.


## Full Reference

See [REFERENCE.md](REFERENCE.md) for complete API reference
documentation including all method signatures, entity field schemas,
and detailed usage examples.
