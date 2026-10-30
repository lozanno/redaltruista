# redaltruista.org — sitio sin Avada

Reconstrucción del sitio de la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas con WordPress + Gutenberg (tema de bloques), sin page builder.

```
wp-content/
├── themes/redaltruista/        Tema de bloques (theme.json, plantillas, patrones, fuentes locales)
└── plugins/ra-directorio/      Directorio de asociaciones (CPT, áreas, campos, bloques, importador)
```

## Tema `redaltruista`

- **theme.json** con la paleta y las tipografías del sitio actual (extraídas de Avada):
  - Verde azulado `#00827b`, turquesa `#00afa9`, cian `#00bcd4` (botones), menta `#98dad9`, amarillo `#fec96b`, coral `#ed6967`, azul noche `#262e44`, texto `#5c6668`.
  - Montserrat (títulos), Raleway (texto) y Roboto Condensed (menú y botones), servidas desde el propio tema (`assets/fonts`, sin Google Fonts).
- **Plantillas**: `page` (con banda de título), `page-sin-titulo` (ancho completo, para Inicio y páginas armadas con secciones), `archive-asociacion` (directorio), `taxonomy-area-servicio`, `single-asociacion`, `single`, `index`, `404`.
- **Partes**: `header` (logo, menú, botones Voluntario/Dona) y `footer` (acerca de, contacto, redes).
- **Patrones** (insertador → Red Altruista): portada, objetivo, caminos (conoce / afíliate / constitúyete), nuestros programas (ancla `#programas`), cifras, nuestras asociaciones (con filtro por área), llamado a afiliarse, tarjeta de persona.
- **Patrones de página** (`patterns/pagina-*.php`): contenido completo de cada página institucional. Al crear o editar la página en producción, elige el patrón (p. ej. "Página – Sobre nosotros" para `/acerca-de/`, con la plantilla Página).

## Plugin `ra-directorio`

- Tipo de contenido **Asociación** (`asociacion`):
  - `/asociaciones-afiliadas/` → directorio (misma URL que hoy)
  - `/asociaciones-afiliadas/{nombre}/` → ficha de cada asociación
  - `/area/{area}/` → directorio filtrado
- **Logo** = imagen destacada. **Descripción** = contenido. **Orden** = atributo "Orden" (de 10 en 10).
- **Áreas de servicio** (taxonomía con casillas): salud, educación, niñez, adultos mayores, discapacidad, asistencia comunitaria, derechos humanos, medio ambiente.
- Caja **Enlaces y redes sociales**: sitio web, Facebook, Instagram, X, TikTok, YouTube, correo y teléfono. Solo se muestra lo que tenga valor. Acepta dominios sin `https://`.
- **Bloques**: `Enlaces de la asociación` (botón "Ir a la web" + íconos) y `Filtro por área de servicio`. Sin paso de compilación.
- **Shortcode `[ra_total_asociaciones]`**: imprime cuántas asociaciones hay publicadas en el directorio. Úsalo en cualquier texto (párrafo, encabezado, pie) en lugar de escribir el número: se actualiza solo cuando entra o sale una asociación. Una asociación en borrador o en la papelera no cuenta.
- **Importador** con los datos de las 28 asociaciones del sitio actual (`data/asociaciones.json`).

### Importar el directorio

Los logos se buscan por nombre de archivo en la Biblioteca de medios. En producción ya están ahí, así que no hay que subir nada.

Desde el admin: **Asociaciones → Importar** (primero en modo simulación).

Con WP-CLI:

```bash
wp ra-directorio import --dry-run
wp ra-directorio import                          # producción: toma logos de la biblioteca
wp ra-directorio import --logos=./logos          # local: sube los logos desde una carpeta
```

Es idempotente: las asociaciones que ya existen se omiten (usa `--update` para sobrescribir).

Las **áreas asignadas a cada asociación son una propuesta inicial**: hay que validarlas con el cliente.

## Formularios (Contact Form 7)

