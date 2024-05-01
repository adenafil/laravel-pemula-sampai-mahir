<?php

namespace App\Models;

use \Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(
          VirtualAccount::class,
          Wallet::class,
          'customer_id', // FK on wallets table
            'wallet_id', // fk on virtual_accounts table
            'id',  // PK on customer table
            'id' // PK on wallets table
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id', 'id');
    }

    public function likeProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
          'customers_likes_products',
          'customer_id',
            'product_id'
        )->withPivot('created_at');
    }

    public function likeProductsLastWeek(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,
            'customers_likes_products',
            'customer_id',
            'product_id'
        )->withPivot('created_at')
            ->wherePivot('created_at', '>=', Date::now()->addDays(-7));
    }
}
