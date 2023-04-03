@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body" id="profile">
                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="aboutme">

                            <div class="timeline-alt pb-0">
                                <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Course</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap mb-0" id="table-course">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div> <!-- end tab-content -->
                    </div> <!-- end card body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div> <!-- end col-->
    <!-- end row-->
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            function getData() {
                const path = window.location.pathname;
                const parts = path.split('/');
                const user = parts[parts.length - 1];
                $.ajax({
                    url: `http://laravel_bhsoft_v1.test/api/users/${user}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        let user = response.data.user
                        let course = response.data.course
                        let profileHtml = `
                            <img src="{{asset(${user.logo})}}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                            <h4 class="mb-0 mt-2">
                                ${user.name}
                            </h4>
                            <div class="text-left mt-3">

                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong>
                                <span class="ml-2">
                                    ${user.name}
                                </span>
                            </p>

                            <p class="text-muted mb-2 font-13"><strong>Mobile :</strong>
                                <span class="ml-2">
                                    ${user.phone_number}
                                </span>
                            </p>

                            <p class="text-muted mb-2 font-13"><strong>Email :</strong>
                                <span class="ml-2 ">
                                    ${user.email}
                                </span>
                            </p>

                            <p class="text-muted mb-1 font-13"><strong>Birthdate</strong> <span class="ml-2">
                                    ${user.birthdate}
                                </span>
                            </p>
                        `
                        $('#profile').html(profileHtml)
                        course.forEach(function (value, index) {
                            value = value.courses
                            $('#table-course').append($('<tr>')
                                .append($('<td>').append(value.id))
                                .append($('<td>').append(value.name))
                                .append($('<td>').append(value.start_date))
                                .append($('<td>').append(value.end_date))
                            )
                        })
                    },
                    error: function (response) {
                        $.toast({
                            heading: 'Import Error',
                            text: response.responseJSON.message,
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'error'
                        })
                    },
                })
            }

            getData()
        })
    </script>
@endpush
