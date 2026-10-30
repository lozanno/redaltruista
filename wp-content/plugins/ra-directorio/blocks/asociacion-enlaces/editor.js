( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el, Fragment } = wp.element;
	const { useBlockProps, InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl, ToggleControl } = wp.components;
	const ServerSideRender = wp.serverSideRender;

	registerBlockType( 'ra/asociacion-enlaces', {
		edit( { attributes, setAttributes, context } ) {
			const blockProps = useBlockProps();
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
							label: 'Mostrar botón al sitio web',
							checked: attributes.showButton,
							onChange: ( v ) => setAttributes( { showButton: v } ),
						} ),
						el( TextControl, {
							label: 'Texto del botón',
							value: attributes.buttonText,
							onChange: ( v ) => setAttributes( { buttonText: v } ),
						} ),
						el( ToggleControl, {
							label: 'Mostrar teléfono y correo como texto',
							checked: attributes.showContact,
							onChange: ( v ) => setAttributes( { showContact: v } ),
						} )
					)
				),
				el(
					'div',
					blockProps,
					el( ServerSideRender, {
						block: 'ra/asociacion-enlaces',
						attributes,
						// Dentro de un Query Loop, el contexto trae el ID de cada asociación.
						urlQueryArgs: context && context.postId ? { post_id: context.postId } : {},
						EmptyResponsePlaceholder: () =>
							el( 'p', { style: { opacity: 0.6, fontSize: '13px' } }, 'Enlaces de la asociación (sin datos en esta vista previa)' ),
					} )
				)
			);
		},
		save: () => null,
	} );
} )( window.wp );
