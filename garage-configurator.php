<?php
/**
 * Plugin Name: Garage Configurator
 * Plugin URI: http://www.mywebsite.com/my-first-plugin
 * Description: Garage Configurator
 * Version: 1.0
 * Author: webo.agency
 * Author URI: https://www.webo.agency
 */


add_action('wp_enqueue_scripts',function(){
   wp_register_style('garage_woocommerce', plugins_url('/garage-woocommerce.css', __FILE__), array(), '1.2'); 
   wp_enqueue_style('garage_woocommerce');

   wp_register_script( 'wcf7-submit-conf-garage', '', array("contact-form-7"), '', true );
   wp_enqueue_script( 'wcf7-submit-conf-garage'  );
   wp_add_inline_script( 'wcf7-submit-conf-garage', "

     document.querySelector('.wpcf7-form').addEventListener('submit click', (e) => {
       e.preventDefault()
       document.dispatchEvent(new CustomEvent('wpcf7loaded'), {eventOriginal: e});
     }, { capture: true });
     document.querySelector('.wpcf7-submit').addEventListener('click',(e) => {
       e.preventDefault()
       document.dispatchEvent(new CustomEvent('wpcf7loaded'), {eventOriginal: e});
	}, { capture: true });
   ");

 wp_register_script( 'garage_woocommerce_i18n', plugins_url( '/garage_woocommerce.js', __FILE__ ), array( 'wp-i18n' ), '1.2' );



 // Register the script
 //wp_register_script( 'garage_woocommerce_i18n', plugins_url( '/garage_woocommerce.js', __FILE__ ), array( ), '1.2' , false);
 
 // Localize the script with new data
 // $translation_array = array(
 //   'some_string' => __( 'Some string to translate', 'garage_woocommerce' )
 //);
 //wp_localize_script( 'garage_woocommerce_i18n', 'garage_woocommerce_i18n_translations', $translation_array );
 
 // Enqueued script with localized data.
 wp_enqueue_script( 'garage_woocommerce_i18n' );

 wp_set_script_translations( 'garage_woocommerce_i18n', 'garage-woocommerce' );

}, 1000);




add_action('woocommerce_before_single_product', 'garage_product_configurable');

function garage_product_configurable() {
    global $product;
    $id = $product->get_id();

	if($id == 15){
      require(__DIR__ . '/template/index.html');
    }
}

add_action( 'init', 'my_rewrite' );
function my_rewrite() {
  global $wp_rewrite;

  $plugin_url = plugins_url( '/', __FILE__ );
  $plugin_url = substr( $plugin_url, strlen( home_url() ) + 1 );

  add_rewrite_rule('configurator-custom(/.*|$)', $plugin_url . 'template/$1'  ,'top');

  $wp_rewrite->flush_rules(true);
}

