<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;

class ApiController extends Controller
{
    /**
     * Status code
     * @var String
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * Return the status code
     * @return String
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
