@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-between">
                    <div class="order-1 order-lg-0 col-12 col-md-6 col-lg-9">


                        <h6 id="extraFieldsTitle" class="profile-section-title font-weight-bold">{{trans('iprofile::frontend.form.Basic')}}</h6>

                        <hr class="border-top-dotted">
                        <div class="px-3 row">
                            <div class="col-12">
                                <label for="email" class="font-weight-bold">{{trans('user::users.form.email')}}</label>
                                <div class="d-block mb-3 ml-1"><span>{{$user->email}}</span></div>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold">{{ trans('user::users.form.first-name') }}</label>
                                <div class="d-block mb-3 ml-1"><span>{{$user->first_name}}</span></div>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold">{{ trans('user::users.form.last-name') }}</label>
                                <div class="d-block mb-3 ml-1"><span>{{$user->last_name}}</span></div>
                            </div>
                        </div>
                        @if(!empty($user->fields->isNotEmpty()))
                            <h6 id="extraFieldsTitle" class="profile-section-title font-weight-bold">{{trans('iprofile::frontend.title.extraFields')}}</h6>
                            <hr class="border-top-dotted">
                            @php
                                $registerExtraFields = json_decode(setting('iprofile::registerExtraFields', null, "[]"));
                                $extFields = isset($fields) ? collect($fields)->keyBy('name') : [];
                            @endphp
                            @foreach($registerExtraFields as $extraField)
                                @php
                                    $oldValue = isset($extFields[$extraField->field]) ? $extFields[$extraField->field]->value : null;
                                @endphp
                                {{-- if is active--}}
                                @if(isset($extraField->active) && $extraField->active)
                                    {{-- form group--}}
                                    <div class="col-sm-12 col-md-6 py-2 has-feedback">
                                        {{-- label --}}
                                        <label for="extraField{{$extraField->field}}">{{trans("iprofile::frontend.form.$extraField->field")}}</label>
                                        <div>
                                            {{ $oldValue }}
                                        </div>
                                    </div>
                                @endif {{-- end if is active --}}
                            @endforeach
                        @endif
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 py-2 text-center">
                        @php $defaultImage = url("modules/iprofile/img/default.jpg"); @endphp
                        <div class="img-frame mx-auto w-75">
                            @if(isset($fields['mainImage']) &&  !empty($fields['mainImage']) && $fields['mainImage']!=null )
                                <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{ url($fields['mainImage']).'?'.strtotime(now()) }}" alt="Logo" >
                            @else
                                <img id="mainImage" class="mx-auto img-fluid rounded-circle bg-white" src="{{$defaultImage}}" alt="Logo">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <h4>{!! trans('iplan::common.messages.user-'.($userValidSubscription ?'valid':'not-valid').'-subscription', ['name' => $user->present()->fullName]) !!}</h4>
            </div>
        </div>
    </div>
@endsection
