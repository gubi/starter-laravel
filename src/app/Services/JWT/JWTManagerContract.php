<?php
namespace Zikkio\Services\JWT;


interface JWTManagerContract
{
    
    public function encode($payload);
    
    public function decode($token); 
    
    public function isExpired($token);

    public function get($token, $claim);

}