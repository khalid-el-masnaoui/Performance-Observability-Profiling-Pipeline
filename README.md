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
