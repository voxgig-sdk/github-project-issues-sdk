
import { BaseFeature } from './feature/base/BaseFeature'
import { TestFeature } from './feature/test/TestFeature'



const FEATURE_CLASS: Record<string, typeof BaseFeature> = {
   test: TestFeature

}


class Config {

  makeFeature(this: any, fn: string) {
    const fc = FEATURE_CLASS[fn]
    const fi = new fc()
    // TODO: errors etc
    return fi
  }


  main = {
    name: 'ProjectName',
  }


  feature = {
     test:     {
      "options": {
        "active": false
      }
    }

  }


  options = {
    base: 'https://ironoc.net',

    auth: {
      prefix: 'Bearer',
    },

    headers: {
      "content-type": "application/json"
    },

    entity: {
      
      coffee: {
      },

      coffee_domain: {
      },

      donate_rest_controller: {
      },

      portfolio_controller: {
      },

      repository_detail_domain: {
      },

      repository_issue_domain: {
      },

      version: {
      },

    }
  }


  entity = {
    "coffee": {
      "fields": [
        {
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 0
        },
        {
          "name": "id",
          "req": false,
          "type": "`$INTEGER`",
          "active": true,
          "index$": 1
        },
        {
          "name": "image",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 2
        },
        {
          "name": "ingredient",
          "req": true,
          "type": "`$ARRAY`",
          "active": true,
          "index$": 3
        },
        {
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 4
        }
      ],
      "name": "coffee",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "method": "GET",
              "orig": "/api/coffees",
              "parts": [
                "api",
                "coffees"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        },
        "update": {
          "name": "update",
          "points": [
            {
              "method": "PUT",
              "orig": "/api/coffees",
              "parts": [
                "api",
                "coffees"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "update"
        }
      },
      "relations": {
        "ancestors": []
      }
    },
    "coffee_domain": {
      "fields": [
        {
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 0
        },
        {
          "name": "id",
          "req": false,
          "type": "`$INTEGER`",
          "active": true,
          "index$": 1
        },
        {
          "name": "image",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 2
        },
        {
          "name": "ingredient",
          "req": true,
          "type": "`$ARRAY`",
          "active": true,
          "index$": 3
        },
        {
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 4
        }
      ],
      "name": "coffee_domain",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "method": "GET",
              "orig": "/api/coffees-graph-ql",
              "parts": [
                "api",
                "coffees-graph-ql"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        }
      },
      "relations": {
        "ancestors": []
      }
    },
    "donate_rest_controller": {
      "fields": [],
      "name": "donate_rest_controller",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "method": "GET",
              "orig": "/api/donate-items",
              "parts": [
                "api",
                "donate-items"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        }
      },
      "relations": {
        "ancestors": []
      }
    },
    "portfolio_controller": {
      "fields": [],
      "name": "portfolio_controller",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "method": "GET",
              "orig": "/api/portfolio-items",
              "parts": [
                "api",
                "portfolio-items"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        }
      },
      "relations": {
        "ancestors": []
      }
    },
    "repository_detail_domain": {
      "fields": [
        {
          "name": "app_home",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 0
        },
        {
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 1
        },
        {
          "name": "full_name",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 2
        },
        {
          "name": "issue_count",
          "req": false,
          "type": "`$INTEGER`",
          "active": true,
          "index$": 3
        },
        {
          "name": "name",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 4
        },
        {
          "name": "repo_url",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 5
        },
        {
          "name": "topic",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 6
        }
      ],
      "name": "repository_detail_domain",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "args": {
                "query": [
                  {
                    "kind": "query",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`",
                    "active": true
                  }
                ]
              },
              "method": "GET",
              "orig": "/api/get-repo-detail",
              "parts": [
                "api",
                "get-repo-detail"
              ],
              "select": {
                "exist": [
                  "username"
                ]
              },
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        },
        "load": {
          "name": "load",
          "points": [
            {
              "args": {
                "params": [
                  {
                    "kind": "param",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`",
                    "active": true
                  }
                ]
              },
              "method": "GET",
              "orig": "/api/get-repo-detail/{username}/",
              "parts": [
                "api",
                "get-repo-detail",
                "{username}"
              ],
              "select": {
                "exist": [
                  "username"
                ]
              },
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "load"
        }
      },
      "relations": {
        "ancestors": [
          [
            "get_repo_detail"
          ]
        ]
      }
    },
    "repository_issue_domain": {
      "fields": [
        {
          "name": "body",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 0
        },
        {
          "name": "label",
          "req": false,
          "type": "`$ARRAY`",
          "active": true,
          "index$": 1
        },
        {
          "name": "number",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 2
        },
        {
          "name": "state",
          "req": false,
          "type": "`$STRING`",
          "active": true,
          "index$": 3
        },
        {
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "active": true,
          "index$": 4
        }
      ],
      "name": "repository_issue_domain",
      "op": {
        "list": {
          "name": "list",
          "points": [
            {
              "args": {
                "params": [
                  {
                    "kind": "param",
                    "name": "repository",
                    "orig": "repository",
                    "reqd": true,
                    "type": "`$STRING`",
                    "active": true
                  },
                  {
                    "kind": "param",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`",
                    "active": true
                  }
                ]
              },
              "method": "GET",
              "orig": "/api/get-repo-issue/{username}/{repository}/",
              "parts": [
                "api",
                "get-repo-issue",
                "{username}",
                "{repository}"
              ],
              "select": {
                "exist": [
                  "repository",
                  "username"
                ]
              },
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "list"
        }
      },
      "relations": {
        "ancestors": [
          [
            "get_repo_issue"
          ]
        ]
      }
    },
    "version": {
      "fields": [],
      "name": "version",
      "op": {
        "load": {
          "name": "load",
          "points": [
            {
              "method": "GET",
              "orig": "/api/application/version",
              "parts": [
                "api",
                "application",
                "version"
              ],
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "active": true,
              "args": {},
              "select": {},
              "index$": 0
            }
          ],
          "input": "data",
          "key$": "load"
        }
      },
      "relations": {
        "ancestors": []
      }
    }
  }
}


const config = new Config()

export {
  config
}

