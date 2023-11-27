#!/bin/bash
docker-compose -f $PWD/docker-compose.yml exec php composer $@
