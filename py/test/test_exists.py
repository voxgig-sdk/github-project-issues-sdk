# ProjectName SDK exists test

import pytest
from githubprojectissues_sdk import GithubProjectIssuesSDK


class TestExists:

    def test_should_create_test_sdk(self):
        testsdk = GithubProjectIssuesSDK.test(None, None)
        assert testsdk is not None
