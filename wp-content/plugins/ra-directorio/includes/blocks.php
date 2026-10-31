<?php
/**
 * Registro de los bloques dinámicos del directorio.
 *
 *  - ra/asociacion-enlaces : botón "Ir a la web" + íconos de redes (solo los que tengan valor).
 *  - ra/filtro-areas       : botones para filtrar el directorio por área de servicio.
 *  - ra/necesidades        : necesidades vigentes de las asociaciones (todas, o las de la asociación en contexto).
 *
 * No requieren compilación: el editor usa wp.serverSideRender para la vista previa.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	static function () {
		register_block_type( RA_DIR_PATH . 'blocks/asociacion-enlaces' );
		register_block_type( RA_DIR_PATH . 'blocks/filtro-areas' );
		register_block_type( RA_DIR_PATH . 'blocks/necesidades' );
	}
);
