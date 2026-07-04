# frozen_string_literal: true

# Typed models for the GithubProjectIssues SDK.
#
# GENERATED from the API model: main.kit.entity.<e>.fields[] and per-op
# params (op.<name>.points[].args.params[]). Member types come from the
# canonical type sentinels via @voxgig/sdkgen canonToType (source of truth:
# @voxgig/apidef VALID_CANON). Ruby types are unenforced; these YARD
# annotations document the shapes. Do not edit by hand.

# Coffee entity data model.
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] id
#   @return [Integer, nil]
#
# @!attribute [rw] image
#   @return [String]
#
# @!attribute [rw] ingredient
#   @return [Array]
#
# @!attribute [rw] title
#   @return [String]
Coffee = Struct.new(
  :description,
  :id,
  :image,
  :ingredient,
  :title,
  keyword_init: true
)

# Match filter for Coffee#list (any subset of Coffee fields).
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] id
#   @return [Integer, nil]
#
# @!attribute [rw] image
#   @return [String, nil]
#
# @!attribute [rw] ingredient
#   @return [Array, nil]
#
# @!attribute [rw] title
#   @return [String, nil]
CoffeeListMatch = Struct.new(
  :description,
  :id,
  :image,
  :ingredient,
  :title,
  keyword_init: true
)

# Match filter for Coffee#update (any subset of Coffee fields).
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] id
#   @return [Integer, nil]
#
# @!attribute [rw] image
#   @return [String, nil]
#
# @!attribute [rw] ingredient
#   @return [Array, nil]
#
# @!attribute [rw] title
#   @return [String, nil]
CoffeeUpdateData = Struct.new(
  :description,
  :id,
  :image,
  :ingredient,
  :title,
  keyword_init: true
)

# CoffeeDomain entity data model.
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] id
#   @return [Integer, nil]
#
# @!attribute [rw] image
#   @return [String]
#
# @!attribute [rw] ingredient
#   @return [Array]
#
# @!attribute [rw] title
#   @return [String]
CoffeeDomain = Struct.new(
  :description,
  :id,
  :image,
  :ingredient,
  :title,
  keyword_init: true
)

# Match filter for CoffeeDomain#list (any subset of CoffeeDomain fields).
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] id
#   @return [Integer, nil]
#
# @!attribute [rw] image
#   @return [String, nil]
#
# @!attribute [rw] ingredient
#   @return [Array, nil]
#
# @!attribute [rw] title
#   @return [String, nil]
CoffeeDomainListMatch = Struct.new(
  :description,
  :id,
  :image,
  :ingredient,
  :title,
  keyword_init: true
)

# DonateRestController entity data model.
class DonateRestController
end

# Match filter for DonateRestController#list (any subset of DonateRestController fields).
class DonateRestControllerListMatch
end

# PortfolioController entity data model.
class PortfolioController
end

# Match filter for PortfolioController#list (any subset of PortfolioController fields).
class PortfolioControllerListMatch
end

# RepositoryDetailDomain entity data model.
#
# @!attribute [rw] app_home
#   @return [String, nil]
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] full_name
#   @return [String]
#
# @!attribute [rw] issue_count
#   @return [Integer, nil]
#
# @!attribute [rw] name
#   @return [String]
#
# @!attribute [rw] repo_url
#   @return [String]
#
# @!attribute [rw] topic
#   @return [String, nil]
RepositoryDetailDomain = Struct.new(
  :app_home,
  :description,
  :full_name,
  :issue_count,
  :name,
  :repo_url,
  :topic,
  keyword_init: true
)

# Request payload for RepositoryDetailDomain#load.
#
# @!attribute [rw] username
#   @return [String]
RepositoryDetailDomainLoadMatch = Struct.new(
  :username,
  keyword_init: true
)

# Match filter for RepositoryDetailDomain#list (any subset of RepositoryDetailDomain fields).
#
# @!attribute [rw] app_home
#   @return [String, nil]
#
# @!attribute [rw] description
#   @return [String, nil]
#
# @!attribute [rw] full_name
#   @return [String, nil]
#
# @!attribute [rw] issue_count
#   @return [Integer, nil]
#
# @!attribute [rw] name
#   @return [String, nil]
#
# @!attribute [rw] repo_url
#   @return [String, nil]
#
# @!attribute [rw] topic
#   @return [String, nil]
RepositoryDetailDomainListMatch = Struct.new(
  :app_home,
  :description,
  :full_name,
  :issue_count,
  :name,
  :repo_url,
  :topic,
  keyword_init: true
)

# RepositoryIssueDomain entity data model.
#
# @!attribute [rw] body
#   @return [String, nil]
#
# @!attribute [rw] label
#   @return [Array, nil]
#
# @!attribute [rw] number
#   @return [String]
#
# @!attribute [rw] state
#   @return [String, nil]
#
# @!attribute [rw] title
#   @return [String]
RepositoryIssueDomain = Struct.new(
  :body,
  :label,
  :number,
  :state,
  :title,
  keyword_init: true
)

# Request payload for RepositoryIssueDomain#list.
#
# @!attribute [rw] repository
#   @return [String]
#
# @!attribute [rw] username
#   @return [String]
RepositoryIssueDomainListMatch = Struct.new(
  :repository,
  :username,
  keyword_init: true
)

# Version entity data model.
class Version
end

# Match filter for Version#load (any subset of Version fields).
class VersionLoadMatch
end

