BASELINE_ROUTES=/,/api/users

slow_traffic:
	@echo "testing slow requests alerts and spx profiling trigger..."
	k6 run scripts/ingest_slow_requests.js
