@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline mb-4" id="form-search" method="GET">
                        <input type="text" class="form-control mr-4" id="ip-search" name="q" placeholder="Search...">
                        <select class="form-control mr-4" id="ip-field" name="field">
                            <option value="name">Name</option>
                            <option value="description">Description</option>
                        </select>
                        <button class="btn btn-success" type="submit">Search</button>
                    </form>
                    <table class="table table-striped table-centered mb-0" id="table-data">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                            Create
                        </a>
                        <form action="#">
                            @csrf
                            <label class="btn btn-info ml-2 mb-0" for="csv">Import CSV</label>
                            <input type="file" name="csv" id="csv" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
                        </tbody>
                    </table>
                    <nav class="mt-4">
                        <ul class="pagination pagination-rounded mb-0" id="paginate">
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
            let urlParams = new URLSearchParams(window.location.search)
            $('#ip-search').val(urlParams.get('q') || '')
            $("#ip-field").val(urlParams.get('field') || 'name').change();
            $.ajax({
                url: '{{ route('api.courses.all_courses')}}',
                dataType: 'json',
                data: {
                    page: {{ request()->get('page') ?? 1 }},
                    q: urlParams.has('q') ? urlParams.get('q') : '',
                    field: urlParams.has('field') ? urlParams.get('field') : 'name',
                },
                success :function(response){
                    response.data.data.forEach(function(value,index){
                        let id = '<a href="' + "{{ route('admin.courses.show', ['course' => 'valueId']) }}" + '">'+`${value.id}`+'</a>';
                        id = id.replace('valueId', value.id);
                        let name = `${value.name}`
                        let edit = '<a class="btn btn-success" href="' + "{{ route('admin.courses.edit', ['course' => 'valueId']) }}" + '">edit</a>';
                        edit = edit.replace('valueId', value.id);
                        let destroy ='<form action="' + "{{ route("admin.$table.destroy",['course' => 'valueId']) }}" + '" method="POST">'
                            + '@csrf'
                            + '@method('DELETE')'
                            + '<button class="btn btn-danger">delete</button>'
                            + '</form>'
                        destroy = destroy.replace('valueId', value.id);

                        $('#table-data').append($('<tr>')
                            .append($('<td>').append(id))
                            .append($('<td>').append(name))
                            .append($('<td>').append(value.start_date))
                            .append($('<td>').append(value.end_date))
                            .append($('<td>').append(edit))
                            .append($('<td>').append(destroy))
                        )
                    })
                    renderPagination(response.data.pagination)
                },
                error: function(response) {
                    /* Act on the event */
                    $.toast({
                        heading: 'Import Error',
                        text: 'loi',
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'error'
                    })
                },
            })
            if(localStorage.getItem('data')){
                localStorage.removeItem('data');
            }
            $("#csv").change(function(event) {
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
                        $.toast({
                            heading: 'Import Error',
                            text: 'Your data have not  been imported',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'error'
                        })
                        /* Act on the event */
                    }
                })
            });
            $(document).on('click','#paginate > li > a',function (e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                urlParams.set('page',page)
                window.location.search = urlParams
            })
            $(document).on('submit', '#form-search', function (e) {
                e.preventDefault();
                let q = $('#ip-search').val();
                let field = $('#ip-field').val();
                urlParams.set('q',q)
                urlParams.set('field',field)
                window.location.search = urlParams
            });
        })
    </script>
@endpush
