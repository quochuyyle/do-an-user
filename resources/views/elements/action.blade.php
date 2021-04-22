@if($model->approve==0)
    @isset($approve)
        <a class="btn btn-light app btn-approve" data-id="{{$model->id}}" href="{{route('admin.motel.approve',$model->id)}}">
            {!! $approve !!}
        </a>
    @endisset
@else
    @isset($unapprove)
        <a class="btn btn-light btn-unapprove" data-id="{{$model->id}}" href="{{route('admin.motel.unapprove',$model->id)}}">
            {!! $unapprove !!}
        </a>
    @endisset
@endif
@if(isset($element_id))
    <button href="{{$url_edit}}" class="btn btn-info waves-effect waves-light btn-sm mr-2 btn-edit" data-toggle="modal"  data-target="#{{ $element_id }}"  data-id="{{$model->id}}"><i class="fas fa-edit"></i></button>
    {{--<button class="btn btn-info waves-effect waves-light btn-sm btn-edit mr-2" data-toggle="modal" data-id="{{ $model->iddata-target="#editCategory" }}" ><i class="fas fa-edit"></i></button>--}}
@endif
<a href="{{$url_destroy}}" class="btn btn-danger waves-effect waves-light btn-sm btn-delete" data-id="{{ $model->id }}" title="{{ $model->title }}"><i class="fas fa-trash-alt btn-delete"></i></a>
{{--<button  data-url="{{$url_destroy}}" class="btn btn-danger waves-effect waves-light btn-sm btn-delete btn-delete"  data-id="{{ $model->id }}" title="{{ $model->title }}"><i class="fas fa-trash-alt"></i></button>--}}
