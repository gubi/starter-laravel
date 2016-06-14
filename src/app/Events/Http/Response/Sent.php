<?php
namespace Zikkio\Events\Http\Response;

use Zikkio\Events\Event;

class Sent extends Event
{

    /** @var array $data */
    protected $data;

    /** @var integer $statusCode */
    protected $statusCode;

    public function __construct($data, $statusCode)
    {
        $this->setData($data);
        $this->setStatusCode($statusCode);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

}