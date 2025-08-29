<?php
namespace SocialLogin\Exceptions;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;

class SocialLoginException extends Exception {
    public function __construct(Exception $ex) {
        $message = $ex->getMessage();
        parent::__construct($message, $ex->getCode(), $ex->getPrevious());
    }

    public static function fromObjectMessage($message, $code, $previous = null){

        if(is_array($message)){

            $newMessageString = [];

            foreach($message as $error){
                $newMessageString[] =  $error;
            }

            return new SocialLoginException( new Exception(implode("\n", $newMessageString), $code, $previous) );
        }

        if(is_string($message)){

            return new SocialLoginException( new Exception($message, $code, $previous) );

        }

    }

    public static function fromGuzzleException(ServerException|ClientException|BadResponseException|RequestException $ex){
        $responseBody = '['.$ex::class.'] Body: ' . (string)$ex->getResponse()->getBody();
        return new SocialLoginException( new \Exception($responseBody, $ex->getCode(), $ex->getPrevious()) );
    }
}