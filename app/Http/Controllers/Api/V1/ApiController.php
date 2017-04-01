<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

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
     * Return a 204 no content response
     * @param  string $message
     * @return \Illuminate\Http\Response
     */
    public function respondNoContent($message = '')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NO_CONTENT)->respond($message);
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

    /**
     * Bind an item to a transformer and return data.
     *
     * @param object $item
     * @param object $transformer
     * @param String $resourceKey
     *
     * @return Array
     */
    public function item($item, $transformer, $resourceKey = null)
    {
        $resource = new Item($item, $transformer, $resourceKey);

        return $this->createData($resource);
    }

    /**
     * Bind an collection to a transformer and return data.
     *
     * @param object $collection
     * @param object $transformer
     * @param String $resourceKey
     *
     * @return Array
     */
    public function collection($items, $transformer, $resourceKey = null)
    {
        $resource = new Collection($items, $transformer, $resourceKey);

        return $this->createData($resource);
    }

    /**
     * Bind an paginated collection to a transformer and return data.
     *
     * @param object $item
     * @param object $transformer
     * @param String $resourceKey
     *
     * @return Array
     */
    public function paginatedCollection($paginator, $transformer, $resourceKey = null)
    {
        $resource = new Collection($paginator->getCollection(), $transformer, $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->createData($resource);
    }

    /**
     * Return data of a transformed resource.
     *
     * @param object $resource
     * @return Array
     */
    private function createData($resource)
    {
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());

        return $manager->createData($resource)->toArray();
    }
}
