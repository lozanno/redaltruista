( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl, ToggleControl } = wp.components;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'ra/filtro-areas', {
		edit( { attributes, setAttributes } ) {
			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: 'Ajustes' },
						el( TextControl, {
							label: 'Texto de "todas"',
							value: attributes.allLabel,
							onChange: ( v ) => setAttributes( { allLabel: v } ),
						} ),
						el( ToggleControl, {
							label: 'Mostrar número de asociaciones',
							checked: attributes.showCount,
							onChange: ( v ) => setAttributes( { showCount: v } ),
						} )
					)
				),
				el(
					'div',
					useBlockProps(),
					el( ServerSideRender, { block: 'ra/filtro-areas', attributes } )
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
