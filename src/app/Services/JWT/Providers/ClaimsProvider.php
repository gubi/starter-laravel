<?php
namespace Zikkio\Services\JWT\Providers;

use ArrayAccess;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Traversable;

class ClaimsProvider implements Arrayable, ArrayAccess
{
    protected $claims = [];
    
    public function __construct()
    {
        $this->reset();
    }

    public function getDefaultIssuer()
    {
        return env('ZIKKIO_NODE_IDENTIFIER');
    }

    public function getDefaultExpiration()
    {
        $expirationMinutes = env('JWT_EXPIRATION', 60);
        $expirationDateTime = new Carbon("+ $expirationMinutes minutes");
        return $expirationDateTime->getTimestamp();
    }
    
    public function processPayload($payload)
    {
        foreach ($payload as $name => $value){
            $this->claims[$name] = $value;
        }
    }
    
    public function reset(){
        $this->claims['iss'] = $this->getDefaultIssuer();
        $this->claims['exp'] = $this->getDefaultExpiration();
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->claims))
        {
            return $this->claims[$name];
        }else
        {
            return null;
        }
    }
    
    public function __set($name, $value)
    {
        $this->claims[$name] = $value;
    }
    
    public function toArray(){
        return $this->claims;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->claims);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->claims[$offset]);
    }
}