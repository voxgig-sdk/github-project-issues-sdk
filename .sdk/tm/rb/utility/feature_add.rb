# GithubProjectIssues SDK utility: feature_add
module GithubProjectIssuesUtilities
  FeatureAdd = ->(ctx, f) {
    ctx.client.features << f
  }
end
