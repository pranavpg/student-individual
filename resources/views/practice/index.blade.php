@extends('layouts.app')
@section('content')

<main class="course-book">
    <div class="container-fluid">
        <div class="row flex-wrap">
            <div class="col-6 course-book-navigation d-flex flex-wrap">
                <div class="row w-100">
                    <div class="say-hello col-12 col-md-3 col-lg-5 col-xl-6">
                        <a href="">back</a>

                        <h1>{{$response['title']}}</h1>
                        <picture class="picture d-flex">
                            <img src="{{$response['image']}}" alt="Hello" class="rounded" width="326px" height="400px">
                        </picture>
                    </div>
                    <div class="book-navigation col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="close-course">
                            <a href="#!" class="close-course-icon"><img src="{{asset('public/images/icon-close-course.svg')}}" alt="X"
                                    class="img-fluid"></a>
                        </div>
                        <a href="javascript:;" class="navigation active">
                            AIM
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        @if(!empty($response['tasks']))
                          @foreach($response['tasks'] as $key => $value)
                            <a href="javascript:;" class="navigation open_task" data-course_id="{{$course_id}}" data-level_id="{{$level_id}}" data-topic_id="{{$topic_id}}" data-task_id="{{$value['id']}}">
                                <small>T{{$key+1}}</small>
                                <strong>{{$value['name']}}</strong>
                                <span>
                                    <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                                </span>
                            </a>
                          @endforeach
                        @endif
                        <!-- <a href="" class="navigation active">
                            <small>T1</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        <a href="" class="navigation">
                            <small>T2</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        <a href="" class="navigation">
                            <small>T3</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        <a href="" class="navigation">
                            <small>T4</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        <a href="" class="navigation">
                            <small>T5</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a>
                        <a href="" class="navigation">
                            <small>T6</small>
                            <strong>Speaking</strong>
                            <span>
                                <img src="{{asset('public/images/icon-right-circle.svg')}}" alt="" class="img-fluid">
                            </span>
                        </a> -->
                    </div>
                </div>
            </div>

            <div class="speaking-course flex-wrap col-6">
                <div class="course-content bg-white scrollbar">
                    <div class="course-description">
                        <h1>Course Book</h1>
                        <iframe srcdoc="{{$response['aim']}}" scrolling="no" height="500" width="500" frameborder="0"></iframe>
                        <div class="text-right course-next">
                            <a href="#!" class="btn btn-dark rounded-circle" id="fullscreen">
                                <img src="{{ asset('public/images/icon-course-nextpage.svg')}}" alt="Next" class="img-fluid">
                            </a>
                        </div>
                    </div> <!-- /. course-description-->


                    <div class="course-tab">
                        <div class="course-tab-fixed-heading d-flex flex-wrap align-items-center">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill"
                                        href="#pills-home" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Course Book</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                                        href="#pills-profile" role="tab" aria-controls="pills-profile"
                                        aria-selected="false">Teacher Book</a>
                                </li>
                            </ul>
                            <div class="pull-right">
                                <a href="#!">
                                    <img src="{{ asset('public/images/icon-fullscreen.svg')}}" alt="Fullscreen" class="img-fluid">
                                </a>
                            </div>
                        </div>

                        <div class="course-tab-content">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active course_book_data" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" >
                                    <iframe name="abc_frame" id="task_desc_frame" class="iframe" frameborder="0" scrolling="yes"></iframe>

                                </div>
                                <!-- tab 1-->
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">...</div>
                            </div>
                            <!-- /. tab content-->
                        </div>
                    </div>
                </div>

                <div class="practice-content bg-white scrollbar course-content ieukpb-cucmob">
                    <div class="practice-tab">
                        <div
                            class="practice-content-heading d-flex flex-wrap justify-content-between align-items-center">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active ieukpb-btnmain" href="#!">Practice Book</a>
                                </li>
                            </ul>

                            <div class="abc-tab m-auto">
                                <ul class="nav nav-pills text-uppercase align-items-center ieukpb-abcul" id="abc-tab"
                                    role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="abc-a-tab" data-toggle="pill" href="#abc-a"
                                            role="tab" aria-controls="abc-a" aria-selected="true">A</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="abc-b-tab" data-toggle="pill" href="#abc-b"
                                            role="tab" aria-controls="abc-b" aria-selected="false">B</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="abc-c-tab" data-toggle="pill" href="#abc-c"
                                            role="tab" aria-controls="abc-c" aria-selected="false">c</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="abc-d-tab" data-toggle="pill" href="#abc-d"
                                            role="tab" aria-controls="abc-d" aria-selected="false">d</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="abc-e-tab" data-toggle="pill" href="#abc-e"
                                            role="tab" aria-controls="abc-e" aria-selected="false">e</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="abc-f-tab" data-toggle="pill" href="#abc-f"
                                            role="tab" aria-controls="abc-f" aria-selected="false">f</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /. abc tab-->
                            <div class="heading-right">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="#!">
                                            <img src="{{asset('public/images/icon-tab-edit.svg') }}" alt="edit" class="img-fluid">
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#!">
                                            <img src="{{ asset('public/images/icon-fullscreen.svg') }}" alt="Fullscreen"
                                                class="img-fluid">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /. practice heading-->
                        <div class="course-tab-content">
                            <div class="tab-content" id="abc-tabContent">
                                <div class="tab-pane fade show active" id="abc-a" role="tabpanel"
                                    aria-labelledby="abc-a-tab">
                                    <p>Lorem ipsum dolor et, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et</p>
                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                    <p>Lorem ipsum dolor et, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et</p>
                                </div>
                                <!-- tab 1-->

                                <div class="tab-pane fade" id="abc-b" role="tabpanel" aria-labelledby="abc-b-tab">
                                    <p>Lorem ipsum dolor et, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et</p>
                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <!-- tab 1-->
                                <div class="tab-pane fade" id="abc-c" role="tabpanel" aria-labelledby="abc-c-tab">

                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <!-- tab 1-->

                                <div class="tab-pane fade" id="abc-d" role="tabpanel" aria-labelledby="abc-d-tab">

                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <!-- tab 1-->

                                <div class="tab-pane fade" id="abc-e" role="tabpanel" aria-labelledby="abc-e-tab">
                                    <p>Lorem ipsum dolor et, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et</p>
                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <!-- tab 1-->

                                <div class="tab-pane fade" id="abc-f" role="tabpanel" aria-labelledby="abc-f-tab">

                                    <div class="picture">
                                        <img src="{{asset('public/images/dummy-block.svg')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <!-- tab 1-->

                            </div>
                            <!-- /. tab content-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
var get_task_details_url = "{{url('get-task-detail')}}";
var get_task_description_url = "{{url('get-task-description')}}";
</script>
<script src="{{asset('public/js/pages/practice.js')}}"></script>
@endsection
