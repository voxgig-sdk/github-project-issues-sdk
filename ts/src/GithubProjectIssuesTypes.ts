// Typed models for the GithubProjectIssues SDK.
//
// GENERATED from the API model: main.kit.entity.<e>.fields[] and per-op
// params (op.<name>.points[].args.params[]). Field/param types come from the
// canonical type sentinels via @voxgig/sdkgen canonToType (source of truth:
// @voxgig/apidef VALID_CANON). Do not edit by hand.

export interface Coffee {
  description?: string
  id?: number
  image: string
  ingredient: any[]
  title: string
}

export interface CoffeeListMatch {
  description?: string
  id?: number
  image?: string
  ingredient?: any[]
  title?: string
}

export interface CoffeeUpdateData {
  description?: string
  id?: number
  image?: string
  ingredient?: any[]
  title?: string
}

export interface CoffeeDomain {
  description?: string
  id?: number
  image: string
  ingredient: any[]
  title: string
}

export interface CoffeeDomainListMatch {
  description?: string
  id?: number
  image?: string
  ingredient?: any[]
  title?: string
}

export interface DonateRestController {
}

export interface DonateRestControllerListMatch {
}

export interface PortfolioController {
}

export interface PortfolioControllerListMatch {
}

export interface RepositoryDetailDomain {
  app_home?: string
  description?: string
  full_name: string
  issue_count?: number
  name: string
  repo_url: string
  topic?: string
}

export interface RepositoryDetailDomainLoadMatch {
  username: string
}

export interface RepositoryDetailDomainListMatch {
  app_home?: string
  description?: string
  full_name?: string
  issue_count?: number
  name?: string
  repo_url?: string
  topic?: string
}

export interface RepositoryIssueDomain {
  body?: string
  label?: any[]
  number: string
  state?: string
  title: string
}

export interface RepositoryIssueDomainListMatch {
  repository: string
  username: string
}

export interface Version {
}

export interface VersionLoadMatch {
}

