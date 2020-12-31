<?php

namespace App\Biz;

use App\Models\ProductCategory;

class ProductCategoryBiz extends BaseBiz
{
    const STATUS_ACTIVE = 1;

    public function getModel()
    {
        return ProductCategory::class;
    }

    public function all()
    {
        return $this->_model->where('status', self::STATUS_ACTIVE)->get();
    }
}
