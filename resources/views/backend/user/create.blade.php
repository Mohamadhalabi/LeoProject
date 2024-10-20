@extends('backend.layout.app')
@section('title',trans('backend.menu.users').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('style')
    <link rel="stylesheet" href="{{asset('backend/plugins/custom/intltell/css/intlTelInput.css')}}">
    <style>
        .iti {
            width: 100% !important;

        }
    </style>
@endsection
@section('content')
    <div class="col">
        <form action="{{route('backend.users.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-header">
                    <h3 class="card-title"> {{trans('backend.user.create_new_user')}}</h3>
                    <div class="card-toolbar">
                        <a href="{{route('backend.users.index')}}" class="btn btn-info"><i
                                    class="las la-redo fs-4 me-2"></i> {{trans('backend.global.back')}}</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="mb-10">
                                <label for="name" class="required form-label">{{trans('backend.user.name')}}</label>
                                <input required autocomplete="off" type="text" class="form-control " id="name"
                                       name="name" value="{{old('name')}}"
                                       placeholder="{{trans('backend.user.name')}}"/>
                                @error('name') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>

                        <div class="col-12 col-md-6">
                            <div class="  mb-10">
                                <label for="email" class="required form-label">{{trans('backend.user.email')}}</label>
                                <input required autocomplete="off" type="email" class="form-control" id="email"
                                       name="email" value="{{old('email')}}"
                                       placeholder="{{trans('backend.user.email')}}"/>
                                @error('email') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror

                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="mb-10">
                                <label for="phone" class="form-label required">{{trans('backend.user.phone')}}</label><br>
                                <input required autocomplete="off" type="text" class="form-control w-100  " id="phone"
                                       name="phone" value="{{old('phone')}}"
                                       placeholder="{{trans('backend.user.phone')}}"/>
                                @error('phone') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror
                            </div>

                        </div>

    
                    </div>

                    <div class="row">
                        @php
                         $pass=    substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);    @endphp
                        <div class="col-12 col-md-6">
                            <div class="  mb-10">
                                <label for="password"
                                       class="form-label required">{{trans('backend.user.password')}}</label>
                                <input required autocomplete="off" type="text" class="form-control " id="password"
                                       name="password" value="{{old('password',$pass)}}"
                                       placeholder="{{trans('backend.user.password')}}"/>
                                @error('password') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror

                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class=" mb-10">
                                <label for="password_confirmation"
                                       class="form-label required">{{trans('backend.user.password_confirmation')}}</label>
                                <input required autocomplete="off" type="text" class="form-control"
                                       id="password_confirmation" name="password_confirmation"  value="{{old('password_confirmation',$pass)}}"
                                       placeholder="{{trans('backend.user.password_confirmation')}}"/>
                                @error('password_confirmation') <b class="text-danger"><i
                                            class="las la-exclamation-triangle"></i> {{$message}} </b> @enderror

                            </div>
                        </div>
                    </div>


                    <div class="row">
                    <div class="col-12 col-sm-6 align-items-center">
                        <div class="form-group align-items-center">
                        <label for="rankSelect" class="form-label w-100">Select Rank</label>

                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                <br>
                                <select class="form-select" id="rankSelect" name="rank">
                                <option value="NULL" selected>Select A rank</option>

                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}">{{ $rank->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>    
                    </div>
                </div>



                    <div class="row">
                    <div class="col-12 col-sm-12  align-items-center">
                            <div class="form-group  align-items-center">
                                <br>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" @if(old('allowdebt')== 1) checked
                                            @endif type="checkbox" value="1"
                                            name="allowdebt" id="allowdebt"/>
                                        <label class="form-check-label" for="allowdebt">
                                            Allow debt
                                        </label>
                                    </div>
                                </div>
                        </div>    
                    </div>

                    <div class="row mb-6">
                        <div class="col-12 col-sm-6  ">
                            <div class="form-group ">

                                <label class=" form-label fw-bold m-4   mx-auto">{{trans('backend.profile.avatar')}}</label>

                                <div class=" mx-auto">
                                    <div class="image-input image-input-outline image-input-empty"
                                         data-kt-image-input="true"
                                         style="background-image: url({{ old('avatar',asset('backend/media/avatars/blank.png'))}})">
                                        <div class="image-input-wrapper text-center z-index-3 w-125px h-125px p-5"
                                             style="background-image: none">
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow "
                                               data-kt-image-input-action="change" data-bs-toggle="tooltip" title=""
                                               data-bs-original-title="Change avatar">
                                            <i class="bi bi-pencil-fill fs-7"></i>
                                            <input type="file" name="avatar" value="{{old('avatar')}}"
                                                   accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="avatar_remove">
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title=""
                                              data-bs-original-title="Cancel avatar">
																<i class="bi bi-x fs-2"></i>
															</span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title=""
                                              data-bs-original-title="Remove avatar">
																<i class="bi bi-x fs-2"></i>
															</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6  align-items-center">
                            <div class="form-group  align-items-center">
                                <br>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" @if(old('status')== 1) checked
                                           @endif type="checkbox" value="1"
                                           name="status" id="status"/>
                                    <label class="form-check-label" for="status">
                                        {{trans('backend.user.status')}}
                                    </label>
                                </div>
                            </div>
                    </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">  {{trans('backend.global.save')}} </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{asset("backend/plugins/custom/intltell/js/intlTelInput.js")}}"></script>

    <script>

        $(document).ready(function () {
            var country = $("#country").val();
            @if(!empty(old('country')))
            $("#country").val("{{old('country')}}").change();
            @endif

        })
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: "tr",

            utilsScript: "{{asset('backend/plugins/custom/intltell/js/utils.js')}}",
        });
    </script>
@endsection
