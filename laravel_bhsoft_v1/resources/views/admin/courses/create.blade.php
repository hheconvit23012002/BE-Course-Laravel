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
                    <form class="form-horizontal" id="form-course" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            
                            <textarea class="form-control" name="description"
                                      rows="12">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start date</label>
                            
                            <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End date</label>
                            
                            <input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}">
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
            $('#form-course').submit(function(e) {
                e.preventDefault();
                console.log($(this).serialize())
                $.ajax({
                    url: '{{ route('api.courses.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        window.location.href = '/admin/courses'
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
