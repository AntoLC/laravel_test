<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
            ->with('transactions.buyer')
            ->whereHas('transactions')
            ->get()
            ->pluck("transactions")
            ->collapse()
            ->values()
            ->pluck("buyer")
            ->unique("id")
            ->values();
        return $this->showAll($buyers);
    }
}
