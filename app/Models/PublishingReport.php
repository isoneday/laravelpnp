<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishingReport extends Model
{
    //
      protected $fillable = ['book_id','published_by'];
   
    public function book()
{
    return $this->belongsTo(Book::class);
}

}
