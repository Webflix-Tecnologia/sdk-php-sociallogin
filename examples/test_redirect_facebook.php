<?php
session_start();
include __DIR__ . '/../vendor/autoload.php';
$config = parse_ini_file("config.ini");

$socialLogin = new \SocialLogin\Facebook\Api();
$socialLogin
    ->setAppId($config['app_id_facebook'])
    ->setRedirectFacebook($config['redirect_facebook'])
    ->setSecretId($config['secret_id_facebook']);

try {
    $response = $socialLogin->generateToken($_GET['code']);
    $accessToken = $response['access_token'];
    $result = $socialLogin->getUserInfo($accessToken);
    print_r($result);
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}