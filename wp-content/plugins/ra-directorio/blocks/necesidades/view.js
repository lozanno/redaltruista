/* Filtro por tipo del bloque ra/necesidades: muestra u oculta tarjetas sin recargar. */
document.querySelectorAll( '.ra-necesidades' ).forEach( ( bloque ) => {
	const filtro = bloque.querySelector( '.ra-nec-filtro' );
	if ( ! filtro ) {
		return;
	}
	filtro.hidden = false;
	filtro.addEventListener( 'click', ( evento ) => {
		const boton = evento.target.closest( 'button[data-tipo]' );
		if ( ! boton ) {
			return;
		}
		const tipo = boton.dataset.tipo;
		filtro.querySelectorAll( 'button' ).forEach( ( b ) => b.setAttribute( 'aria-pressed', String( b === boton ) ) );
		bloque.querySelectorAll( '.ra-nec' ).forEach( ( tarjeta ) => {
			tarjeta.hidden = tipo !== '' && tarjeta.dataset.tipo !== tipo;
		} );
	} );
} );
