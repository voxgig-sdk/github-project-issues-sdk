<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility: result_body

class GithubProjectIssuesResultBody
{
    public static function call(GithubProjectIssuesContext $ctx): ?GithubProjectIssuesResult
    {
        $response = $ctx->response;
        $result = $ctx->result;
        if ($result && $response && $response->json_func && $response->body) {
            $result->body = ($response->json_func)();
        }
        return $result;
    }
}
