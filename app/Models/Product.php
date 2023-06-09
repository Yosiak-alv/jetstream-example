<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeFilter($query, Array $filters){
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
            $query->where('name','like','%'.$search.'%')
                ->orWhere('quantity','like','%'.$search.'%')
                ->orWhere('price','like','%'.$search.'%')

            );
        });
    }
}
