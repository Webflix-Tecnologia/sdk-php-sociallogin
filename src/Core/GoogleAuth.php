<?php

namespace SocialLogin\Core;

class GoogleAuth extends GoogleController {
    public function __construct(array $config = []) {
        $config = array_replace_recursive($config, [
            'base_uri' => self::GOOGLE_TOKEN,
        ]);
        parent::__construct($config);
    }
}