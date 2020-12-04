<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{

    use SoftDeletes;

    protected $table = 'items';
    protected $appends = ['logom','icon','short_description'];
    protected $fillable = ['name','description','image','price','category_id','vat'];
    protected $imagePath='/uploads/restorants/';

    protected function getImge($imageValue,$default,$version="_large.jpg"){
        if($imageValue==""||$imageValue==null){
            return $default;
        }else{
            if(strpos($imageValue, 'http') !== false){
                if(strpos($imageValue, '.jpg') !== false||strpos($imageValue, '.jpeg') !== false||strpos($imageValue, '.png') !== false){
                    return $imageValue;
                }else{
                    return $imageValue.$version;
                }
            }else{
                return ($this->imagePath.$imageValue).$version;
            }
        }
    }

    public function getApiImage() {
        $imageValue = $this->image;
        $version="_large.jpg";
        if(strpos($imageValue, 'http') !== false){
            if(strpos($imageValue, '.jpg') !== false||strpos($imageValue, '.jpeg') !== false||strpos($imageValue, '.png') !== false){
                return $imageValue;
            }else{
                return $imageValue.$version;
            }
        }else{
            return env('APP_URL')."/".($this->imagePath.$imageValue).$version;
        }

    }


    public function substrwords($text, $chars, $end='...') {
        if(strlen($text) > $chars) {
            $text = $text.' ';
            $text = substr($text, 0, $chars);
            $text = substr($text, 0, strrpos($text ,' '));
            $text = $text.'...';
        }
        return $text;
    }


    public function getLogomAttribute()
    {
        return $this->getImge($this->image,config('global.restorant_details_image'));
    }
    public function getIconAttribute()
    {
        return $this->getImge($this->image,config('global.restorant_details_image'),'_thumbnail.jpg');
    }

    public function getItempriceAttribute()
    {
        return  Money($this->price, env('CASHIER_CURRENCY','usd'),true)->format();
    }

    public function getShortDescriptionAttribute()
    {
        return  $this->substrwords($this->description,40);
    }

    public function category()
    {
        return $this->belongsTo('App\Categories');
    }

}
