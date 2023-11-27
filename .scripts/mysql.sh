#!/bin/bash
docker-compose -f $PWD/docker-compose.yml exec db mysql $@
