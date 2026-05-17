# GithubProjectIssues SDK exists test

require "minitest/autorun"
require_relative "../GithubProjectIssues_sdk"

class ExistsTest < Minitest::Test
  def test_create_test_sdk
    testsdk = GithubProjectIssuesSDK.test(nil, nil)
    assert !testsdk.nil?
  end
end
