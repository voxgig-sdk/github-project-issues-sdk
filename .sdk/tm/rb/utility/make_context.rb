# GithubProjectIssues SDK utility: make_context
require_relative '../core/context'
module GithubProjectIssuesUtilities
  MakeContext = ->(ctxmap, basectx) {
    GithubProjectIssuesContext.new(ctxmap, basectx)
  }
end
