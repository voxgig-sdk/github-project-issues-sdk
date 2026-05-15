<?php
declare(strict_types=1);

// GithubProjectIssues SDK base feature

class GithubProjectIssuesBaseFeature
{
    public string $version;
    public string $name;
    public bool $active;

    public function __construct()
    {
        $this->version = '0.0.1';
        $this->name = 'base';
        $this->active = true;
    }

    public function get_version(): string { return $this->version; }
    public function get_name(): string { return $this->name; }
    public function get_active(): bool { return $this->active; }

    public function init(GithubProjectIssuesContext $ctx, array $options): void {}
    public function PostConstruct(GithubProjectIssuesContext $ctx): void {}
    public function PostConstructEntity(GithubProjectIssuesContext $ctx): void {}
    public function SetData(GithubProjectIssuesContext $ctx): void {}
    public function GetData(GithubProjectIssuesContext $ctx): void {}
    public function GetMatch(GithubProjectIssuesContext $ctx): void {}
    public function SetMatch(GithubProjectIssuesContext $ctx): void {}
    public function PrePoint(GithubProjectIssuesContext $ctx): void {}
    public function PreSpec(GithubProjectIssuesContext $ctx): void {}
    public function PreRequest(GithubProjectIssuesContext $ctx): void {}
    public function PreResponse(GithubProjectIssuesContext $ctx): void {}
    public function PreResult(GithubProjectIssuesContext $ctx): void {}
    public function PreDone(GithubProjectIssuesContext $ctx): void {}
    public function PreUnexpected(GithubProjectIssuesContext $ctx): void {}
}
