
const envlocal = __dirname + '/../../../.env.local'
require('dotenv').config({ quiet: true, path: [envlocal] })

import Path from 'node:path'
import * as Fs from 'node:fs'

import { test, describe, afterEach } from 'node:test'
import assert from 'node:assert'


import { GithubProjectIssuesSDK, BaseFeature, stdutil } from '../../..'

import {
  envOverride,
  liveDelay,
  makeCtrl,
  makeMatch,
  makeReqdata,
  makeStepData,
  makeValid,
  maybeSkipControl,
} from '../../utility'


describe('CoffeeEntity', async () => {

  // Per-test live pacing. Delay is read from sdk-test-control.json's
  // `test.live.delayMs`; only sleeps when GITHUBPROJECTISSUES_TEST_LIVE=TRUE.
  afterEach(liveDelay('GITHUBPROJECTISSUES_TEST_LIVE'))

  test('instance', async () => {
    const testsdk = GithubProjectIssuesSDK.test()
    const ent = testsdk.Coffee()
    assert(null != ent)
  })


  test('basic', async (t) => {

    const live = 'TRUE' === process.env.GITHUB_PROJECT_ISSUES_TEST_LIVE
    for (const op of ['list', 'update']) {
      if (maybeSkipControl(t, 'entityOp', 'coffee.' + op, live)) return
    }

    const setup = basicSetup()
    // The basic flow consumes synthetic IDs and field values from the
    // fixture (entity TestData.json). Those don't exist on the live API.
    // Skip live runs unless the user provided a real ENTID env override.
    if (setup.syntheticOnly) {
      t.skip('live entity test uses synthetic IDs from fixture — set GITHUB_PROJECT_ISSUES_TEST_COFFEE_ENTID JSON to run live')
      return
    }
    const client = setup.client
    const struct = setup.struct

    const isempty = struct.isempty
    const select = struct.select

    let coffee_ref01_data = Object.values(setup.data.existing.coffee)[0] as any

    // LIST
    const coffee_ref01_ent = client.Coffee()
    const coffee_ref01_match: any = {}

    const coffee_ref01_list = await coffee_ref01_ent.list(coffee_ref01_match)


    // UPDATE
    const coffee_ref01_data_up0: any = {}
    coffee_ref01_data_up0.id = coffee_ref01_data.id

    const coffee_ref01_markdef_up0 = { name: 'description', value: 'Mark01-coffee_ref01_' + setup.now }
    coffee_ref01_data_up0 [coffee_ref01_markdef_up0.name] = coffee_ref01_markdef_up0.value

    const coffee_ref01_resdata_up0 = await coffee_ref01_ent.update(coffee_ref01_data_up0)
    assert(coffee_ref01_resdata_up0.id === coffee_ref01_data_up0.id)

    assert(coffee_ref01_resdata_up0[coffee_ref01_markdef_up0.name] === coffee_ref01_markdef_up0.value)


  })
})



function basicSetup(extra?: any) {
  // TODO: fix test def options
  const options: any = {} // null

  // TODO: needs test utility to resolve path
  const entityDataFile =
    Path.resolve(__dirname, 
      '../../../../.sdk/test/entity/coffee/CoffeeTestData.json')

  // TODO: file ready util needed?
  const entityDataSource = Fs.readFileSync(entityDataFile).toString('utf8')

  // TODO: need a xlang JSON parse utility in voxgig/struct with better error msgs
  const entityData = JSON.parse(entityDataSource)

  options.entity = entityData.existing

  let client = GithubProjectIssuesSDK.test(options, extra)
  const struct = client.utility().struct
  const merge = struct.merge
  const transform = struct.transform

  let idmap = transform(
    ['coffee01','coffee02','coffee03'],
    {
      '`$PACK`': ['', {
        '`$KEY`': '`$COPY`',
        '`$VAL`': ['`$FORMAT`', 'upper', '`$COPY`']
      }]
    })

  // Detect whether the user provided a real ENTID JSON via env var. The
  // basic flow consumes synthetic IDs from the fixture file; without an
  // override those synthetic IDs reach the live API and 4xx. Surface this
  // to the test so it can skip rather than fail.
  const idmapEnvVal = process.env['GITHUB_PROJECT_ISSUES_TEST_COFFEE_ENTID']
  const idmapOverridden = null != idmapEnvVal && idmapEnvVal.trim().startsWith('{')

  const env = envOverride({
    'GITHUB_PROJECT_ISSUES_TEST_COFFEE_ENTID': idmap,
    'GITHUB_PROJECT_ISSUES_TEST_LIVE': 'FALSE',
    'GITHUB_PROJECT_ISSUES_TEST_EXPLAIN': 'FALSE',
    'GITHUB_PROJECT_ISSUES_APIKEY': 'NONE',
  })

  idmap = env['GITHUB_PROJECT_ISSUES_TEST_COFFEE_ENTID']

  const live = 'TRUE' === env.GITHUB_PROJECT_ISSUES_TEST_LIVE

  if (live) {
    client = new GithubProjectIssuesSDK(merge([
      {
        apikey: env.GITHUB_PROJECT_ISSUES_APIKEY,
      },
      extra
    ]))
  }

  const setup = {
    idmap,
    env,
    options,
    client,
    struct,
    data: entityData,
    explain: 'TRUE' === env.GITHUB_PROJECT_ISSUES_TEST_EXPLAIN,
    live,
    syntheticOnly: live && !idmapOverridden,
    now: Date.now(),
  }

  return setup
}
  
