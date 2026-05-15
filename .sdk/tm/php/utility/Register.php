<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility registration

require_once __DIR__ . '/../core/UtilityType.php';
require_once __DIR__ . '/Clean.php';
require_once __DIR__ . '/Done.php';
require_once __DIR__ . '/MakeError.php';
require_once __DIR__ . '/FeatureAdd.php';
require_once __DIR__ . '/FeatureHook.php';
require_once __DIR__ . '/FeatureInit.php';
require_once __DIR__ . '/Fetcher.php';
require_once __DIR__ . '/MakeFetchDef.php';
require_once __DIR__ . '/MakeContext.php';
require_once __DIR__ . '/MakeOptions.php';
require_once __DIR__ . '/MakeRequest.php';
require_once __DIR__ . '/MakeResponse.php';
require_once __DIR__ . '/MakeResult.php';
require_once __DIR__ . '/MakePoint.php';
require_once __DIR__ . '/MakeSpec.php';
require_once __DIR__ . '/MakeUrl.php';
require_once __DIR__ . '/Param.php';
require_once __DIR__ . '/PrepareAuth.php';
require_once __DIR__ . '/PrepareBody.php';
require_once __DIR__ . '/PrepareHeaders.php';
require_once __DIR__ . '/PrepareMethod.php';
require_once __DIR__ . '/PrepareParams.php';
require_once __DIR__ . '/PreparePath.php';
require_once __DIR__ . '/PrepareQuery.php';
require_once __DIR__ . '/ResultBasic.php';
require_once __DIR__ . '/ResultBody.php';
require_once __DIR__ . '/ResultHeaders.php';
require_once __DIR__ . '/TransformRequest.php';
require_once __DIR__ . '/TransformResponse.php';

GithubProjectIssuesUtility::setRegistrar(function (GithubProjectIssuesUtility $u): void {
    $u->clean = [GithubProjectIssuesClean::class, 'call'];
    $u->done = [GithubProjectIssuesDone::class, 'call'];
    $u->make_error = [GithubProjectIssuesMakeError::class, 'call'];
    $u->feature_add = [GithubProjectIssuesFeatureAdd::class, 'call'];
    $u->feature_hook = [GithubProjectIssuesFeatureHook::class, 'call'];
    $u->feature_init = [GithubProjectIssuesFeatureInit::class, 'call'];
    $u->fetcher = [GithubProjectIssuesFetcher::class, 'call'];
    $u->make_fetch_def = [GithubProjectIssuesMakeFetchDef::class, 'call'];
    $u->make_context = [GithubProjectIssuesMakeContext::class, 'call'];
    $u->make_options = [GithubProjectIssuesMakeOptions::class, 'call'];
    $u->make_request = [GithubProjectIssuesMakeRequest::class, 'call'];
    $u->make_response = [GithubProjectIssuesMakeResponse::class, 'call'];
    $u->make_result = [GithubProjectIssuesMakeResult::class, 'call'];
    $u->make_point = [GithubProjectIssuesMakePoint::class, 'call'];
    $u->make_spec = [GithubProjectIssuesMakeSpec::class, 'call'];
    $u->make_url = [GithubProjectIssuesMakeUrl::class, 'call'];
    $u->param = [GithubProjectIssuesParam::class, 'call'];
    $u->prepare_auth = [GithubProjectIssuesPrepareAuth::class, 'call'];
    $u->prepare_body = [GithubProjectIssuesPrepareBody::class, 'call'];
    $u->prepare_headers = [GithubProjectIssuesPrepareHeaders::class, 'call'];
    $u->prepare_method = [GithubProjectIssuesPrepareMethod::class, 'call'];
    $u->prepare_params = [GithubProjectIssuesPrepareParams::class, 'call'];
    $u->prepare_path = [GithubProjectIssuesPreparePath::class, 'call'];
    $u->prepare_query = [GithubProjectIssuesPrepareQuery::class, 'call'];
    $u->result_basic = [GithubProjectIssuesResultBasic::class, 'call'];
    $u->result_body = [GithubProjectIssuesResultBody::class, 'call'];
    $u->result_headers = [GithubProjectIssuesResultHeaders::class, 'call'];
    $u->transform_request = [GithubProjectIssuesTransformRequest::class, 'call'];
    $u->transform_response = [GithubProjectIssuesTransformResponse::class, 'call'];
});
