<?php
declare(strict_types=1);

// GithubProjectIssues SDK

require_once __DIR__ . '/utility/struct/Struct.php';
require_once __DIR__ . '/core/UtilityType.php';
require_once __DIR__ . '/core/Spec.php';
require_once __DIR__ . '/core/Helpers.php';

// Load utility registration
require_once __DIR__ . '/utility/Register.php';

// Load config and features
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/feature/BaseFeature.php';
require_once __DIR__ . '/features.php';

use Voxgig\Struct\Struct;

class GithubProjectIssuesSDK
{
    public string $mode;
    public array $features;
    public ?array $options;

    private $_utility;
    private $_rootctx;

    public function __construct(array $options = [])
    {
        $this->mode = "live";
        $this->features = [];
        $this->options = null;

        $utility = new GithubProjectIssuesUtility();
        $this->_utility = $utility;

        $config = GithubProjectIssuesConfig::make_config();

        $this->_rootctx = ($utility->make_context)([
            "client" => $this,
            "utility" => $utility,
            "config" => $config,
            "options" => $options ?? [],
            "shared" => [],
        ], null);

        $this->options = ($utility->make_options)($this->_rootctx);

        if (Struct::getpath($this->options, "feature.test.active") === true) {
            $this->mode = "test";
        }

        $this->_rootctx->options = $this->options;

        // Add features from config.
        $feature_opts = GithubProjectIssuesHelpers::to_map(Struct::getprop($this->options, "feature"));
        if ($feature_opts) {
            $items = Struct::items($feature_opts);
            if ($items) {
                foreach ($items as $item) {
                    $fname = $item[0];
                    $fopts = GithubProjectIssuesHelpers::to_map($item[1]);
                    if ($fopts && isset($fopts["active"]) && $fopts["active"] === true) {
                        ($utility->feature_add)($this->_rootctx, GithubProjectIssuesFeatures::make_feature($fname));
                    }
                }
            }
        }

        // Add extension features.
        $extend_val = Struct::getprop($this->options, "extend");
        if (is_array($extend_val)) {
            foreach ($extend_val as $f) {
                if (is_object($f) && method_exists($f, 'get_name')) {
                    ($utility->feature_add)($this->_rootctx, $f);
                }
            }
        }

        // Initialize features.
        foreach ($this->features as $f) {
            ($utility->feature_init)($this->_rootctx, $f);
        }

        ($utility->feature_hook)($this->_rootctx, "PostConstruct");
    }

    public function options_map(): array
    {
        $out = Struct::clone($this->options);
        return is_array($out) ? $out : [];
    }

    public function get_utility()
    {
        return GithubProjectIssuesUtility::copy($this->_utility);
    }

    public function get_root_ctx()
    {
        return $this->_rootctx;
    }

    public function prepare(array $fetchargs = []): mixed
    {
        $utility = $this->_utility;
        $fetchargs = $fetchargs ?? [];

        $ctrl = GithubProjectIssuesHelpers::to_map(Struct::getprop($fetchargs, "ctrl")) ?? [];

        $ctx = ($utility->make_context)([
            "opname" => "prepare",
            "ctrl" => $ctrl,
        ], $this->_rootctx);

        $opts = $this->options;
        $path = Struct::getprop($fetchargs, "path") ?? "";
        $path = is_string($path) ? $path : "";
        $method_val = Struct::getprop($fetchargs, "method") ?? "GET";
        $method_val = is_string($method_val) ? $method_val : "GET";
        $params = GithubProjectIssuesHelpers::to_map(Struct::getprop($fetchargs, "params")) ?? [];
        $query = GithubProjectIssuesHelpers::to_map(Struct::getprop($fetchargs, "query")) ?? [];
        $headers = ($utility->prepare_headers)($ctx);

        $base = Struct::getprop($opts, "base") ?? "";
        $base = is_string($base) ? $base : "";
        $prefix = Struct::getprop($opts, "prefix") ?? "";
        $prefix = is_string($prefix) ? $prefix : "";
        $suffix = Struct::getprop($opts, "suffix") ?? "";
        $suffix = is_string($suffix) ? $suffix : "";

        $ctx->spec = new GithubProjectIssuesSpec([
            "base" => $base, "prefix" => $prefix, "suffix" => $suffix,
            "path" => $path, "method" => $method_val,
            "params" => $params, "query" => $query, "headers" => $headers,
            "body" => Struct::getprop($fetchargs, "body"),
            "step" => "start",
        ]);

        // Merge user-provided headers.
        $uh = Struct::getprop($fetchargs, "headers");
        if (is_array($uh)) {
            foreach ($uh as $k => $v) {
                $ctx->spec->headers[$k] = $v;
            }
        }

        [$_, $err] = ($utility->prepare_auth)($ctx);
        if ($err) {
            return ($utility->make_error)($ctx, $err);
        }

        [$fetchdef, $fd_err] = ($utility->make_fetch_def)($ctx);
        if ($fd_err) {
            return ($utility->make_error)($ctx, $fd_err);
        }
        return $fetchdef;
    }

