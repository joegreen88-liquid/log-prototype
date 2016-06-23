#!/bin/bash

# Create the virtual machine for docker
docker-machine create -d virtualbox log-prototype

# Enable nfs on the virtual machine
docker-machine-nfs log-prototype

# Set up some filepath vars
host_project_root="$(cd "$(dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Link the folders in the VM
docker-machine ssh log-prototype "sudo ln -s $host_project_root/webapp /webapp-data"

# (Re)build the docker containers
eval "$(docker-machine env log-prototype)"
docker-compose stop
docker-compose rm
docker-compose up -d
