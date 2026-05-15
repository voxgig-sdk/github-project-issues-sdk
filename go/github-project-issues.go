package voxgiggithubprojectissuessdk

import (
	"github.com/voxgig-sdk/github-project-issues-sdk/core"
	"github.com/voxgig-sdk/github-project-issues-sdk/entity"
	"github.com/voxgig-sdk/github-project-issues-sdk/feature"
	_ "github.com/voxgig-sdk/github-project-issues-sdk/utility"
)

// Type aliases preserve external API.
type GithubProjectIssuesSDK = core.GithubProjectIssuesSDK
type Context = core.Context
type Utility = core.Utility
type Feature = core.Feature
type Entity = core.Entity
type GithubProjectIssuesEntity = core.GithubProjectIssuesEntity
type FetcherFunc = core.FetcherFunc
type Spec = core.Spec
type Result = core.Result
type Response = core.Response
type Operation = core.Operation
type Control = core.Control
type GithubProjectIssuesError = core.GithubProjectIssuesError

// BaseFeature from feature package.
type BaseFeature = feature.BaseFeature

func init() {
	core.NewBaseFeatureFunc = func() core.Feature {
		return feature.NewBaseFeature()
	}
	core.NewTestFeatureFunc = func() core.Feature {
		return feature.NewTestFeature()
	}
	core.NewCoffeeEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewCoffeeEntity(client, entopts)
	}
	core.NewCoffeeDomainEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewCoffeeDomainEntity(client, entopts)
	}
	core.NewDonateRestControllerEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewDonateRestControllerEntity(client, entopts)
	}
	core.NewPortfolioControllerEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewPortfolioControllerEntity(client, entopts)
	}
	core.NewRepositoryDetailDomainEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewRepositoryDetailDomainEntity(client, entopts)
	}
	core.NewRepositoryIssueDomainEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewRepositoryIssueDomainEntity(client, entopts)
	}
	core.NewVersionEntityFunc = func(client *core.GithubProjectIssuesSDK, entopts map[string]any) core.GithubProjectIssuesEntity {
		return entity.NewVersionEntity(client, entopts)
	}
}

// Constructor re-exports.
var NewGithubProjectIssuesSDK = core.NewGithubProjectIssuesSDK
var TestSDK = core.TestSDK
var NewContext = core.NewContext
var NewSpec = core.NewSpec
var NewResult = core.NewResult
var NewResponse = core.NewResponse
var NewOperation = core.NewOperation
var MakeConfig = core.MakeConfig
var NewBaseFeature = feature.NewBaseFeature
var NewTestFeature = feature.NewTestFeature
