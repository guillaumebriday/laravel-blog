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

    /**
     * Method to make a response in json.
     * @param  array $data
     * @param  array  $headers
     * @return \Illuminate\Http\Response
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function respondUnauthorized($message = 'Unauthorized.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function respondForbidden($message = 'Forbidden.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }

    /**
     * Return a 404 not found error
     * @param  string $message
     * @return \Illuminate\Http\Response
     */
    public function respondNotFound($message = 'Not found.')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Return an error response
     * @param String $message
     * @return \Illuminate\Http\Response
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status' => $this->getStatusCode()
            ]
        ]);
    }
}
