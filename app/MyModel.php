<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyModel extends Model
{
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
}
