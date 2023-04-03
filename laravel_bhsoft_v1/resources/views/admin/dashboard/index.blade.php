@extends('layout.master')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12" id="dashboard-total">
                        </div> <!-- end col -->
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap mb-0" id="table-top-user">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Number Course</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ route("api.dashboard") }}',
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    let html = `
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <i class="mdi mdi-concourse-ci widget-icon bg-success-lighten text-success"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Total Course</h5>
                                            <h3 class="mt-3 mb-3" id="total-course">${response.data.courses[0].total}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-lg-12">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <i class="uil-chat-bubble-user widget-icon bg-danger-lighten text-danger"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Total User</h5>
                                            <h3 class="mt-3 mb-3" id="total-user">${response.data.users[0].total}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                                <div class="col-lg-12">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <i class="mdi mdi-currency-usd widget-icon bg-info-lighten text-info"></i>
                                            </div>
                                            <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">The course has been registered</h5>
                                            <h3 class="mt-3 mb-3" id="course-signuped">${response.data.courses_signup}</h3>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            `
                    $('#dashboard-total').html(html)
                    response.data.top_user.forEach(function (value, index) {
                        let id = '<a href="' + "{{ route('admin.users.show', ['user' => 'valueId']) }}" + '">' + `${value.id}` + '</a>';
                        id = id.replace('valueId', value.id);
                        $('#table-top-user').append($('<tr>')
                            .append($('<td>').append(id))
                            .append($('<td>').append(value.rank))
                            .append($('<td>').append(value.name))
                            .append($('<td>').append(value.number_courses))
                        )
                    })
                }
            })

        });
    </script>
@endpush
