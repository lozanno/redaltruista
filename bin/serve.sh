#!/usr/bin/env bash
# Arranca el WordPress local en http://localhost:8080 (Ctrl+C para detenerlo).
set -e
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
if ! command -v php >/dev/null 2>&1; then
  echo "No encuentro PHP. Instálalo con:  brew install php"
  exit 1
fi
if ! php -m | grep -qi pdo_sqlite; then
  echo "Tu PHP no tiene la extensión pdo_sqlite. Usa el PHP de Homebrew:  brew install php"
  exit 1
fi
# Enlaza el tema y el plugin del repo dentro del WordPress local (solo la primera vez).
WPC="$ROOT/local/wp/wp-content"
link() { # link <destino relativo> <ruta del enlace>
  if [ ! -L "$2" ]; then
    rm -rf "$2"
    ln -s "$1" "$2"
  fi
}
link ../../../../wp-content/themes/redaltruista  "$WPC/themes/redaltruista"
link ../../../../wp-content/plugins/ra-directorio "$WPC/plugins/ra-directorio"

cd "$ROOT/local/wp"
echo "WordPress local: http://localhost:8080   ·   Admin: http://localhost:8080/wp-admin  (admin / admin)"
exec php -S localhost:8080 -t .
