<?php
namespace Zikkio\Models\Behaviors;

use Illuminate\Database\Eloquent\Model;
use Zikkio\Services\Uuid\UuidGeneratorContract;

/**
 * Trait Uuids
 * @package Zikkio\Behaviors
 */
trait Uuids {
    
    protected static function registerUuidGenerator(){
        static::creating(function (Model $model) {
            if(isset($model->needsUuid) && $model->needsUuid && !$model->{$model->getKeyName()}){
                $uuidGenerator = app(UuidGeneratorContract::class);
                $model->{$model->getKeyName()} = $uuidGenerator->generateUuid();
            }
        });
    }

}