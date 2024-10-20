@extends('backend.layout.app')
@section('content')
    <div class="col">
        <form action="{{route('backend.ranks.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-header">
                    <h3 class="card-title"> Create new rank</h3>
                    <div class="card-toolbar">
                        <a href="{{route('backend.ranks.index')}}" class="btn btn-info"><i
                                    class="las la-redo fs-4 me-2"></i> {{trans('backend.global.back')}}</a>
                    </div>
                </div>
                <div class="card card-flush">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                            @foreach(get_languages() as $key => $item)
                                <li class="nav-item">
                                    <a class="nav-link  {{$key == 0 ? "active" : ""}}" data-bs-toggle="tab"
                                       href="#lang_{{$item->code}}">{{$item->language}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="information_tabs">
                            @foreach(get_languages() as $key => $item)
                                <div class="tab-pane fade show  {{$key == 0 ? "active" : ""}}"
                                     id="lang_{{$item->code}}" role="tabpane{{$key}}">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="title_{{$item->code}}"
                                                       class="form-label @if($key == 0 ) required @endif">{{trans('backend.product.title')}}</label>
                                                <input type="text" class="form-control has-error" name="title_{{$item->code}}"
                                                       value="{{old('title_'.$item->code , $rank->getTranslation('title' , $item->code))}}"
                                                       id="title_{{$item->code}}" maxlength="70">
                                                <b id="error_title_{{$item->code}}" class="text-danger"></b>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 form-group ">
                                            <div class="form-group">
                                                <label class="form-label  @if($key == 0 ) required @endif"
                                                       for="description_{{$item->code}}"> {{trans('backend.category.description')}}</label>
                                                <textarea type="text" class="form-control" id="description_{{$item->code}}"
                                                          name="description_{{$item->code}}"
                                                > {{old('description_'.$item->code , $rank->getTranslation('description' , $item->code))}}</textarea>
                                                <b class="text-danger" id="error_description_{{$item->code}}">
                                                    @error('description_'.$item->code)<i
                                                        class="las la-exclamation-triangle"></i> {{$message}} @enderror</b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <h2><label for="image" class="required mt-6">{{trans('backend.product.image')}}</label></h2>
                        <div class="card-body  pt-0">
                            {!! single_image('image' , media_file(old('image',$rank->icon) ), old('image',$rank->icon), 'image',['watermark'=>'no' ]) !!}
                            <br>
                            <b class="text-danger" id="error_image">    @error('image'){{ $message }}@enderror</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-body">
                    <div class="col  align-items-center">
                        <div class="col-12 col-md-12 form-group mb-10 mt-6 ">
                            <div class="form-group">
                                <label class="form-label @if($key == 0) required @endif" for="min_purchase">
                                    <span style="color:red;font-size:16px">*</span> Minimum Purchase to get this rank
                                </label>
                                <input type="number" min="0" class="form-control @error('min_purchase') is-invalid @enderror" name="min_purchase" 
                                       value="{{$rank->min_purchase}}" id="min_purchase">
                                <b class="text-danger">
                                    @error('min_purchase')<i class="las la-exclamation-triangle"></i> {{ $message }} @enderror
                                </b>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 form-group mb-5 mt-6 ">
                            <div class="form-group">
                                <label class="form-label  @if($key == 0 ) @endif"
                                    for="benefits"> Benifts</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group  align-items-center">
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" 
                                           type="checkbox"
                                           value="{{ $rank->is_special_price == 1 ? '1' : '0' }}"
                                           name="special_price" 
                                           id="special_price"
                                           data-special-price="{{ $rank->discount_value }}"
                                           {{ $rank->is_special_price == 1 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="special_price">
                                        Special price
                                    </label>
                                </div>
                                <div id="discount_container"></div>
                            </div>
                            <div class="form-group  align-items-center mt-10">
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" type="checkbox"
                                           value="{{ $rank->is_coupon == 1 ? '1' : '0' }}"
                                           name="get_coupon" id="get_coupon"
                                           data-get-coupon="{{ $rank->coupon_value }}"
                                           {{ $rank->is_coupon == 1 ? 'checked' : '' }} />
                                    <label class="form-check-label" for="">
                                        Send Coupons
                                    </label>
                                </div>
                                <div id="coupons_container"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group  align-items-center mt-10">
                            <br>
                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-30px" checked type="checkbox" value="1"
                                       name="status" id="status"/>
                                <label class="form-check-label" for="status">
                                    Activate this rank
                                </label>
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
<script>
    $(document).ready(function () {
        // Check the state of the checkboxes on page load
        var specialPriceChecked = $('#special_price').is(':checked');
        var getCouponChecked = $('#get_coupon').is(':checked');

        // Set the initial state of the discount and coupon inputs based on checkbox state
        if (specialPriceChecked) {
            $('#discount_container').html(
                '<div class="mt-3">' +
                '<label for="discount">Discount (%) (The price of the products will be reduced by this percentage)</label>' +
                '<input type="number" class="form-control" id="discount" name="discount" min="0" max="100" placeholder="Enter discount percentage" value="' + $('#special_price').data('special-price') + '">' +
                '</div>'
            );
        }

        if (getCouponChecked) {
            $('#coupons_container').html(
                '<div class="mt-3">' +
                '<label for="coupon_code">Coupon Code (The coupon code will be generated automatically and sent to the users.)</label>' +
                '<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Coupon code value (%)" value="' + $('#get_coupon').data('get-coupon') + '">' +
                '</div>'
            );
        }

        // Listen for changes on the "Special price" checkbox
        $('#special_price').change(function () {
            toggleDiscountInput();
        });

        // Listen for changes on the "Send Coupons" checkbox
        $('#get_coupon').change(function () {
            toggleCouponInput();
        });

        function toggleDiscountInput() {
            if ($('#special_price').is(':checked')) {
                // If checked, add the discount input field
                $('#discount_container').html(
                    '<div class="mt-3">' +
                    '<label for="discount">Discount (%) (The price of the products will be reduced by this percentage)</label>' +
                    '<input type="number" class="form-control" id="discount" name="discount" min="0" max="100" placeholder="Enter discount percentage">' +
                    '</div>'
                );
            } else {
                // If unchecked, remove the discount input field
                $('#discount_container').empty();
            }
        }

        function toggleCouponInput() {
            if ($('#get_coupon').is(':checked')) {
                // If checked, add the coupon code input field
                $('#coupons_container').html(
                    '<div class="mt-3">' +
                    '<label for="coupon_code">Coupon Code (The coupon code will be generated automatically and sent to the users.)</label>' +
                    '<input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Coupon code value (%)">' +
                    '</div>'
                );
            } else {
                // If unchecked, remove the coupon code input field
                $('#coupons_container').empty();
            }
        }
    });
</script>
@endsection
