package = "voxgig-sdk-github-project-issues"
version = "0.0-1"
source = {
  url = "git://github.com/voxgig-sdk/github-project-issues-sdk.git"
}
description = {
  summary = "GithubProjectIssues SDK for Lua",
  license = "MIT"
}
dependencies = {
  "lua >= 5.3",
  "dkjson >= 2.5",
  "dkjson >= 2.5",
}
build = {
  type = "builtin",
  modules = {
    ["github-project-issues_sdk"] = "github-project-issues_sdk.lua",
    ["config"] = "config.lua",
    ["features"] = "features.lua",
  }
}
