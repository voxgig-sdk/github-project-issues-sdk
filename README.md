# GithubProjectIssues SDK

Personal portfolio backend exposing GitHub repo/issue lookups, a coffee list, and a donate hook

> TypeScript, Python, PHP, Golang, Ruby, Lua SDKs, a CLI, an interactive REPL, and an MCP server for AI agents — all generated from one OpenAPI spec by [@voxgig/sdkgen](https://github.com/voxgig/sdkgen).

## About iRonoc API

`iRonoc API` is the backend behind [ironoc.net](https://ironoc.net), the personal portfolio site of software engineer Conor Heffron. It is a small Spring-style service that mixes a couple of GitHub-proxy endpoints (used to populate the portfolio's repo and issues pages) with a handful of site-specific helpers — a coffee list, a donation hook, and a version probe.

What you can actually call:

- `GET /api/get-repo-detail?username={username}` — list a GitHub user's repositories (the portfolio uses this to render Conor's own repos).
- `GET /api/get-repo-issue/{owner}/{repo}/` — list issues for a specific GitHub repo (example: `conorheffron/ironoc`).
- Supporting controllers for the site itself: a coffee catalogue, a donation endpoint, a portfolio controller, and a version endpoint.

Operational notes: this is a personal site, not a managed platform. The freepublicapis.com catalogue page reports it as healthy with sub-500ms response times and **CORS disabled**, and no authentication is documented for the public endpoints. Interactive docs live at the [Swagger UI](https://ironoc.net/swagger-ui/index.html). Because the GitHub-facing endpoints ultimately read from GitHub, expect their behaviour and rate to track upstream GitHub limits.

## Try it

**TypeScript**
```bash
npm install github-project-issues
```

**Python**
```bash
pip install github-project-issues-sdk
```

**PHP**
```bash
composer require voxgig/github-project-issues-sdk
```

**Golang**
```bash
go get github.com/voxgig-sdk/github-project-issues-sdk/go
```

**Ruby**
```bash
gem install github-project-issues-sdk
```

**Lua**
```bash
luarocks install github-project-issues-sdk
```

## 30-second quickstart

### TypeScript

```ts
import { GithubProjectIssuesSDK } from 'github-project-issues'

const client = new GithubProjectIssuesSDK({})

// List all coffees
const coffees = await client.Coffee().list()
```

See the [TypeScript README](ts/README.md) for the
full guide, or scroll down for the same example in other languages.

## What's in the box

| Surface | Use it for | Path |
| --- | --- | --- |
| **SDK** (TypeScript, Python, PHP, Golang, Ruby, Lua) | App integration | `ts/` `py/` `php/` `go/` `rb/` `lua/` |
| **CLI** | Scripts, CI, ops, one-off API calls | `go-cli/` |
| **MCP server** | AI agents (Claude, Cursor, Cline) | `go-mcp/` |

## Use it from an AI agent (MCP)

The generated MCP server exposes every operation in this SDK as an
[MCP](https://modelcontextprotocol.io) tool that Claude, Cursor or Cline
can call directly. Build and register it:

```bash
cd go-mcp && go build -o github-project-issues-mcp .
```

Then add it to your agent's MCP config (Claude Desktop, Cursor, etc.):

```json
{
  "mcpServers": {
    "github-project-issues": {
      "command": "/abs/path/to/github-project-issues-mcp"
    }
  }
}
```

## Entities

The API exposes 7 entities:

| Entity | Description | API path |
| --- | --- | --- |
| **Coffee** | Items from the site's coffee catalogue, served by the coffee controller. | `/api/coffees` |
| **CoffeeDomain** | Domain/model shape used to describe a coffee entry returned by the coffee endpoints. | `/api/coffees-graph-ql` |
| **DonateRestController** | Endpoints behind the site's donate flow. | `/api/donate-items` |
| **PortfolioController** | Endpoints that drive the portfolio pages on ironoc.net. | `/api/portfolio-items` |
| **RepositoryDetailDomain** | Shape of a GitHub repository record returned by `GET /api/get-repo-detail?username={username}`. | `/api/get-repo-detail` |
| **RepositoryIssueDomain** | Shape of a GitHub issue record returned by `GET /api/get-repo-issue/{owner}/{repo}/`. | `/api/get-repo-issue/{username}/{repository}/` |
| **Version** | Version/build info endpoint for the deployed service. | `/api/application/version` |

Each entity supports the following operations where available: **load**,
**list**, **create**, **update**, and **remove**.

## Quickstart in other languages

### Python

```python
from githubprojectissues_sdk import GithubProjectIssuesSDK

client = GithubProjectIssuesSDK({})

# List all coffees
coffees, err = client.Coffee(None).list(None, None)
```

### PHP

```php
<?php
require_once 'githubprojectissues_sdk.php';

$client = new GithubProjectIssuesSDK([]);

// List all coffees
[$coffees, $err] = $client->Coffee(null)->list(null, null);
```

### Golang

```go
import sdk "github.com/voxgig-sdk/github-project-issues-sdk/go"

client := sdk.NewGithubProjectIssuesSDK(map[string]any{})

// List all coffees
coffees, err := client.Coffee(nil).List(nil, nil)
```

### Ruby

```ruby
require_relative "GithubProjectIssues_sdk"

client = GithubProjectIssuesSDK.new({})

# List all coffees
coffees, err = client.Coffee(nil).list(nil, nil)
```

### Lua

```lua
local sdk = require("github-project-issues_sdk")

local client = sdk.new({})

-- List all coffees
local coffees, err = client:Coffee(nil):list(nil, nil)
```

## Unit testing in offline mode

Every SDK ships a test mode that swaps the HTTP transport for an
in-memory mock, so unit tests run offline.

### TypeScript

```ts
const client = GithubProjectIssuesSDK.test()
const result = await client.Coffee().load({ id: 'test01' })
// result.ok === true, result.data contains mock data
```

### Python

```python
client = GithubProjectIssuesSDK.test(None, None)
result, err = client.Coffee(None).load(
    {"id": "test01"}, None
)
```

### PHP

```php
$client = GithubProjectIssuesSDK::test(null, null);
[$result, $err] = $client->Coffee(null)->load(
    ["id" => "test01"], null
);
```

### Golang

```go
client := sdk.TestSDK(nil, nil)
result, err := client.Coffee(nil).Load(
    map[string]any{"id": "test01"}, nil,
)
```

### Ruby

```ruby
client = GithubProjectIssuesSDK.test(nil, nil)
result, err = client.Coffee(nil).load(
  { "id" => "test01" }, nil
)
```

### Lua

```lua
local client = sdk.test(nil, nil)
local result, err = client:Coffee(nil):load(
  { id = "test01" }, nil
)
```

## How it works

Every SDK call runs the same five-stage pipeline:

1. **Point** — resolve the API endpoint from the operation definition.
2. **Spec** — build the HTTP specification (URL, method, headers, body).
3. **Request** — send the HTTP request.
4. **Response** — receive and parse the response.
5. **Result** — extract the result data for the caller.

A feature hook fires at each stage (e.g. `PrePoint`, `PreSpec`,
`PreRequest`), so features can inspect or modify the pipeline without
forking the SDK.

### Features

| Feature | Purpose |
| --- | --- |
| **TestFeature** | In-memory mock transport for testing without a live server |

Pass custom features via the `extend` option at construction time.

### Direct and Prepare

For endpoints the entity model doesn't cover, use the low-level methods:

- **`direct(fetchargs)`** — build and send an HTTP request in one step.
- **`prepare(fetchargs)`** — build the request without sending it.

Both accept a map with `path`, `method`, `params`, `query`,
`headers`, and `body`. See the [How-to guides](#how-to-guides) below.

## How-to guides

### Make a direct API call

When the entity interface does not cover an endpoint, use `direct`:

**TypeScript:**
```ts
const result = await client.direct({
  path: '/api/resource/{id}',
  method: 'GET',
  params: { id: 'example' },
})
console.log(result.data)
```

**Python:**
```python
result, err = client.direct({
    "path": "/api/resource/{id}",
    "method": "GET",
    "params": {"id": "example"},
})
```

**PHP:**
```php
[$result, $err] = $client->direct([
    "path" => "/api/resource/{id}",
    "method" => "GET",
    "params" => ["id" => "example"],
]);
```

**Go:**
```go
result, err := client.Direct(map[string]any{
    "path":   "/api/resource/{id}",
    "method": "GET",
    "params": map[string]any{"id": "example"},
})
```

**Ruby:**
```ruby
result, err = client.direct({
  "path" => "/api/resource/{id}",
  "method" => "GET",
  "params" => { "id" => "example" },
})
```

**Lua:**
```lua
local result, err = client:direct({
  path = "/api/resource/{id}",
  method = "GET",
  params = { id = "example" },
})
```

## Per-language documentation

- [TypeScript](ts/README.md)
- [Python](py/README.md)
- [PHP](php/README.md)
- [Golang](go/README.md)
- [Ruby](rb/README.md)
- [Lua](lua/README.md)

## Using the iRonoc API

- Upstream: [https://ironoc.net](https://ironoc.net)
- API docs: [https://ironoc.net/swagger-ui/index.html](https://ironoc.net/swagger-ui/index.html)

- Source code for the underlying project is published under the **GPL-3.0 license**.
- The API itself is hosted on a personal site (ironoc.net) run by an individual developer; treat availability and rate as best-effort.
- No published terms of service or commercial SLA — if you build on it, vendor the data or proxy it.
- CORS is disabled on the documented endpoints, so calls are expected to come from a server, not a browser.

---

Generated from the iRonoc API OpenAPI spec by [@voxgig/sdkgen](https://github.com/voxgig/sdkgen).
