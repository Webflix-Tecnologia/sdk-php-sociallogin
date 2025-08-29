<?php
session_start();
include __DIR__ . '/../vendor/autoload.php';
$config = parse_ini_file("config.ini");

$socialLogin = new \SocialLogin\Google\Api();
$socialLogin
    ->setClientId($config['client_id_google'])
    ->setSecretKey($config['secret_key_google'])
    ->setRedirectGoogle($config['redirect_google']);

try {
    $response = $socialLogin->generateToken($_GET['code']);
    $accessToken = $response['access_token'];
    $result = $socialLogin->getUserInfo($accessToken);
    print_r($result);
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}