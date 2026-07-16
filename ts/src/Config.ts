
import { BaseFeature } from './feature/base/BaseFeature'
import { TestFeature } from './feature/test/TestFeature'



const FEATURE_CLASS: Record<string, typeof BaseFeature> = {
   test: TestFeature,

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
    },

  }


  options = {
    base: 'https://ironoc.net',

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
          "active": true,
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "index$": 0
        },
        {
          "active": true,
          "name": "id",
          "req": false,
          "type": "`$INTEGER`",
          "index$": 1
        },
        {
          "active": true,
          "name": "image",
          "req": true,
          "type": "`$STRING`",
          "index$": 2
        },
        {
          "active": true,
          "name": "ingredient",
          "req": true,
          "type": "`$ARRAY`",
          "index$": 3
        },
        {
          "active": true,
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "index$": 4
        }
      ],
      "name": "coffee",
      "op": {
        "list": {
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "GET",
              "orig": "/api/coffees",
              "parts": [
                "api",
                "coffees"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
          "key$": "list"
        },
        "update": {
          "input": "data",
          "name": "update",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "PUT",
              "orig": "/api/coffees",
              "parts": [
                "api",
                "coffees"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
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
          "active": true,
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "index$": 0
        },
        {
          "active": true,
          "name": "id",
          "req": false,
          "type": "`$INTEGER`",
          "index$": 1
        },
        {
          "active": true,
          "name": "image",
          "req": true,
          "type": "`$STRING`",
          "index$": 2
        },
        {
          "active": true,
          "name": "ingredient",
          "req": true,
          "type": "`$ARRAY`",
          "index$": 3
        },
        {
          "active": true,
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "index$": 4
        }
      ],
      "name": "coffee_domain",
      "op": {
        "list": {
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "GET",
              "orig": "/api/coffees-graph-ql",
              "parts": [
                "api",
                "coffees-graph-ql"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
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
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "GET",
              "orig": "/api/donate-items",
              "parts": [
                "api",
                "donate-items"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
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
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "GET",
              "orig": "/api/portfolio-items",
              "parts": [
                "api",
                "portfolio-items"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
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
          "active": true,
          "name": "app_home",
          "req": false,
          "type": "`$STRING`",
          "index$": 0
        },
        {
          "active": true,
          "name": "description",
          "req": false,
          "type": "`$STRING`",
          "index$": 1
        },
        {
          "active": true,
          "name": "full_name",
          "req": true,
          "type": "`$STRING`",
          "index$": 2
        },
        {
          "active": true,
          "name": "issue_count",
          "req": false,
          "type": "`$INTEGER`",
          "index$": 3
        },
        {
          "active": true,
          "name": "name",
          "req": true,
          "type": "`$STRING`",
          "index$": 4
        },
        {
          "active": true,
          "name": "repo_url",
          "req": true,
          "type": "`$STRING`",
          "index$": 5
        },
        {
          "active": true,
          "name": "topic",
          "req": false,
          "type": "`$STRING`",
          "index$": 6
        }
      ],
      "name": "repository_detail_domain",
      "op": {
        "list": {
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {
                "query": [
                  {
                    "active": true,
                    "kind": "query",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`"
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
              "index$": 0
            }
          ],
          "key$": "list"
        },
        "load": {
          "input": "data",
          "name": "load",
          "points": [
            {
              "active": true,
              "args": {
                "params": [
                  {
                    "active": true,
                    "kind": "param",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`",
                    "index$": 0
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
              "index$": 0
            }
          ],
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
          "active": true,
          "name": "body",
          "req": false,
          "type": "`$STRING`",
          "index$": 0
        },
        {
          "active": true,
          "name": "label",
          "req": false,
          "type": "`$ARRAY`",
          "index$": 1
        },
        {
          "active": true,
          "name": "number",
          "req": true,
          "type": "`$STRING`",
          "index$": 2
        },
        {
          "active": true,
          "name": "state",
          "req": false,
          "type": "`$STRING`",
          "index$": 3
        },
        {
          "active": true,
          "name": "title",
          "req": true,
          "type": "`$STRING`",
          "index$": 4
        }
      ],
      "name": "repository_issue_domain",
      "op": {
        "list": {
          "input": "data",
          "name": "list",
          "points": [
            {
              "active": true,
              "args": {
                "params": [
                  {
                    "active": true,
                    "kind": "param",
                    "name": "repository",
                    "orig": "repository",
                    "reqd": true,
                    "type": "`$STRING`",
                    "index$": 0
                  },
                  {
                    "active": true,
                    "kind": "param",
                    "name": "username",
                    "orig": "username",
                    "reqd": true,
                    "type": "`$STRING`",
                    "index$": 1
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
              "index$": 0
            }
          ],
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
          "input": "data",
          "name": "load",
          "points": [
            {
              "active": true,
              "args": {},
              "method": "GET",
              "orig": "/api/application/version",
              "parts": [
                "api",
                "application",
                "version"
              ],
              "select": {},
              "transform": {
                "req": "`reqdata`",
                "res": "`body`"
              },
              "index$": 0
            }
          ],
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

