@extends('app.layouts.main')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-user-shield"></i>Manage Home - {{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Key Feature</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            {{ session('success') }}
                        </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ session('error') }}
                    </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @include('app.includes._heading_form',['type'=>'home_key_feature'])
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <a href="{{url(Helper::sitePrefix().'home/key-feature/create')}}" class="btn btn-success pull-right">Add Key Feature <i class="fa fa-plus-circle pull-right mt-1 ml-2"></i></a>
                        </div>
                        <div class="card-body">
                            <table class="dataTable table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>number</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th class="not-sortable">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($keyfeatureList as $feature)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{!! $feature->title !!}</td>
                                        <td>{!! $feature->number !!}</td>
                                        <td>
                                            <input type="text" name="sort_order" id="sort_order_{{$loop->iteration}}" data-extra="id"
                                                   data-extra_key="{{$feature->id}}" data-table="KeyFeature"
                                                   data-id="{{ $feature->id }}" class="common_sort_order" style="width:25%"
                                                   value="{{$feature->sort_order}}">
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input id="switch-state" type="checkbox" class="status_check"
                                                       data-size="mini" data-url="/status-change"
                                                       data-limit="4" data-table="KeyFeature"
                                                       data-field="status" data-pk="{{ $feature->id }}"
                                                    {{($feature->status=="Active")?'checked':''}}>
                                                <span class="slider"></span>
                                            </label>
                                        </td>

                                        <td>{{ date("d-M-Y", strtotime($feature->created_at)) }}</td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{url(Helper::sitePrefix().'home/key-feature/edit/'.$feature->id)}}" class="btn btn-success mr-2 tooltips" title="Edit Key Feature"><i class="fas fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger mr-2 delete_entry tooltips" title="Delete Key Feature" data-url="home/key-feature/delete" data-id="{{$feature->id}}"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#image").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: true,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            allowedFileTypes: ['image'],
            minImageWidth: 1920,
            minImageHeight: 980,
            maxImageWidth: 1920,
            maxImageHeight: 980,
            showRemove: false,
            @if(isset($home_heading) && $home_heading->image!=NULL)
            initialPreview: ["{{asset($home_heading->image)}}"],
            initialPreviewConfig: [{
                caption: "{{ last(explode('/',$home_heading->image)) }}",
                width: "120px"
            }]
            @endif
        });
        $("#about_us_image").fileinput({
            'theme': 'explorer-fas',
            validateInitialCount: true,
            overwriteInitial: false,
            autoReplace: true,
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            dropZoneEnabled: false,
            allowedFileTypes: ['image'],
            minImageWidth: 1920,
            minImageHeight: 1130,
            maxImageWidth: 1920,
            maxImageHeight: 1130,
            showRemove: false,
            @if(isset($about_us_heading) && $about_us_heading->image!=NULL)
            initialPreview: ["{{asset($about_us_heading->image)}}"],
            initialPreviewConfig: [{
                caption: "{{ last(explode('/',$about_us_heading->image)) }}",
                width: "120px"
            }]
            @endif
        });
    });
</script>
@endsection
