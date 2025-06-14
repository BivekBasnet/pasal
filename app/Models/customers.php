<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    protected $fillable = ['c_name', 'phone'];
    public function transictions() {
        return $this->hasMany(transictions::class, 'customer_id');
    }
}
