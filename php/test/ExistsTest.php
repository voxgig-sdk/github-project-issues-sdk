<?php
declare(strict_types=1);

// GithubProjectIssues SDK exists test

require_once __DIR__ . '/../githubprojectissues_sdk.php';

use PHPUnit\Framework\TestCase;

class ExistsTest extends TestCase
{
    public function test_create_test_sdk(): void
    {
        $testsdk = GithubProjectIssuesSDK::test(null, null);
        $this->assertNotNull($testsdk);
    }
}
