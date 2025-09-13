<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['user_id','name','slug','description','status'];

    public function owner(){ return $this->belongsTo(User::class,'user_id'); }
    public function products(){ return $this->hasMany(Product::class); }
}
