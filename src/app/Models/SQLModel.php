<?php

namespace Zikkio\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait as SelfValidation;
use Zikkio\Models\Behaviors\Uuids;

/**
 * Class SQLModel
 * @package Zikkio\Models
 * @method boolean isValid()
 * @method boolean isInvalid()
 * @method array getErrors()
 */
abstract class SQLModel extends Model
{
    use Uuids, SelfValidation;
    
    /**
     * Validation rules
     * @var array
     */
    protected $rules = [];

    /**
     * Validation messages
     * @var array
     */
    protected $validationMessages = [];

    /**
     * Whether the model should throw a ValidationException if it
     * fails validation. If not set, it will default to false.
     *
     * @var boolean
     */
    protected $throwValidationExceptions = false;

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;

    /**
     * User exposed observable events
     *
     * available events: 'validating', 'validated'
     * @var array
     */
    protected $observables = [];
    
    /**
     * Whether the model should generate a uuid to use as primary key on save
     * @var bool
     */
    protected $needsUuid = true;

    /**
     * Whether the model uses auto-increment ids
     * @var bool
     */
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::registerUuidGenerator();
    }
    
}
