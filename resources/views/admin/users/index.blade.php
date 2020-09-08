@extends('admin.layout')

@push('css')
    <link href="{{url('')}}/admin_assets/plugins/custom/datatables/datatables.bundle.rtl.css?v=7.0.5" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{url('')}}/admin_assets/custom/css/plugins/magnific-popup.min.css">

@endpush

@section('content')
    @include('admin.includes.heading' , ['show' => false])
    <div id="app">

        <user-comp :countries="countries" :data="data" :shock_event="shock_event"
                   :add="add" :default_image="default_image">
        </user-comp>

        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h2 class="card-label">{{trans('admin.users')}}</h2>
                </div>
                <div class="card-toolbar">
                    <a href="javascript:;" class="btn btn-success font-weight-bold mr-2 add-button">
                        <i class="fa fa-plus"></i>إضافة</a>
                </div>
            </div>
            <div class="card-body">

                <option-comp @emit-execute-option="emitExecuteOption" :options="options" :ids="ids"
                             :url="option_url"></option-comp>
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable" id="user-table">
                    <thead>
                    <tr>
                        <th>
                            <span style="width: 20px;"><label class="checkbox checkbox-single checkbox-all">
                                    <input type="checkbox" id="check_all">&nbsp;<span></span></label>
                            </span>
                        </th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name')}}</th>
                        <th>{{trans('admin.email')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.status')}}</th>
                        <th>{{trans('admin.date')}}</th>
                        <th>{{trans('admin.control')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        var default_image = "{{getImage('users' ,'true')}}";
        var countries = {!! $countries !!};
        var options = {!! $options !!};
    </script>
    <script src="{{url('')}}/admin_assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5"></script>
    <script src="{{url('')}}/admin_assets/custom/js/plugins/magnific-popup.min.js"></script>

    <script src="{{url('')}}/admin_assets/custom/js/users/list.js"></script>
    <script src="{{url('')}}/admin_assets/custom/js/users/user.js"></script>
    <script src="{{url('')}}/admin_assets/custom/js/users/service.js"></script>
@endpush