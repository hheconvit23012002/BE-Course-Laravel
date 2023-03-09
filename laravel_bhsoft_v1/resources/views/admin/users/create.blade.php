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
                    <form class="form-horizontal" id="form-user" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" value="">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input class="form-control" type="date" name="birthdate" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number"
                                   value="">
                        </div>
                        <div class="form-group">
                            <label for="logo">Avatar</label>
                            <input class="form-control" id="input-logo" type="file" name="logo"
                                   value="">
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
            $('#form-user').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('api.users.store') }}',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '/admin/users'
                        localStorage.setItem('success', JSON.stringify("Thêm thành công"))
                    },
                    error: function (response) {
                        $.toast({
                            heading: 'Server Error',
                            text: response.responseJSON,
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'error'
                        })
                    }
                })
            });
        });
    </script>
@endpush
