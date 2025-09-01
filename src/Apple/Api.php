<?php

namespace SocialLogin\Apple;

class Api extends \SocialLogin\Core\AppleAuth {
    public function login($state, $nonce) {
        try {
            $loginUrl = self::APPLE_AUTH.'auth/authorize?'.http_build_query([
                'response_type' => 'code id_token',
                'response_mode' => 'form_post',
                'client_id'     => $this->getClientId(),
                'redirect_uri'  => $this->getRedirectApple(),
                'scope'         => 'name email',
                'state'         => $state,
                'nonce'         => $nonce,
            ]);
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
            $clientSecret = $this->generateAppleClientSecret();
            $postFields = [
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => $this->getRedirectApple(),
                'client_id'     => $this->getClientId(),
                'client_secret' => $clientSecret,
            ];
            $response = $this->http->post("auth/token", [
                'form_params' => $postFields
            ]);
            $responseData = (string) $response->getBody();
            return json_decode($responseData);
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

    public function validateToken($data, $nonce) {
        try {
            $resp = $this->http->get("auth/keys");
            $responseData = (string) $resp->getBody();
            $jwk = \Firebase\JWT\JWK::parseKeySet(json_decode($responseData, true));
            $idToken = $data->id_token;
            $decoded = \Firebase\JWT\JWT::decode($idToken, $jwk);
            $response = [
                "code" => 200,
                "message" => ""
            ];
            if (
                $decoded->iss !== self::APPLE_AUTH ||
                $decoded->aud !== $this->getClientId() ||
                $decoded->nonce !== $nonce
            ) {
                $response['code'] = 401;
                $response['message'] = "Token Inválido";
            }else{
                $response['message'] = "Token válido";
                $response['token'] = $idToken;
                $response['id'] = $decoded->sub;
                $response['email'] = $decoded->email;
                if(isset($data->name)){
                    $response['name'] = $data->name;
                }
            }
            return $response;
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

    public function generateAppleClientSecret() {
        $now = time();
        $exp   = $now + 300;//15777000;
        $payload = [
            "iss" => $this->getTeamId(),
            "iat" => $now,
            "exp" => $exp,
            "aud" => "https://appleid.apple.com",//rtrim(self::APPLE_AUTH, '/'),
            "sub" => $this->getClientId()
        ];
        $privateKey = file_get_contents($this->getPrivateKeyPath());
        $this->secretClient = \Firebase\JWT\JWT::encode($payload, $privateKey, "ES256", $this->getKeyId());
        return $this->secretClient;
    }

    private function base64url_encode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function derToRawSignature(string $der, int $curvelen = 64): string {
        $offset = 0;
        // SEQUENCE tag
        if (ord($der[$offset++]) !== 0x30) {
            throw new \UnexpectedValueException('Formato DER inválido: aguardando SEQUENCE');
        }
        // Comprimento da sequence
        $length = ord($der[$offset++]);
        if ($length & 0x80) {
            $bytes = $length & 0x7f;
            $length = 0;
            for ($i = 0; $i < $bytes; $i++) {
                $length = ($length << 8) + ord($der[$offset++]);
            }
        }
        // R integer
        if (ord($der[$offset++]) !== 0x02) {
            throw new \UnexpectedValueException('Formato DER inválido: aguardando INTEGER (r)');
        }
        $rLen = ord($der[$offset++]);
        $r = substr($der, $offset, $rLen);
        $offset += $rLen;

        // S integer
        if (ord($der[$offset++]) !== 0x02) {
            throw new \UnexpectedValueException('Formato DER inválido: aguardando INTEGER (s)');
        }
        $sLen = ord($der[$offset++]);
        $s = substr($der, $offset, $sLen);

        // Remover zeros à esquerda e padronizar para metade da curva
        $half = $curvelen / 2;
        $r = str_pad(ltrim($r, "\x00"), $half, "\x00", STR_PAD_LEFT);
        $s = str_pad(ltrim($s, "\x00"), $half, "\x00", STR_PAD_LEFT);

        return $r . $s;
    }
}