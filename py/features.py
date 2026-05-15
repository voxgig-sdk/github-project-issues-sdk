# GithubProjectIssues SDK feature factory

from feature.base_feature import GithubProjectIssuesBaseFeature
from feature.test_feature import GithubProjectIssuesTestFeature


def _make_feature(name):
    features = {
        "base": lambda: GithubProjectIssuesBaseFeature(),
        "test": lambda: GithubProjectIssuesTestFeature(),
    }
    factory = features.get(name)
    if factory is not None:
        return factory()
    return features["base"]()
