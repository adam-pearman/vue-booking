/*
    Soak testing is useful for:
    - Verifying that your system doesn't suffer from bugs or memory leaks.
    - Verifying that expected application restarts don't lose requests.
    - Finding bugs related to race-conditions that appear sporadically.
    - Making sure your database and logs don't exhaust the allotted storage space.
    - Making sure external services don't stop working after a certain amount of requests.

    How to run a soak test:
    - Determine the maximum number of users the system can handle.
    - Work out 75-80% of that value, and set that many VUs.
    - Run the test in 3 stages. First ramp up to the number of VUs, then stay there for 4-12 hours, and then ramp
    back down to 0 VUs.
 */

import http from 'k6/http'
import { sleep } from 'k6'

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    stages: [
        {duration: '2m', target: 400}, // ramp up the traffic
        {duration: '12h', target: 400}, // maintain traffic for a very long time
        {duration: '2m', target: 0}, // ramp down
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
