@extends('layouts.teacher-app')
@section('content')
  @include('common.sidebar')
  <main class="main">
    <div class="container-fluid">
        <div class="row">

            <div class="marking-header pt-4 pb-1 main__content d-flex flex-wrap align-items-center w-100">
                <div class="pull-left">
                    <a href="javascript:void(0)" class="btn btn-light"  data-toggle="modal" data-target="#selectClass">
                      {{$selected_class}}
                    </a>
                </div>
                <h1>Marking</h1>
            </div>
            <!-- /. Marking header-->
            <?php
          //  pr($levels);
            ?>
            <div class="mt-3 main__content d-flex flex-wrap align-items-center w-100">
              <ul class="nav nav-pills" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                      <a class="nav-link filterWorkRecordCourse active show active-course" data-courseName="ges" id="pills-ges-tab" data-filter="1" data-toggle="pill" href="#pills-ges" role="tab" aria-controls="pills-ges" aria-selected="true">
                        GES
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link filterWorkRecordCourse" id="pills-aes-tab" data-courseName="aes" data-filter="2" data-toggle="pill" href="#pills-aes" role="tab" aria-controls="pills-aes" aria-selected="false">
                        AES
                      </a>
                  </li>
              </ul>
            </div>
            <div class="ilp-heading main__content d-flex flex-wrap align-items-center w-100">

                <ul class="list-inline mr-4 pb-2">
                  <li class="list-inline-item">
                    <a href="javascript:void(0)" class="btn btn-light selected_level"  data-toggle="modal" data-target="#selectLevel">
                        Select Level
                    </a>
                  </li>
                </ul>

                <ul class="list-inline marking-button pb-2">
                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-danger pending_records">Pending</a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-light extra_records">Extra</a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-light work_record_btn" data-toggle="modal" data-target="#selectStudent" >Work Record</a></li>  
                </ul>
                <!-- /. nav pills-->
                <div class="pull-right d-flex flex-wrap justify-content-end pb-2" style="margin-top: -18px;">
                    <div class="search-form" style="margin-right:50px">
                        <div class="form-group" style="width:270px; margin-right:40px" >
                            <input type="text" style="max-width:256px;padding-top:0;" class="form-control form-control-lg search_marking" placeholder="Search by student name">
                            <span class="icon-search">
                                <img src="{{asset('public/images/icon-search-pink.svg')}}" alt="Search" class="img-fluid">
                            </span>
                        </div>
                    </div>
                    <!-- /. Search Form-->
                    <a href="javascript:void(0)" class="btn btn-light filter-opner">
                        <img src="{{asset('public/images/icon-filter.svg')}}" alt="Filter" class="img-fluid">
                    </a>

                </div>
                <!-- /. Search Form-->
            </div>
            <!-- /. ILP Heading -->
            <?php
          //  pr($studentListArray);
            ?>
            <div class="main__content_full w-100">
                <table class="table" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Student ID</th>
                            <!-- <th scope="col">Course</th>
                            <th scope="col">Level</th> -->
                            <th scope="col">Student Name</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Task</th>
                            <th scope="col">Skill</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="marking_record_body">
                    <?php  //pr($studentListArray); ?>
                        @if(!empty($studentListArray))
                          @foreach($studentListArray as $course_key => $course_val)
                             <?php 
                                $student_list_array =  $studentListArray[$course_key];
                                usort($student_list_array, function($a, $b) {
                                    return (int) $b['updated_at'] - (int) $a['updated_at'];
                                }); 
                                
                              ?>
                              <?php //dd($student_list_array);?>
                            @foreach($student_list_array as $key => $value)

                            <?php
                            // pr($value);
                             if(isset($sessionAll['tasks'][$value['task_id']]['total_practise']) && isset($practise_calculate[$value['studentid']][$value['task_id']])){
                              if(count($practise_calculate[$value['studentid']][$value['task_id']]) == $sessionAll['tasks'][$value['task_id']]['total_practise']){
                                //  echo $value['task_id'].'=='.$sessionAll['tasks'][$value['task_id']]['total_practise'].'__'; 
                                //  echo count($practise_calculate[$value['studentid']][$value['task_id']]).'<br>';
                                // continue;/
                             
                              if(empty($topicTaskArrayList[$value['topic_id']])){

                                $topicTaskArrayList[$value['topic_id']] = array();
                              }
                               if(!in_array($value['task_id'], $topicTaskArrayList[$value['topic_id']])) {   
                                  array_push($topicTaskArrayList[$value['topic_id']], $value['task_id']);                             
                                // if($value['is_extra']=='1' && $value['is_marked_old']=='1'){
                                //   //echo '<pre>'; print_r($value); exit;
                                // }
                                  // dd(date_create('15 days ago'));
                                  // dd(date('Y-m-d',strtotime($value['updated_date'])));
                                  $afterFiftteenDays = true;
                                  if( date_format(date_create('15 days ago'), 'Y-m-d') < date('Y-m-d',strtotime($value['updated_date'])) ) {
                                    // dd("asdasd");
                                    $afterFiftteenDays = false;
                                  }
                                ?>
                              <tr class="{{strtolower($course_key)}} {{ ($value['is_extra']=='1' && $value['is_marked_old']=='1') && $value['is_marked_by'] != 'student_self_marking' && !$afterFiftteenDays ?'extra': ''}} {{($value['is_marked_old']=='0') && $value['is_marked_by'] != 'student_self_marking' ?'pending':''}}  {{ 'work_record' }} marking_records topic{{$value['topic_no']}} task{{$value['task_no']}} level{{$value['level_id']}} {{'student'.$value['studentid']}} {{$value['studentname']}} {{strtolower(str_replace(' ','_',$value['studentname']))}} {{strtolower(str_replace(' ','',$value['studentname']))}}">
                                  <th scope="row">{{$value['studentid']}}</th>  <!-- '==>'. $value['course_type'].'Is extra===>'. $value['is_extra']. '=Is Marked==>'.$value['is_marked']-->
                                  
                                  <td>{{ $value['studentname']}}</td>
                                  <td>Topic {{ $value['topic_no'] }}</td>
                                  <td> <?php echo ($value['task_title']=="Grammar Practice")? "GP": "Task ". $value['task_no']; ?></td>
                                  <td>{{ $value['task_title'] }}</td>
                                  <td>
                                      <a href="{{url('practice-detail/').'/'.$value['topic_id'].'/'.$value['task_id'].'/'.$value['studentid']}}" title="Edit" class="action-button">
                                          <img src="{{asset('public/images/icon-table-edit.svg')}}" alt="Edit" class="img-fluid">
                                      </a>
                                  </td>
                              </tr>
                              <?php
                               }
                              } 
                            } ?>
                            @endforeach
                            <?php //pr($topicTaskArrayList) ?>
                          @endforeach
                        @endif 
                        <tr class="no-work-record"style="display:none"><td colspan="6"><center>No record found</center></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </main>
  <!-- /. Main-->
  <aside class="filter-sidebar bg-light">
      <div class="heading d-flex flex-wrap justify-content-between">
          <a href="#!" class="filter-opner">
              <img src="{{asset('public/images/icon-close-filter.svg')}}" alt="" class="img-fluid">
          </a>
          <h5>Filter</h5>
      </div>
      <!-- /. Filter Heading-->
      <div class="filter-body scrollbar">
      <button type="submit" class="btn btn-danger mb-2">Clear All</button>
          <div class="filter-badges">

          </div>

          <div class="filter-accordion">
              <div class="accordion" id="accordionExample">
                @if(!empty($all_topics))
                  <div class="card">
                      <div class="card-header" id="headingOne">
                          <h2 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse"
                                  data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  Topic
                              </button>
                          </h2>
                      </div>

                      <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                          data-parent="#accordionExample">

                          <div class="card-body">
                            <input type="hidden" class="final_filter_string">
                            <div class="custom-control custom-radio  mb-3" >
                                <input type="radio" class="custom-control-input filterWorkRecordTopic" data-filter="0" id="topic0"
                                    name="radio-stacked-topic[]" required>
                                <label class="custom-control-label" for="topic0">All</label>
                            </div>
                            <?php $i=0;?>
                            @foreach($all_topics as $topic_key => $topic_val)
                            <?php $i++;?>
                              <div class="custom-control custom-radio  mb-3" >
                                  <input type="radio" class="custom-control-input filterWorkRecordTopic topic_{{$i}}" data-filter="{{$topic_val}}" id="topic_{{$topic_key}}"
                                      name="radio-stacked-topic[]" required>
                                  <label class="custom-control-label" for="topic_{{$topic_key}}">Topic {{$topic_val}}</label>
                              </div>
                            @endforeach

                          </div>
                      </div>
                  </div>
                @endif
                @if(!empty($all_tasks))
                  <div class="card">
                      <div class="card-header" id="headingTwo">
                          <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                  data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Task
                              </button>
                          </h2>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                          data-parent="#accordionExample">
                          <div class="card-body">
                            <input type="hidden" class="previous_selected_task">
                            <div class="custom-control custom-radio  mb-3" >
                                <input type="radio" class="custom-control-input filterWorkRecordTask" data-filter="0" id="task0"
                                    name="radio-stacked[]" required>
                                <label class="custom-control-label" for="task0">All</label>
                            </div>
                            <?php $k=0;?>
                            @foreach($all_tasks as $task_key => $task_val)
                            <?php $k++;?>
                              <div class="custom-control custom-radio mb-3" >
                                  <input type="radio" class="custom-control-input filterWorkRecordTask task_{{$k}}" data-filter="{{$task_val}}" id="task_{{$task_key}}"
                                      name="radio-stacked[]" required>
                                  <label class="custom-control-label" for="task_{{$task_key}}">Task {{$task_val}}</label>
                              </div>
                            @endforeach
                          </div>
                      </div>
                  </div>
                @endif
                @if(!empty($studentsArray))
                  <div class="card">
                      <div class="card-header" id="headingThree">
                          <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                  data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Student
                              </button>
                          </h2>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                          data-parent="#accordionExample">
                          <div class="card-body">
                            <input type="hidden" class="previous_selected_student">
                            <div class="custom-control custom-radio  mb-3" >
                                <input type="radio" class="custom-control-input filterWorkRecordStudent" data-filter="0" id="student0"
                                    name="student" required>
                                <label class="custom-control-label" for="student0">All</label>
                            </div>
                            @foreach($studentsArray as $s_key => $s_val)
                              <div class="custom-control custom-radio">
                                  <input type="radio" name="student" class="custom-control-input filterWorkRecordStudent" data-studentname="{{$s_val}}" data-filter="{{$s_key}}" id="student_{{$s_key}}"
                                      required>
                                  <label class="custom-control-label" for="student_{{$s_key}}">{{$s_val}}</label>
                              </div>
                            @endforeach
                          </div>
                      </div>
                  </div>
                @endif
              </div>
          </div>
      </div>
  </aside>
  <!-- Modal -->
  @if(!empty($classListArray))
    <div class="modal fade" id="selectClass" tabindex="-1" role="dialog" aria-labelledby="selectClassLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
          <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
              <div class="modal-header mb-4 flex-wrap">
                  <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100">
                      <h4 class="modal-title text-center" id="selectClassLabel">
                          Select Class
                      </h4>
                  </div>
                  <!-- /. Modal Header top-->
              </div>
              <div class="modal-body selection-body popup_list_option scrollbar d-scrollbar">
                  <ul class="list-unstyled text-center pt-3">
                    @foreach($classListArray as $key => $value)
                      <li class="list-item"><a href="{{url('/marking/').'/'.$value['id']}}"  >{{$value['class_name']}}</a></li>
                    @endforeach
                  </ul>
              </div>
          </div>
      </div>
    </div>
  @else
  <div class="modal fade" id="selectNoClass" tabindex="-1" role="dialog" aria-labelledby="selectClassLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
          <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
              <div class="modal-header mb-4 flex-wrap">
                  <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100">
                      <h4 class="modal-title text-center" id="selectClassLabel">
                         
                      </h4>
                  </div>
                  <!-- /. Modal Header top-->
              </div>
              <div class="modal-body selection-body scrollbar">
                   <center><h2>You have not been assigned to a class.</h2>
                   <h2> Please contact your academy administrator.</h2></center>
              </div>
          </div>
      </div>
    </div>
  @endif
  <div class="modal fade" id="selectLevel" tabindex="-1" role="dialog" aria-labelledby="selectLevelLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
            <div class="modal-header mb-4 flex-wrap">
                <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100">
                    <h4 class="modal-title text-center" id="selectClassLabel">
                        Select Level
                    </h4>
                </div>
                <!-- /. Modal Header top-->
            </div>
            <div class="modal-body selection-body scrollbar">
                @if(!empty($levels))
                  @foreach($levels as $key => $value)
                    <ul class="list-unstyled text-center mt-3 both_levels {{strtolower($key)}}_levels" style="{{($key=='AES')?'display:none':''}}">
                      @foreach($value as $k => $v)
                        <li class="list-item">
                          <a href="javascript:void(0)" class="btn btn-light active-level filterWorkRecordLevel {{ $v['title'] }} first_{{$k}}" data-levelTitle="{{$v['title']}}" data-filter="{{$v['id']}}">
                            {{ $v['title'] }}
                          </a>
                        </li>
                      @endforeach
                    </ul>
                  @endforeach
                @endif
            </div>
        </div>
    </div>
  </div>

  <!-- Modal -->
  @if(!empty($studentsArray))
    <div class="modal fade" id="selectStudent" tabindex="-1" role="dialog" aria-labelledby="selectStudentLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
          <div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
              <div class="modal-header mb-4 flex-wrap">
                  <div class="modal-header-top d-flex flex-wrap justify-content-center align-items-center w-100">
                      <h4 class="modal-title text-center" id="selectStudentLabel">
                          Select Student
                      </h4>

                  </div>
                  <!-- /. Modal Header top-->
              </div>
              <div class="modal-body selection-body popup_list_option scrollbar d-scrollbar">
                  <ul class="list-unstyled text-center pt-3">
                      @foreach($studentsArray as $s_key => $s_val)
                        <li class="list-item"><a href="javascript:void(0)" class="filterWorkRecordStudent popup" data-studentname="{{$s_val}}" data-filter="{{$s_key}}" id="student_{{$s_key}}">{{$s_val}}</a></li>
                      @endforeach
                  </ul>
              </div>
          </div>
      </div>
  </div>
  @endif
