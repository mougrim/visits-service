wrk --threads 4 --connections 100 --duration 60s --rate 2000 'http://visits-service/country'
