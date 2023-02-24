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

                <form class="form-horizontal" action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        @if($errors->any('name'))
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        @if($errors->any('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        @if($errors->any('birthdate'))
                            <span class="error">
                                {{ $errors->first('birthdate') }}
                            </span>
                        @endif
                        <input class="form-control" type="date" name="birthdate" value="{{ old('birthdate') }}">
                    </div>
                    <div class="form-group">

                        <label for="phone_number">Phone Number</label>
                        @if($errors->any('phone_number'))
                            <span class="error">
                                {{ $errors->first('phone_number') }}
                            </span>
                        @endif
                        <input class="form-control" type="text" name="phone_number" value="{{ old('phone_number') }}">
                    </div>

                    <div class="form-group">
                        <label for="logo">Avatar</label>

                        @if($errors->any('logo'))
                            <span class="error">
                                {{ $errors->first('logo') }}
                            </span>
                        @endif
                        <input class="form-control" id="input-logo" type="file" name="logo" value="{{ old('img') }}">
{{--                        <input type="hidden" id="item_img" name ="img" value="{{ old('img') }}" />--}}

                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        @if($errors->any('course'))
                            <span class="error">
                                {{ $errors->first('course') }}
                            </span>
                        @endif
                        <select class="form-control" name="course[]" id="select-course" multiple="multiple">
{{--                            @if(old('course')  !== null)--}}
{{--                                <option value="{{ old('course') }}" selected="selected">--}}
{{--                                    {{ old('item_title') }}--}}
{{--                                </option>--}}
{{--                            @endif--}}
                        </select>
                    </div>
                    <button class="btn btn-primary">submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            let data = [];

            $('#select-course').select2({
              ajax: {
                  delay: 250,
                  url: '{{ route('api.courses') }}',
                  data: function (params) {
                      return {
                        q: params.term
                    };
                  },
                  processResults: function (data) {
                      return {
                          results: $.map(data.data, function (item) {
                              return {
                                  text: item.name,
                                  id: item.id,
                              }
                          })
                      };
                  },
              }
            })
            if(localStorage.getItem('data')){
                let course_old = JSON.parse(localStorage.getItem('data'));
                    course_old.forEach(function(value){
                    $('#select-course').append(`<option value="${value.id}" selected="selected">${value.title}</option>`)
                    // console.log(value.id)
                })
                localStorage.removeItem('data');
            }
            // $('#input-logo').on('change',function(e){
            //     $('#item_img').val($(this).val())
            // })
            $('#select-course').on('change', function(e){
                let all_course = $(this).select2('data')
                data = [];
                all_course.forEach(function(value){
                    let id = value.id;
                    let title = value.text;
                    data.push({id,title});
                })
                localStorage.setItem('data', JSON.stringify(data))
            });
        });
    </script>
@endpush
