<div class="col-12">
    <div class="card card-flush mt-3">
        <div class="card-header">
            <div class="card-title">
                <h2>{{trans('backend.product.discounts_and_offers')}}</h2>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12 col-md-3" >
                    <label  class="form-label" for="date_type">{{trans('backend.product.date_type')}}</label>
                    <select name="date_type"  data-control="select2" class="form-control" id="date_type">
                        <option  @if(!(old('date_type', $product->date_type)== 'for_ever' || empty($product->end_date_discount))) selected @endif selected value="custom_date">{{trans('backend.product.custom_date')}}</option>
                        <option  @if(old('date_type', $product->date_type)== 'for_ever' || empty($product->end_date_discount)) selected @endif value="for_ever">{{trans('backend.product.for_ever')}}</option>
                    </select>
                </div>
                <div class="col-12 col-md-3" id="div_date_type"  @if(old('date_type', $product->date_type)== 'for_ever' || empty($product->end_date_discount)) style="display: none;" @endif>
                    <label class="form-label">{{trans('backend.product.discount_range')}}</label>
                    <input class="form-control" value="{{date('m/d/Y',strtotime(old('discount_range_start' , $product->start_date_discount)))}} - {{date('m/d/Y',strtotime(old('discount_range_end' , $product->end_date_discount)))}}" name="discount_range" id="discount_range"/>
                    <input type="hidden" value="{{old('discount_range_start' , $product->start_date_discount)}}" name="discount_range_start" id="discount_range_start"/>
                    <input type="hidden" value="{{old('discount_range_end' , $product->end_date_discount)}}" name="discount_range_end"   id="discount_range_end"/>

                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="discount_type">{{trans('backend.product.discount_type')}}</label>
                        <select name="discount_type" class="form-control" data-control="select2" id="discount_type">
                            <option @if(old('discount_type',$product->discount_type)=='none') selected @endif value="none">{{trans('backend.product.none')}}</option>
                            <option @if(old('discount_type',$product->discount_type)=='fixed') selected @endif value="fixed">{{trans('backend.product.fixed')}}</option>
                            <option @if(old('discount_type',$product->discount_type)=='percent') selected @endif value="percent">{{trans('backend.product.percent')}}</option>
                        </select>
                        @error('discount_type') <b class="text-danger"><i class="las la-exclamation-triangle"></i> {{$message}}
                        </b> @enderror
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label class="form-label"  for="discount_value">{{trans('backend.product.discount_value')}}</label>
                        <input type="number" step="0.01" value="{{old('discount_value' , $product->discount_value)}}" class="form-control"
                               name="discount_value" id="discount_value">
                        @error('discount_value') <b class="text-danger"><i class="las la-exclamation-triangle"></i> {{$message}}
                        </b> @enderror
                    </div>
                </div>
            </div>
            </div>
    </div>
</div>
