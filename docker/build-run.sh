#!/usr/bin/bash -x

IMG_NAME=eduk8r-app
IMG_RUN_NAME=eduk8r-runtime

docker build -t $IMG_NAME .
docker run -dp 127.0.0.1:8080:8080 --name $IMG_RUN_NAME $IMG_NAME
