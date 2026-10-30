<?php
/**
 * Crea o actualiza los formularios de Contact Form 7 del sitio. Es idempotente.
 *
 * Local:       bin/wp eval-file bin/formularios.php
 * Producción:  wp eval-file formularios.php   (o copiar cada campo a mano en Contacto → Formularios)
 *
 * Los formularios se buscan por título; los patrones de página los insertan por ese mismo título.
 */

if ( ! function_exists( 'wpcf7_save_contact_form' ) ) {
	WP_CLI::error( 'Contact Form 7 no está activo.' );
}

$ra_correo = 'info@redaltruista.org';

$ra_mensajes = array(
	'mail_sent_ok'             => 'Gracias por escribirnos. Te responderemos lo antes posible.',
	'mail_sent_ng'             => 'No pudimos enviar tu mensaje. Inténtalo más tarde o escríbenos a ' . $ra_correo . '.',
	'validation_error'         => 'Revisa los campos marcados e inténtalo de nuevo.',
	'spam'                     => 'No pudimos enviar tu mensaje. Inténtalo más tarde o escríbenos a ' . $ra_correo . '.',
	'accept_terms'             => 'Debes aceptar para continuar.',
	'invalid_required'         => 'Este campo es obligatorio.',
	'invalid_too_long'         => 'Este texto es demasiado largo.',
	'invalid_too_short'        => 'Este texto es demasiado corto.',
	'upload_failed'            => 'No se pudo subir el archivo.',
	'invalid_email'            => 'Escribe un correo electrónico válido.',
	'invalid_tel'              => 'Escribe un número de teléfono válido.',
);

$ra_formularios = array(
	array(
		'title' => 'Contacto',
		'form'  => <<<'CF7'
<label> Nombre
    [text* nombre autocomplete:name akismet:author] </label>

<label> Correo electrónico
    [email* correo autocomplete:email akismet:author_email] </label>

<label> Teléfono (opcional)
    [tel telefono autocomplete:tel] </label>

<label> Asunto
    [select* asunto "Información general" "Quiero afiliar mi asociación" "Quiero constituir una asociación" "Donativos" "Voluntariado" "Otro"] </label>

<label> Mensaje
    [textarea* mensaje maxlength:3000] </label>

[submit "Enviar mensaje"]
CF7
		,
		'mail'  => array(
			'subject'            => 'Contacto desde el sitio: [asunto] · [nombre]',
			'sender'             => 'Red Altruista <' . $ra_correo . '>',
			'recipient'          => $ra_correo,
			'additional_headers' => 'Reply-To: [nombre] <[correo]>',
			'body'               => "Nombre: [nombre]\nCorreo: [correo]\nTeléfono: [telefono]\nAsunto: [asunto]\n\nMensaje:\n[mensaje]\n\n--\nEnviado desde el formulario de contacto de [_site_url]",
		),
	),
);

foreach ( $ra_formularios as $ra_f ) {
	$ra_existente = wpcf7_get_contact_form_by_title( $ra_f['title'] );
	$ra_cf        = wpcf7_save_contact_form(
		array(
			'id'       => $ra_existente ? $ra_existente->id() : -1,
			'title'    => $ra_f['title'],
			'locale'   => 'es_MX',
			'form'     => $ra_f['form'],
			'mail'     => $ra_f['mail'],
			'messages' => $ra_mensajes,
		)
	);
	if ( ! $ra_cf ) {
		WP_CLI::warning( "No se pudo guardar «{$ra_f['title']}»." );
		continue;
	}
	WP_CLI::success( sprintf( '%s «%s» (ID %d, hash %s).', $ra_existente ? 'Actualizado' : 'Creado', $ra_cf->title(), $ra_cf->id(), $ra_cf->hash() ) );
}
