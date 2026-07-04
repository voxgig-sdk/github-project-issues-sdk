# Typed models for the GithubProjectIssues SDK.
#
# GENERATED from the API model: main.kit.entity.<e>.fields[] and per-op
# params (op.<name>.points[].args.params[]). Field/param types come from the
# canonical type sentinels via @voxgig/sdkgen canonToType (source of truth:
# @voxgig/apidef VALID_CANON). Do not edit by hand.

from __future__ import annotations

from dataclasses import dataclass
from typing import Optional, Any


@dataclass
class Coffee:
    image: str
    ingredient: list
    title: str
    description: Optional[str] = None
    id: Optional[int] = None


@dataclass
class CoffeeListMatch:
    description: Optional[str] = None
    id: Optional[int] = None
    image: Optional[str] = None
    ingredient: Optional[list] = None
    title: Optional[str] = None


@dataclass
class CoffeeUpdateData:
    description: Optional[str] = None
    id: Optional[int] = None
    image: Optional[str] = None
    ingredient: Optional[list] = None
    title: Optional[str] = None


@dataclass
class CoffeeDomain:
    image: str
    ingredient: list
    title: str
    description: Optional[str] = None
    id: Optional[int] = None


@dataclass
class CoffeeDomainListMatch:
    description: Optional[str] = None
    id: Optional[int] = None
    image: Optional[str] = None
    ingredient: Optional[list] = None
    title: Optional[str] = None


@dataclass
class DonateRestController:
    pass


@dataclass
class DonateRestControllerListMatch:
    pass


@dataclass
class PortfolioController:
    pass


@dataclass
class PortfolioControllerListMatch:
    pass


@dataclass
class RepositoryDetailDomain:
    full_name: str
    name: str
    repo_url: str
    app_home: Optional[str] = None
    description: Optional[str] = None
    issue_count: Optional[int] = None
    topic: Optional[str] = None


@dataclass
class RepositoryDetailDomainLoadMatch:
    username: str


@dataclass
class RepositoryDetailDomainListMatch:
    app_home: Optional[str] = None
    description: Optional[str] = None
    full_name: Optional[str] = None
    issue_count: Optional[int] = None
    name: Optional[str] = None
    repo_url: Optional[str] = None
    topic: Optional[str] = None


@dataclass
class RepositoryIssueDomain:
    number: str
    title: str
    body: Optional[str] = None
    label: Optional[list] = None
    state: Optional[str] = None


@dataclass
class RepositoryIssueDomainListMatch:
    repository: str
    username: str


@dataclass
class Version:
    pass


@dataclass
class VersionLoadMatch:
    pass

