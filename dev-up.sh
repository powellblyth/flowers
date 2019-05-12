#!/bin/sh



export APPLICATION=../
export CONTAINER_NAME_PREFIX="flowers-dev"
export COMPOSE_PROJECT_NAME="flowers-dev"


echo "Building Flowers"

if [ "$1" == "" ] || [ "$1" == "up" ]; then
   VERB="up"
elif [ "$1" == "down" ]; then
   VERB="down"
#   AFTER="--rmi all"
else
   VERB="$1"
fi
docker-compose -f docker-compose.yml --project-name="${COMPOSE_PROJECT_NAME}" $VERB $AFTER

if [ $? -eq 0 ]
 then
    echo "All done. ${VERB}-ing ${APP_NAME}  Hope it worked"
else
    echo "might have been a problem ${VERB}-ing ${APP_NAME}"
fi
