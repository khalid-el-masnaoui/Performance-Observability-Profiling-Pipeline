BASELINE_ROUTES=/,/api/users

test_slow_requests:
	@echo "testing slow requests alerts and spx profiling trigger..."
	k6 run scripts/ingest_slow_requests.js
