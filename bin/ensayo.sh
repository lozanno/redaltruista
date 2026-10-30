#!/usr/bin/env bash
# Ensayo de la publicación sobre una copia de producción (Avada incluido), con MySQL local.
#
#   bin/ensayo.sh            Rehace local/ensayo desde el respaldo de GoDaddy y lo sirve en http://localhost:8081
#   bin/ensayo.sh servir     Solo lo sirve (sin rehacerlo)
#
# Luego, en otra terminal, se ensaya igual que en producción:
#   bin/wp-ensayo eval-file bin/publicar.php simular
#   bin/wp-ensayo eval-file bin/publicar.php
#
# Necesita MySQL (brew install mysql && brew services start mysql) con root sin contraseña.
set -e
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
E="$ROOT/local/ensayo"
DB=redaltruista_ensayo
URL=http://localhost:8081

if [ "$1" != "servir" ]; then
  B="$(ls -d "$ROOT"/*_full_*/ 2>/dev/null | tail -1)"
  [ -n "$B" ] || { echo "No encuentro el respaldo (*_full_*/) en $ROOT"; exit 1; }
  SQL="$(ls "$B"mwp_db/*.sql | head -1)"
  PREFIJO="$(grep -o 'CREATE TABLE `[a-z0-9_]*_options`' "$SQL" | head -1 | sed 's/CREATE TABLE `\(.*\)options`/\1/')"
  echo "Respaldo: $B  ·  prefijo: $PREFIJO"

  rm -rf "$E"
  mkdir -p "$E"
  # Archivos de producción (las imágenes se clonan: en APFS no ocupan espacio extra).
  rsync -a --exclude 'wp-content/uploads' --exclude 'mwp_db' --exclude 'wp-config.php' --exclude 'source-wp-config.php' \
    --exclude '*.zip' --exclude 'wp-content/mu-plugins' "$B" "$E/"
  cp -Rc "$B/wp-content/uploads" "$E/wp-content/uploads"
  mkdir -p "$E/wp-content/mu-plugins"
  cp "$ROOT/local/wp/wp-content/mu-plugins/ra-correo-local.php" "$E/wp-content/mu-plugins/" # no manda correos

  # Lo que se sube por SFTP.
  rsync -a "$ROOT/wp-content/themes/redaltruista" "$E/wp-content/themes/"
  rsync -a "$ROOT/wp-content/plugins/ra-directorio" "$E/wp-content/plugins/"

  cat > "$E/wp-config.php" <<PHP
<?php
define( 'DB_NAME', '$DB' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
define( 'WP_HOME', '$URL' );
define( 'WP_SITEURL', '$URL' );
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
\$table_prefix = '$PREFIJO';
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
PHP

  mysql -uroot -e "DROP DATABASE IF EXISTS $DB; CREATE DATABASE $DB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;"
  { echo "SET SESSION sql_mode = '';"; cat "$SQL"; } | mysql -uroot "$DB" # el volcado trae fechas 0000-00-00
  "$ROOT/bin/wp-ensayo" search-replace 'https://redaltruista.org' "$URL" --all-tables-with-prefix --skip-columns=guid --quiet 2>/dev/null
  "$ROOT/bin/wp-ensayo" search-replace 'http://redaltruista.org' "$URL" --all-tables-with-prefix --skip-columns=guid --quiet 2>/dev/null
  echo "Copia de producción lista en $E"
fi

echo "Ensayo: $URL   (Ctrl+C para detenerlo)"
cd "$E"
exec php -S localhost:8081 -t . "$ROOT/bin/router.php"
