<?php

namespace SocialLogin\Core;

class FacebookController extends SocialLoginHttp {
    protected $appId;
    protected $secretId;
    protected $redirectFacebook;

    public function __construct(array $config = []) {
        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId) {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecretId()
    {
        return $this->secretId;
    }

    /**
     * @param mixed $secretId
     */
    public function setSecretId($secretId) {
        $this->secretId = $secretId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectFacebook()
    {
        return $this->redirectFacebook;
    }

    /**
     * @param mixed $redirectFacebook
     */
    public function setRedirectFacebook($redirectFacebook)  {
        $this->redirectFacebook = $redirectFacebook;
        return $this;
    }
}