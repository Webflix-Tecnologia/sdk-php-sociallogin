<?php

namespace SocialLogin\Google;

class Api extends \SocialLogin\Core\GoogleAuth {
    public function login($state) {
        try {
            $params = [
                'response_type' => 'code',
                'client_id' => $this->getClientId(),
                'redirect_uri' => $this->getRedirectGoogle(),
                'scope' => 'openid email profile',
                'state' => $state,
                'access_type' => 'offline',
                'prompt' => 'consent'
            ];
            $authUrl = self::GOOGLE_AUTH."?".http_build_query($params);
            header("Location: {$authUrl}");
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
            $body = [
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getSecretKey(),
                'redirect_uri' => $this->getRedirectGoogle(),
                'grant_type' => 'authorization_code',
                'code' => $code
            ];
            $response = $this->http->post("", [
                'form_params' => $body
            ]);
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
            $url = self::GOOOLE_API."/userinfo?alt=json&access_token={$accessToken}";
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