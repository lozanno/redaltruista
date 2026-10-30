<?php
/**
 * Router para el servidor embebido de PHP (lo usa bin/serve.sh).
 *
 * Hace lo que Apache hace solo: /wp-admin → /wp-admin/. Sin esa barra final,
 * los enlaces relativos del admin (plugins.php, themes.php…) apuntan a la raíz y dan 404.
 * Todo lo demás lo resuelve el servidor como siempre (archivos, index.php, enlaces permanentes).
 */

$ra_uri  = $_SERVER['REQUEST_URI'];
$ra_path = parse_url( $ra_uri, PHP_URL_PATH );

if ( '/' !== substr( $ra_path, -1 ) && is_dir( $_SERVER['DOCUMENT_ROOT'] . rawurldecode( $ra_path ) ) ) {
	$ra_query = parse_url( $ra_uri, PHP_URL_QUERY );
	header( 'Location: ' . $ra_path . '/' . ( $ra_query ? '?' . $ra_query : '' ), true, 301 );
	return true;
}

return false;
