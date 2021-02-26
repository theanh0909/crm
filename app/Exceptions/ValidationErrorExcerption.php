<?php
namespace App\Exceptions;

use Exception;

class ValidationErrorExcerption extends Exception
{

    /** @var string */
    protected $extraData   = [];

    /**
     * ValidationErrorExcerption constructor
     * @param array  $extraData
     */
    public function __construct($extraData = [])
    {
        $this->extraData   = $extraData;
        parent::__construct('invalidParams', 400, null);
    }

    public function render() {

        \Log::info($this->extraData);
        return response()->json([
            'invalidParams' => $this->extraData
        ], 400);
    }
}
