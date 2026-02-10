#!/bin/bash
# Laravel Sail wrapper - run with: ./sail up
SCRIPT_DIR="${BASH_SOURCE[0]%/*}"
exec "$SCRIPT_DIR/vendor/bin/sail" "$@"
