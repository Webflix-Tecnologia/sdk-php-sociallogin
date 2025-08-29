<?php

namespace SocialLogin\Core;

class AppleAuth extends AppleController {
    public function __construct(array $config = []) {
        $config = array_replace_recursive($config, [
            'base_uri' => self::APPLE_AUTH,
        ]);
        parent::__construct($config);
    }
}