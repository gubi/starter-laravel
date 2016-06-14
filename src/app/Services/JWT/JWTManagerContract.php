<?php
namespace Zikkio\Services\JWT;


interface JWTManagerContract
{

    /**
     * @param array $payload
     * @return string
     */
    public function encode($payload);

    /**
     * @param string $token
     * @return string|null
     */
    public function decode($token);

    /**
     * @param string $token
     * @return boolean
     */
    public function isExpired($token);

    /**
     * @param string $token
     * @param string $claim
     * @return mixed
     */
    public function get($token, $claim);

}