<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @param  \App\User  $buyer
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse("The buyer cannot be the seller", 409);
        }

        if (!$buyer->isVerified()) {
            return $this->errorResponse("The buyer must be verified", 409);
        }

        if (!$product->seller->isVerified()) {
            return $this->errorResponse("The seller must be verified", 409);
        }

        if (!$product->isAvailable()) {
            return $this->errorResponse("The product is not available", 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse("Not enought quantity", 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();
            
            $transaction = Transaction::create([
                'quantity'   => $request->quantity,
                'product_id' => $product->id,
                'buyer_id'   => $buyer->id,
            ]);
            return $this->showOne($transaction);
        });
    }
}
