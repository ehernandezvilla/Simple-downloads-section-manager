=== Simple Downloads Section Manager ===
Contributors: eduhvilla, bakslash
Tags: woocommerce, downloads, my-account, hide, toggle
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
WC requires at least: 5.0
WC tested up to: 8.0

Plugin minimalista para mostrar/ocultar la sección "Descargas" en WooCommerce Mi Cuenta.

== Description ==

**Simple Downloads Section Manager for WooCommerce** es un plugin súper simple que te permite controlar si mostrar o no la pestaña "Descargas" en el área de Mi Cuenta de WooCommerce.

### 🎯 ¿Para qué sirve?

Muchas tiendas online no venden productos digitales y no necesitan mostrar la sección de descargas a sus clientes. Este plugin te permite:

* **Ocultar completamente** la pestaña "Descargas" del menú Mi Cuenta
* **Activar/desactivar** con un simple toggle
* **Panel admin limpio** y fácil de usar
* **Sin configuraciones complejas** - solo ON/OFF

### ✨ Características

* ✅ **Super ligero** - Solo 1 archivo principal
* ✅ **No crea tablas** en la base de datos
* ✅ **Compatible** con todos los temas
* ✅ **Responsive** design en el admin
* ✅ **Traducible** (español incluido)
* ✅ **Seguro** - Usa nonces y sanitización
* ✅ **Integración nativa** con WooCommerce

### 🚀 Instalación Súper Fácil

1. Sube el plugin a `/wp-content/plugins/`
2. Actívalo desde WordPress Admin
3. Ve a **WooCommerce > Downloads Manager**
4. Toggle ON/OFF según necesites
5. ¡Listo!

### 🎨 Dónde Encontrar las Opciones

El plugin aparece en **2 lugares** para tu comodidad:

1. **WooCommerce > Downloads Manager** (recomendado)
2. **WooCommerce > Configuración > Avanzado** (acceso rápido)

### 👨‍💻 Para Desarrolladores

Incluye función helper para usar en tu código:

```php
if (function_exists('dsm_downloads_enabled')) {
    if (dsm_downloads_enabled()) {
        // Las descargas están habilitadas
    } else {
        // Las descargas están deshabilitadas
    }
}
```

### 🌟 ¿Por Qué Este Plugin?

* **WooCommerce no incluye** esta opción nativamente
* **Otros plugins** son demasiado complejos para algo tan simple
* **Código limpio** y optimizado
* **Cero bloat** - solo lo esencial

### 🔗 Desarrollado por Bakslash & Eduardo Hernández Villa

