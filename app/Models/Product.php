<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'purchase_price',
        'description',
        'stock_quantity',
        'expiration_date',
        'image',
        'status',
        'registered_by',
    ];

    protected $guarded = ['id','status','registered_by','created_at','updated_at'];

   

    public function sale_details()
    {
        return $this->hasMany(Sale_detail::class);
    }
}