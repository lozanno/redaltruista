# redaltruista.org — contexto para Claude Code

Reconstrucción del sitio de la Red de Asociaciones Altruistas (Puerto Vallarta) **sin Avada**, con WordPress + Gutenberg.
El cliente mantiene su hosting de WordPress en GoDaddy (sin staging, producción en WP 7.1.4). Sitio solo en español (es_MX).

## Estructura

- `wp-content/themes/redaltruista/` — tema de bloques. El diseño vive en `theme.json`; `style.css` solo para lo que theme.json no cubre.
- `wp-content/plugins/ra-directorio/` — CPT `asociacion` (archivo en `/asociaciones-afiliadas/`), taxonomía `area-servicio` (`/area/{slug}/`), campos en `includes/fields.php` (fuente única), meta box clásica, bloques dinámicos `ra/asociacion-enlaces` y `ra/filtro-areas` (sin build: `editor.js` con `wp.*` globales + `render.php`), importador (`data/asociaciones.json`, WP-CLI `wp ra-directorio import` y pantalla Asociaciones → Importar), shortcode `[ra_total_asociaciones]` (número de asociaciones publicadas: usarlo siempre en lugar de escribir la cifra).
- `local/` — WordPress local 7.1.4 con SQLite (no versionado). `local/ensayo/` es una copia de producción (con Avada, MySQL) para ensayar la publicación: `bin/ensayo.sh` y `bin/wp-ensayo`. `bin/serve.sh` lo arranca en http://localhost:8080 (admin/admin) con `bin/router.php` (agrega la barra final a carpetas como Apache; sin él `/wp-admin` rompe los enlaces del admin) y crea los symlinks del tema y plugin. `bin/wp` = WP-CLI del sitio local.
- `logos/` — logos descargados del sitio actual (no versionado).
- `medios/` — imágenes nuevas que no existen en producción y hay que subir a la Biblioteca (p. ej. `encuentro-2024-portada.jpg`, el cartel de 2024 sin la franja «¡Aparta la fecha!»).
- `*_full_*/` — respaldo completo de GoDaddy (no versionado: trae `wp-config.php` con credenciales). De ahí salieron los uploads y los 388 adjuntos del sitio local (mismos ID que en producción).
- `local/referencia/paginas/{slug}.txt` — contenido original (Avada) de cada página de producción, extraído del respaldo; fuente para la migración.

## Convenciones

- Sin page builders, sin dependencias de pago, sin paso de compilación JS.
- Prefijo `ra_` / `RA_DIR_` en el plugin; text domain `ra-directorio` y `redaltruista`. Textos de interfaz en español.
- Paleta (slugs de theme.json): primario `#00827b`, primario-claro `#00afa9`, acento `#00bcd4`, menta `#98dad9`, menta-suave, amarillo `#fec96b`, coral `#ed6967`, oscuro `#262e44`, texto `#5c6668`, gris-menu, gris-claro, blanco.
- Tipografías locales: Montserrat (títulos), Raleway (texto), Roboto Condensed (menú/botones).
- Validar PHP con `php -l` y probar en el sitio local antes de dar algo por terminado.
- Correo oficial: `info@redaltruista.org` (definitivo). El domicilio del pie es el del acta constitutiva, no una oficina que reciba visitas: no presentarlo como lugar de atención ni ponerle mapa.
- Formularios: Contact Form 7, definidos en `bin/formularios.php`.

## Estado (oct 2026)

Hecho: tema, plugin, importación de las 28 asociaciones con sus logos (tomados de la Biblioteca de medios, como en producción), Inicio (`redaltruista/pagina-inicio`: junta los patrones hero, objetivo, caminos, programas, cifras y nuestras-asociaciones; contenido editable en la página), Sobre nosotros (`redaltruista/pagina-sobre-nosotros`) y Contribuye (`redaltruista/pagina-contribuye`; la lista de necesidades es una hoja de Google que mantiene el cliente, solo se incrusta) y Eventos (`redaltruista/pagina-eventos`: Query Loop de las páginas hijas de Eventos; las 6 hijas —Diplomado 2019 y Encuentros 2017, 2018, 2019, 2023 y 2024— con su patrón `redaltruista/evento-*`: ficha, programa y ponentes, generados por `redaltruista_evento()` en `inc/eventos.php`; sin galerías, registro, costos, patrocinadores ni CTA) Transparencia (`redaltruista/pagina-transparencia`: línea de tiempo) y Contáctanos (`redaltruista/pagina-contactanos`: medios de contacto y formulario «Contacto» de CF7) en el sitio local.

Páginas institucionales: cada una es un patrón de página en `patterns/pagina-*.php` (`Post Types: page`, imágenes por ID de adjunto, mismos ID que producción). En producción se crea/edita la página y se elige el patrón; el contenido queda editable. El `wp-config.php` local define `WP_DEVELOPMENT_MODE` = `theme` para que los patrones nuevos se registren sin caché.

Pendiente:
1. Migrar el contenido de las páginas del sitio actual (redaltruista.org): ~~Inicio~~, ~~Sobre nosotros (`/acerca-de/`)~~, ~~Contribuye~~, ~~Eventos~~ (índice), ~~Transparencia~~, ~~Contáctanos~~ — reconstruir con bloques/patrones, sin shortcodes de Avada. ~~Páginas hijas de Eventos~~. Producción tiene además Programas y Servicios y Registro (decidir con el cliente si se migran).
2. Necesidades en el CPT `asociacion`: que cada asociación tenga sus necesidades (tipo: especie / económico / voluntariado, descripción, frecuencia o cantidad, contacto) editables desde WordPress, y un bloque dinámico que las liste (por tipo, con enlace a la ficha) para reemplazar la hoja de Google incrustada en Contribuye. Así el cliente actualiza todo desde WordPress. Datos iniciales: la hoja actual (`…/pub?output=csv`).
3. Formularios "Registro – Asociación" y "Constituirse" (eran modales de Avada; en producción son el mismo formulario de Avada, ID 1407, solo cambia el título del modal): agregarlos a `bin/formularios.php` (Contact Form 7, ya instalado en producción, 6.2.3) y que lleven a cada uno los botones del llamado "Afilia tu asociación" y los de las tarjetas "Solicitar información" del Inicio (patrón `caminos`, hoy a `/contactanos/#formulario`). Revisar antispam (Akismet está en producción; los campos ya llevan etiquetas `akismet:`).
4. Validar con el cliente: áreas asignadas a cada asociación, cifras de voluntarios (203) y proyectos activos (32), tomadas de producción: el cliente las actualiza en la página de Inicio. Año de fundación: la banda de Sobre nosotros y el texto del Inicio dicen 2009, la historia de Sobre nosotros 2008; la referencia es la línea de tiempo de /transparencia (2008 reuniones de vinculación, 2010 la RED opera formalmente, 2016 A.C.). Transparencia: qué documentos publicar (constancia de donataria autorizada, informes, estados financieros); el usuario lo consulta con el cliente.
5. Publicar en GoDaddy con `bin/publicar.php` (ensayado en `bin/ensayo.sh`; ver README → Migración a producción). Falta confirmar si el plan tiene SSH/WP-CLI; si no, envolver el script en una acción temporal del admin.
6. Después de publicar: necesidades por asociación (punto 2), que reemplaza la hoja de Google en Contribuye.

Repo: https://github.com/lozanno/redaltruista.git
