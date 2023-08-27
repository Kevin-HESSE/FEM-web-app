#!/usr/bin/env bash

export ENV=${APP_ENV}

yarn install --frozen-lockfile

echo "$ENV"

if [ "$ENV" = "dev" ]
then
  yarn watch
else
  yarn build
fi