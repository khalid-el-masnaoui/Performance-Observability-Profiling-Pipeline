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


## Architecture & Layout

### Architecture

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


### Repository Layout

```bash
project-root/
├── docker-compose.yml              # Service definitions

```
