@extends('layout.master')
@push('css')
    <style>
        .error {
            color: red
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="post" id="form-user"
                          enctype="multipart/form-data">
{{--                        @csrf--}}
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name"
                                   id="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email"
                                   id="email" value="">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input class="form-control" type="date" name="birthdate"
                                  id="birthdate" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number"
                                  id="phone_number" value="">
                        </div>
                        <div class="form-group">
                            <label for="logo">Avatar</label>
                            <input class="form-control" type="file" name="logo_new">
                            <label for="logo">Use avatar old</label>
                            <img height="100" id="img-old" src="" alt="">
                            <br>
                        </div>
                        <div class="form-group">
                            <label>Course</label>
                            <select class="form-control" name="course[]" id="select-course" multiple="multiple">
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const path = window.location.pathname;
            const parts = path.split('/');
            let user = parts[parts.length - 1];
            $.ajax({
                url: '{{ route("api.users.show") }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    user: user
                },
                success: function (response) {
                    let user = response.data.user
                    let courses = response.data.course
                    console.log(courses)
                    $("#name").val(user.name)
                    $("#email").val(user.email)
                    $("#birthdate").val(user.birthdate)
                    $("#phone_number").val(user.phone_number)
                    $("#img-old").attr('src',user.logo)
                    courses.forEach(function (value) {
                        $('#select-course').append(`<option value="${value.course}" selected="selected">${value.courses.name}</option>`)
                    })
                },
                error: function (response) {
                    $.toast({
                        heading: 'Server Error',
                        text: response.responseJSON.message,
                        showHideTransition: 'slide',
                        position: 'top-right',
                        icon: 'error'
                    })
                },
            })
            let data = [];
            $('#select-course').select2({
                ajax: {
                    delay: 250,
                    url: '{{ route('api.coursesSelect2') }}',
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
            $("#form-user").submit(function(e){
                e.preventDefault();
                user = parseInt(user)
                let formData = new FormData(this);
                $.ajax({
                    url: `http://laravel_bhsoft_v1.test/api/users/update/${user}`,
                    type: 'POST',
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '/admin/users'
                        localStorage.setItem('success', JSON.stringify("Sửa thành công"))
                    },
                    error: function (response) {
                        $.toast({
                            heading: 'Server Error',
                            text: response.responseJSON.message || response.responseJSON,
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'error'
                        })
                    },
                })
            })
        });
    </script>
@endpush
