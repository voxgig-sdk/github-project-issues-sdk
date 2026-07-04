# GithubProjectIssues SDK

from utility.voxgig_struct import voxgig_struct as vs
from core.utility_type import GithubProjectIssuesUtility
from core.spec import GithubProjectIssuesSpec
from core import helpers

# Load utility registration (populates Utility._registrar)
from utility import register

# Load features
from feature.base_feature import GithubProjectIssuesBaseFeature
from features import _make_feature


class GithubProjectIssuesSDK:

    def __init__(self, options=None):
        self.mode = "live"
        self.features = []
        self.options = None

        utility = GithubProjectIssuesUtility()
        self._utility = utility

        from config import make_config
        config = make_config()

        self._rootctx = utility.make_context({
            "client": self,
            "utility": utility,
            "config": config,
            "options": options if options is not None else {},
            "shared": {},
        }, None)

        self.options = utility.make_options(self._rootctx)

        if vs.getpath(self.options, "feature.test.active") is True:
            self.mode = "test"

        self._rootctx.options = self.options

        # Add features from config.
        feature_opts = helpers.to_map(vs.getprop(self.options, "feature"))
        if feature_opts is not None:
            feature_items = vs.items(feature_opts)
            if feature_items is not None:
                for item in feature_items:
                    fname = item[0]
                    fopts = helpers.to_map(item[1])
                    if fopts is not None and fopts.get("active") is True:
                        utility.feature_add(self._rootctx, _make_feature(fname))

        # Add extension features.
        extend = vs.getprop(self.options, "extend")
        if isinstance(extend, list):
            for f in extend:
                if isinstance(f, dict) or (hasattr(f, "get_name") and callable(f.get_name)):
                    utility.feature_add(self._rootctx, f)

        # Initialize features.
        for f in self.features:
            utility.feature_init(self._rootctx, f)

        utility.feature_hook(self._rootctx, "PostConstruct")

        # #BuildFeatures

    def options_map(self):
        out = vs.clone(self.options)
        if isinstance(out, dict):
            return out
        return {}

    def get_utility(self):
        return GithubProjectIssuesUtility.copy(self._utility)

    def get_root_ctx(self):
        return self._rootctx

    def prepare(self, fetchargs=None):
        utility = self._utility

        if fetchargs is None:
            fetchargs = {}

        ctrl = helpers.to_map(vs.getprop(fetchargs, "ctrl"))
        if ctrl is None:
            ctrl = {}

        ctx = utility.make_context({
            "opname": "prepare",
            "ctrl": ctrl,
        }, self._rootctx)

        options = self.options

        path = vs.getprop(fetchargs, "path") or ""
        if not isinstance(path, str):
            path = ""

        method = vs.getprop(fetchargs, "method") or "GET"
        if not isinstance(method, str):
            method = "GET"

        params = helpers.to_map(vs.getprop(fetchargs, "params"))
        if params is None:
            params = {}
        query = helpers.to_map(vs.getprop(fetchargs, "query"))
        if query is None:
            query = {}

        headers = utility.prepare_headers(ctx)

        base = vs.getprop(options, "base") or ""
        if not isinstance(base, str):
            base = ""
        prefix = vs.getprop(options, "prefix") or ""
        if not isinstance(prefix, str):
            prefix = ""
        suffix = vs.getprop(options, "suffix") or ""
        if not isinstance(suffix, str):
            suffix = ""

        ctx.spec = GithubProjectIssuesSpec({
            "base": base,
            "prefix": prefix,
            "suffix": suffix,
            "path": path,
            "method": method,
            "params": params,
            "query": query,
            "headers": headers,
            "body": vs.getprop(fetchargs, "body"),
            "step": "start",
        })

        # Merge user-provided headers.
        uh = vs.getprop(fetchargs, "headers")
        if isinstance(uh, dict):
            for k, v in uh.items():
                ctx.spec.headers[k] = v

        _, err = utility.prepare_auth(ctx)
        if err is not None:
            raise err

        fetchdef, err = utility.make_fetch_def(ctx)
        if err is not None:
            raise err

        return fetchdef

    def direct(self, fetchargs=None):
        utility = self._utility

        try:
            fetchdef = self.prepare(fetchargs)
        except Exception as err:
            # direct() is the raw-HTTP escape hatch: it never raises, it
            # returns a result object callers branch on via result["ok"].
            return {"ok": False, "err": err}

        if fetchargs is None:
            fetchargs = {}
        ctrl = helpers.to_map(vs.getprop(fetchargs, "ctrl"))
        if ctrl is None:
            ctrl = {}

        ctx = utility.make_context({
            "opname": "direct",
            "ctrl": ctrl,
        }, self._rootctx)

        url = fetchdef.get("url", "")
        fetched, fetch_err = utility.fetcher(ctx, url, fetchdef)

        if fetch_err is not None:
            return {"ok": False, "err": fetch_err}

        if fetched is None:
            return {
                "ok": False,
                "err": ctx.make_error("direct_no_response", "response: undefined"),
            }

        if isinstance(fetched, dict):
            status = helpers.to_int(vs.getprop(fetched, "status"))
            headers = vs.getprop(fetched, "headers") or {}

            # No-body responses (204, 304) and explicit zero content-length
            # must skip JSON parsing — calling json() on an empty body raises.
            content_length = None
            if isinstance(headers, dict):
                content_length = headers.get("content-length")
            no_body = status in (204, 304) or str(content_length) == "0"

            json_data = None
            if not no_body:
                jf = vs.getprop(fetched, "json")
                if callable(jf):
                    try:
                        json_data = jf()
                    except Exception:
                        # Non-JSON body (e.g. text/plain, text/html). Surface
                        # status + headers but leave data as None.
                        json_data = None

            return {
                "ok": status >= 200 and status < 300,
                "status": status,
                "headers": headers,
                "data": json_data,
            }

        return {
            "ok": False,
            "err": ctx.make_error("direct_invalid", "invalid response type"),
        }


    @property
    def coffee(self):
        """Idiomatic facade: client.coffee.list() / client.coffee.load({"id": ...})."""
        from entity.coffee_entity import CoffeeEntity
        cached = getattr(self, "_coffee", None)
        if cached is None:
            cached = CoffeeEntity(self, None)
            self._coffee = cached
        return cached

    def Coffee(self, data=None):
        # Deprecated: use client.coffee instead.
        from entity.coffee_entity import CoffeeEntity
        return CoffeeEntity(self, data)


    @property
    def coffee_domain(self):
        """Idiomatic facade: client.coffee_domain.list() / client.coffee_domain.load({"id": ...})."""
        from entity.coffee_domain_entity import CoffeeDomainEntity
        cached = getattr(self, "_coffee_domain", None)
        if cached is None:
            cached = CoffeeDomainEntity(self, None)
            self._coffee_domain = cached
        return cached

    def CoffeeDomain(self, data=None):
        # Deprecated: use client.coffee_domain instead.
        from entity.coffee_domain_entity import CoffeeDomainEntity
        return CoffeeDomainEntity(self, data)


    @property
    def donate_rest_controller(self):
        """Idiomatic facade: client.donate_rest_controller.list() / client.donate_rest_controller.load({"id": ...})."""
        from entity.donate_rest_controller_entity import DonateRestControllerEntity
        cached = getattr(self, "_donate_rest_controller", None)
        if cached is None:
            cached = DonateRestControllerEntity(self, None)
            self._donate_rest_controller = cached
        return cached

    def DonateRestController(self, data=None):
        # Deprecated: use client.donate_rest_controller instead.
        from entity.donate_rest_controller_entity import DonateRestControllerEntity
        return DonateRestControllerEntity(self, data)


    @property
    def portfolio_controller(self):
        """Idiomatic facade: client.portfolio_controller.list() / client.portfolio_controller.load({"id": ...})."""
        from entity.portfolio_controller_entity import PortfolioControllerEntity
        cached = getattr(self, "_portfolio_controller", None)
        if cached is None:
            cached = PortfolioControllerEntity(self, None)
            self._portfolio_controller = cached
        return cached

    def PortfolioController(self, data=None):
        # Deprecated: use client.portfolio_controller instead.
        from entity.portfolio_controller_entity import PortfolioControllerEntity
        return PortfolioControllerEntity(self, data)


    @property
    def repository_detail_domain(self):
        """Idiomatic facade: client.repository_detail_domain.list() / client.repository_detail_domain.load({"id": ...})."""
        from entity.repository_detail_domain_entity import RepositoryDetailDomainEntity
        cached = getattr(self, "_repository_detail_domain", None)
        if cached is None:
            cached = RepositoryDetailDomainEntity(self, None)
            self._repository_detail_domain = cached
        return cached

    def RepositoryDetailDomain(self, data=None):
        # Deprecated: use client.repository_detail_domain instead.
        from entity.repository_detail_domain_entity import RepositoryDetailDomainEntity
        return RepositoryDetailDomainEntity(self, data)


    @property
    def repository_issue_domain(self):
        """Idiomatic facade: client.repository_issue_domain.list() / client.repository_issue_domain.load({"id": ...})."""
        from entity.repository_issue_domain_entity import RepositoryIssueDomainEntity
        cached = getattr(self, "_repository_issue_domain", None)
        if cached is None:
            cached = RepositoryIssueDomainEntity(self, None)
            self._repository_issue_domain = cached
        return cached

    def RepositoryIssueDomain(self, data=None):
        # Deprecated: use client.repository_issue_domain instead.
        from entity.repository_issue_domain_entity import RepositoryIssueDomainEntity
        return RepositoryIssueDomainEntity(self, data)


    @property
    def version(self):
        """Idiomatic facade: client.version.list() / client.version.load({"id": ...})."""
        from entity.version_entity import VersionEntity
        cached = getattr(self, "_version", None)
        if cached is None:
            cached = VersionEntity(self, None)
            self._version = cached
        return cached

    def Version(self, data=None):
        # Deprecated: use client.version instead.
        from entity.version_entity import VersionEntity
        return VersionEntity(self, data)



    @classmethod
    def test(cls, testopts=None, sdkopts=None):
        if sdkopts is None:
            sdkopts = {}
        sdkopts = vs.clone(sdkopts)
        if not isinstance(sdkopts, dict):
            sdkopts = {}

        if testopts is None:
            testopts = {}
        testopts = vs.clone(testopts)
        if not isinstance(testopts, dict):
            testopts = {}
        testopts["active"] = True

        vs.setpath(sdkopts, "feature.test", testopts)

        sdk = cls(sdkopts)
        sdk.mode = "test"

        return sdk
