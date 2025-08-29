<?php
session_start();

include __DIR__ . '/../vendor/autoload.php';
$config = parse_ini_file("config.ini");
//Login pela Google
/*$socialLogin = new \SocialLogin\Google\Api();
$socialLogin
    ->setClientId($config['client_id_google'])
    ->setRedirectGoogle($config['redirect_google']);

try {
    $socialLogin->login(session_id());
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}*/
//Login pelo Facebook
/*$socialLogin = new \SocialLogin\Facebook\Api();
$socialLogin
    ->setAppId($config['app_id_facebook'])
    ->setSecretId($config['secret_id_facebook'])
    ->setRedirectFacebook($config['redirect_facebook']);

try {
    $socialLogin->login(session_id());
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}*/
//Login pela Apple
$socialLogin = new \SocialLogin\Apple\Api();
$socialLogin
    ->setKeyId($config['APPLE_KEY_ID'])
    ->setClientId($config['APPLE_CLIENT_ID'])
    ->setPrivateKeyPath($config['APPLE_PRIVATE_KEY_PATH'])
    ->setRedirectApple($config['APPLE_REDIRECT_URI'])
    ->setTeamId($config['APPLE_TEAM_ID']);

try {
    $state = bin2hex(random_bytes(8));
    $nonce = bin2hex(random_bytes(16));
    $_SESSION['apple_state'] = $state;
    $_SESSION['apple_nonce'] = $nonce;
    $socialLogin->login($state, $nonce);
}catch (\SocialLogin\Exceptions\SocialLoginException $ex) {
    var_dump($ex);
}