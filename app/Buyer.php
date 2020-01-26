<?php

namespace App;

use App\Scopes\BuyerScope;
use App\Transaction;

class Buyer extends User
{
    /**
     *  To automatically do the relationship with transaction
     *  @see BuyerScope
     */
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
