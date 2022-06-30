<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sections;

class Products extends Model
{
   /* use HasFactory;
    
        protected $fillable = [
        'product_name',
        'description',
        'section_id',
    ];
       = */
    protected $guarded = [];
    
    /**
     * Get the section that owns the product.
     */
    public function section()
    {
        return $this->belongsTo(Sections::class);
    }
}
