<?php

namespace SocialLogin\Core;

class GoogleController extends SocialLoginHttp {
    protected $clientId;
    protected $secretKey;
    protected $redirectGoogle;

    public function __construct(array $config = []) {
        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey) {
        $this->secretKey = $secretKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectGoogle()
    {
        return $this->redirectGoogle;
    }

    /**
     * @param mixed $redirectGoogle
     */
    public function setRedirectGoogle($redirectGoogle) {
        $this->redirectGoogle = $redirectGoogle;
        return $this;
    }
}