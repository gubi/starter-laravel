<?php
namespace Zikkio\Services\Core\Nodes;


use Zikkio\Models\Auth\Node;

interface NodeServiceContract
{
    /**
     * @param $id
     * @return Node|null
     */
    public function get($id);
}