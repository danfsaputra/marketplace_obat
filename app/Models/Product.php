<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['shop_id','category_id','name','sku','description','price','stock','image'];

    public function category(){ return $this->belongsTo(Category::class); }
    public function shop(){ return $this->belongsTo(Shop::class); }
}
