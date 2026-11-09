#!/bin/bash
# Uploads the theme to Hostinger, checks PHP syntax and clears the LiteSpeed cache.
# Needs SSH access by key (hPanel → Advanced → SSH Access).
set -euo pipefail
HOST="u359742695@82.29.189.253"
PORT=65002
SITE="domains/transbionet.eu/public_html"
cd "$(dirname "$0")"
rsync -az --delete --exclude '.DS_Store' -e "ssh -p $PORT" transbionet/ "$HOST:$SITE/wp-content/themes/transbionet/"
ssh -p $PORT "$HOST" "cd $SITE/wp-content/themes/transbionet && find . -name '*.php' -exec php -l {} \; | grep -v 'No syntax errors' || true; cd ~/$SITE && wp litespeed-purge all >/dev/null && echo 'Deployed, cache cleared.'"
