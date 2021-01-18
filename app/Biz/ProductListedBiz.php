<?php

namespace App\Biz;

use App\Models\ProductListed;

class ProductListedBiz extends BaseBiz
{
    const STATUS_ACTIVE = 1;
    const ITEM_PER_PAGE = 15;

    public function getModel()
    {
        return ProductListed::class;
    }

    public function all()
    {
        return $this->_model->where('status', self::STATUS_ACTIVE)->get();
    }

    public function getList($params)
    {
        return $this->_model
            ->with('user')
            ->when($params['keyword'], function ($q, $keyword) {
                return $q->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('status', self::STATUS_ACTIVE)
            ->orderByDesc('created_at')
            ->paginate(self::ITEM_PER_PAGE);
    }
}
