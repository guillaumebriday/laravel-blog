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
     * Resource key
     * @var String
     */
    protected $resourceKey = null;

    /**
     * Resource Transformer
     */
    protected $transformer;

    /**
     * Return the status code
     * @return String
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the Status Code
     * @param string $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Return the transfomer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Set the transformer
     * @param $transfomer
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Return the resourceKey
     */
    public function getResourceKey()
    {
        return $this->resourceKey;
    }

    /**
     * Set the resourceKey
     * @param string $resourceKey
     */
    public function setResourceKey($resourceKey)
    {
        $this->resourceKey = $resourceKey;

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
     * Return a 204 no content response
     * @param  string $message
     * @return \Illuminate\Http\Response
     */
    public function respondNoContent($message = '')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NO_CONTENT)->respond($message);
    }

    /**
     * Bind an item to a transformer and return data.
     *
     * @param object $item
     * @return \Illuminate\Http\Response
     */
    public function item($item)
    {
        $resource = new Item($item, $this->getTransformer(), $this->getResourceKey());

        return $this->respond($this->createData($resource));
    }

    /**
     * Bind a collection to a transformer and return data.
     *
     * @param object $collection
     * @return \Illuminate\Http\Response
     */
    public function collection($items)
    {
        $resource = new Collection($items, $this->getTransformer(), $this->getResourceKey());

        return $this->respond($this->createData($resource));
    }

    /**
     * Bind a paginated collection to a transformer and return data.
     *
     * @param object $item
     * @return \Illuminate\Http\Response
     */
    public function paginatedCollection($paginator)
    {
        $resource = new Collection($paginator->getCollection(), $this->getTransformer(), $this->getResourceKey());
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->respond($this->createData($resource));
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
