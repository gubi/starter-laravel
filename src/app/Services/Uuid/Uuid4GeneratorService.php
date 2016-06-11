<?php

namespace Zikkio\Services\Uuid;

use Ramsey\Uuid\Uuid;

class Uuid4GeneratorService implements UuidGeneratorContract
{
    public function generateUuid()
    {
        return Uuid::uuid4()->toString();
    }
}