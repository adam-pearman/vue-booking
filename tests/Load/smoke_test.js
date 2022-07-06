/*
    Smoke testing is useful for:
    - Running before other load tests to check that your test scripts don't have any errors.
    - Verifying that the system doesn't throw any errors when under minimal load.
 */

import http from 'k6/http'
import { sleep } from 'k6'

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    vus: 1,
    duration: '1m',
    thresholds: {
        http_req_duration: ['p(99)<150'], // 99% of requests must complete below 150ms
    },
}

const API_BASE_URL = 'http://localhost/api/v1'

export default () => {
    http.get(`${API_BASE_URL}/bookings`)

    sleep(1)
}
