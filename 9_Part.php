aA<?php

/**   
 *Plugin Name: DevXpert
 *Plugin URL : http://DevXpert.com
 *Description: Welcome to DevXpert, the ultimate development toolkit designed to empower both novice and experienced WordPress developers.
 *            Whether you’re just starting out or you’re a seasoned pro, DevXpert offers a comprehensive suite of tools and features that rival premium plugins.
 *Version: 1.0
 *Author: Anup_Kankale
 *Author URl: http://anupkankale.com
 * @package Plugin_Development
 */

//similar Step 3
defined('ABSPATH') or die('Hey what are you doing here ?');


if (!class_exists('DevXpert')) {
    class DevXpert
    {
           public $plugin;
        function __construct()
        {
            $this->plugin = plugin_basename(__FILE__);
            add_action('init', array($this, 'custom_post_type'));

        }

        function register()
        {
            //Its use for to link a CSS File 
            //if  its don't show the file in network tab then change the admin_enqueue_scripts to wp_enqueue_scripts
            add_action('wp_enqueue_scripts', array($this, 'enqueue'));
            add_action('admin_menu', array($this,'add_admin_page'));
            add_filter("plugin_action_links_$this->plugin", array($this, 'setting_link'));
        }
        public function setting_link ($links){
            //Add Custom Setting Link
            $setting_link ='<a href="admin.php?page=DevXpert_plugin">Setting </a>';
            array_push( $links, $setting_link);
            return $links;

        }
 
        public function add_admin_page() {
            //add_menu_page( 'Page_title', 'Menu_title', 'Capability', 'Menu_slug', array( $this, 'admin_index' ), 'dashicons-store', 110 );
			add_menu_page( 'DevXpert Plugin', 'DevXpert', 'manage_options', 'DevXpert_plugin', array( $this, 'admin_index' ), 'dashicons-store', 110 );
		}
 
        public function admin_index(){
            // Load admin template
            require_once plugin_dir_path(__FILE__) . 'template/admin.php';
        }
           


        function custom_post_type()
        {
            //Inbulid Method to make Custom Post type Like We Create for News, Bookes, Movies
            register_post_type('Book', ['public' => true, 'label' => 'Book']);
        }

        function enqueue()
        {
            //enqueue all our Scripts
            wp_enqueue_style('mypluginstyle', plugins_url('/assets/style.css', __FILE__));
            wp_enqueue_script('mypluginScript', plugins_url('/assets/script.js', __FILE__));
        }

        function activate()
        {
            require_once plugin_dir_path(__FILE__) . 'config/devXpert_activation.php';
            DevXpert_activation::activate();
        }
    }
    
    $devXpert = new DevXpert();
    $devXpert->register();
    $devXpert->activate();


    //Activation
    
    register_activation_hook(__FILE__, array('DevXpert_activation', 'activate'));

    //Dectivation
    require_once plugin_dir_path(__FILE__) . 'config/devXpert_deactivation.php';
    register_deactivation_hook(__FILE__, array('DevXpert_deactivation', 'deactivate'));

    //Uninstall 
}
