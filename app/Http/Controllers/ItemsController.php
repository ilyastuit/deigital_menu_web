<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\Restorant;
use Image;

class ItemsController extends Controller
{

    private $imagePath="uploads/restorants/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('owner')){
            $canAdd=true;
            $items=Items::whereIn('category_id', auth()->user()->restorant->categories->pluck('id')->toArray());
            $canAdd=1000;

            return view('items.index', [
                'canAdd'=>$canAdd,
                'categories' => auth()->user()->restorant->categories->reverse(),
                'restorant_id' => auth()->user()->restorant->id]);
        }
    }

    public function indexAdmin(Restorant $restorant)
    {
        if(auth()->user()->hasRole('admin')) {
            return view('items.index', ['categories' => Restorant::findOrFail($restorant->id)->categories->reverse(), 'restorant_id' => $restorant->id]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Items;
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);
        $item->category_id = strip_tags($request->category_id);
        if($request->hasFile('item_image')){
            $item->image=$this->saveImageVersions(
                $this->imagePath,
                $request->item_image,
                [
                    ['name'=>'large','w'=>590,'h'=>400],
                    //['name'=>'thumbnail','w'=>300,'h'=>300],
                    ['name'=>'medium','w'=>295,'h'=>200],
                    ['name'=>'thumbnail','w'=>200,'h'=>200]
                ]
            );
        }
        $item->save();

        return redirect()->route('items.index')->withStatus(__('Item successfully updated.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Items $item)
    {

        if(auth()->user()->hasRole('owner') && $item->category->restorant->id == auth()->user()->restorant->id || auth()->user()->hasRole('admin')){

            return view('items.edit',
            [
                'item' => $item,
                'setup'=>[],
                'restorant' => $item->category->restorant,
                'restorant_id' => $item->category->restorant->id]);
        }else{
            return redirect()->route('items.index')->withStatus(__("No Access"));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $item)
    {
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);
        if(isset($request->vat)){
            $item->vat= $request->vat;
        }


        $item->available=$request->exists('itemAvailable');


        if($request->hasFile('item_image')){

            if($request->hasFile('item_image')){
                $item->image=$this->saveImageVersions(
                    $this->imagePath,
                    $request->item_image,
                    [
                        ['name'=>'large','w'=>590,'h'=>400],
                        //['name'=>'thumbnail','w'=>300,'h'=>300],
                        ['name'=>'medium','w'=>295,'h'=>200],
                        ['name'=>'thumbnail','w'=>200,'h'=>200]
                    ]
                );

            }
        }

        $item->update();
        return redirect()->route('items.edit', $item)->withStatus(__('Item successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $item)
    {
        $item->delete();

        return redirect()->route('items.index')->withStatus(__('Item successfully deleted.'));
    }

       public function change(Items $item, Request $request)
    {
        $item->available = $request->value;
        $item->update();

        return response()->json([
            'data' => [
                'itemAvailable' => $item->available
            ],
            'status' => true,
            'errMsg' => ''
        ]);
    }
}
