<?php

namespace App\Biz;

use App\Models\Product;
use App\Utils\ArrayUtil;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductBiz extends BaseBiz
{
    const LISTED_INTERVAL_DAYS = 7;

    public function getModel()
    {
        return Product::class;
    }

    public function store($params)
    {
        $attributes = ArrayUtil::filter($params, ['name', 'image', 'listed_price', 'category_id', 'user_id']);
        $now = Carbon::now();
        $startDate = $now->toDateTimeString();
        $finishDate = $now->addDays(self::LISTED_INTERVAL_DAYS)->toDateTimeString();
        DB::beginTransaction();
        try {
            $attributes['start_at'] = $startDate;
            $attributes['finish_at'] = $finishDate;
            $attributes['status'] = 1;
            $attributes['created_at'] = $startDate;
            $id = DB::table('products')->insertGetId($attributes);
            $productListedAttributes = ArrayUtil::filter($attributes, [
                'name',
                'image',
                'listed_price',
                'category_id',
                'user_id',
                'start_at',
                'finish_at',
                'status',
                'created_at',
            ]);
            $productListedAttributes['product_id'] = $id;
            $productListedId = DB::table('products_listed')->insertGetId($productListedAttributes);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        $attributes['id'] = $id;

        return $attributes;
    }
}
