#!/bin/bash

app/console doctrine:database:create "$@"
app/console doctrine:schema:create "$@"
app/console doctrine:schema:update --force "$@"
./assets.sh "$@"
app/console doctrine:fixtures:load "$@"
