<?php

namespace App\Http\Controllers;
use App\Restorant;
use App\Items;
use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;
use Illuminate\Support\Facades\Cookie;
use Session;
use Illuminate\Support\Facades\App;;


class FrontEndController extends Controller
{
    /**
     * Gets subdomain
     */
    public function getSubDomain(){
        $subdomain = substr_count($_SERVER['HTTP_HOST'], '.') > 1 ? substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.')) : '';
        if($subdomain==""|in_array($subdomain,config('app.ignore_subdomains'))){
            return false;
        }
        return $subdomain;
    }


    /**
     * Returns restaurants based on the q parameter
     * @param $restaurantIDS - the list of the restaurants to take into account
     * @return Restorant[] restaurants
     */
    private function filterRestaurantsOnQuery($restaurantIDS){
         $items = Items::where(['available' => 1])->where(function ($q) {
            $stripedQuery='%'.strip_tags(\Request::input('q'))."%";
            $q->where('name', 'like',$stripedQuery)->orWhere('description', 'like',$stripedQuery);
        })->with('category.restorant')->get();


        $restorants=array();
        foreach($items as $item) {
            if(isset($item->category)){
                if(in_array($item->category->restorant_id,$restaurantIDS)){
                    if(isset($restorants[$item->category->restorant_id])){
                        $restorants[$item->category->restorant_id]->items_count++;
                    }else{
                        $restorants[$item->category->restorant_id]=$item->category->restorant;
                        $restorants[$item->category->restorant_id]->items_count=1;
                    }
                }

            }
        }


        $restorantsQ = Restorant::where(['active' => 1])->where(function ($q) {
            $stripedQuery='%'.strip_tags(\Request::input('q'))."%";
            $q->where('name', 'like',$stripedQuery)->orWhere('description', 'like',$stripedQuery);
        });
        foreach($restorantsQ->get() as $restorant) {
            if(in_array($restorant->id,$restaurantIDS)){
                if(isset($results[$restorant->id])){
                    $restorants[$restorant->id]->items_count+=5;
                }else{
                    $restorants[$restorant->id]=$restorant;
                    $restorants[$restorant->id]->items_count=5;
                }
            }
        }

        usort($restorants, function($a, $b) {return strcmp($a->items_count, $b->items_count);});
        return $restorants;
    }

    public function index(){
        return $this->qrsaasMode();
    }


    public function qrsaasMode(){
        return redirect()->route('login');
   }

    public function restorant(Request $request, string $alias){

        $restorant = Restorant::where('subdomain',$alias)->first();

        $usernames = [];

        $ourDateOfWeek=[6,0,1,2,3,4,5][date('w')];

        $format="G:i";
        if(env('TIME_FORMAT',"24hours")=="AM/PM"){
            $format="g:i A";
        }

        if ($request->header('digitalmenu')) {
            return response()->json($restorant);
        }

        $openingTime = $restorant->hours&&$restorant->hours[$ourDateOfWeek."_from"] ? date($format, strtotime($restorant->hours[$ourDateOfWeek."_from"])) : null;
        $closingTime = $restorant->hours&&$restorant->hours[$ourDateOfWeek."_to"] ? date($format, strtotime($restorant->hours[$ourDateOfWeek."_to"])) : null;

        return view('restorants.show',[
            'restorant' => $restorant,
            'openingTime' => $openingTime,
            'closingTime' => $closingTime,
            'usernames' => $usernames
        ]);
    }
}
