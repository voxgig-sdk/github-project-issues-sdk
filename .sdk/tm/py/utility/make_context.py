# GithubProjectIssues SDK utility: make_context

from core.context import GithubProjectIssuesContext


def make_context_util(ctxmap, basectx):
    return GithubProjectIssuesContext(ctxmap, basectx)
