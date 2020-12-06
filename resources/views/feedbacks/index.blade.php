@extends('layouts.app', ['title' => __('Feedbacks')])
@section('admin_title')
    {{__('Feedbacks')}}
@endsection
@section('content')
    @include('restorants.partials.modals')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Feedbacks') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @include('partials.flash')
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Restaurant') }}</th>
                                    <th scope="col">{{ __('Meal quality') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">{{ __('Customer service') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedbacks as $feedback)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.restaurants.edit', $feedback->restaurant) }}">{{ $feedback->restaurant->name }}</a>
                                        </td>
                                        <td>
                                            @include('feedbacks.partials.percentage', ['var' => $feedback->meal])
                                        </td>
                                        <td>
                                            @include('feedbacks.partials.percentage', ['var' => $feedback->price])
                                        </td>
                                        <td>
                                            @include('feedbacks.partials.percentage', ['var' => $feedback->service])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $feedbacks->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
