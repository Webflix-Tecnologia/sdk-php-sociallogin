<?php

namespace SocialLogin\Facebook;

class Api extends \SocialLogin\Core\FacebookAuth {
    public function login($state) {
        try {
            $loginUrl = self::FACEBOOK_AUTH
                .'?client_id='.urlencode($this->getAppId())
                .'&redirect_uri='.urlencode($this->getRedirectFacebook())
                .'&state='.urlencode($state)
                .'&scope='.urlencode('email,public_profile');
            header("Location: {$loginUrl}");
        } catch (\GuzzleHttp\Exception\ServerException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\ClientException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\BadResponseException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\RequestException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\Exception $ex) {
            throw new \SocialLogin\Exceptions\SocialLoginException($ex);
        }
    }

    public function generateToken($code) {
        try {
            $tokenUrl = self::FACEBOOK_TOKEN.'?client_id='.urlencode($this->getAppId())
                .'&redirect_uri='.urlencode($this->getRedirectFacebook())
                .'&client_secret='.urlencode($this->getSecretId())
                .'&code='.urlencode($code);
            $response = $this->http->get($tokenUrl);
            $responseData = (string) $response->getBody();
            return json_decode($responseData, true);
        } catch (\GuzzleHttp\Exception\ServerException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\ClientException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\BadResponseException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\RequestException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\Exception $ex) {
            throw new \SocialLogin\Exceptions\SocialLoginException($ex);
        }
    }

    public function getUserInfo($accessToken) {
        try {
            $fields = 'id,name,email,picture';
            $url = self::FACEBOOK_GRAPH.'?fields='. urlencode($fields)
                .'&access_token='.urlencode($accessToken);
            $response = $this->http->get($url);
            $responseData = (string) $response->getBody();
            return json_decode($responseData, true);
        } catch (\GuzzleHttp\Exception\ServerException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\ClientException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\BadResponseException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\GuzzleHttp\Exception\RequestException $ex) {

            throw \SocialLogin\Exceptions\SocialLoginException::fromGuzzleException($ex);

        } catch (\Exception $ex) {
            throw new \SocialLogin\Exceptions\SocialLoginException($ex);
        }
    }
}