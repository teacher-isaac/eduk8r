#!/usr/bin/bash
#
# usage: build-run.sh [DEV|PROD]

SCRIPT=$(realpath "$0")
SCRIPT_PATH=$(dirname "$SCRIPT")
PRG_PATH=$(dirname "$SCRIPT_PATH")
echo "PRG_PATH: $PRG_PATH"
IMAGE_NAME=eduk8r-app
CONTAINER_NAME=eduk8r-runtime
TARGET=PROD

if [ ! -z "$1" ]
then
	TARGET="$1"
fi

docker build -t $IMAGE_NAME .

if [ "$TARGET" == "DEV" ]
then
	docker run \
		--detach=true \
		--publish 127.0.0.1:8080:8080 \
		--mount "type=bind,source=$PRG_PATH/include,destination=/var/www/eduk8r/include" \
		--mount "type=bind,source=$PRG_PATH/lib,destination=/var/www/eduk8r/lib" \
		--mount "type=bind,source=$PRG_PATH/www,destination=/var/www/eduk8r/www" \
		--name $CONTAINER_NAME $IMAGE_NAME
else
	docker volume rm include lib www
	docker volume create include
	docker volume create lib
	docker volume create www
	docker run \
		--detach=true \
		--publish 127.0.0.1:8080:8080 \
		--volume include:/var/www/eduk8r/include:ro \
		--volume lib:/var/www/eduk8r/lib:ro \
		--volume www:/var/www/eduk8r/www:ro \
		--name $CONTAINER_NAME $IMAGE_NAME
fi
