package core

var UtilityRegistrar func(u *Utility)

var NewBaseFeatureFunc func() Feature

var NewTestFeatureFunc func() Feature

var NewCoffeeEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewCoffeeDomainEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewDonateRestControllerEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewPortfolioControllerEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewRepositoryDetailDomainEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewRepositoryIssueDomainEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

var NewVersionEntityFunc func(client *GithubProjectIssuesSDK, entopts map[string]any) GithubProjectIssuesEntity

