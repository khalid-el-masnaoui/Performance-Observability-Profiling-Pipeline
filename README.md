# Performance Observability & Profiling Pipeline

A containerized **performance observability and automated profiling system** for PHP applications.

This project integrates:

- ⚡ Nginx + PHP-FPM application layer
- 📊 Prometheus metrics collection
- 📈 Grafana dashboards
- 🔥 SPX PHP profiler with flamegraphs
- 🚨 Alertmanager for alert routing
- 🧪 k6 load testing for automated performance validation (slow request simulation & profiling) 


This project is intended as a practical demo of how to wire **PHP request metrics**, **alerting**, and **dynamic profiler activation** together into a reproducible Docker-based observability pipeline.

## Overview

This project implements a modern performance engineering pipeline where:

- Instrumented PHP application with Prometheus metrics
- Slow endpoints are automatically detected
- Redis-backed SPX trigger for automatic profiling of slow routes
- Flamegraphs are stored, visualized and browsing via `/flamegraphs`
- Alerts are sent to Slack when performance degrades

The system is fully containerized and reproducible using Docker Compose.


## Architecture

The stack is designed to demonstrate a simple full pipeline:

```bash
[k6 Load Test]
      ↓
   Nginx
      ↓

 PHP-FPM Application
      ↓
Prometheus Metrics Exporter
      ↓
Prometheus Server
      ↓
Alertmanager
      ↓
Slow Requests Detected (P95)
      ↓
SPX Trigger Service
      ↓
SPX PHP Profiler
      ↓
Flamegraph Storage (/spx-data)
      ↓
Flamegraph UI (Web Viewer)
      ↓
Grafana Dashboards + Slack Alerts
```


## Repository Layout

```bash
project-root/
├── docker-compose.yml              # Service definitions
│
├── nginx/
│   └── default.conf                # Nginx config and default site settings
│
├── php/
│   ├── php.dockerfile              # PHP Dockerfile
│   └── spx.ini                     # SPX configs
│
├── prometheus/
│   ├── prometheus.yml              # Prometheus scrape configuration
│   └── alerts.yml                  # Alert rules
│
├── alertmanager/
│   ├── alertmanager.dockerfile     # Alertmanager Dockerfile
│   ├── entrypoint.sh               # Docker entrypoint
│   └── alertmanager.yml            # Alertmanager configuration
│
├── spx-trigger/
│   ├── spx.dockerfile              # PHP-SPX Dockerfile
│   └── index.js                    # Node.js service that receives alerts and enables SPX profiling
│
├── k6/
│   ├── k6.dockerfile               # K6 Dockerfile
│   └── ingest_slow_requests.js     # Load testing script
│   └── entrypoint.sh               # Docker entrypoint
│
├── src/
│   ├── index.php                   # PHP Application entrypoint
│   ├── metrics.php                 # PHP prometheus metrics endpoint
│   └── flamegraphs.php             # Flamegraphs json files web viewer
│   └── spx_prepend.php             # SPX integration
│
└── spx-data/                       # Persistent SPX flamegraph output
│
├── testing/                        # Local testing with k6
│   └── makefile                    # Automated Testing
│   └── scripts/
│   └────  ingest_slow_requests.sh  # Load testing script
```

## Setup, Requirement & Installation

### Requirements

- Docker & Docker Compose
- Optional : 
    - Node.js & K6 (only if need to test locally with `/testing`)

### Setup & Installation 

1. Clone the repository

```bash
git clone https://github.com/khalid-el-masnaoui/Performance-Observability-Profiling-Pipeline
cd Performance-Observability-Profiling-Pipeline
```

2. Copy `.env.example` to `.env` in the repo root folder(configure you SLACK_WEBHOOK URL ...etc)

3. Start the full stack
```bash
docker compose up -d --build

```
4. Services

| Service | URL |
|---|---|
| App | http://localhost:8080 |
| Prometheus  |	http://localhost:9090 |
| Grafana |	http://localhost:3000 |
| Alertmanager  |	 http://localhost:9093
| Flamegraph UI  |	http://localhost:8080/flamegraphs
| SPX Web UI | http://localhost:8080/?SPX_KEY=dev&SPX_UI=1&SPX_UI_URI=/ 

**Note**: The SPX web UI is only available when profiling is triggered!

5. Application Endpoints

- `/` — home route
- `/api/users` — sample API route
- `/metrics` — Prometheus metrics output
- `/flamegraphs` — SPX flamegraph index page
- `/spx-data/<file>.json` — direct SPX flamegraph JSON access
- `/status` — PHP-FPM status endpoint

### Customization

- Add new Prometheus rules in `prometheus/alerts.yml`
- Extend the PHP app in `src/index.php`
- Add new SPX profiling logic in `src/spx_prepend.php`
- Add UI or search to `src/flamegraphs.php`
- Change Nginx routing in `nginx/default.conf`

## How it works

### 1. Request Flow

Each request passes through:

- Nginx routing
- PHP execution
- Metrics collection (Prometheus client)
- Timing instrumentation per route

### 2. Metrics Collection

Each endpoint exposes:

- Request duration histogram
- Route labels
- Status codes

Example metric:
```bash
app_request_duration_seconds_bucket{route="/api/users"}
```
