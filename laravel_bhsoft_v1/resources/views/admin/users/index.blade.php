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
                            <option value="email">Email</option>
                            <option value="birthdate">Birthdate</option>
                            <option value="phone_number">PhoneNumber</option>
                            <option value="number_courses">NumberCourse</option>
                            /
                        </select>
                        <button class="btn btn-success" type="submit">Search</button>
                    </form>
                    <table class="table table-striped table-centered mb-0" id="table-data">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            Create
                        </a>
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>logo</td>
                            <td>info</td>
                            <td>birthdate</td>
                            <td>sum course</td>
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
        function destroy(e){
            let id = e.data("id")
            $.ajax({
                type:'Delete',
                url:'{{ route('api.users.destroy')}}',
                data:{
                    id: id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (response) {
                    let parent_tr = e.parents('tr');
                    parent_tr.remove();
                    $.toast({
                        heading: 'Success',
                        text: 'Delete success',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        icon: 'success'
                    })
                },
                error: function (response) {
                    $.toast({
                        heading: 'Server Error',
                        text: 'error',
                        showHideTransition: 'slide',
                        position: 'top-right',
                        icon: 'error'
                    })
                }
            })
        }
        $(document).ready(function () {
            function getData() {
                const urlParams = new URLSearchParams(window.location.search);
                $('#ip-search').val(urlParams.get('q') || '')
                $("#ip-field").val(urlParams.get('field') || 'name').change();
                $.ajax({
                    url: '{{ route('api.users.index')}}',
                    dataType: 'json',
                    data: {
                        page: {{ request()->get('page') ?? 1 }},
                        q: urlParams.has('q') ? urlParams.get('q') : '',
                        field: urlParams.has('field') ? urlParams.get('field') : 'name',
                    },
                    success: function (response) {
                        response.data.data.forEach(function (value, index) {
                            let id = '<a href="' + "{{ route('admin.users.show', ['user' => 'valueId']) }}" + '">' + `${value.id}` + '</a>';
                            id = id.replace('valueId', value.id);
                            let logo = `<img src="{{ public_path()."/" }}${value.logo}" height="100">`
                            let info = `${value.name}
                                    <br>
                                    <a href="mailto:${value.email}">${value.email}</a>
                                    <br>
                                    <a href="tel:${value.phone_number}">${value.phone_number}</a>`
                            let edit = '<a class="btn btn-success" href="' + "{{ route('admin.users.edit', ['user' => 'valueId']) }}" + '">edit</a>';
                            edit = edit.replace('valueId', value.id);
                            let destroy =
                                `<button class="btn btn-danger" onclick="destroy($(this))" data-id=${value.id}>
                                    Delete
                                </button>`
                            $('#table-data').append($('<tr>')
                                .append($('<td>').append(id))
                                .append($('<td>').append(logo))
                                .append($('<td>').append(info))
                                .append($('<td>').append(value.birthdate))
                                .append($('<td>').append(value.number_courses))
                                .append($('<td>').append(edit))
                                .append($('<td>').append(destroy))
                            )
                        })
                        renderPagination(response.data.pagination)
                    },
                    error: function (response) {
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
            }
            getData();
            $(document).on('click', '#paginate > li > a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                let urlParams = new URLSearchParams(window.location.search)
                urlParams.set('page', page)
                window.location.search = urlParams
            })
            $(document).on('submit', '#form-search', function (e) {
                e.preventDefault();
                let q = $('#ip-search').val();
                let field = $('#ip-field').val();
                let urlParams = new URLSearchParams(window.location.search)
                urlParams.set('q', q)
                urlParams.set('field', field)
                window.location.search = urlParams
            });
            if (localStorage.getItem('success')) {
                $.toast({
                    heading: 'Create success',
                    text: localStorage.getItem('success'),
                    showHideTransition: 'slide',
                    position: 'top-right',
                    icon: 'success'
                })
                localStorage.removeItem('success');
            }
        })
    </script>
@endpush
