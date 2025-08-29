<?php

namespace SocialLogin\Core;

class FacebookAuth extends FacebookController {
    public function __construct(array $config = []) {
        $config = array_replace_recursive($config, []);
        parent::__construct($config);
    }
}