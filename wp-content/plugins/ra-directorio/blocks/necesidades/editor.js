( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl, ToggleControl } = wp.components;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'ra/necesidades', {
		edit( { attributes, setAttributes, context } ) {
			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: 'Ajustes' },
						el( ToggleControl, {
							label: 'Solo las de esta asociación',
							help: 'Para la plantilla de la ficha de cada asociación.',
							checked: attributes.deAsociacion,
							onChange: ( v ) => setAttributes( { deAsociacion: v } ),
						} ),
						attributes.deAsociacion &&
							el( TextControl, {
								label: 'Título de la sección',
								value: attributes.titulo,
								onChange: ( v ) => setAttributes( { titulo: v } ),
							} ),
						! attributes.deAsociacion &&
							el( ToggleControl, {
								label: 'Mostrar filtro por tipo',
								checked: attributes.mostrarFiltro,
								onChange: ( v ) => setAttributes( { mostrarFiltro: v } ),
							} )
					)
				),
				el(
					'div',
					useBlockProps(),
					el( ServerSideRender, {
						block: 'ra/necesidades',
						attributes,
						urlQueryArgs: context.postId ? { post_id: context.postId } : {},
					} )
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
