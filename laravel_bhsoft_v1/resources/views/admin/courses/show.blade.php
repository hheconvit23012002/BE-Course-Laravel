@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body" id="info-course">
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="aboutme">

                            <div class="timeline-alt pb-0">
                                <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>
                                    Student</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-nowrap mb-0" id="table-user">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
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
        <!-- end row-->
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            function getData() {
                const path = window.location.pathname;
                const parts = path.split('/');
                const course = parts[parts.length - 1];
                $.ajax({
                    url: '{{ route("api.courses.get_course") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        course: course
                    },
                    success: function (response) {
                        let course = response.data.course
                        let users = response.data.users
                        let profileHtml = `
                            <h4 class="mb-0 mt-2">${course.name}</h4>
                            <p class="text-muted font-14">Founder</p>
                            <div class="text-left mt-3">
                                <h4 class="font-13 text-uppercase">About Course :</h4>
                                <p class="text-muted font-13 mb-3">
                                        ${course.description}
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Course Name :</strong>
                                    <span class="ml-2">${course.name}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>Start date :</strong>
                                    <span class="ml-2">${course.start_date}</span></p>
                                <p class="text-muted mb-2 font-13"><strong>End date :</strong> <span
                                        class="ml-2 ">${course.end_date}</span></p>
                            </div>
                        `
                        $('#info-course').html(profileHtml)
                        users.forEach(function (value, index) {
                            value = value.users
                            $('#table-user').append($('<tr>')
                                .append($('<td>').append(value.id))
                                .append($('<td>').append(value.name))
                                .append($('<td>').append(value.email))
                                .append($('<td>').append(value.phone_number))
                            )
                        })
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
            getData()
        })
    </script>
@endpush
