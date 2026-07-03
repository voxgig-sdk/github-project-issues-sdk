
const envlocal = __dirname + '/../../../.env.local'
require('dotenv').config({ quiet: true, path: [envlocal] })

import { test, describe, afterEach } from 'node:test'
import assert from 'node:assert'


import { GithubProjectIssuesSDK } from '../../..'

import {
  envOverride,
  liveDelay,
  maybeSkipControl,
  skipIfMissingIds,
} from '../../utility'


describe('RepositoryIssueDomainDirect', async () => {

  // Per-test live pacing. Delay is read from sdk-test-control.json's
  // `test.live.delayMs`; only sleeps when GITHUBPROJECTISSUES_TEST_LIVE=TRUE.
  afterEach(liveDelay('GITHUBPROJECTISSUES_TEST_LIVE'))

  test('direct-exists', async () => {
    const sdk = new GithubProjectIssuesSDK({
      system: { fetch: async () => ({}) }
    })
    assert('function' === typeof sdk.direct)
    assert('function' === typeof sdk.prepare)
  })


  test('direct-list-repository_issue_domain', async (t: any) => {
    const setup = directSetup([{ id: 'direct01' }, { id: 'direct02' }])
    if (maybeSkipControl(t, 'direct', 'direct-list-repository_issue_domain', setup.live)) return
    if (skipIfMissingIds(t, setup, ["repository01","username01"])) return
    const { client, calls } = setup

    const params: any = {}
    const query: any = {}
    if (setup.live) {
      params.repository = setup.idmap['repository01']
      params.username = setup.idmap['username01']
    } else {
      params.repository = 'direct01'
      params.username = 'direct02'
    }

    const result: any = await client.direct({
      path: 'api/get-repo-issue/{username}/{repository}',
      method: 'GET',
      params,
      query,
    })

    if (setup.live) {
      // Live mode is lenient: synthetic IDs frequently 4xx and the list-
      // response shape varies wildly across public APIs. Skip rather than
      // fail when the call doesn't return a usable list.
      if (!result.ok || result.status < 200 || result.status >= 300) {
        return
      }
      const listArr = unwrapListData(result.data)
      if (!Array.isArray(listArr)) {
        return
      }
    } else {
      assert(result.ok === true)
      assert(result.status === 200)
      assert(null != result.data)
      const listArr = unwrapListData(result.data)
      assert(Array.isArray(listArr))
      assert(listArr!.length === 2)
      assert(calls.length === 1)
      assert(calls[0].init.method === 'GET')
      assert(calls[0].url.includes('direct01'))
      assert(calls[0].url.includes('direct02'))
    }
  })

})



function directSetup(mockres?: any) {
  const calls: any[] = []

  const env = envOverride({
    'GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID': {},
    'GITHUBPROJECTISSUES_TEST_LIVE': 'FALSE',
    'GITHUBPROJECTISSUES_APIKEY': 'NONE',
  })

  const live = 'TRUE' === env.GITHUBPROJECTISSUES_TEST_LIVE

  if (live) {
    const client = new GithubProjectIssuesSDK({
      apikey: env.GITHUBPROJECTISSUES_APIKEY,
    })

    let idmap: any = env['GITHUBPROJECTISSUES_TEST_REPOSITORY_ISSUE_DOMAIN_ENTID']
    if ('string' === typeof idmap && idmap.startsWith('{')) {
      idmap = JSON.parse(idmap)
    }

    return { client, calls, live, idmap }
  }

  const mockFetch = async (url: string, init: any) => {
    calls.push({ url, init })
    return {
      status: 200,
      statusText: 'OK',
      headers: {},
      json: async () => (null != mockres ? mockres : { id: 'direct01' }),
    }
  }

  const client = new GithubProjectIssuesSDK({
    base: 'http://localhost:8080',
    system: { fetch: mockFetch },
  })

  return { client, calls, live, idmap: {} as any }
}

// direct() returns the raw response body. List endpoints often wrap the
// array in an envelope (e.g. { data: [...] }, { entities: [...] },
// { pagination, data: [...] }). The test transforms the raw body to
// extract the first array — either the body itself or the first array
// property of an envelope object.
function unwrapListData(data: any): any[] | null {
  if (Array.isArray(data)) return data
  if (data && 'object' === typeof data) {
    for (const v of Object.values(data)) {
      if (Array.isArray(v)) return v as any[]
    }
  }
  return null
}
  
