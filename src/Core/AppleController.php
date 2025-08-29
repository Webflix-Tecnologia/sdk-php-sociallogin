<?php

namespace SocialLogin\Core;

class AppleController extends SocialLoginHttp {
    protected $teamId;
    protected $clientId;
    protected $keyId;
    protected $privateKeyPath;
    protected $redirectApple;
    protected $secretClient;

    public function __construct(array $config = []) {
        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function getTeamId()
    {
        return $this->teamId;
    }

    /**
     * @param mixed $teamId
     */
    public function setTeamId($teamId) {
        $this->teamId = $teamId;
        return $this;
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
    public function getKeyId()
    {
        return $this->keyId;
    }

    /**
     * @param mixed $keyId
     */
    public function setKeyId($keyId) {
        $this->keyId = $keyId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivateKeyPath()
    {
        return $this->privateKeyPath;
    }

    /**
     * @param mixed $privateKeyPath
     */
    public function setPrivateKeyPath($privateKeyPath) {
        $this->privateKeyPath = $privateKeyPath;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectApple()
    {
        return $this->redirectApple;
    }

    /**
     * @param mixed $redirectApple
     */
    public function setRedirectApple($redirectApple) {
        $this->redirectApple = $redirectApple;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretClient()
    {
        return $this->secretClient;
    }

    /**
     * @param mixed $secretClient
     */
    public function setSecretClient($secretClient) {
        $this->secretClient = $secretClient;
        return $this;
    }
}