-- GithubProjectIssues SDK error

local GithubProjectIssuesError = {}
GithubProjectIssuesError.__index = GithubProjectIssuesError


function GithubProjectIssuesError.new(code, msg, ctx)
  local self = setmetatable({}, GithubProjectIssuesError)
  self.is_sdk_error = true
  self.sdk = "GithubProjectIssues"
  self.code = code or ""
  self.msg = msg or ""
  self.ctx = ctx
  self.result = nil
  self.spec = nil
  return self
end


function GithubProjectIssuesError:error()
  return self.msg
end


function GithubProjectIssuesError:__tostring()
  return self.msg
end


return GithubProjectIssuesError
