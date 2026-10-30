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
- **Patrones** (insertador → Red Altruista): portada, nuestros programas (ancla `#programas`), cifras, llamado a afiliarse.

## Plugin `ra-directorio`

- Tipo de contenido **Asociación** (`asociacion`):
  - `/asociaciones-afiliadas/` → directorio (misma URL que hoy)
  - `/asociaciones-afiliadas/{nombre}/` → ficha de cada asociación
  - `/area/{area}/` → directorio filtrado
- **Logo** = imagen destacada. **Descripción** = contenido. **Orden** = atributo "Orden" (de 10 en 10).
- **Áreas de servicio** (taxonomía con casillas): salud, educación, niñez, adultos mayores, discapacidad, asistencia comunitaria, derechos humanos, medio ambiente.
- Caja **Enlaces y redes sociales**: sitio web, Facebook, Instagram, X, TikTok, YouTube, correo y teléfono. Solo se muestra lo que tenga valor. Acepta dominios sin `https://`.
- **Bloques**: `Enlaces de la asociación` (botón "Ir a la web" + íconos) y `Filtro por área de servicio`. Sin paso de compilación.
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

## Desarrollo local (el plan de GoDaddy no tiene staging)

`local/` contiene un WordPress 7.1.4 (la misma versión que producción) con base de datos SQLite: no necesita MySQL, Docker ni LocalWP, solo PHP.
El tema y el plugin están enlazados (symlinks) a `wp-content/` del repo, así que lo que edites se ve al recargar.

```bash
cd ~/Development/redaltruista
bin/serve.sh                 # http://localhost:8080  ·  admin / admin
```

Si no tienes PHP: `brew install php`.

Ya trae: el tema y el plugin activos, las 28 asociaciones importadas, una página de Inicio armada con los patrones, y páginas vacías para el resto del menú.

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
6. Activar el tema **Red Altruista**. En el Editor del sitio, asignar el logo (bloque Logo del sitio).
7. Desactivar Avada y Avada Builder/Core. Revisar menú, formularios y URLs.

## Pendientes conocidos

- El correo del pie en el sitio actual enlaza a `info@redaltruista.com`, pero el texto dice `.org`. El tema usa `.org`: confirmar con el cliente.
- Las cifras de voluntarios y proyectos (patrón "Cifras") quedan como `XX` hasta que el cliente dé los números.
- Formularios "Registro – Asociación" y "Constituirse": falta elegir plugin (Contact Form 7 / Fluent Forms) y reemplazarlos.
