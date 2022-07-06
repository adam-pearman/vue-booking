/*
    Spike testing is useful for:
    - Determining how the system will perform under a sudden surge of traffic.
    - Determining if the system will recover once the traffic has subsided.

    Success is based on expectations. The system will generally react in 1 of the following 4 ways:
    - Excellent: The system performance is not degraded during the surge of traffic. Response time is similar during
      low traffic and high traffic.
    - Good: Response time is slower, but the system does not produce any errors. All requests are handled.
    - Poor: The system produces errors during the surge of traffic, but recovers to normal after the traffic subsides.
    - Bad: The system crashes, and does not recover after the traffic has subsided.
 */

import http from 'k6/http'
import { sleep } from 'k6'

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    stages: [
        {duration: '10s', target: 100}, // below normal load (warm up)
        {duration: '1m', target: 100},
        {duration: '10s', target: 1400}, // big spike
        {duration: '3m', target: 1400}, // stay at spike for a while
        {duration: '10s', target: 100}, // scale down (recovery stage)
        {duration: '3m', target: 100},
        {duration: '10s', target: 0},
    ]
}

const API_BASE_URL = 'http://localhost/api/v1'

export default () => {
    http.get(`${API_BASE_URL}/bookings`)

    sleep(1)
}
