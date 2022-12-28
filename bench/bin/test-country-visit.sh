wrk \
  --threads 4 \
  --connections 100 \
  --duration 60s \
  --rate 2000 \
  --script bench/script/post.lua \
  'http://visits-service/country/it'
