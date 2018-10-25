<?php
session_start();
require_once( 'src/Facebook/autoload.php' );

$fb = new Facebook\Facebook([
  'app_id' => '436674993352607',
  'app_secret' => '175286cba570a928aff71ced7553ca1e',
  'default_graph_version' => 'v2.5',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions for more permission you need to send your application for review
$loginUrl = $helper->getLoginUrl('https://qykpay.com/fpx/social_login/callback.php', $permissions);
header("location: ".$loginUrl);

?>