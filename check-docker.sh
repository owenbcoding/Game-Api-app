#!/usr/bin/env bash
# Quick check: can WSL reach the Docker daemon? (Run this from WSL.)
echo "=== Docker connectivity check (WSL) ==="
echo ""

if [ -S /var/run/docker.sock ]; then
  echo "✓ Socket found: /var/run/docker.sock"
else
  echo "✗ Socket missing: /var/run/docker.sock"
  echo ""
  echo "→ Enable WSL integration in Docker Desktop:"
  echo "  Settings → Resources → WSL Integration"
  echo "  Turn ON for your distro (e.g. Ubuntu-24.04), then Apply & Restart."
  exit 1
fi

if docker info > /dev/null 2>&1; then
  echo "✓ Docker daemon is reachable"
  echo ""
  docker info --format 'Server Version: {{.ServerVersion}}'
  echo ""
  echo "You can run: sail up -d"
else
  echo "✗ Docker daemon not reachable (docker info failed)"
  echo ""
  echo "→ In Docker Desktop (Windows):"
  echo "  1. Settings (gear) → Resources → WSL Integration"
  echo "  2. Enable 'Use the WSL 2 based engine' if needed"
  echo "  3. Turn ON integration for this distro (e.g. Ubuntu-24.04)"
  echo "  4. Apply & Restart"
  echo "  5. Close and reopen this terminal, then run this script again."
  exit 1
fi
