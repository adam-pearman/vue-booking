/*
    Stress testing is useful for:
    - Determining how the system behaves under extreme conditions.
    - Determining the maximum capacity of the system in terms of users or throughput.
    - Determining the breaking point of the system and its failure mode.
    - Determining if the system will recover without manual intervention after the stress test is over.
*/

import http from 'k6/http'
import { sleep } from 'k6'

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    stages: [
        {duration: '2m', target: 100}, // below normal load
        {duration: '5m', target: 100},
        {duration: '2m', target: 200}, // normal load
        {duration: '5m', target: 200},
        {duration: '2m', target: 300}, // around breaking point
        {duration: '5m', target: 300},
        {duration: '2m', target: 400}, // beyond breaking point
        {duration: '5m', target: 400},
        {duration: '10m', target: 0}, // recovery stage
    ]
}

const API_BASE_URL = 'http://localhost/api/v1'

export default () => {
    http.get(`${API_BASE_URL}/bookings`)

    sleep(1)
}
