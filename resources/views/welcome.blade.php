@extends('layouts.front', ['class' => ''])

@section('content')
        @foreach ($sections as $section)

        <section class="section" id="main-content">
            <div class="container mt--100">
                <h2>{{ $section['title'] }}</h2>
                @isset($section['super_title'])
                    <h2 class="super_title">{{ $section['super_title'] }}</h2>
                @endisset

                <br />
                <div class="row">
                    <!-- Stores -->
                    @isset($section['restorants'])
                        @forelse ($section['restorants'] as $restorant)
                            <?php $link=route('vendor',['alias'=>$restorant->alias]); ?>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                <div class="strip">
                                    <figure>
                                    <a href="{{ $link }}"><img src="{{ $restorant->logom }}" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                                    </figure>
                                    <span class="res_title"><b><a href="{{ $link }}">{{ $restorant->name}}</a></b></span><span class="float-right"><i class="fa fa-star" style="color: #dc3545"></i> <strong>{{ number_format($restorant->averageRating, 1, '.', ',') }} <span class="small">/ 5 ({{ count($restorant->ratings) }})</strong></span></span><br />
                                    <span class="res_description">{{ $restorant->description}}</span><br />

                                </div>
                            </div>
                            @empty
                            <div class="col-md-12">
                            <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                            </div>

                        @endforelse
                    @endisset


                                    </div>



            </div>
        </section>
    @endforeach
@endsection
