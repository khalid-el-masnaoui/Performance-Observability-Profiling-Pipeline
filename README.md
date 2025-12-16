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

## Setup & Installation

1. Clone the repository

```bash
git clone https://github.com/khalid-el-masnaoui/Performance-Observability-Profiling-Pipeline
cd Performance-Observability-Profiling-Pipeline
```
