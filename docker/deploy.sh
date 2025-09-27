#!/usr/bin/env bash
set -euo pipefail

# Resolve repository root (the directory containing this script's parent).
ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

info() { printf '\033[1;34m[deploy]\033[0m %s\n' "$*"; }
warn() { printf '\033[1;33m[deploy]\033[0m %s\n' "$*"; }
error() { printf '\033[1;31m[deploy]\033[0m %s\n' "$*"; }

# Ensure required tools exist.
if command -v docker >/dev/null 2>&1 && docker compose version >/dev/null 2>&1; then
  COMPOSE=(docker compose)
elif command -v docker-compose >/dev/null 2>&1; then
  COMPOSE=(docker-compose)
else
  error "Docker Compose is not installed. Install Docker Desktop or docker-compose." >&2
  exit 1
fi

info "Using Compose command: ${COMPOSE[*]}"

# Prepare Laravel environment file if needed.
if [[ ! -f .env ]]; then
  if [[ -f .env.example ]]; then
    cp .env.example .env
    warn "No .env detected. Copied .env.example -> .env; review and customize as needed."
  else
    error ".env is missing and .env.example not found; cannot continue."
    exit 1
  fi
fi

# Optionally ensure writable storage directory (matching entrypoint expectations).
if [[ ! -d storage ]]; then
  warn "storage directory is missing; creating it for volume mount compatibility."
  mkdir -p storage
fi

info "Pulling latest base images (ignore errors if offline)..."
if ! "${COMPOSE[@]}" pull --ignore-pull-failures; then
  warn "Pull failed; continuing with locally cached images."
fi

info "Building application image..."
"${COMPOSE[@]}" build

info "Starting containers in detached mode..."
"${COMPOSE[@]}" up -d

info "Deployment complete. View logs with '${COMPOSE[*]} logs -f app' and stop with '${COMPOSE[*]} down'."
