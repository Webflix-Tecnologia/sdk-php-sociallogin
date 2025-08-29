<?php
session_start();
include __DIR__ . '/../vendor/autoload.php';
$config = parse_ini_file("config.ini");

$socialLogin = new \SocialLogin\Apple\Api();
$socialLogin
    ->setKeyId($config['APPLE_KEY_ID'])
    ->setClientId($config['APPLE_CLIENT_ID'])
    ->setPrivateKeyPath($config['APPLE_PRIVATE_KEY_PATH'])
    ->setRedirectApple($config['APPLE_REDIRECT_URI'])
    ->setTeamId($config['APPLE_TEAM_ID']);

try {
    $data = $socialLogin->generateToken($_POST['code']);
    if(!isset($data['error'])) {
        $result = $socialLogin->validateToken($data, $_SESSION['apple_nonce']);
        print_r($result);
    }
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}