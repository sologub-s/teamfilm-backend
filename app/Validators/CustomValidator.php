<?php

namespace App\Validators;

class CustomValidator extends \Illuminate\Validation\Validator
{

    public function __construct($translator, $data, $rules, $messages = [],$customAttributes = [])
    {
        /**
         * Custom messages
         */
        $messages = array_merge($messages, [
            'mongoid' => 'The :attribute should be acceptable by \MongoDB\BSON\ObjectID::__construct()',
            'filteredarray' => 'The :attribute must be an array with limited values',
        ]);
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function validateMongoid($attribute, $value, $parameters)
    {
        try {
            new \MongoDB\BSON\ObjectId($value);
            return true;
        } catch (\Exception $e) {

        }
        return false;
    }

    public function validateFilteredarray($attribute, $value, $parameters)
    {
        return is_array($value) && !array_diff($value, $parameters);
    }
}