@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">

                    <h4 class="mb-0 mt-2">{{ $course->name }}</h4>
                    <p class="text-muted font-14">Founder</p>

                    <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">About Course :</h4>
                        <p class="text-muted font-13 mb-3">
                                {{ $course->description }}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Course Name :</strong>
                            <span class="ml-2">{{ $course->name }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Start date :</strong>
                            <span class="ml-2">{{ $course->start_date }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>End date :</strong> <span
                                class="ml-2 ">{{ $course->end_date }}</span></p>
                    </div>

                    <ul class="social-list list-inline mt-3 mb-0">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                    class="mdi mdi-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                    class="mdi mdi-google"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                    class="mdi mdi-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                    class="mdi mdi-github-circle"></i></a>
                        </li>
                    </ul>
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
                                    <table class="table table-borderless table-nowrap mb-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $each)
                                            <tr>
                                                <td>{{$each->users->id}}</td>
                                                <td>{{$each->users->name}}</td>
                                                <td>{{$each->users->email}}</td>
                                                <td>{{$each->users->phone_number}}</td>
                                            </tr>
                                        @endforeach

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