    public function direct(array $fetchargs = []): mixed
    {
        $utility = $this->_utility;

        // direct() is the raw-HTTP escape hatch: it never throws, it returns
        // an {ok, err, ...} dict. prepare() now raises on error, so catch it
        // and surface the failure through the dict instead.
        try {
            $fetchdef = $this->prepare($fetchargs);
        } catch (\Throwable $err) {
            return ["ok" => false, "err" => $err];
        }

        $fetchargs = $fetchargs ?? [];
        $ctrl = GithubProjectIssuesHelpers::to_map(Struct::getprop($fetchargs, "ctrl")) ?? [];

        $ctx = ($utility->make_context)([
            "opname" => "direct",
            "ctrl" => $ctrl,
        ], $this->_rootctx);

        $url = $fetchdef["url"] ?? "";
        [$fetched, $fetch_err] = ($utility->fetcher)($ctx, $url, $fetchdef);

        if ($fetch_err) {
            return ["ok" => false, "err" => $fetch_err];
        }

        if ($fetched === null) {
            return [
                "ok" => false,
                "err" => $ctx->make_error("direct_no_response", "response: undefined"),
            ];
        }

        if (is_array($fetched)) {
            $status = GithubProjectIssuesHelpers::to_int(Struct::getprop($fetched, "status"));
            $headers = Struct::getprop($fetched, "headers") ?? [];

            // No-body responses (204, 304) and explicit zero content-length
            // must skip JSON parsing — calling json() on an empty body errors.
            $content_length = is_array($headers) ? ($headers["content-length"] ?? null) : null;
            $no_body = $status === 204 || $status === 304 || (string)$content_length === "0";

            $json_data = null;
            if (!$no_body) {
                $jf = Struct::getprop($fetched, "json");
                if (is_callable($jf)) {
                    try {
                        $json_data = $jf();
                    } catch (\Throwable $e) {
                        // Non-JSON body — leave data null but keep status/ok.
                        $json_data = null;
                    }
                }
            }

            return [
                "ok" => $status >= 200 && $status < 300,
                "status" => $status,
                "headers" => Struct::getprop($fetched, "headers"),
                "data" => $json_data,
            ];
        }

        return [
            "ok" => false,
            "err" => $ctx->make_error("direct_invalid", "invalid response type"),
        ];
    }


    private $_coffee = null;

    // Idiomatic facade: $client->coffee()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias Coffee() (PHP method
    // names are case-insensitive).
    public function coffee($data = null)
    {
        require_once __DIR__ . '/entity/coffee_entity.php';
        if ($data === null) {
            if ($this->_coffee === null) {
                $this->_coffee = new CoffeeEntity($this, null);
            }
            return $this->_coffee;
        }
        return new CoffeeEntity($this, $data);
    }


    private $_coffee_domain = null;

