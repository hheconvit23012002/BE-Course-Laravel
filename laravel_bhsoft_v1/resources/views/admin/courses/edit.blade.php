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
                    <form class="form-horizontal" method="post" id="form-course"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                   value="">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="12">
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            <input class="form-control" type="date" id="start_date" name="start_date"
                                   value="">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            <input class="form-control" type="date" id="end_date" name="end_date"
                                   value="">
                        </div>
                        <button class="btn btn-primary">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            const path = window.location.pathname;
            const parts = path.split('/');
            let course = parts[parts.length - 1];
            $.ajax({
                url: '{{ route("api.courses.show") }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    course: course
                },
                success: function (response) {
                    let course = response.data.course
                    $("#name").val(course.name)
                    $("#description").val(course.description)
                    $("#start_date").val(course.start_date)
                    $("#end_date").val(course.end_date)
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

            $("#form-course").submit(function(e){
                e.preventDefault();
                course = parseInt(course)
                console.log(course)
                $.ajax({
                    url: `http://laravel_bhsoft_v1.test/api/courses/update/${course}`,
                    type: 'PUT',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function (response) {
                        window.location.href = '/admin/courses'
                        localStorage.setItem('success', JSON.stringify("Sửa thành công"))
                    },
                    error: function (response) {
                        console.log(course)
                        $.toast({
                            heading: 'Server Error',
                            text: response.responseJSON,
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
