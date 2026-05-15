<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility: prepare_body

class GithubProjectIssuesPrepareBody
{
    public static function call(GithubProjectIssuesContext $ctx): mixed
    {
        if ($ctx->op->input === 'data') {
            return ($ctx->utility->transform_request)($ctx);
        }
        return null;
    }
}
