<?php

namespace App\Api\Response;

use Illuminate\Support\Collection;

abstract class ResponseAbstract
{
    /**
     * @var Collection of response data
     */
    public $data;

    public function __construct()
    {
        $this->data = new Collection();
    }

    /**
     * @param $name - string ex: User
     * @param $data - array/object --> toJson() will convert it to json response
     */
    public function addData($name, $data)
    {
        $this->data->put($name, $data);
    }


}