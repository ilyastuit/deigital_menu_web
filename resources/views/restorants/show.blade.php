@extends('layouts.front', ['class' => ''])

@section('content')
@include('restorants.partials.modals')

    <section class="section-profile-cover section-shaped grayscale-05 d-none d-md-none d-lg-block d-lx-block">
      <!-- Circles background -->
      <img class="bg-image" loading="lazy" src="{{ $restorant->coverm }}" style="width: 100%;">
      <!-- SVG separator -->
      <div class="separator separator-bottom separator-skew">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>

    <section class="section pt-lg-0 mb--5 mt--9 d-none d-md-none d-lg-block d-lx-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title white"  <?php if($restorant->description || $openingTime && $closingTime){echo 'style="border-bottom: 1px solid #f2f2f2;"';} ?> >
                        <h1 class="display-3 text-white" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">{{ $restorant->name }}</h1>
                        <p class="display-4" style="margin-top: 120px">{{ $restorant->description }}</p>
                       <p>@if(!empty($openingTime) && !empty($closingTime))  <i class="ni ni-watch-time"></i> <span>{{ $openingTime }}</span> - <span>{{ $closingTime }}</span> | @endif  <i class="ni ni-pin-3"></i></i> <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restorant->address) }}">{{ $restorant->address }}</a>  |  <i class="ni ni-mobile-button"></i> <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg d-md-block d-lg-none d-lx-none" style="padding-bottom: 0px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title">
                        <h1 class="display-3 text" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">{{ $restorant->name }}</h1>
                        <p class="display-4 text">{{ $restorant->description }}</p>
                        @if(!empty($openingTime) && !empty($closingTime))
                            <p>{{ __('Today working hours') }}: <span><strong>{{ $openingTime }}</strong></span> - <span><strong>{{ $closingTime }}</strong></span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-lg-0" id="restaurant-content" style="padding-top: 0px">
        <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
        <div class="container container-restorant">

            @if(!$restorant->categories->isEmpty())
        <nav class="tabbable sticky" style="top: 64px;">
                <ul class="nav nav-pills bg-white mb-2">
                    <li class="nav-item nav-item-category ">
                        <a class="nav-link  mb-sm-3 mb-md-0 active" data-toggle="tab" role="tab" href="">{{ __('All categories') }}</a>
                    </li>
                    @foreach ( $restorant->categories as $key => $category)
                        @if(!$category->items->isEmpty())
                            <li class="nav-item nav-item-category" id="{{ 'cat_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                                <a class="nav-link mb-sm-3 mb-md-0" data-toggle="tab" role="tab" id="{{ 'nav_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" href="#{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
            @endif


            @if(!$restorant->categories->isEmpty())
            @foreach ( $restorant->categories as $key => $category)
                @if(!$category->items->isEmpty())
                <div id="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" class="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                    <h1>{{ $category->name }}</h1><br />
                </div>
                @endif
                <div class="row {{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                    @foreach ($category->items as $item)
                        @if($item->available == 1)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="strip">
                                <figure>
                                    <a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)"><img src="{{ $item->logom }}" loading="lazy" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                                </figure>
                                <span class="res_title"><b><a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)">{{ $item->name }}</a></b></span><br />
                                <span class="res_description">{{ $item->short_description}}</span><br />
                                <span class="res_mimimum">@money($item->price, env('CASHIER_CURRENCY','usd'),true)</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            @else
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                        <br/><br/><br/>
                        <div class="text-center" style="opacity: 0.2;">
                            <img src="https://www.jing.fm/clipimg/full/256-2560623_juice-clipart-pizza-box-pizza-box.png" width="200" height="200"></img>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <i id="scrollTopBtn"  onclick="topFunction()" class="fa fa-arrow-up btn-danger"></i>

    </section>
@endsection

@section('js')
<script>
    "use strict";
    var items=[];
    var currentItem=null;
    var currentItemSelectedPrice=null;
    var lastAdded=null;
    var previouslySelected=[];
    var variantID=null;
    var CASHIER_CURRENCY = "<?php echo  env('CASHIER_CURRENCY','usd') ?>";
    var LOCALE="<?php echo  App::getLocale() ?>";

    /*
    * Price formater
    * @param {Nummber} price
    */
    function formatPrice(price){
        var formatter = new Intl.NumberFormat(LOCALE, {
            style: 'currency',
            currency:  CASHIER_CURRENCY,
        });

        var formated=formatter.format(price);

        return formated;
    }

    function getTheDataForTheFoundVariable(){
        console.log(previouslySelected);
        var comparableObject={};
        previouslySelected.forEach(element => {
            comparableObject[element.option_id]=element.name.trim().toLowerCase().replace(/\s/g , "-");
        });
        comparableObject=JSON.stringify(comparableObject)
        currentItem['variants'].forEach(element => {
            if(comparableObject==element.options){
                console.log(element.options);
                setSelectedVariant(element);
            }
        });

    }

    function setCurrentItem(id){


        var item=items[id];
        currentItem=item;
        previouslySelected=[];
        $('#modalTitle').text(item.name);
        $('#modalName').text(item.name);
        $('#modalPrice').html(item.price);
        $('#modalID').text(item.id);
        $("#modalImg").attr("src",item.image);
        $('#modalDescription').html(item.description);


        currentItemSelectedPrice=item.priceNotFormated;
        $('#variants-area').hide();
        $('.quantity-area').show();



        $('#productModal').modal('show');

    }
    <?php

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    $items=[];
    $categories = [];
    foreach ($restorant->categories as $key => $category) {

        array_push($categories, clean(str_replace(' ', '', strtolower($category->name)).strval($key)));

        foreach ($category->items as $key => $item) {

            //Now add the variants and optins to the item data
            $itemOptions=$item->options;

            $theArray=array(
                'name'=>$item->name,
                'id'=>$item->id,
                'priceNotFormated'=>$item->price,
                'price'=>@money($item->price, env('CASHIER_CURRENCY','usd'),true)."",
                'image'=>$item->logom,
                'description'=>$item->description
            );
            echo "items[".$item->id."]=".json_encode($theArray).";";
        }
    }
    ?>
</script>
    <script type="text/javascript">

        var categories = <?php echo json_encode($categories); ?>;

        var mybutton = document.getElementById("scrollTopBtn");

        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        function topFunction() {
            //document.body.scrollTop = 0;
            $("html, body").animate({ scrollTop: 0 }, 600);
            document.documentElement.scrollTop = 0;
        }


        $(".nav-item-category").on('click', function() {
            $.each(categories, function( index, value ) {
                $("."+value).show();
            });

            var id = $(this).attr("id");
            var category_id = id.substr(id.indexOf("_")+1, id.length);

            $.each(categories, function( index, value ) {
                if(value != category_id){
                    $("."+value).hide();
                }
            });
        });
    </script>
@endsection
