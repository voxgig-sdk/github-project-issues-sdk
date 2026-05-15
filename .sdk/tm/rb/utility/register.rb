# GithubProjectIssues SDK utility registration
require_relative '../core/utility_type'
require_relative 'clean'
require_relative 'done'
require_relative 'make_error'
require_relative 'feature_add'
require_relative 'feature_hook'
require_relative 'feature_init'
require_relative 'fetcher'
require_relative 'make_fetch_def'
require_relative 'make_context'
require_relative 'make_options'
require_relative 'make_request'
require_relative 'make_response'
require_relative 'make_result'
require_relative 'make_point'
require_relative 'make_spec'
require_relative 'make_url'
require_relative 'param'
require_relative 'prepare_auth'
require_relative 'prepare_body'
require_relative 'prepare_headers'
require_relative 'prepare_method'
require_relative 'prepare_params'
require_relative 'prepare_path'
require_relative 'prepare_query'
require_relative 'result_basic'
require_relative 'result_body'
require_relative 'result_headers'
require_relative 'transform_request'
require_relative 'transform_response'

GithubProjectIssuesUtility.registrar = ->(u) {
  u.clean = GithubProjectIssuesUtilities::Clean
  u.done = GithubProjectIssuesUtilities::Done
  u.make_error = GithubProjectIssuesUtilities::MakeError
  u.feature_add = GithubProjectIssuesUtilities::FeatureAdd
  u.feature_hook = GithubProjectIssuesUtilities::FeatureHook
  u.feature_init = GithubProjectIssuesUtilities::FeatureInit
  u.fetcher = GithubProjectIssuesUtilities::Fetcher
  u.make_fetch_def = GithubProjectIssuesUtilities::MakeFetchDef
  u.make_context = GithubProjectIssuesUtilities::MakeContext
  u.make_options = GithubProjectIssuesUtilities::MakeOptions
  u.make_request = GithubProjectIssuesUtilities::MakeRequest
  u.make_response = GithubProjectIssuesUtilities::MakeResponse
  u.make_result = GithubProjectIssuesUtilities::MakeResult
  u.make_point = GithubProjectIssuesUtilities::MakePoint
  u.make_spec = GithubProjectIssuesUtilities::MakeSpec
  u.make_url = GithubProjectIssuesUtilities::MakeUrl
  u.param = GithubProjectIssuesUtilities::Param
  u.prepare_auth = GithubProjectIssuesUtilities::PrepareAuth
  u.prepare_body = GithubProjectIssuesUtilities::PrepareBody
  u.prepare_headers = GithubProjectIssuesUtilities::PrepareHeaders
  u.prepare_method = GithubProjectIssuesUtilities::PrepareMethod
  u.prepare_params = GithubProjectIssuesUtilities::PrepareParams
  u.prepare_path = GithubProjectIssuesUtilities::PreparePath
  u.prepare_query = GithubProjectIssuesUtilities::PrepareQuery
  u.result_basic = GithubProjectIssuesUtilities::ResultBasic
  u.result_body = GithubProjectIssuesUtilities::ResultBody
  u.result_headers = GithubProjectIssuesUtilities::ResultHeaders
  u.transform_request = GithubProjectIssuesUtilities::TransformRequest
  u.transform_response = GithubProjectIssuesUtilities::TransformResponse
}
