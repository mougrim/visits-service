## Requirements
- php8.1
- composer
- nginx
- redis

## Install

On ubuntu:
- put code to /home/sites/visits-service
- run commands:
```sh
sudo ln -sfT /home/sites/visits-service/config/nginx-visits-service.conf /etc/nginx/sites-available/nginx-visits-service.conf
sudo ln -sfT /etc/nginx/sites-available/nginx-visits-service.conf /etc/nginx/sites-enabled/nginx-visits-service.conf
sudo service nginx restart
```

Add to /etc/hosts:
```text
127.0.0.1 visits-service
```

## Using

Get countries visits: `GET http://visits-service/country`.
Save country visit: `POST http://visits-service/country/<countryCode>`, where `countryCode` is in ISO 3166 in lower case.

## Benchmark

Need to make wrk2 https://github.com/giltene/wrk2 and add it to PATH.

Results on my laptop:
```text
$ bench/bin/test-country-list.sh
Running 1m test @ http://visits-service/country
  4 threads and 100 connections
  Thread calibration: mean lat.: 2.033ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.023ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.043ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.054ms, rate sampling interval: 10ms
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency     2.06ms  723.48us   8.03ms   67.94%
    Req/Sec   526.85    133.24     1.00k    69.69%
  119924 requests in 1.00m, 21.61MB read
Requests/sec:   1998.69
Transfer/sec:    368.81KB

$ bench/bin/test-country-visit.sh
Running 1m test @ http://visits-service/country/it
  4 threads and 100 connections
  Thread calibration: mean lat.: 1.796ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.068ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.128ms, rate sampling interval: 10ms
  Thread calibration: mean lat.: 2.090ms, rate sampling interval: 10ms
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency     1.94ms  641.19us  13.38ms   73.13%
    Req/Sec   526.38    127.01     1.22k    70.61%
  119924 requests in 1.00m, 22.18MB read
Requests/sec:   1998.71
Transfer/sec:    378.57KB

```
