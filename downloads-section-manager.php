<?php
/**
 * Plugin Name: Downloads Section Manager
 * Plugin URI: https://www.bakslash.com/servicios/woocommerce-chile
 * Description: Plugin minimalista para mostrar/ocultar la sección "Descargas" en WooCommerce Mi Cuenta.
 * Version: 1.0.0
 * Author: Bakslash & Eduardo Hernández Villa
 * Author URI: 
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 8.0
 * Text Domain: simple-downloads-section-manager
 * Domain Path: /languages
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit('No direct script access allowed');
}

// Verificar si WooCommerce está activo
add_action('plugins_loaded', function() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Downloads Section Manager</strong> requiere WooCommerce para funcionar.</p></div>';
        });
        return;
    }
    
    // Declarar compatibilidad con HPOS
    add_action('before_woocommerce_init', function() {
        if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('orders_cache', __FILE__, true);
        }
    });
    
    // Inicializar el plugin
    new Downloads_Section_Manager();
});

/**
 * Clase principal del plugin
 */
class Downloads_Section_Manager {
    
    /**
     * Versión del plugin
     */
    const VERSION = '1.0.0';
    
    /**
     * Opción para guardar configuración
     */
    const OPTION_NAME = 'dsm_downloads_enabled';
    
    /**
     * Constructor - Inicializar hooks
     */
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Hooks para controlar la funcionalidad
        add_filter('woocommerce_account_menu_items', array($this, 'manage_downloads_tab'));
        
