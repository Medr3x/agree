<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\DeletedMedia;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'sku_id',
        'first_edition',
        'serial_code',
        'category_id',
        'atk',
        'def',
        'qty_star',
        'description',
        'price',
        'image',
        'card_creation_date',
        'created_by',
		'updated_by'
    ];
    
    public $file_folder = 'card';

    public function subcategor()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->hasOne(UserCard::class, 'card_id');
    }

    /**
     * Obtiene la foto de la carta
     * @return object Multimedia
     */
    public function getUrlImage()
    {
        return env('APP_URL').'//img//'.$this->image;
    }
}