Especialistas en desarrollo WordPress y WooCommerce.
[Visita nuestro sitio web](https://www.bakslash.com)

== Installation ==

### Instalación Automática (Recomendada)

1. Ve a **Plugins > Añadir nuevo** en tu WordPress admin
2. Busca "Downloads Section Manager"
3. Haz clic en **"Instalar ahora"**
4. Activa el plugin
5. Ve a **WooCommerce > Downloads Manager** para configurar

### Instalación Manual

1. Descarga el archivo ZIP del plugin
2. Ve a **Plugins > Añadir nuevo > Subir plugin**
3. Selecciona el archivo ZIP y haz clic en **"Instalar ahora"**
4. Activa el plugin
5. Ve a **WooCommerce > Downloads Manager** para configurar

### Instalación vía FTP

1. Descomprime el archivo ZIP del plugin
2. Sube la carpeta `downloads-section-manager` a `/wp-content/plugins/`
3. Activa el plugin desde **Plugins** en WordPress admin
4. Ve a **WooCommerce > Downloads Manager** para configurar

### Requisitos

* WordPress 5.0 o superior
* WooCommerce 5.0 o superior
* PHP 7.4 o superior

== Frequently Asked Questions ==

= ¿Necesito WooCommerce para usar este plugin? =

Sí, este plugin requiere WooCommerce para funcionar. Si no tienes WooCommerce instalado, verás un aviso en el admin.

= ¿Elimina permanentemente las descargas de los clientes? =

No. El plugin solo oculta la pestaña del menú. Las descargas siguen existiendo en la base de datos y se pueden reactivar en cualquier momento.

= ¿Es compatible con mi tema? =

Sí, el plugin es compatible con todos los temas porque solo modifica el menú de WooCommerce, no el diseño visual.

= ¿Afecta el rendimiento de mi tienda? =

Para nada. Es súper ligero y solo ejecuta una función simple para mostrar/ocultar la pestaña.

= ¿Puedo personalizar qué otras pestañas mostrar? =

Esta versión solo controla la pestaña "Descargas". Si necesitas más opciones, contáctanos.

= ¿Dónde encuentro las opciones del plugin? =

En **WooCommerce > Downloads Manager** o en **WooCommerce > Configuración > Avanzado**.

= ¿Es seguro usar este plugin? =

Absolutamente. Usa todas las mejores prácticas de WordPress: nonces, sanitización, y no modifica tablas de la base de datos.

= ¿Incluye traducciones? =

Sí, incluye español y es compatible con herramientas de traducción como WPML y Polylang.

= ¿Funciona con multisite? =

Sí, funciona perfectamente en instalaciones multisite de WordPress.

= ¿Qué pasa si desactivo el plugin? =

La pestaña "Descargas" vuelve a aparecer automáticamente. No se pierde ningún dato.

== Screenshots ==

1. Panel de administración principal con toggle ON/OFF
2. Vista del menú Mi Cuenta con descargas habilitadas
3. Vista del menú Mi Cuenta con descargas deshabilitadas
4. Configuración en WooCommerce > Configuración > Avanzado

== Changelog ==

= 1.0.0 - 2024-11-17 =
* Lanzamiento inicial
* Toggle ON/OFF para sección Descargas
* Panel admin responsivo
* Integración nativa con WooCommerce
* Soporte para traducciones
* Función helper para desarrolladores
* Documentación completa

== Upgrade Notice ==

= 1.0.0 =
Primera versión del plugin. ¡Instala y disfruta del control total sobre la sección Descargas!

== Developer Notes ==

### Hooks Disponibles

El plugin usa los siguientes hooks de WordPress/WooCommerce:

* `woocommerce_account_menu_items` - Para remover la pestaña del menú
* `init` - Para cargar traducciones
* `admin_init` - Para registrar configuraciones
* `admin_menu` - Para agregar página de admin

### Función Helper

```php
/**
 * Verificar si las descargas están habilitadas
 * @return bool
 */
dsm_downloads_enabled()
```

### Constantes del Plugin

```php
Downloads_Section_Manager::VERSION     // Versión actual
Downloads_Section_Manager::OPTION_NAME // Nombre de la opción en wp_options
```

### Estructura de Archivos

```
downloads-section-manager/
├── downloads-section-manager.php  # Archivo principal
├── admin/
│   └── admin-styles.css           # Estilos del admin
├── readme.txt                     # Este archivo
└── languages/                     # Traducciones
```

== Support ==

### Soporte Técnico

Si encuentras algún problema o tienes preguntas:

1. **Documentación**: Lee este archivo readme completo
2. **Foros de WordPress**: [Plugin Support Forum](https://wordpress.org/support/plugin/downloads-section-manager/)
3. **Contacto directo**: [Bakslash.com](https://www.bakslash.com)

### Reportar Bugs

Si encuentras un bug, por favor incluye:

* Versión de WordPress
* Versión de WooCommerce  
* Tema activo
* Otros plugins activos
* Pasos para reproducir el problema

### Contribuir

¿Quieres contribuir al desarrollo? ¡Genial!

* Traducciones son muy bienvenidas
* Reportes de bugs ayudan muchísimo
* Sugerencias de mejoras

---

**¡Gracias por usar Simple Downloads Section Manager!** ⭐

Desarrollado con ❤️ por [Basklash](https://www.bakslash.com)