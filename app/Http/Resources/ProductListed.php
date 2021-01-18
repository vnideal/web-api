<?php

namespace App\Http\Resources;

use App\Classes\Helper\GCSHelper;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductListed extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($product){
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => GCSHelper::getUrl($product->image),
                    'created_at' => $product->created_at,
                    'user' => new UserResource($product->user)
                ];
            }),
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],
        ];
    }
}
