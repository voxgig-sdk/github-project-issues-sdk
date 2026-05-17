<?php
declare(strict_types=1);

// GithubProjectIssues SDK utility: feature_add

class GithubProjectIssuesFeatureAdd
{
    public static function call(GithubProjectIssuesContext $ctx, mixed $f): void
    {
        $ctx->client->features[] = $f;
    }
}
