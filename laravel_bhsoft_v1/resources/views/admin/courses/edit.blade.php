@extends('layout.master')
@push('css')
    <style>
        .error{
            color:red
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('admin.courses.update',$course) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            @if($errors->any('name'))
                                <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                            <input class="form-control" type="text" name="name" value="{{ !old('name') ? $course->name : old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            @if($errors->any('description'))
                                <span class="error">
                                {{ $errors->first('description') }}
                            </span>
                            @endif
                            <textarea class="form-control" name="description" rows="12">{{ !old('description') ? $course->description : old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            @if($errors->any('start_date'))
                                <span class="error">
                                {{ $errors->first('start_date') }}
                            </span>
                            @endif
                            <input class="form-control" type="date" name="start_date" value="{{ !old('start_date') ? $course->start_date : old('start_date') }}">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            @if($errors->any('end_date'))
                                <span class="error">
                                {{ $errors->first('end_date') }}
                            </span>
                            @endif
                            <input class="form-control" type="date" name="end_date" value="{{ !old('end_date') ? $course->end_date : old('end_date') }}">
                        </div>
                        <button class="btn btn-primary">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
