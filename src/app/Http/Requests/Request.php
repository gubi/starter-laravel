<?php

namespace Zikkio\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Zikkio\Http\Behaviors\JsonApiResponses;

abstract class Request extends FormRequest
{
    use JsonApiResponses;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true; //Means authorization is delegated to policies
    }

    /**
     * Validation rules for request's parameters
     * @return array
     */
    public function rules(){
        return [];
    }

    /**
    Handles Validation Errors
     */
    public function response(array $errors){
        return $this->respondError('Invalid Request', 'Some fields are missing/invalid');
    }

    /**
     * Handles Authorization Errors
     * @return mixed
     */
    public function forbiddenResponse(){
        return $this->respondForbidden('Action Forbidden', 'You lack the necessary permissions/conditions to perform this action');
    }
}
