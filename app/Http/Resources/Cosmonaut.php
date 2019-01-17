<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cosmonaut extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        ## you can specify what items to send (if u dont want all to be sent)
        // return [
        //     'id' => $this->id,
        // ];
    }

    ## to add other data being send
    // public function with($request) {
    //     return [
    //         'version' => '1.0.0',
    //     ];
    // }
}
