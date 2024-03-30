#!/usr/bin/bash

IMG_RUN_NAME=eduk8r-runtime

docker stop $IMG_RUN_NAME
docker rm $IMG_RUN_NAME
