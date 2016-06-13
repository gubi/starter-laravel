<?php
namespace Zikkio\Services\JWT;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Zikkio\Services\JWT\Providers\ClaimsProvider;

class JWTService implements JWTManagerContract
{
    /**
     * The key used for signing tokens
     * @var string
     */
    protected $key;

    /**
     * The algorithm used to encode/decode tokens
     * @var string
     */
    protected $algo = 'HS256';
    
    protected $claims;

    public function __construct(ClaimsProvider $claimsProvider)
    {
        $this->key = (env('APP_DEBUG') === true) ? '12345678901234567890123456789012' : env('JWT_SECRET');

        $this->claims = $claimsProvider;
    }

    /**
     * @param $payload
     * @return string
     */
    public function encode($payload)
    {
        $this->claims->processPayload($payload);
        
        return JWT::encode($this->claims->toArray(), $this->key, $this->algo);
    }

    /**
     * @param $token
     * @return array
     */
    public function decode($token)
    {
        $payload = (array) JWT::decode($token, $this->key, [$this->algo]);
        $this->claims->processPayload($payload);
        return $this->claims->toArray();
    }

    public function isExpired($token)
    {
        $expiration = $this->get($token, 'exp');
        if($expiration)
        {
            return Carbon::createFromTimestampUTC($expiration)->isPast();
        }
        else
        {
            return true;    
        }
    }
    
    public function get($token, $claim)
    {
        $payload = $this->decode($token);
        if($payload && array_key_exists($claim, $payload))
        {
            return $payload[$claim];
        }
        else
        {
            return null;
        }
    }
    
}