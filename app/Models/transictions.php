<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transictions extends Model
{
    protected $fillable = ['customer_id', 'date','details','sellamount','paymentamount'];
    public function customer() {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
