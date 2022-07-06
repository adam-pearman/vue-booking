/*
    Load testing is useful for:
    - Assessing the current performance of your system under typical and peak load.
    - Making sure performance standards are being met as the system changes.
    - Simulating a normal day of system usage.
 */

import http from 'k6/http'
import { sleep } from 'k6'

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    stages: [
        {duration: '5m', target: 100}, // ramp up the traffic
        {duration: '10m', target: 100}, // maintain traffic for a while
        {duration: '5m', target: 0}, // ramp down
    ],
    thresholds: {
        http_req_duration: ['p(99)<150'], // 99% of requests must complete below 150ms
    },
}

const API_BASE_URL = 'http://localhost/api/v1'

export default () => {
    http.get(`${API_BASE_URL}/bookings`)

    sleep(1)
}