    // Idiomatic facade: $client->coffee_domain()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias CoffeeDomain() (PHP method
    // names are case-insensitive).
    public function coffee_domain($data = null)
    {
        require_once __DIR__ . '/entity/coffee_domain_entity.php';
        if ($data === null) {
            if ($this->_coffee_domain === null) {
                $this->_coffee_domain = new CoffeeDomainEntity($this, null);
            }
            return $this->_coffee_domain;
        }
        return new CoffeeDomainEntity($this, $data);
    }


    private $_donate_rest_controller = null;

    // Idiomatic facade: $client->donate_rest_controller()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias DonateRestController() (PHP method
    // names are case-insensitive).
    public function donate_rest_controller($data = null)
    {
        require_once __DIR__ . '/entity/donate_rest_controller_entity.php';
        if ($data === null) {
            if ($this->_donate_rest_controller === null) {
                $this->_donate_rest_controller = new DonateRestControllerEntity($this, null);
            }
            return $this->_donate_rest_controller;
        }
        return new DonateRestControllerEntity($this, $data);
    }


    private $_portfolio_controller = null;

    // Idiomatic facade: $client->portfolio_controller()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias PortfolioController() (PHP method
    // names are case-insensitive).
    public function portfolio_controller($data = null)
    {
        require_once __DIR__ . '/entity/portfolio_controller_entity.php';
        if ($data === null) {
            if ($this->_portfolio_controller === null) {
                $this->_portfolio_controller = new PortfolioControllerEntity($this, null);
            }
            return $this->_portfolio_controller;
        }
        return new PortfolioControllerEntity($this, $data);
    }


    private $_repository_detail_domain = null;

    // Idiomatic facade: $client->repository_detail_domain()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias RepositoryDetailDomain() (PHP method
    // names are case-insensitive).
    public function repository_detail_domain($data = null)
    {
        require_once __DIR__ . '/entity/repository_detail_domain_entity.php';
        if ($data === null) {
            if ($this->_repository_detail_domain === null) {
                $this->_repository_detail_domain = new RepositoryDetailDomainEntity($this, null);
            }
            return $this->_repository_detail_domain;
        }
        return new RepositoryDetailDomainEntity($this, $data);
    }


    private $_repository_issue_domain = null;

    // Idiomatic facade: $client->repository_issue_domain()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias RepositoryIssueDomain() (PHP method
    // names are case-insensitive).
    public function repository_issue_domain($data = null)
    {
        require_once __DIR__ . '/entity/repository_issue_domain_entity.php';
        if ($data === null) {
            if ($this->_repository_issue_domain === null) {
                $this->_repository_issue_domain = new RepositoryIssueDomainEntity($this, null);
            }
            return $this->_repository_issue_domain;
        }
        return new RepositoryIssueDomainEntity($this, $data);
    }


    private $_version = null;

    // Idiomatic facade: $client->version()->list() / ->load(["id" => ...]).
    // Also serves the deprecated PascalCase alias Version() (PHP method
    // names are case-insensitive).
    public function version($data = null)
    {
        require_once __DIR__ . '/entity/version_entity.php';
        if ($data === null) {
            if ($this->_version === null) {
                $this->_version = new VersionEntity($this, null);
            }
            return $this->_version;
        }
        return new VersionEntity($this, $data);
    }



    public static function test(?array $testopts = null, ?array $sdkopts = null): self
    {
        $sdkopts = $sdkopts ?? [];
        $sdkopts = Struct::clone($sdkopts);
        $sdkopts = is_array($sdkopts) ? $sdkopts : [];

        $testopts = $testopts ?? [];
        $testopts = Struct::clone($testopts);
        $testopts = is_array($testopts) ? $testopts : [];
        $testopts["active"] = true;

        if (!isset($sdkopts["feature"])) {
            $sdkopts["feature"] = [];
        }
        $sdkopts["feature"]["test"] = $testopts;

        $sdk = new GithubProjectIssuesSDK($sdkopts);
        $sdk->mode = "test";
        return $sdk;
    }
}
