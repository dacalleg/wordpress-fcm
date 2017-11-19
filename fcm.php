<?php
/**
 * Plugin Name:     Firebase Cloud Messaging
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Plugin for integrate FCM in Wordpress
 * Author:          Daniele Callegaro
 * Author URI:      YOUR SITE HERE
 * Text Domain:     wordpress
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Fcm
 */


require_once "option_page.php";
require_once "vendor/autoload.php";

use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Topic;
use paragraph1\phpFCM\Notification;


function post_published_notification($ID, $post)
{

    $options = get_option("fcm_settings");
    $api_key = $options["api_key"];


    $client = new Client();
    $client->setApiKey($api_key);
    $client->injectHttpClient(new \GuzzleHttp\Client());

    $categories = get_the_category($ID);

    foreach($categories as $category) {
        $message = new Message();
        $message->addRecipient(new Topic($post->post_type . "_" . $category["slug"]));
        $message->setNotification(new Notification($post->post_title, $post->post_excerpt))
            ->setData(array('ID' => $ID));

        $client->send($message);
    }
}

add_action( 'publish_post', 'post_published_notification', 10, 2 );