Los formularios se definen en `bin/formularios.php` (campos, correo y mensajes en español) y se crean o actualizan con:

```bash
bin/wp eval-file bin/formularios.php      # local
wp eval-file formularios.php              # producción, si hay WP-CLI
```

Sin WP-CLI, se pueden capturar a mano en **Contacto → Formularios** copiando los campos del archivo. Los patrones de página buscan cada formulario por su título ("Contacto").
Todos los correos van a `info@redaltruista.org`, el correo oficial.

En local, `local/wp/wp-content/mu-plugins/ra-correo-local.php` no envía correos: los escribe en `local/wp/wp-content/debug.log`.

## Desarrollo local (el plan de GoDaddy no tiene staging)

`local/` contiene un WordPress 7.1.4 (la misma versión que producción) con base de datos SQLite: no necesita MySQL, Docker ni LocalWP, solo PHP.
El tema y el plugin están enlazados (symlinks) a `wp-content/` del repo, así que lo que edites se ve al recargar.

```bash
cd ~/Development/redaltruista
bin/serve.sh                 # http://localhost:8080  ·  admin / admin
```

Si no tienes PHP: `brew install php`.

Ya trae: el tema y el plugin activos, las 28 asociaciones importadas con logos y las páginas del menú armadas con sus patrones de página.

Para cargar los logos reales, ponlos en `logos/` (mismos nombres de archivo que en el sitio) y corre:

```bash
bin/wp ra-directorio import --update --logos=logos
```

`bin/wp` es WP-CLI apuntando al sitio local (`bin/wp plugin list`, `bin/wp cache flush`, etc.).
La base de datos vive en `local/wp/wp-content/database/`; para empezar de cero, bórrala y pide reconstruir `local/`.

## Migración a producción (GoDaddy)

1. Respaldo completo (archivos + base de datos).
2. Subir `themes/redaltruista` y `plugins/ra-directorio` por el administrador de archivos o SFTP.
3. Activar **ra-directorio** → Asociaciones → Importar.
4. Mandar la página antigua "Asociaciones Afiliadas" a la papelera (el directorio nuevo ocupa esa URL).
5. Rehacer las páginas institucionales con bloques y patrones (en un staging o como borradores).
   - **Eventos**: cada evento es una página hija de Eventos con imagen destacada, y la cuadrícula se arma sola (orden por fecha de publicación). En producción, a Diplomado 2019 y a los Encuentros 2017, 2018, 2019, 2023 y 2024 asígnales *Superior: Eventos* e imagen destacada (`diplomado_2019-1.jpg`, `1erEncuentro_2017.jpg`, `2erEncuentro_2018.jpg`, `3erEncuentro_2019.jpg`, `evento-2023.jpg`, `evento-2024.jpg`), y a Encuentro 2017 la fecha 2017-09-01 para que quede en orden. Las URL viejas (`/encuentro-2024/`) redirigen solas a `/eventos/encuentro-2024/`.
6. Activar el tema **Red Altruista**. En el Editor del sitio, asignar el logo (bloque Logo del sitio): `Logo-Comercial-small.png` ("LA RED Altruista", el logo principal que usa Avada hoy). `logo-red-altruismo-color.png` es el diseño anterior y no se usa.
7. Desactivar Avada y Avada Builder/Core. Revisar menú, formularios y URLs.
8. Formularios: Contact Form 7 ya está instalado en producción. Crear los del sitio con `bin/formularios.php` y borrar el formulario de ejemplo de 2017 ("Contact form 1", en inglés y con envío a un correo personal). Hacer un envío de prueba para confirmar que llegan a `info@redaltruista.org`.

## Pendientes conocidos

- Las cifras de voluntarios (203) y proyectos (32) vienen del sitio actual; el cliente las actualiza en la página de Inicio. El número de asociaciones es automático.
- Formularios "Registro – Asociación" y "Constituirse": agregarlos a `bin/formularios.php` (Contact Form 7) y enlazarlos desde el llamado "Afilia tu asociación".
