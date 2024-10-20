@extends('backend.layout.app')
@section('title',trans('backend.menu.menus').' | '.get_translatable_setting('system_name', app()->getLocale()))

@section('content')
    <div class="col">


        <form action="{{route('backend.cms.menus.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card flex-row-fluid mb-2  ">
                <div class="card-header">
                    <h3 class="card-title"> {{trans('backend.menu.create_new_menu')}}</h3>
                    <div class="card-toolbar">
                        <a href="{{route('backend.cms.menus.index')}}" class="btn btn-info"><i
                                class="las la-redo fs-4 me-2"></i> {{trans('backend.global.back')}}</a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach(get_languages() as $key=> $language)
                            <li class="nav-item">
                                <a class="nav-link  @if($key == 0 ) active @endif" data-bs-toggle="tab"
                                   href="#{{$language->code}}">{{$language->language}}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="card flex-row-fluid mb-2 mt-5  ">

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary">{{trans('backend.global.save')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')

    <script>
        $(document).on('change', '#type', function () {
            var value = $(this).val();
            if (value === 'header') {
                $('#icon-wrapper').removeClass('d-none');
            } else {
                $('#icon-wrapper').addClass('d-none');
            }
        });
    </script>
@endsection
