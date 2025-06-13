<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    //
        protected $fillable = ['sale_id','sold_to'];
    public function sale()
{
    return $this->belongsTo(Sale::class);
}

}
