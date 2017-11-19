<?php
/**
 * Created by PhpStorm.
 * User: Daniele
 * Date: 19/11/2017
 * Time: 15:18
 */

add_action( 'admin_menu', 'fcm_add_admin_menu' );
add_action( 'admin_init', 'fcm_settings_init' );


function fcm_add_admin_menu(  ) {

    add_options_page( 'Firebase Cloud Messaging', 'Firebase Cloud Messaging', 'manage_options', 'fcm', 'fcm_options_page' );

}


function fcm_settings_init(  ) {

    register_setting( 'pluginPage', 'fcm_settings' );

    add_settings_section(
        'fcm_pluginPage_section',
        __( 'Firebase Cloud Messaging', 'wordpress' ),
        'fcm_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'api_key',
        __( 'Api Key', 'wordpress' ),
        'api_key_render',
        'pluginPage',
        'fcm_pluginPage_section'
    );


}


function api_key_render(  ) {

    $options = get_option( 'fcm_settings' );
    ?>
    <input type='text' name='fcm_settings[api_key]' value='<?php echo $options['api_key']; ?>'>
    <?php

}


function fcm_settings_section_callback(  ) {

    echo __( 'Configuration Settings', 'wordpress' );

}


function fcm_options_page(  ) {

    ?>
    <form action='options.php' method='post'>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

    </form>
    <?php

}

?>