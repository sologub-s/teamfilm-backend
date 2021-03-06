<?php
/**
 * Created by PhpStorm.
 * User: zeitgeist
 * Date: 5/3/17
 * Time: 4:24 PM
 */

namespace App\Components\Api;

use Illuminate\Http\Response as Response;

class Exception extends \Exception {

    protected $defaultCode = 500;

    protected $defaultMessage = 'Server error';

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        $code = in_array((int) $code, array_keys(Response::$statusTexts)) ? (int) $code : $this->defaultCode;
        parent::__construct($message ?? $this->defaultMessage ?? Response::$statusTexts[$code], $code, $previous);
    }

}