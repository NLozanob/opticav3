<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers";
    protected $fillable = [
        'first_name',
        'identification_document',
        'email',
        'phone', 
        'address',
        'image',
        'status',
        
];
    protected $guarded = ['id','status','registered_by','created_at', 'updated_at'];

    public function sales()
 {
   return $this->hasMany(Sale::class);
 }
}
