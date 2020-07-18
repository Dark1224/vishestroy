<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //
    public function scopeFilter($q)
    {
        $q->where('price', '>=', request('min_price'));
        dd($q);
        $q->where('price', '<=', request('max_price'));

        return $q;
    }
}
