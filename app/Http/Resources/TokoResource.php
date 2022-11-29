<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokoResource extends JsonResource
{
    public $status;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $resource)
    {
        parent::__construct($resource);
        $this->status  = $status;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success'   => $this->status,
            'data'      => $this->resource
        ];
    }
}
