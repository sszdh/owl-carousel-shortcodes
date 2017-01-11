<?php

/*
Plugin Name: Simple Owl Shortcodes
Plugin URI: https://github.com/sszdh/owl-carousel-shortcodes
Description: A simple shortcode generator for Owl Carousel. Add carousel Wrapper, carousel Items and options to your theme.
Version: 2.1.1
Author: Soheil Samadzadeh <s.samadzadeh@islet.ir>
Author URI: http://www.islet.ir
Text Domain: owl-carousel-shortcodes
*/


require_once( 'inc/owls_wrapper.php' );
require_once( 'inc/owls_item.php' );

class OwlsShortcodes {

  public $shortcodes = array(
    'wrapper',
    'item'
  );

  public function __construct() {
    add_action( 'init', array( &$this, 'init' ) );
    add_action( 'plugins_loaded' , array( &$this, 'load_textdomain' ));
    register_activation_hook( __FILE__, array( &$this, 'set_options_defaults' ) );
    add_action( 'admin_init', array( &$this, 'register_settings' ) );
    add_action( 'admin_menu', array( &$this, 'register_settings_page' ) );
  }

  function init() {
    $options = get_option( 'owls_options' );

    if( !is_admin() ) {
      if( isset( $options[ 'chk_default_options_css' ] ) && $options[ 'chk_default_options_css' ] ) {
        wp_enqueue_style( 'owls_css', plugins_url( 'assets/libs/owlcarousel/assets/owl.carousel.min.css', __FILE__ ) );
        wp_enqueue_style( 'owls_theme', plugins_url( 'assets/libs/owlcarousel/assets/owl.theme.default.min.css', __FILE__ ) );
      }
      if( isset( $options[ 'chk_default_options_js' ]) && $options[ 'chk_default_options_js' ] ) {
        wp_enqueue_script( 'owls_js', plugins_url( 'assets/libs/owlcarousel/owl.carousel.min.js', __FILE__ ) , array( 'jquery' ) );
      }
      if( isset( $options[ 'chk_defualt_options_script' ]) && $options[ 'chk_default_options_script' ]){
        wp_enqueue_script( 'owls_script', plugins_url( 'assets/js/script.js', __FILE__ ) , array( 'jquery' ) );
      }
    } else {
      wp_enqueue_style( 'owls_admin_style', plugins_url( 'assets/css/admin.css', __FILE__ ) );
    }

    if ( get_user_option( 'rich_editing' ) == 'true' ) {
      add_filter( 'mce_external_plugins', array( &$this, 'register_plugins' ) );
      add_filter( 'mce_buttons_2', array( &$this, 'register_btns' ) );
    }
  }

  function load_textdomain() {
    load_plugin_textdomain('owl-carousel-shortcodes', false, dirname(plugin_basename(__FILE__)) . '/languages');
  }

  function register_btns( $buttons ) {
    array_push($buttons, '|'); // The separator
    foreach ( $this->shortcodes as &$shortcode ) {
      array_push( $buttons, 'owls_' . $shortcode );
    }
    return $buttons;
  }

  function register_plugins( $plgs) {
    foreach ( $this->shortcodes as &$shortcode ) {
      $plgs[ 'owls_' . $shortcode ] = plugins_url( 'assets/js/plugins/' . $shortcode . '.js', __FILE__ );
    }
    return $plgs;
  }

  function register_settings_page() {
    add_options_page( esc_html__( 'Simple Owl Shortcodes', 'owl-carousel-shortcodes' ), esc_html__( 'Simple Owl Shortcodes', 'owl-carousel-shortcodes' ), 'manage_options', __FILE__, array( &$this, 'render_form') );
  }

  function set_options_defaults() {
    $arr = array(
        'chk_default_options_css'       => '1',
        'chk_default_options_js'        => '1',
        'chk_default_options_script'    => '1'
    );
    update_option( 'owls_options', $arr );
  }

  function register_settings() {
    register_setting( 'owls_plugin_options', 'owls_options' );
  }

  function render_form() {
    ?>
    <div class="wrap" id="owls-options">
      <div class="icon32" id="icon-options-general"><br></div>
      <h2><?php esc_html_e('Simple Owl Shortcodes Options', 'owl-carousel-shortcodes')?></h2>
      <form method="post" action="options.php">
        <?php settings_fields( 'owls_plugin_options' ); ?>
        <?php $options = get_option( 'owls_options'); ?>
        <table class="form-table">
          <tr><td colspan="2"><div style="margin-top:10px;"></div></td></tr>
          <tr valign="top" style="border-top:#dddddd 1px solid;">
            <th scope="row"><?php esc_html_e('Owl Carousel 2 CSS', 'owl-carousel-shortcodes')?></th>
            <td>
              <label><input name="owls_options[chk_default_options_css]" type="checkbox" value="1" <?php if ( isset( $options[ 'chk_default_options_css' ] ) ) { checked( '1', $options[ 'chk_default_options_css' ] ); } ?> /> <?php esc_html_e('Load Owl Carousel 2 css file', 'owl-carousel-shortcodes') ?></label><br /><span style="color:#666666;margin-left:2px;"><?php esc_html_e('Uncheck this if you already include Owl Carousel css on your template', 'owl-carousel-shortcodes')?></span>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php esc_html_e('Owl Carousel 2 JS', 'owl-carousel-shortcodes')?></th>
            <td>
              <label><input name="owls_options[chk_default_options_js]" type="checkbox" value="1" <?php if ( isset( $options[ 'chk_default_options_js' ] ) ) { checked( '1', $options[ 'chk_default_options_js' ] ); } ?> /> <?php esc_html_e('Load Owl Carousel 2 javascript file', 'owl-carousel-shortcodes') ?></label><br /><span style="color:#666666;margin-left:2px;"><?php esc_html_e('Uncheck this if you already include Owl Carousel javascript on your template', 'owl-carousel-shortcodes')?></span>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><?php esc_html_e('Attachment script', 'owl-carousel-shortcodes')?></th>
            <td>
              <label><input name="owls_options[chk_default_options_script]" type="checkbox" value="1" <?php if ( isset( $options[ 'chk_default_options_script' ] ) ) { checked( '1', $options[ 'chk_default_options_script' ] ); } ?> /> <?php esc_html_e('Load attachment script file', 'owl-carousel-shortcodes') ?></label><br /><span style="color:#666666;margin-left:2px;"><?php esc_html_e('Uncheck this if you already have customized Owl Carousel attachment script on your template', 'owl-carousel-shortcodes')?></span>
            </td>
          </tr>
          <tr class="top">
            <th scope="row"><?php esc_html_e('Attachment script preview', 'owl-carousel-shortcodes')?></th>
            <td>
              <textarea dir="ltr" rows="25" cols="80" readonly="true" style="width=100%">
                <?php
                if(dirname(__FILE__) . '/assets/js/script.js'){
                  echo file_get_contents(dirname(__FILE__) . '/assets/js/script.js');
                }
                ?>
              </textarea>
            </td>
          </tr>
        </table>
        <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>
    </div>
    <?php
  }
}

$owlscodes = new OwlsShortcodes();
