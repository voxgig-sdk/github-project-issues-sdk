<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility: result_headers

class GithubProjectIssuesResultHeaders
{
    public static function call(GithubProjectIssuesContext $ctx): ?GithubProjectIssuesResult
    {
        $response = $ctx->response;
        $result = $ctx->result;
        if ($result) {
            if ($response && is_array($response->headers)) {
                $result->headers = $response->headers;
            } else {
                $result->headers = [];
            }
        }
        return $result;
    }
}