<style>
.btn-danger, .btn-danger:focus {
  color:#ffffff;
}
</style>
<script>
    var topicArray          = [];
    var taskArray           = [];
    var courseArray         = [];
    var WorkRecordArray     = [];
    var LevelArray          = [];
    var studentArray        = [];
    var CommonPenExWr       = [];
    var sarchArray          = [];
    var trclass             = [];
    var removeFlag          = false;
    var category_data = "";
    function getCookie(cname){
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
    function clickPendingRecords(){
        CommonPenExWr=[];
        removeFlag = false; 
        //$('.marking-button li').find('a:not(.work_record)').removeClass('btn-danger').addClass('btn-light');
        $('.marking-button li').find('a').removeClass('btn-danger').addClass('btn-light');
        $('.marking-button li').find('a.pending_records').addClass('btn-danger').addClass('active-pending');

        $('.extra_records').removeClass('active-extra');
        var task =  $('.active-task').attr('data-filter');
        var topic = $('.active-topic').attr('data-filter');
        var level = $('.active-level').attr('data-filter');
        var pending = 1;
        var extra = 0;
        $('.extra_records').removeClass("active-extra");
        var student = $('.active-student').attr('data-filter');
        var course =  $('.active-course').attr('data-filter');
        var search_keyword = $.trim($('.search_marking').val())
        CommonPenExWr.push('.pending');
        document.cookie = "common=pending;path=/";
        filterRecord(course, topic, task, level, pending, extra, student, search_keyword);
    }
    function initDataSet(){
        var data =  getCookie("oldfilter");
        
        LevelArray.push('.level'+$('.first_0').attr("data-filter"));
        $('.selected_level').html("ELEMENTARY");
        $('.selected_level').addClass("btn-danger");
        if(data==""){
            courseArray.push(".ges");
            CommonPenExWr.push('.pending');
            document.cookie = "common=pending;path=/";
            document.cookie = "course=ges;path=/";
            var course = "";
            var topic = "";
            var task = "";
            var level = "";
            var pending = "";
            var extra = "";
            var student = "";
            var search_keyword = "";
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, student, search_keyword);
        }else{
            
            var course  =  getCookie("course");
            var extra   =  getCookie("extra");
            var student =  getCookie("student");
            var level   =  getCookie("level");
            var task    =  getCookie("task");
            var topic   =  getCookie("topic");
            var common  =  getCookie("common");
            var search  =  getCookie("search");

            if(course!=""){
                $('.filterWorkRecordCourse').each(function(){
                    $(this).removeClass("active-course active show")
                });
                $('.filterWorkRecordCourse').each(function(){
                    if($(this).text().trim().toLowerCase() == course){
                        $(this).addClass("active-course active show")
                    }
                });
            }
            if(level!=""){
                $('.filterWorkRecordLevel').each(function(){
                    if($(this).attr("data-filter") == level){
                        $('.selected_level').text($(this).attr("data-leveltitle"))
                    }
                });
            }
            if(common!=""){
                if(common == "extra"){
                    $('.extra_records').addClass("btn-danger active-extra")
                    $('.pending_records').removeClass("btn-danger active-extra")
                }else if(common == "pending"){
                    $('.pending_records').addClass("btn-danger active-extra")
                    $('.extra_records').removeClass("btn-danger active-extra")
                }else if(common == "workrecord"){
                    $('.extra_records').removeClass("btn-danger active-extra")
                    $('.pending_records').removeClass("btn-danger active-extra")
                }
                $('.pending_records').addClass("btn-light")
            }
            if(topic!=""){
                if(topic == "all"){
                    $('#topic0').attr('checked', 'checked');
                    // $('.topic_'+topic).attr('checked', 'checked');
                    $('#topic0').addClass('active-topic');
                }else{
                    $('.topic_'+topic).prop("checked", true);
                    $('.topic_'+topic).attr('checked', 'checked');
                    $('.topic_'+topic).addClass('active-topic');
                }
            }
            if(task!=""){
                if(task=="all"){
                    $('#task0').prop("checked", true);
                    $('#task0').addClass('active-task');
                }else{

                    $('.task_'+task).prop("checked", true);
                    $('.task_'+task).attr('checked', 'checked');
                    $('.task_'+task).addClass('active-task');
                }
            }
            if(student!=""){
                if(student == "all"){
                    $('#student0').prop("checked", true);
                    $('#student0').addClass('active-student');
                }else{

                    $('#student_'+student).prop("checked", true);
                    $('#student_'+student).attr('checked', 'checked');
                    $('#student_'+student).addClass('active-student');
                }
            }
           /* if(search!=""){
                $('.search_marking').val(search);
            }*/

            $('.marking_record_body tr').hide();
            $('.marking_record_body '+data).fadeIn();
        }
    }
    function initOpen(){
      $('.filterWorkRecordLevel').removeClass('active-level');
        $('.Elementary').addClass('active-level');
        var task =  $('.active-task').attr('data-filter');
        var topic = $('.active-topic').attr('data-filter');
        var level = $('.Elementary').attr('data-filter');
        var levelTitle = $('.Elementary').attr('data-levelTitle');
        $('.selected_level').removeClass('btn-light').addClass('btn-danger');
        
        $('.selected_level').html(levelTitle);

        var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
        var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
        var work = ($('.work_record').hasClass('active-work'))?1:0; 

        var student = $('.active-student').attr('data-filter');
          var course =  $('.active-course').attr('data-filter');
          var search_keyword = $.trim($('.search_marking').val())
          removeFlag = false;
        filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
    }
    function filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword){
      // alert(topic);
        if(!removeFlag){
          // alert(topic)
          // alert(task)
          // alert(student)
            if(topic>0) {
              $('.topic-filter').remove();
              if( !trclass.includes('.topic'+topic)){
                var trclass_string = trclass.join();
                if(trclass_string.includes('topic')){
                  var index = trclass.indexOf('.topic'+topic);
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('topic');
                    });
                  }
                }
                trclass.push('.topic'+topic);
              }
              tr_class_string = trclass.join().replace(/,/g, "");
              filterdata();

              $('.filter-badges').append(`<div class="alert alert-dark alert-dismissible fade show topic-filter" role="alert">
                                              Topic `+topic+`
                                              <button type="button" class="close remove_filter" data-val="`+topic+`" data-section="topic" data-category="filterWorkRecordTopic">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>`);

            }
            if(topic==0){
              trclass = trclass.filter(function(s) {
                  return !s.includes('topic');
              });
              tr_class_string = trclass.join().replace(/,/g, "");
              $('.topic-filter').remove();
              filterdata();
            }

            if(task > 0 ){

                    $('.task-filter').remove();
                    // $('.marking_record_body tr').hide();

                    if( !trclass.includes('.task'+task)){

                          var trclass_string = trclass.join();
                          if(trclass_string.includes('task')){
                            var index = trclass.indexOf('.task'+task);
                            if (index > -1) {
                              trclass.splice(index, 1);
                            } else {
                              trclass = trclass.filter(function(s) {
                                  return !s.includes('task');
                              });
                            }
                          }
                          trclass.push('.task'+task);
                    }
                    tr_class_string = trclass.join().replace(/,/g, "");
                    filterdata();

                    $('.filter-badges').append(`<div class="alert alert-dark alert-dismissible fade show task-filter" role="alert">
                        Task `+task+`
                        <button type="button" class="close remove_filter" data-val="`+task+`" data-section="task" data-category="filterWorkRecordTask">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
            }
            if(task==0){
              trclass = trclass.filter(function(s) {
                  return !s.includes('task');
              });
              tr_class_string = trclass.join().replace(/,/g, "");
              $('.task-filter').remove();
              filterdata();
            }
            if( level ){
              if( !trclass.includes('.level'+level)){
              
                var trclass_string = trclass.join();
                if(trclass_string.includes('level')){
                  var index = trclass.indexOf('.level'+level);
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('level');
                    });
                  }
                }
                trclass.push('.level'+level);
              }
              tr_class_string = trclass.join().replace(/,/g, "")
                filterdata();
            }

            if(pending ){
              if( !trclass.includes('.pending')){

                var trclass_string = trclass.join();
           
                if(trclass_string.includes('pending')){
                  var index = trclass.indexOf('.pending');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('pending');
                    });
                  }
                }
                if(trclass_string.includes('extra')){
                  var index = trclass.indexOf('.extra');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('extra');
                    });
                  }
                }
                trclass.push('.pending');
              }


              tr_class_string = trclass.join().replace(/,/g, "");
              filterdata();
            }

            if(extra ){
              // $('.marking_record_body tr').hide();
              if( !trclass.includes('.extra')){
                var trclass_string = trclass.join();
                if(trclass_string.includes('extra')){
                //  trclass.pop();
                  var index = trclass.indexOf('.extra');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('extra');
                    });
                  }
                }
                if(trclass_string.includes('.pending')){
                  //trclass.pop();
                  var index = trclass.indexOf('.pending');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('pending');
                    });
                  }
                }
                trclass.push('.extra');
              }

              tr_class_string = trclass.join().replace(/,/g, "")
              filterdata();
             
            }
            if(work ){
              if( !trclass.includes('.work_record ')){
                var trclass_string = trclass.join();
                if(trclass_string.includes('work_record')){
                  var index = trclass.indexOf('.work_record');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('work_record');
                    });
                  }
                }
                if(trclass_string.includes('.pending')){
                  //trclass.pop();
                  var index = trclass.indexOf('.pending');
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('pending');
                    });
                  }
                }
                trclass.push('.work_record');
              }

              tr_class_string = trclass.join().replace(/,/g, "")
              filterdata();
            }
            if(student) {
              
              $('.student-filter').remove();

              if( !trclass.includes('.student'+student)){
                var trclass_string = trclass.join();
                if(trclass_string.includes('student')){
                  var index = trclass.indexOf('.student'+student);
                  if (index > -1) {
                    trclass.splice(index, 1);
                  } else {
                    trclass = trclass.filter(function(s) {
                        return !s.includes('student');
                    });
                  } 
                }
                trclass.push('.student'+student);
              }
              tr_class_string = trclass.join("")
              filterdata();
              var studentname = $('.filterWorkRecordStudent.active-student').attr('data-studentname');
              $('.filter-badges').append(`<div class="alert alert-dark alert-dismissible fade show student-filter" role="alert">
                                              Student: `+studentname+`
                                              <button type="button" class="close remove_filter" data-val="`+student+`" data-section="student" data-category="filterWorkRecordStudent">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>`);
            }
          
            if(student==0){
              trclass = trclass.filter(function(s) {
                  return !s.includes('student');
              });
              tr_class_string = trclass.join().replace(/,/g, "");
              $('.student-filter').remove();
              filterdata();
            }
            if(course>0){
                var trclass_string = trclass.join();
                if(course==1) {

                    //  trclass.pop();
                    var index = trclass.indexOf('.aes');
                    if (index > -1) {
                      trclass.splice(index, 1);
                    } else {
                      trclass = trclass.filter(function(s) {
                        return !s.includes('aes');
                      });
                    }
                    trclass = trclass.filter(function(s) {
                        return !s.includes('ges');
                      });
                    trclass.push('.ges');

                }
                if(course==2) {
                    var index = trclass.indexOf('.ges');
                    if (index > -1) {
                      trclass.splice(index, 1);
                    } else {
                      trclass = trclass.filter(function(s) {
                        return !s.includes('ges');
                      });
                    }
                    trclass = trclass.filter(function(s) {
                        return !s.includes('aes');
                      });
                    trclass.push('.aes');

                }
              tr_class_string = trclass.join().replace(/,/g, "")
              filterdata();
            }

            if(search_keyword!=""){
              var search_array = []; 
              search_array.push('.'+search_keyword);
              var concated_array = trclass.concat(search_array);
              $('.marking_record_body tr').hide();
              var trclass_string = concated_array.join();
              tr_class_string = concated_array.join().replace(/,/g, "");      filterdata();
              commonDataChange(tr_class_string,course, topic, task, level, pending, extra, work, student, search_keyword);
            }

        }else{
            filterdata();
        }
        $('.final_filter_string').val(tr_class_string);
    }
    function filterdata(){
        $('.marking_record_body tr').hide();
        var tr_class_string_temp = "";
        if (typeof courseArray !== 'undefined' && courseArray.length > 0) {
            tr_class_string_temp += courseArray[0];
        }
        if (typeof LevelArray !== 'undefined' && LevelArray.length > 0) {
            tr_class_string_temp += LevelArray[0];
        }
        if (typeof studentArray !== 'undefined' && studentArray.length > 0) {
            tr_class_string_temp += studentArray[0];
        }
        if (typeof topicArray !== 'undefined' && topicArray.length > 0) {
            tr_class_string_temp += topicArray[0];
        }
        if (typeof taskArray !== 'undefined' && taskArray.length > 0) {
            tr_class_string_temp += taskArray[0];
        }
        if (typeof CommonPenExWr !== 'undefined' && CommonPenExWr.length > 0) {
            tr_class_string_temp += CommonPenExWr[0];
        }
        if (typeof sarchArray !== 'undefined' && sarchArray.length > 0) {
            tr_class_string_temp += sarchArray[0];
        }
        document.cookie = "oldfilter="+tr_class_string_temp+"; path=/";
        console.log(('.marking_record_body '+tr_class_string_temp));
        $('.marking_record_body '+tr_class_string_temp).fadeIn();
    }
    function commonDataChange(tr_class_string,course, topic, task, level, pending, extra, work, student, search_keyword) {
        $('.marking_record_body '+tr_class_string).fadeIn();
    }
    $(document).ready(function(){
        var forFlag = '<?php echo json_encode($studentListArray); ?>';
        var class_count = "{{!empty($classListArray)?1:0}}"
        if(getCookie('popupAllow') == "yes") {
            if(forFlag == "[]"){
                document.cookie = "popupAllow=no;path=/";
                 $('#selectClass').modal('show');
            }
        }

        if(class_count==0){
            $('#selectNoClass').modal('show'); 
        }

        $('.filter-opner').click(function () {
            $(".filter-sidebar, .main").toggleClass("open");
        });
        initDataSet();
        $('.pending_records').on('click', function() {
            clickPendingRecords()
        });

        $(".search_marking").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tbody tr ").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $('.thead-dark').css("display","contents")
        });


       /* $('.search_marking').on('keydown', function(event){
             var regex = new RegExp("^[0-9a-zA-Z]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            // console.log(key)
             if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });*/
        /*$('.search_marking').on('keyup', function(){
            sarchArray = [];
           

            var search_keyword =$.trim($('.search_marking').val()) ;
            var topic = $(this).attr('data-filter');
            var task = $('.active-task').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
           
            search_keyword = search_keyword.toLowerCase();
            search_keyword = search_keyword.replace(" ", "_"); 
            sarchArray.push('.'+search_keyword);
            // document.cookie = "search="+search_keyword+"; path=/";
            if(search_keyword == ""){
                sarchArray = [];
            }
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, student, search_keyword);
        });*/
        $('.extra_records').on('click', function() {
            CommonPenExWr = [];
            $('.marking-button li').find('a').removeClass('btn-danger').addClass('btn-light');
            $(this).addClass('btn-danger');
            $(this).addClass('active-extra');
            $('.pending_records').removeClass('active-peding');
            var task =  $('.active-task').attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var pending = 0;
            var extra = 1;
            $('.pending_records').removeClass("active-pending");
            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())
            CommonPenExWr.push('.extra');
            document.cookie = "common=extra; path=/";
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, student, search_keyword)
        });
        $('.work_record_btn').on('click', function() {

            CommonPenExWr = [];
            $('.marking-button li').find('a').removeClass('btn-danger').addClass('btn-light');
            $('.pending_records').removeClass('active-peding');
            var task =  $('.active-task').attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var pending = 0;
            var extra = 0;
            var work = 1;
            $('.pending_records').removeClass("active-pending");
            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())
            CommonPenExWr.push('.work_record');
            document.cookie = "common=workrecord; path=/";
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
        });
        $('.filterWorkRecordTopic').on('click', function(e) {
            topicArray = [];

            $('.filterWorkRecordTopic').removeClass('active-topic');
            $(this).addClass('active-topic');
            var topic = $(this).attr('data-filter');
            var task = $('.active-task').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var work = ($('.work_record').hasClass('active-work'))?1:0; 
            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())
            topicArray.push('.topic'+topic);
            document.cookie = "topic="+topic+"; path=/";
            if(topic ==0){
                topicArray = [];
                document.cookie = "topic=all; path=/";
            }
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword);
        });
        $('.filterWorkRecordTask').on('click', function(e) {
            taskArray = [];
            $('.filterWorkRecordTask').removeClass('active-task');
            $(this).addClass('active-task');
            var task = $(this).attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var work = ($('.work_record').hasClass('active-work'))?1:0; 
            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())
            taskArray.push('.task'+task);
            document.cookie = "task="+task+"; path=/";
            if(task ==0){
                taskArray = [];
                document.cookie = "task=all; path=/";
            }
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword);
        });
        $('.filterWorkRecordLevel').on('click', function(e) {
            LevelArray = [];
            $('.filterWorkRecordLevel').removeClass('active-level');
            $(this).addClass('active-level');
            var task =  $('.active-task').attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $(this).attr('data-filter');
            var levelTitle = $(this).attr('data-levelTitle');
            $('.selected_level').removeClass('btn-light').addClass('btn-danger');
            $('#selectLevel').modal('toggle');
            $('.selected_level').html(levelTitle);

            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var work = ($('.work_record').hasClass('active-work'))?1:0; 

            var student = $('.active-student').attr('data-filter');
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())
            LevelArray.push('.level'+level);
            document.cookie = "level="+level+"; path=/";
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
        });
        $('.filterWorkRecordStudent').on('click', function(e) {
            studentArray = [];
            if($(this).hasClass('popup')){
                $('#selectStudent').modal('toggle')
            }
            var student_name = $(this).attr('data-studentname');
            $('.filterWorkRecordStudent').removeClass('active-student');
            $(this).addClass('active-student');
            var task =  $('.active-task').attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var student = $(this).attr('data-filter');
            var studentTitle = $(this).attr('data-studentTitle');
            $('.selected_student').removeClass('btn-light').addClass('btn-danger');
            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var work = ($('.work_record').hasClass('active-work'))?1:0; 
            var course =  $('.active-course').attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val())

            studentArray.push('.student'+student);
            document.cookie = "student="+student+"; path=/";

            if(student == 0){
                studentArray = [];   
                document.cookie = "student=all; path=/";
            }
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
        });
        $('.filterWorkRecordCourse').on('click', function(e) {
           
            courseArray = [];
            var courseName = $(this).attr('data-courseName');
            $('.both_levels').hide();
            $('.'+courseName+'_levels').show();
            $('.filterWorkRecordCourse').removeClass('active-course');
            $(this).addClass('active-course');
            var task =  $('.active-task').attr('data-filter');
            var topic = $('.active-topic').attr('data-filter');
            var level = $('.active-level').attr('data-filter');
            var student = $('.active-student').attr('data-filter');
            var pending = ($('.pending_records').hasClass('active-pending'))?1:0;
            var extra = ($('.extra_records').hasClass('active-extra'))?1:0;
            var work = ($('.work_record').hasClass('active-work'))?1:0; 
            var course = $(this).attr('data-filter');
            var search_keyword = $.trim($('.search_marking').val());
            var filter = course==1?"ges":"aes";
            courseArray.push("."+filter);
            document.cookie = "course="+filter+"; path=/";
            var selected_level = $('.selected_level').text();
            LevelArray = [];
            LevelArray.push('.level'+$("."+filter+'_levels').find("."+selected_level).attr("data-filter"));
            removeFlag = false;
            filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
        });
    });
    $(document).on('click','.remove_filter', function() {
        var category = $(this).attr('data-category');
        var section = $(this).attr('data-section');
        removeFlag = true;
        
        category_data = $(this).attr('data-category');
        if(category_data == "filterWorkRecordStudent" ){
            studentArray = [];
            $('.filterWorkRecordTopic').each(function(){
                $(this).removeClass('active-topic')
            });
        }else if(category_data == "filterWorkRecordTask" ){
            taskArray  = [];
            $('.filterWorkRecordTask').each(function(){
                $(this).removeClass('active-task')
            });
        }else if(category_data == "filterWorkRecordTopic" ){
            topicArray  = [];
            $('.filterWorkRecordStudent').each(function(){
                $(this).removeClass('active-student')
            });
        }
     

        $('.'+category_data).prop('checked', false);
        
        var trclass_string = trclass.join();
        $(this).parent().remove();
        var val = $(this).attr('data-val');

        var index = trclass.indexOf('.'+section+val);
            
        if (index > -1) {
          trclass.splice(index, 1);
        } else {
          trclass = trclass.filter(function(s) {
            return !s.includes(section+val);
          });
        }
        
        tr_class_string = trclass.join().replace(/,/g, "")
        if(trclass.length>0){
          $('.marking_record_body').find(tr_class_string).show();
          // $('.no-work-record').hide();
        }else{
          // $('.no-work-record').show();
        }
       $('.marking_records').fadeIn();


        var task =  "";
        var topic = "";
        var level = $('.Elementary').attr('data-filter');
        var levelTitle = $('.Elementary').attr('data-levelTitle');
        $('.selected_level').removeClass('btn-light').addClass('btn-danger');
        
        $('.selected_level').html(levelTitle);

        var pending = ($('.pending_records').hasClass('active-pending'))?1:"";
        var extra = ($('.extra_records').hasClass('active-extra'))?1:"";
        var work = ($('.work_record').hasClass('active-work'))?1:""; 

        var student = "";
        var course =  $('.active-course').attr('data-filter');
        var search_keyword = $.trim($('.search_marking').val())
        filterRecord(course, topic, task, level, pending, extra, work, student, search_keyword)
    })
</script>
@endsection
