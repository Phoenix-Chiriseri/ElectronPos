<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['total', 'change', 'amountPaid', 'invoice_id','html','user_id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'invoice_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
   
}
