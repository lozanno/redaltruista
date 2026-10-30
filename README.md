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
- **Patrones de página** (`patterns/pagina-*.php`, y `patterns/evento-*.php` para las páginas hijas de Eventos): contenido completo de cada página institucional. Al crear o editar la página en producción, elige el patrón (p. ej. "Página – Sobre nosotros" para `/acerca-de/`, con la plantilla Página).

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

Todo el cambio lo hace `bin/publicar.php` en una sola corrida (≈1 s), con WP-CLI por SSH:

1. **Respaldo completo** desde GoDaddy (archivos + base de datos).
2. **Subir por SFTP** (no cambia nada del sitio mientras no se active):
   - `wp-content/themes/redaltruista` y `wp-content/plugins/ra-directorio` a su lugar en `wp-content/`.
   - `bin/publicar.php`, `bin/formularios.php` y la carpeta `medios/` a una misma carpeta, p. ej. `~/publicar/`.
3. **Simular**: `wp eval-file ~/publicar/publicar.php simular` — revisa que estén las páginas, patrones, imágenes y el logo, y lista lo que hará.
4. **Publicar**: `wp eval-file ~/publicar/publicar.php`. En orden:
   - activa Contact Form 7, ra-directorio y el tema Red Altruista;
   - importa las 28 asociaciones (logos de la Biblioteca) y crea el formulario «Contacto» (el de ejemplo de 2017 va a la papelera);
   - pone a cada página el contenido de su patrón, con título, plantilla, página superior, imagen destacada y fecha (el contenido de Avada queda como revisión). La portada actual (`home-2`) recibe Inicio; los eventos pasan debajo de Eventos (las URL viejas redirigen solas) y se sube `encuentro-2024-portada.jpg`;
   - pasa a borrador Programas y Servicios y Registro (sin Avada mostrarían shortcodes) y manda a la papelera la página «Asociaciones Afiliadas» (el directorio ocupa su URL);
   - pone el logo (`Logo-Comercial-small.png`) y desactiva Avada Builder y Avada Core.
5. **Revisar** el sitio y hacer un envío de prueba en /contactanos/ (debe llegar a `info@redaltruista.org`).
6. **Volver atrás**, si hiciera falta: restaurar el respaldo (o activar Avada y sus plugins: el contenido anterior está en las revisiones de cada página).

Es idempotente: si algo falla a medias, se corrige y se vuelve a correr. Las páginas y adjuntos se buscan por slug y por ID (los mismos que en producción).

**Ensayo local** sobre una copia exacta de producción (Avada incluido, MySQL de Homebrew): `bin/ensayo.sh` la rehace desde el respaldo y la sirve en http://localhost:8081; luego `bin/wp-ensayo eval-file bin/publicar.php`. Ensayado con el respaldo del 30-oct-2026: sin avisos, todas las páginas responden, el formulario envía.

## Pendientes conocidos

- Las cifras de voluntarios (203) y proyectos (32) vienen del sitio actual; el cliente las actualiza en la página de Inicio. El número de asociaciones es automático.
- Formularios "Registro – Asociación" y "Constituirse": agregarlos a `bin/formularios.php` (Contact Form 7) y enlazarlos desde el llamado "Afilia tu asociación".
