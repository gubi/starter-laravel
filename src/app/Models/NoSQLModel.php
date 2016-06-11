<?php
namespace Zikkio\Models;

use BaoPham\DynamoDb\DynamoDbModel;
use Carbon\Carbon;
use Watson\Validating\ValidatingTrait as SelfValidation;
use Zikkio\Models\Behaviors\Uuids;

abstract class NoSQLModel extends DynamoDbModel
{
    use SelfValidation, Uuids;

    protected $needsUuid = true;

    protected $fillable = ['id'];

    protected static function boot(){
        parent::boot();
        static::registerUuidGenerator();

        static::creating(function($model){
            $model->created_at = time();
        });
        
        static::saving(function($model){
            $model->updated_at = Carbon::now();
        });
    }
}
