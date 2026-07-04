-- Typed models for the GithubProjectIssues SDK (LuaLS annotations).
--
-- GENERATED from the API model: main.kit.entity.<e>.fields[] and per-op
-- params (op.<name>.points[].args.params[]). Field/param types come from the
-- canonical type sentinels via @voxgig/sdkgen canonToType (source of truth:
-- @voxgig/apidef VALID_CANON). Annotations only — no runtime effect. Do not
-- edit by hand.

---@class Coffee
---@field description? string
---@field id? number
---@field image string
---@field ingredient table
---@field title string

---@class CoffeeListMatch

---@class CoffeeUpdateData

---@class CoffeeDomain
---@field description? string
---@field id? number
---@field image string
---@field ingredient table
---@field title string

---@class CoffeeDomainListMatch

---@class DonateRestController

---@class DonateRestControllerListMatch

---@class PortfolioController

---@class PortfolioControllerListMatch

---@class RepositoryDetailDomain
---@field app_home? string
---@field description? string
---@field full_name string
---@field issue_count? number
---@field name string
---@field repo_url string
---@field topic? string

---@class RepositoryDetailDomainLoadMatch
---@field username string

---@class RepositoryDetailDomainListMatch

---@class RepositoryIssueDomain
---@field body? string
---@field label? table
---@field number string
---@field state? string
---@field title string

---@class RepositoryIssueDomainListMatch
---@field repository string
---@field username string

---@class Version

---@class VersionLoadMatch

local M = {}

return M
