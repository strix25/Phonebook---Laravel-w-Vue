<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Phonebook extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'phonenumber' => $this->phonenumber,
            'region' => $this->region,
            'address' => $this->address
        ];
    }

    public function with($request) {
        return [
            'version' => '1.0.0'
        ];
    }
}