# Typed models for the GithubProjectIssues SDK.
#
# GENERATED from the API model: main.kit.entity.<e>.fields[] and per-op
# params (op.<name>.points[].args.params[]). Field/param types come from the
# canonical type sentinels via @voxgig/sdkgen canonToType (source of truth:
# @voxgig/apidef VALID_CANON). Do not edit by hand.
#
# These are TypedDicts, not dataclasses: the SDK ops return/accept plain dicts
# at runtime, and a TypedDict IS a dict shape, so the types match the runtime.
# Optional (req:false) keys are modelled as TypedDict key-optionality
# (total=False), split into a required base + total=False subclass when a type
# has both required and optional keys.

from __future__ import annotations

from typing import TypedDict, Any


class CoffeeRequired(TypedDict):
    image: str
    ingredient: list
    title: str


class Coffee(CoffeeRequired, total=False):
    description: str
    id: int


class CoffeeListMatch(TypedDict, total=False):
    description: str
    id: int
    image: str
    ingredient: list
    title: str


class CoffeeUpdateData(TypedDict, total=False):
    description: str
    id: int
    image: str
    ingredient: list
    title: str


class CoffeeDomainRequired(TypedDict):
    image: str
    ingredient: list
    title: str


class CoffeeDomain(CoffeeDomainRequired, total=False):
    description: str
    id: int


class CoffeeDomainListMatch(TypedDict, total=False):
    description: str
    id: int
    image: str
    ingredient: list
    title: str


class DonateRestController(TypedDict):
    pass


class DonateRestControllerListMatch(TypedDict):
    pass


class PortfolioController(TypedDict):
    pass


class PortfolioControllerListMatch(TypedDict):
    pass


class RepositoryDetailDomainRequired(TypedDict):
    full_name: str
    name: str
    repo_url: str


class RepositoryDetailDomain(RepositoryDetailDomainRequired, total=False):
    app_home: str
    description: str
    issue_count: int
    topic: str


class RepositoryDetailDomainLoadMatch(TypedDict):
    username: str


class RepositoryDetailDomainListMatch(TypedDict, total=False):
    app_home: str
    description: str
    full_name: str
    issue_count: int
    name: str
    repo_url: str
    topic: str


class RepositoryIssueDomainRequired(TypedDict):
    number: str
    title: str


class RepositoryIssueDomain(RepositoryIssueDomainRequired, total=False):
    body: str
    label: list
    state: str


class RepositoryIssueDomainListMatch(TypedDict):
    repository: str
    username: str


class Version(TypedDict):
    pass


class VersionLoadMatch(TypedDict):
    pass
