<?php
namespace SocialLogin\Core;

use GuzzleHttp\Client;
use phpDocumentor\Reflection\Types\Self_;

class SocialLoginHttp {
    protected Client $http;
    protected $config;
    const GOOGLE_AUTH = "https://accounts.google.com/o/oauth2/v2/auth";
    const GOOGLE_TOKEN = "https://oauth2.googleapis.com/token";
    const GOOOLE_API = "https://www.googleapis.com/oauth2/v1";
    const APPLE_AUTH = "https://appleid.apple.com/";
    const FACEBOOK_AUTH = "https://www.facebook.com/v17.0/dialog/oauth";
    const FACEBOOK_TOKEN = "https://graph.facebook.com/v17.0/oauth/access_token";
    const FACEBOOK_GRAPH = "https://graph.facebook.com/me";

    public function __construct(array $config = []) {
        $defaultConfig = array(
            'base_uri' => '',
            'timeout' => 30,
            'headers' => array(
                'content-type' => 'application/json',
                'Accept' => 'application/json',
            )
        );
        $this->config = array_replace_recursive($defaultConfig, $config);
        $this->http = new Client($this->config);
    }
}