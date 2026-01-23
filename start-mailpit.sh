#!/bin/bash
# Check if Mailpit is already running
if ! pgrep -x "mailpit" > /dev/null
then
    echo "Starting Mailpit..."
    mailpit --ui-port 8085 --smtp-port 1025 &
else
    echo "Mailpit already running"
fi
