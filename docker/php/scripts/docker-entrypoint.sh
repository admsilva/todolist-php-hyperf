#!/usr/bin/env sh
set -e

cp /app/.env.example /app/.env

exec php bin/hyperf.php server:watch