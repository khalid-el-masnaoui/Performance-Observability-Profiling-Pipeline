#!/bin/sh
set -e

# Replace placeholders with environment variable values in the config file
sed -i "s|\${SLACK_WEBHOOK}|${SLACK_WEBHOOK}|g" /etc/alertmanager/alertmanager.yml
sed -i "s|\${SPX_TRIGGER_URL}|${SPX_TRIGGER_URL}|g" /etc/alertmanager/alertmanager.yml

# Start Alertmanager
exec alertmanager --config.file=/etc/alertmanager/alertmanager.yml
