@extends('layouts.app', ['title' => __('Restaurants')])
@section('admin_title')
    {{__('Restaurant Management')}}
@endsection
@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-6">
                <br/>
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Restaurant Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                @endif

                                <a target="_blank" href="{{ route('vendor',$restorant->subdomain) }}" class="btn btn-sm btn-success">{{ __('View it') }}</a>

                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                       <h6 class="heading-small text-muted mb-4">{{ __('Restaurant information') }}</h6>
                        @include('partials.flash')
                        <div class="pl-lg-4">
                            <form method="post" action="{{ route('admin.restaurants.update', $restorant) }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                    <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
                                    @include('partials.fields',['fields'=>[
                                         ['ftype'=>'input','name'=>"Restaurant Name",'id'=>"name",'placeholder'=>"Restaurant Name",'required'=>true,'value'=>$restorant->name],
                                         ['ftype'=>'input','name'=>"Restaurant Description",'id'=>"description",'placeholder'=>"Restaurant description",'required'=>true,'value'=>$restorant->description],
                                         ['ftype'=>'input','name'=>"Restaurant Address",'id'=>"address",'placeholder'=>"Restaurant description",'required'=>true,'value'=>$restorant->address],
                                    ]])

                                    <div class="row">
                                        <?php
                                            $images=[
                                                ['name'=>'resto_logo','label'=>__('Restaurant Image'),'value'=>$restorant->logom,'style'=>'width: 295px; height: 200px;'],
                                                ['name'=>'resto_cover','label'=>__('Restaurant Cover Image'),'value'=>$restorant->coverm,'style'=>'width: 200px; height: 100px;']
                                            ]
                                        ?>
                                        @foreach ($images as $image)
                                            <div class="col-md-6">
                                                @include('partials.images',$image)
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                            <hr />
                            <h6 class="heading-small text-muted mb-4">{{ __('Owner information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name_owner') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name_owner">{{ __('Owner Name') }}</label>
                                    <input type="text" name="name_owner" id="name_owner" class="form-control form-control-alternative" placeholder="{{ __('Owner Name') }}" value="{{ old('name', $restorant->user->name) }}" readonly>
                                </div>
                                <div class="form-group{{ $errors->has('email_owner') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="email_owner">{{ __('Owner Email') }}</label>
                                    <input type="text" name="email_owner" id="email_owner" class="form-control form-control-alternative" placeholder="{{ __('Owner Email') }}" value="{{ old('name', $restorant->user->email) }}" readonly>
                                </div>
                                <div class="form-group{{ $errors->has('phone_owner') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="phone_owner">{{ __('Owner Phone') }}</label>
                                    <input type="text" name="phone_owner" id="phone_owner" class="form-control form-control-alternative" placeholder="{{ __('Owner Phone') }}" value="{{ old('name', $restorant->user->phone) }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-5 mb-xl-0">
                    <br/>
                <div class="card card-profile bg-secondary shadow">
                    <div class="card-header">
                        <h5 class="h3 mb-0">{{ __("Working Hours")}}</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('restaurant.workinghours') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="rid" name="rid" value="{{ $restorant->id }}"/>
                            <div class="form-group">
                                @foreach($days as $key => $value)
                                    <br/>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="days" class="custom-control-input" id="{{ 'day'.$key }}" value={{ $key }}>
                                                <label class="custom-control-label" for="{{ 'day'.$key }}">{{ __($value) }}</label>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-time-alarm"></i></span>
                                                </div>
                                                <input id="{{ $key.'_from' }}" name="{{ $key.'_from' }}" class="flatpickr datetimepicker form-control" type="text" placeholder="{{ __('Time') }}">
                                            </div>
                                        </div>
                                        <div class="col-2 text-center">
                                            <p class="display-4">-</p>
                                        </div>
                                        <div class="col-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-time-alarm"></i></span>
                                                </div>
                                                <input id="{{ $key.'_to' }}" name="{{ $key.'_to' }}" class="flatpickr datetimepicker form-control" type="text" placeholder="{{ __('Time') }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        "use strict";
        var defaultHourFrom = "09:00";
        var defaultHourTo = "17:00";

        var timeFormat = '{{ env('TIME_FORMAT','24hours') }}';

        function formatAMPM(date) {
            var hours = date.split(':')[0];
            var minutes = date.split(':')[1];

            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }

        var config = {
            enableTime: true,
            dateFormat: timeFormat == "AM/PM" ? "h:i K": "H:i",
            noCalendar: true,
            altFormat: timeFormat == "AM/PM" ? "h:i K" : "H:i",
            altInput: true,
            allowInput: true,
            time_24hr: timeFormat == "AM/PM" ? false : true,
            onChange: [
                function(selectedDates, dateStr, instance){
                    //...
                    this._selDateStr = dateStr;
                },
            ],
            onClose: [
                function(selDates, dateStr, instance){
                    if (this.config.allowInput && this._input.value && this._input.value !== this._selDateStr) {
                        this.setDate(this.altInput.value, false);
                    }
                }
            ]
        };

        $("input[type='checkbox'][name='days']").change(function() {


            var hourFrom = flatpickr($('#'+ this.value + '_from'), config);
            var hourTo = flatpickr($('#'+ this.value + '_to'), config);

            if(this.checked){
                hourFrom.setDate(timeFormat == "AP/PM" ? formatAMPM(defaultHourFrom) : defaultHourFrom, false);
                hourTo.setDate(timeFormat == "AP/PM" ? formatAMPM(defaultHourTo) : defaultHourTo, false);
            }else{
                hourFrom.clear();
                hourTo.clear();
            }
        });

        //Initialize working hours
        function initializeWorkingHours(){
            var workingHours = {!! json_encode($hours) !!};
            if(workingHours != null){
                Object.keys(workingHours).map((key, index)=>{
                    if(workingHours[key] != null){
                        var hour = flatpickr($('#'+key), config);
                        hour.setDate(workingHours[key], false);

                        var day_key = key.split('_')[0];
                        $('#day'+day_key).attr('checked', 'checked');
                    }
                })
            }
        }

        window.onload = function () {
            initializeWorkingHours();
        }
    </script>
@endsection

