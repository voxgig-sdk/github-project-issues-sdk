# GithubProjectIssues SDK feature factory

require_relative 'feature/base_feature'
require_relative 'feature/test_feature'


module GithubProjectIssuesFeatures
  def self.make_feature(name)
    case name
    when "base"
      GithubProjectIssuesBaseFeature.new
    when "test"
      GithubProjectIssuesTestFeature.new
    else
      GithubProjectIssuesBaseFeature.new
    end
  end
end
