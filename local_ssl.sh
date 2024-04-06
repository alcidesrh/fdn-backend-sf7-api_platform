#!/bin/bash
sudo docker cp $(docker compose ps -q php):/data/caddy/pki/authorities/local/root.crt /usr/local/share/ca-certificates/root.crt && sudo update-ca-certificates && sudo cp /usr/local/share/ca-certificates/root.crt /home/alcides/fdn/api/frankenphp
