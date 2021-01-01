<?php

namespace App\Http\Controllers;

use App\Biz\ProductBiz;
use App\Classes\Helper\GCSHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends ApiController
{
    public function __construct(ProductBiz $biz)
    {
        $this->biz = $biz;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->biz->all();

        return $this->success($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = $this->validateStore($request);
        $user = Auth::user();
        $attr['user_id'] = $user->id;

        if ($request->hasFile('image')) {
            $disk = Storage::disk('gcs');
            $image = $disk->put('products/images', $request->file('image'));
            $attr['image'] = $image;
        }

        $product = $this->biz->store($attr);
        $product['image'] = GCSHelper::getUrl($product['image']);

        return $this->success($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validateStore($request)
    {
        return $request->validate([
            'name' => 'required|string',
            'image' => 'required|file',
            'listed_price' => 'required|integer',
            'category_id' => 'required|integer',
        ]);
    }
}
