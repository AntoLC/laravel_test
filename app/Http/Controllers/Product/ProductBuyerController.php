<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $buyer = $product->with("transactions.buyer")->get()
            ->pluck("transactions")
            ->collapse()
            ->pluck("buyer")
            ->unique("id")
            ->values();
        return $this->showAll($buyer);
    }
}
