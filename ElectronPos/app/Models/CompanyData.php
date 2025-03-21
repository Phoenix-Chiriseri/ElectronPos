<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyData extends Model
{
    use HasFactory;    
    protected $fillable = [
        'name',
        'shop_name',
        'tinnumber',
        'vatnumber',
        'shop_address',
        'phone_number',
        'email',
        'bank_details',
        'bank_account_number'

       
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
