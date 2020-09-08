@extends('admin.layout')

@push('css')
    <link href="{{url('')}}/admin_assets/plugins/custom/datatables/datatables.bundle.rtl.css?v=7.0.5" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{url('')}}/admin_assets/custom/css/plugins/magnific-popup.min.css">

@endpush

@section('content')
    <div id="app">

        <category-comp @add-category="addCategory" @update-category="updateCategory"
                       :data="data" :shock_event="shock_event"
                       :categories="categories"
                       :add="add" :default_image="default_image">
        </category-comp>


        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h2 class="card-label">{{trans('admin.categories')}}</h2>
                </div>
                <div class="card-toolbar">
                    <a href="javascript:;" class="btn btn-success font-weight-bold mr-2 add-button">
                        <i class="fa fa-plus"></i>{{trans('admin.add')}}</a>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="dropdown bootstrap-select form-control dropup">
                            <select id="select_filter_category" class="form-control selectpicker"
                                    data-live-search="true"
                                    tabindex="null"
                                    :data-none-selected-text="__('admin.select_category')">
                                <option value="-1">{{__('admin.all')}}</option>
                                <option v-for="category in categories" :value="category.id"
                                        v-text="category.name[locale] + ' ' + category.get_parents_name"></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" style="width: 100%" :disabled="filter_loading" @click="filterData"
                                class="btn btn-primary"
                                :class="filter_loading ? 'spinner spinner-white spinner-left' : ''">
                            {{__('admin.apply')}}
                        </button>
                    </div>
                </div>

                <option-comp @emit-execute-option="emitExecuteOption" :options="options" :ids="ids"
                             :url="option_url">
                </option-comp>
                <!--begin: Datatable-->
                <table class="table table-separate table-head-custom table-checkable" id="category-table">
                    <thead>
                    <tr>
                        <th>
                            <span style="width: 20px;"><label class="checkbox checkbox-single checkbox-all">
                                    <input type="checkbox" id="check_all">&nbsp;<span></span></label>
                            </span>
                        </th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name')}}</th>
                        <th>{{trans('admin.parent')}}</th>
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
        var default_image = "{{getImage('categories' ,true)}}";
        var options = {!! $options !!};
        var categories = {!! $categories !!};
    </script>
    <script src="{{url('')}}/admin_assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5"></script>
    <script src="{{url('')}}/admin_assets/custom/js/plugins/magnific-popup.min.js"></script>

    <script src="{{url('')}}/admin_assets/custom/js/categories/list.js"></script>
    <script src="{{url('')}}/admin_assets/custom/js/categories/category.js"></script>
    <script src="{{url('')}}/admin_assets/custom/js/categories/service.js"></script>
@endpush