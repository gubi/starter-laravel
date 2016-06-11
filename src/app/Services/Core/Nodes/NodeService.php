<?php
namespace Zikkio\Services\Core\Nodes;

use Zikkio\Models\Auth\Node;

class NodeService implements NodeServiceContract
{
    /**
     * @param $nodeId
     * @return Node|null
     */
    public function get($nodeId){
        return new Node();
    }
}