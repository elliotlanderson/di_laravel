<?php

namespace App\Api\Response;

use Illuminate\Support\Collection;

class ApiResponse extends ResponseAbstract
{
    public function __construct()
    {
        $this->data = new Collection();
    }

    public function response($data_array = null)
    {
        $this->data->put('status', 200);
        $this->data->put('errors', []);
        return $this->data->toJson();
    }

    public function errorResponse(\Exception $exception)
    {
        $message = $exception->getMessage();

        $this->data->put('error', $message);
        $this->data->put('status', 500);

        return $this->data->toJson();
    }
}