<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility: make_context

require_once __DIR__ . '/../core/Context.php';

class GithubProjectIssuesMakeContext
{
    public static function call(array $ctxmap, ?GithubProjectIssuesContext $basectx): GithubProjectIssuesContext
    {
        return new GithubProjectIssuesContext($ctxmap, $basectx);
    }
}
