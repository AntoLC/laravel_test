<?php

namespace App;

use App\Category;
use App\Transaction;
use App\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    public const AVAILABLE_PRODUCT = 'available';
    public const UNAVAILABLE_PRODUCT = 'unavailable';
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    protected $hidden = [
        'pivot',
    ];

    public function isAvailable()
    {
        return $this->status == self::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
