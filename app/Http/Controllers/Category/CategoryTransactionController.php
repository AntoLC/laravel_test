<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
            ->with('transactions')
            ->whereHas('transactions')
            ->get()
            ->pluck("transactions")
            ->collapse()
            ->unique()
            ->values();
        return $this->showAll($transactions);
    }
}
