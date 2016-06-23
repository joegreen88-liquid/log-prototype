#!/bin/bash

# Project root path
host_project_root="$(cd "$(dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Ensure that we have a docker-machine-ip file
if [ ! -f "$host_project_root/.docker-machine-ip" ]; then
    echo "ERROR .docker-machine-ip file doesn't exist - run setup.sh first"
    exit 1
fi

# Put the docker machine IP address into a variable
ip="$(cat $host_project_root/.docker-machine-ip)"

if grep -q log-prototype /etc/hosts; then
    # Then we need to update an existing entry in /etc/hosts
    line=$(grep -n log-prototype /etc/hosts | grep -Eo '^[^:]+')
    if [ "$(uname)" == "Darwin" ]; then
        # osx sed format
        sed -i '' "${line}s/.*/$ip log-prototype/" /etc/hosts
    else
        # regular unix sed format
        sed -i "${line}s/.*/$ip log-prototype/" /etc/hosts
    fi
    echo "Updated log-prototype entry in hosts file"
else
    # Then we need to add a new entry to /etc/hosts
    echo "$ip log-prototype" >> /etc/hosts
    echo "Added log-prototype to hosts file"
fi
