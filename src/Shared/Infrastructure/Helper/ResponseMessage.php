<?php

namespace App\Shared\Infrastructure\Helper;

class ResponseMessage
{
    public const ADD_RECORD = 'Record successfully add';
    public const PARAMS_ERROR = 'All fields are required';
    public const REMOVE_RECORD = 'Record successfully remove';
    public const UPDATE_RECORD = 'Record successfully update';
    public const NOT_FOUND = 'Record not found';
    public const INVALID_USER = 'User is invalid';
    public const INVALID_DATA = 'Data is incorrect';
    public const SUCCESS_PAY = 'Payment is success';
}
