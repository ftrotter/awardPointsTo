#!/bin/bash

# Script to create a new houseteam via the API
curl -X 'POST' \
  'https://awardpointsto.ft1.us/api/houseteams' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer ErBVMfTzlM3bqW8CeAi0vnYXTTddUPTVPrs6jRw30c90cbf8' \
  -H 'Content-Type: application/json' \
  -d '{
  "name": "Red Team"
}'
