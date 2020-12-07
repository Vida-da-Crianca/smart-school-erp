#!/usr/bin/env bash

List=(
    billet:generate
    invoice:cancel
    invoice:tribute
    billet:paid
    billet:cancel
    clean:directory
)

while [ true ]; do
    for c in ${List[*]}; do
        /usr/local/bin/php /app/man ${c}
        sleep 2
    done
    sleep 10
done
