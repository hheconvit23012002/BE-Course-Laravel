@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                            Create
                        </a>
                        <form>
                            <label class="btn btn-info ml-2 mb-0" for="ip_csv">Import CSV</label>
                            <input type="file" name="ip_csv" id="import_csv" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </form>
                        <form action="{{ route('admin.courses.export_csv') }}">
                            <button class="btn btn-info ml-2 mb-0">Export CSV</button>
                        </form>
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>name</td>
                            <td>start date</td>
                            <td>end date</td>
                            <td>edit</td>
                            <td>delete</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>
                                    <a href="{{ route("admin.$table.show",$each) }}">
                                        {{$each->id}}
                                    </a>
                                </td>
                                <td>
                                    {{$each->name}}
                                </td>
                                <td>
                                    {{ $each->start_date }}
                                </td>
                                <td>
                                    {{ $each->end_date }}
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route("admin.courses.edit",$each) }}">
                                        edit
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route("admin.$table.destroy",$each) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav class="mt-4">
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            if(localStorage.getItem('data')){
                localStorage.removeItem('data');
            }
            $("#import_csv").change(function(event) {
                /* Act on the event */
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    url: '{{ route('admin.courses.import_csv')}}',
                    type: 'POST',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data have been imported',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'success'
                        })
                    },
                    error: function(response) {
                        /* Act on the event */
                    }
                })
            });
        })
    </script>
@endpush
