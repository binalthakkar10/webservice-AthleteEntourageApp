<?php
$app_id = getenv("594880890607276");
$app_secret = getenv("e26c19f294c0124e7853068578a94478");
$app_namespace = getenv("letsnurture_app");
$app_url = 'https://apps.facebook.com/' . $app_namespace . '/';
$scope = 'email,publish_actions';
 
// Init the Facebook SDK
$facebook = new Facebook(array(
    'appId'  => $app_id,
    'secret' => $app_secret,
));