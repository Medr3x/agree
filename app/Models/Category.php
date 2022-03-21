<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'sku_id',
        'parent_id',
        'created_by',
		'updated_by'
    ];

	public function childs()
	{
		return $this->hasMany(Category::class, 'parent_id');
	}

    public function parent()
    {
		return $this->belongsTo(Category::class, 'parent_id');
	}

    public function cards()
    {
        return $this->hasMany(Card::class, 'category_id');
    }
    
    public function isParent()
    {
        return is_null($this->parent_id);
    } 
}
