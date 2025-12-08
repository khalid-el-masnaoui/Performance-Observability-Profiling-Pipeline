#!/bin/bash

set -e


echo "⏳ Waiting for app to be ready..."
sleep 20

echo "Stimulating slow requests..."
k6 run /scripts/ingest_slow_requests.js

echo "✅ k6 tests completed"
