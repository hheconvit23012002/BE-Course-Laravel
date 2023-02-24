@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-centered mb-0">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            Create
                        </a>
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>logo</td>
                                <td>info</td>
                                <td>birthdate</td>
                                <td>edit</td>
                                <td>delete</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $each)
                            <tr>
                                <td>
                                    <a href="{{ route("admin.users.show",$each) }}">
                                        {{$each->id}}
                                    </a>
                                </td>
                                <td>
                                    <img src="{{ public_path()."/".$each->logo }}" height="100">
                                </td>
                                <td>
                                    {{$each->name}}
                                    <br>
                                    <a href="mailto:{{ $each->email }}">{{ $each->email }}</a>
                                    <br>
                                    <a href="tel:{{ $each->phone_number }}">{{ $each->phone_number }}</a>
                                </td>
                                <td>
                                    {{ $each->birthdate }}
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{ route("admin.users.edit",$each) }}">
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
        })
    </script>
@endpush
