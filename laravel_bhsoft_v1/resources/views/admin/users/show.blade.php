@extends('layout.master')
@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ $user->logo }}" class="rounded-circle avatar-lg img-thumbnail"
                     alt="profile-image">

                <h4 class="mb-0 mt-2">{{ $user->name }}</h4>
                <p class="text-muted font-14">Founder</p>

                <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>
                <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>

                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">About Me :</h4>
                    <p class="text-muted font-13 mb-3">
                        Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the
                        1500s, when an unknown printer took a galley of type.
                    </p>
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong>
                        <span class="ml-2">{{ $user->name }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Mobile :</strong>
                        <span class="ml-2">{{ $user->phone_number }}</span></p>

                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                            class="ml-2 ">{{ $user->email }}</span></p>

                    <p class="text-muted mb-1 font-13"><strong>Birthdate</strong> <span class="ml-2">
                            {{ $user->birthdate }}
                        </span></p>
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
                                Course</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courses as $each)
                                    <tr>
                                        <td>{{$each->courses->id}}</td>
                                        <td>{{$each->courses->name}}</td>
                                        <td>{{$each->courses->start_date}}</td>
                                        <td>{{$each->courses->end_date}}</td>
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
