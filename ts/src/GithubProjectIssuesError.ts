
import { Context } from './Context'


class GithubProjectIssuesError extends Error {

  isGithubProjectIssuesError = true

  sdk = 'GithubProjectIssues'

  code: string
  ctx: Context

  constructor(code: string, msg: string, ctx: Context) {
    super(msg)
    this.code = code
    this.ctx = ctx
  }

}

export {
  GithubProjectIssuesError
}

