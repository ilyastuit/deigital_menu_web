<?php

namespace App;

class Restorant extends MyModel
{
    protected $fillable = ['name','subdomain', 'user_id','address','phone','logo','description'];
    protected $appends = ['alias','logom','icon','coverm'];
    protected $imagePath='/uploads/restorants/';

    /**
     * Get the user that owns the restorant.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getAliasAttribute()
    {
        return $this->subdomain;
    }

    public function getLogomAttribute()
    {
        return $this->getImge($this->logo,config('global.restorant_details_image'));
    }
    public function getIconAttribute()
    {
        return $this->getImge($this->logo,str_replace("_large.jpg","_thumbnail.jpg",config('global.restorant_details_image')),"_thumbnail.jpg");
    }

    public function getCovermAttribute()
    {
        return $this->getImge($this->cover,config('global.restorant_details_cover_image'),"_cover.jpg");
    }

    public function categories()
    {
        return $this->hasMany('App\Categories','restorant_id','id')->where(['categories.active' => 1]);
    }

    public function hours()
    {
        return $this->hasOne('App\Hours','restorant_id','id');
    }

    public function toArray() {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
        ];

        if ($categories = $this->categories) {
            $data['categories'] = [];
            foreach ($categories as $category) {
                if ($items = $category->items) {
                    $itemsData = [];
                    foreach ($items as $item) {
                        $itemsData[] = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'description' => $item->description,
                            'price' => $item->price,
                            'available' => $item->available,
                            'image' => $item->getApiImage()
                        ];
                    }
                    $data['categories'][] =[
                        'id' => $category->id,
                        'name' => $category->name,
                        'items' => $itemsData
                    ];
                } else {
                    $data['categories'][] =[
                        'id' => $category->id,
                        'name' => $category->name
                    ];
                }
            }
        } else {
            $data['categories'] = null;
        }
        return $data;
    }
}