        // Hook de activación
        register_activation_hook(__FILE__, array($this, 'activate'));
    }
    
    /**
     * Inicializar plugin
     */
    public function init() {
        // Cargar textdomain para traducciones
        load_plugin_textdomain('downloads-section-manager', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    /**
     * Activación del plugin - valores por defecto
     */
    public function activate() {
        // Por defecto, mantener las descargas habilitadas
        if (get_option(self::OPTION_NAME) === false) {
            update_option(self::OPTION_NAME, 'yes');
        }
    }
    
    /**
     * Inicializar admin
     */
    public function admin_init() {
        // Registrar configuración
        register_setting('dsm_settings', self::OPTION_NAME, array(
            'type' => 'string',
            'default' => 'yes',
            'sanitize_callback' => array($this, 'sanitize_checkbox')
        ));
        
        // Agregar sección y campo en WooCommerce > Configuración > Avanzado
        add_action('woocommerce_settings_advanced', array($this, 'add_woocommerce_setting'));
    }
    
    /**
     * Agregar menú en admin
     */
    public function add_admin_menu() {
        add_submenu_page(
            'woocommerce',
            __('Downloads Manager', 'downloads-section-manager'),
            __('Downloads Manager', 'downloads-section-manager'),
            'manage_woocommerce',
            'downloads-section-manager',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Página de administración
     */
    public function admin_page() {
        // Procesar formulario si se envió
        if (isset($_POST['submit']) && wp_verify_nonce($_POST['dsm_nonce'], 'dsm_save_settings')) {
            $enabled = isset($_POST[self::OPTION_NAME]) ? 'yes' : 'no';
            update_option(self::OPTION_NAME, $enabled);
            
            echo '<div class="notice notice-success"><p>' . 
                 __('Configuración guardada correctamente.', 'downloads-section-manager') . 
                 '</p></div>';
        }
        
        $enabled = get_option(self::OPTION_NAME, 'yes');
        ?>
        <div class="wrap">
            <h1><?php _e('Downloads Section Manager', 'downloads-section-manager'); ?></h1>
            
            <div class="dsm-admin-container">
                <div class="dsm-main-content">
                    <h2><?php _e('Configuración', 'downloads-section-manager'); ?></h2>
                    
                    <form method="post" action="">
                        <?php wp_nonce_field('dsm_save_settings', 'dsm_nonce'); ?>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php _e('Mostrar sección Descargas', 'downloads-section-manager'); ?>
                                </th>
                                <td>
                                    <label>
                                        <input type="checkbox" 
                                               name="<?php echo esc_attr(self::OPTION_NAME); ?>" 
                                               value="yes" 
                                               <?php checked($enabled, 'yes'); ?>>
                                        <?php _e('Habilitar la sección "Descargas" en Mi Cuenta', 'downloads-section-manager'); ?>
                                    </label>
                                    <p class="description">
                                        <?php _e('Desmarcar para ocultar completamente la pestaña Descargas del menú de Mi Cuenta.', 'downloads-section-manager'); ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        
                        <?php submit_button(__('Guardar Configuración', 'downloads-section-manager')); ?>
                    </form>
                </div>
                
                <div class="dsm-sidebar">
                    <div class="dsm-info-box">
                        <h3><?php _e('Información', 'downloads-section-manager'); ?></h3>
                        <p><?php _e('Este plugin te permite controlar si mostrar o no la sección "Descargas" en el área de Mi Cuenta de WooCommerce.', 'downloads-section-manager'); ?></p>
                        
                        <hr>
                        
                        <h4><?php _e('Estado actual:', 'downloads-section-manager'); ?></h4>
                        <p>
                            <span class="dsm-status dsm-status-<?php echo $enabled === 'yes' ? 'enabled' : 'disabled'; ?>">
                                <?php echo $enabled === 'yes' ? __('Habilitado', 'downloads-section-manager') : __('Deshabilitado', 'downloads-section-manager'); ?>
                            </span>
                        </p>
                        
                        <hr>
                        
                        <p><strong>Versión:</strong> <?php echo self::VERSION; ?></p>
                        <p><strong>Desarrollado por:</strong> <a href= " target="_blank">Bakslash & Eduardo Hernández Villa</a></p>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .dsm-admin-container {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            margin-top: 20px;
        }
        
        .dsm-main-content {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        
        .dsm-sidebar {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
            height: fit-content;
        }
        
        .dsm-info-box h3 {
            margin-top: 0;
            color: #23282d;
        }
        
        .dsm-status {
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        .dsm-status-enabled {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .dsm-status-disabled {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 782px) {
            .dsm-admin-container {
                grid-template-columns: 1fr;
            }
        }
        </style>
        <?php
    }
    
    /**
     * Agregar setting en WooCommerce > Configuración > Avanzado
     */
    public function add_woocommerce_setting() {
        $enabled = get_option(self::OPTION_NAME, 'yes');
        ?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <?php _e('Sección Descargas', 'downloads-section-manager'); ?>
            </th>
            <td class="forminp">
                <label>
                    <input type="checkbox" 
                           name="<?php echo esc_attr(self::OPTION_NAME); ?>" 
                           value="yes" 
                           <?php checked($enabled, 'yes'); ?>>
                    <?php _e('Mostrar sección Descargas en Mi Cuenta', 'downloads-section-manager'); ?>
                </label>
                <p class="description">
                    <?php _e('Controla si mostrar o no la pestaña Descargas en el área de cliente.', 'downloads-section-manager'); ?>
                </p>
            </td>
        </tr>
        <?php
    }
    
    /**
     * Controlar si mostrar o no la pestaña Downloads
     */
    public function manage_downloads_tab($items) {
        $enabled = get_option(self::OPTION_NAME, 'yes');
        
        // Si está deshabilitado, remover del menú
        if ($enabled !== 'yes' && isset($items['downloads'])) {
            unset($items['downloads']);
        }
        
        return $items;
    }
    
    /**
     * Sanitizar checkbox
     */
    public function sanitize_checkbox($input) {
        return $input === 'yes' ? 'yes' : 'no';
    }
}

/**
 * Función helper para verificar si las descargas están habilitadas
 * 
 * @return bool
 */
function dsm_downloads_enabled() {
    return get_option(Downloads_Section_Manager::OPTION_NAME, 'yes') === 'yes';
}