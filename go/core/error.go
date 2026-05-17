package core

type GithubProjectIssuesError struct {
	IsGithubProjectIssuesError bool
	Sdk              string
	Code             string
	Msg              string
	Ctx              *Context
	Result           any
	Spec             any
}

func NewGithubProjectIssuesError(code string, msg string, ctx *Context) *GithubProjectIssuesError {
	return &GithubProjectIssuesError{
		IsGithubProjectIssuesError: true,
		Sdk:              "GithubProjectIssues",
		Code:             code,
		Msg:              msg,
		Ctx:              ctx,
	}
}

func (e *GithubProjectIssuesError) Error() string {
	return e.Msg
}
