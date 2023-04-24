@section('style')
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <style type="text/css">
    	
	    tfoot{
	    	display: table-row-group;
	    }
    </style>
@endsection
@extends('layouts.teacher-app')
@section('content')
@include('common.sidebar')
  <?php

  // dd($studentListArray);

  $courseWiseArray = [];
  foreach ($sessionAll['courses'] as $ckey => $course) {
    foreach ($sessionAll['levels'] as $lkey => $level) {
		if($level['course_id'] == $ckey){
			$courseWiseArray[$level['course_id']][] = $level;
		}
    }
  }

  ?>
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

                <ul class="list-inline marking-button pb-2" style="width: 90%;">
                    <li class="list-inline-item"><a href="javascript:void(0)" class="findOne btn btn-light btn-danger pending_records">Pending</a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="findOne btn btn-light extra_records">Extra</a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)" class="findOne btn btn-light work_record_btn" >Work Record</a></li>
                    <li class="list-inline-item">
                        <select class="form-control" id="student">
                            <option value="">Select Student</option>
                            @foreach($studentsArray as $s_key => $s_val)
                                <option value="{{$s_key}}" data="student_{{$s_key}}">{{$s_val}}</option>
                            @endforeach
                        </select>
                    </li>
<!--                     <li class="list-inline-item" style="float: right;">
                        <input type="text" placeholder="Search by student name" class="form-control" id="serachdata" style="width: 194px;">
                    </li> -->
                </ul>
                <!-- /. nav pills-->
               
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
                            <th scope="col">Student Name</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Task</th>
                            <th scope="col">Skill</th>
                            <th scope="col" style="display:none;">Level</th>
                            <th scope="col" style="display:none;">Course</th>
                            <th scope="col" style="display:none;">extra</th>
                            <th scope="col" style="display:none;">pending</th>
                            <th scope="col" style="display:none;">work-record</th>
                            <th scope="col" class="hideto">Action</th>
                            <th scope="col" style="display:none;">date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($studentListArray))
                            @foreach($studentListArray as $course_key => $course_val)
                                 <?php $student_list_array =  $studentListArray[$course_key]; ?>
                                @foreach($student_list_array as $key => $value)
                                    <?php
                                    if(isset($sessionAll['tasks'][$value['task_id']]['total_practise']) && isset($practise_calculate[$value['studentid']][$value['task_id']])){
                                        if(count($practise_calculate[$value['studentid']][$value['task_id']]) == $sessionAll['tasks'][$value['task_id']]['total_practise']){
                                            if(empty($topicTaskArrayList[$value['topic_id']])){
                                                $topicTaskArrayList[$value['topic_id']] = array();
                                            }
                                            if(!in_array($value['task_id'], $topicTaskArrayList[$value['topic_id']])) {  
                                                array_push($topicTaskArrayList[$value['topic_id']], $value['task_id']);
                                                $afterFiftteenDays = true;
                                                if( date_format(date_create('15 days ago'), 'Y-m-d') < date('Y-m-d',strtotime($value['updated_date'])) ) {
                                                    $afterFiftteenDays = false;
                                                }
                                                ?>
                                                <tr>
                                                    <td scope="row">{{$value['studentid']}}</td>
                                                    <td>{{ $value['studentname']}}</td>
                                                    <td>Topic {{ $value['topic_no'] }}</td>
                                                    <td> <?php echo ($value['task_title']=="Grammar Practice")? "GP": "Task ". $value['task_no']; ?></td>
                                                    <td>{{ $value['task_title'] }}</td>
                                                    <td style="display:none;">{{ $value['level_id'] }}</td>
                                                    <td style="display:none;">{{ $value['course_type']=="GES"?"5bd16843b0dace44d0546c02":"5bd16d03b0dace44d92e7263" }}</td>
                                                    <td style="display:none;">{{ ($value['is_extra']=='1' && $value['is_marked_old']=='1') && $value['is_marked_by'] != 'student_self_marking' && !$afterFiftteenDays ?'*&^%$': ''}}  </td>
                                                    <td style="display:none;">{{($value['is_marked_old']=='0') && $value['is_marked_by'] != 'student_self_marking' ?'##$$##$$##':''}}  </td>
                                                    <td style="display:none;">{{ '!@#$%' }}</td>
                                                    <td>
                                                      <a href="{{url('practice-detail/').'/'.$value['topic_id'].'/'.$value['task_id'].'/'.$value['studentid']}}" title="Edit" class="action-button">
                                                          <img src="{{asset('public/images/icon-table-edit.svg')}}" alt="Edit" class="img-fluid">
                                                      </a>
                                                    </td>
                                                    <td style="display:none;">{{$value['updated_date'] }}</td>
                                                </tr>
                                                <?php
                                            }
                                        } 
                                    } ?>
                                @endforeach
                            @endforeach
                        @endif 
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Topic</th>
                            <th>Task</th>
                            <th>Skill</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
  </main>

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
  <div class="modal fade" id="selectLevel" tabindex="-1" role="dialog" aria-labelledby="selectLevelLabel" aria-hidden="true">
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
@endsection
@section('script')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	var table          = "";
	var LevelCourse    = '<?php echo json_encode($courseWiseArray); ?>';
    var newLevel       = JSON.parse(LevelCourse);
    console.log(newLevel);
    $(document).ready( function () {
        $('#myTable thead tr').clone(true).appendTo( '#myTable thead' );
        $('#myTable thead tr:eq(1) th').each( function (i) {
            if(i == 5) {
                return false;
            }
            var title = $(this).text();
            var oldval          =  getCookie("search_"+i);
            $(this).html( '<input type="text" id="search_'+i+'" placeholder="Search '+title+'" value="'+oldval+'"/>' );
            $('input',this).on( 'keyup change', function () {
                document.cookie = $(this).attr("id")+"="+$(this).val()+"; path=/";

                if (table.column(i).search() !== this.value) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });
        var flag = 0;
        $('.hideto').each(function(){
          if(flag == 1){
            $(this).html("")
          }
          flag++;
        });
        $('#myTable thead tr:eq(1) th').css("background-color","white")
        table = $('#myTable').DataTable({
            "orderCellsTop": true,
            "fixedHeader": true,
            "order": [[ 11, "desc" ]],
            "iDisplayLength": 50,
            "bSortable": false,
            "columnDefs": [{
              "targets": 10,
              "orderable": false
            }]
	    });

	    $('.filterWorkRecordCourse').on('click', function(e) {
	    	var courseName = $(this).attr('data-courseName')=="ges"?"5bd16843b0dace44d0546c02":"5bd16d03b0dace44d92e7263";
	        var LevelId    = getLevelByCourseChange(courseName);
            table
		    .columns(6).search(courseName)
            .columns(5).search(LevelId)
            .columns(7).search('')
            .columns(8).search("##$$##$$##")
            .columns(9).search('')
            .columns(0).search('')
		    .draw();

            $('.findOne').removeClass("btn-danger").addClass('btn-light');
            $('.findOne').first().addClass("btn-danger");
            $('#student').val("");

            document.cookie = "studentfilter=; path=/";
            document.cookie = "student=; path=/";
            document.cookie = "pending=true; path=/";
            document.cookie = "extra=false; path=/";
            document.cookie = "workrecord=false; path=/";
            document.cookie = "course="+courseName+"; path=/";
            document.cookie = "level="+LevelId+"; path=/";
		});

        $('.filterWorkRecordLevel').on('click', function(e) {
            $('.filterWorkRecordLevel').removeClass('active-level');
            $(this).addClass('active-level');
            var level       = $(this).attr('data-filter');
            var levelTitle  = $(this).attr('data-levelTitle');
            $('.selected_level').removeClass('btn-light').addClass('btn-danger');
            $('#selectLevel').modal('toggle');
            $('.selected_level').html(levelTitle);
            document.cookie = "level="+level+"; path=/";
            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(5).search(level)
            .columns(8).search("##$$##$$##")
            .draw();
            document.cookie = "level="+level+"; path=/";
            document.cookie = "levelTitle="+levelTitle+"; path=/";
        });

        $('.pending_records').on('click', function() {
            $(this).addClass('btn-danger').removeClass('btn-light');
            $('.work_record_btn').removeClass('btn-danger').addClass('btn-light');
            $('.extra_records').removeClass('btn-danger').addClass('btn-light');
            commonButtonsChange("pending")

            document.cookie = "pending=true; path=/";
            document.cookie = "extra=false; path=/";
            document.cookie = "workrecord=false; path=/";
        });
     
        $('.extra_records').on('click', function() {
            $(this).addClass('btn-danger').removeClass('btn-light');
            $('.pending_records').removeClass('btn-danger').addClass('btn-light');
            $('.work_record_btn').removeClass('btn-danger').addClass('btn-light');
            commonButtonsChange("extra")

            document.cookie = "pending=false; path=/";
            document.cookie = "extra=true; path=/";
            document.cookie = "workrecord=false; path=/";
        });
        
        $('.work_record_btn').on('click', function() {
            if($('#student').val()==""){
                $('#selectStudent').modal("show");
            }else{
                document.cookie = "common=workrecord; path=/";
                commonButtonsChange("work")
            }
            $(this).addClass('btn-danger').removeClass('btn-light');
            $('.extra_records').removeClass('btn-danger').addClass('btn-light');
            $('.pending_records').removeClass('btn-danger').addClass('btn-light');
            document.cookie = "pending=false; path=/";
            document.cookie = "extra=false; path=/";
            document.cookie = "workrecord=true; path=/";
        });

        $('#serachdata').on('keyup', function() {
            
            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(0).search($('#student').val()==""?"":$('#student').val())
            .columns(1).search($(this).val().trim()==""?'':$(this).val())
            .columns(5).search(level)
            .columns(7).search($('.findOne.btn-danger').text()=="Extra"?"*&^%$":"")
            .columns(8).search($('.findOne.btn-danger').text()=="Pending"?"##$$##$$##":"")
            .columns(9).search($('.findOne.btn-danger').text()=="Work Record"?"!@#$%":"")
            .draw();

            document.cookie = "serachdatafilter="+$(this).val()+"; path=/";
        });

        $('.filterWorkRecordStudent').on('click', function() {
            $('#student').val($(this).attr("data-filter"));
            $('#selectStudent').modal("hide")
            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(5).search(level)
            .columns(0).search($(this).attr("data-filter"))
            .columns(8).search($('.findOne.btn-danger').text()=="Pending"?"##$$##$$##":"")
            .columns(9).search($('.findOne.btn-danger').text()=="Work Record"?"!@#$%":"")
            .columns(7).search($('.findOne.btn-danger').text()=="Extra"?"*&^%$":"")
            .draw(); 

            document.cookie = "studentfilter="+$(this).attr("data-filter")+"; path=/";
        });
        $('#student').on('change', function() {
            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(5).search(level)
            .columns(0).search($(this).val())
            .columns(8).search($('.findOne.btn-danger').text()=="Pending"?"##$$##$$##":"")
            .columns(9).search($('.findOne.btn-danger').text()=="Work Record"?"!@#$%":"")
            .columns(7).search($('.findOne.btn-danger').text()=="Extra"?"*&^%$":"")
            .draw();
            document.cookie = "student="+$(this).val()+"; path=/";
        });

        var course          =  getCookie("course");
        var level           =  getCookie("level");
        var pending         =  getCookie("pending");
        var courseName      = "5bd16843b0dace44d0546c02";
      
        if(course=="" && level == "" && pending == ""){
            $('.selected_level').html("ELEMENTARY");
            $('.selected_level').addClass("btn-danger").removeClass('btn-light');;
            $('.filterWorkRecordCourse').first().addClass("btn-danger").removeClass('btn-light');
            $('.pending_records').addClass("btn-danger").removeClass('btn-light');
            defaultData(courseName);
        }else{
            initdata();
        }
	});

     function defaultData(courseName) {
        
        table
        .columns(6).search(courseName)
        .columns(5).search(newLevel[courseName][0]['id'])
        .columns(8).search("##$$##$$##")
        .draw();
        var course      = getCommonCourseSelected();
        var LevelId     = getLevelByCourseChange(courseName);
    /*    alert("LevelId")
        alert(LevelId)
        alert(courseName)*/
      /*  alert(course)
        alert(courseName)*/
        document.cookie = "course="+course+"; path=/";
        document.cookie = "level="+LevelId+"; path=/";
        document.cookie = "pending=true; path=/";

    }

    function initdata() {

        var course          =  getCookie("course");
        var level           =  getCookie("level");
        var pending         =  getCookie("pending");
        var extra           =  getCookie("extra");
        var workrecord      =  getCookie("workrecord");
        var student         =  getCookie("student");
        var levelTitle      =  getCookie("levelTitle");
        var search0         =  getCookie("search_0");
        var search1         =  getCookie("search_1");
        var search2         =  getCookie("search_2");
        var search3         =  getCookie("search_3");
        var search4         =  getCookie("search_4");
        // alert(course);
        var courseName      = course=="5bd16843b0dace44d0546c02"?"ges":"aes";
      /*  alert(courseName);
        alert(level);
        alert(findlevel(course,level));*/
        $('.selected_level').html(findlevel(course,level));
        $('.selected_level').removeClass('btn-light').addClass('btn-danger');

        // console.log("course====>"+course)
        // console.log("level====>"+level)
        // console.log("pending====>"+pending)
        // console.log("extra====>"+extra)
        // console.log("workrecord====>"+workrecord)
        // console.log("student====>"+student)

        $('.filterWorkRecordCourse').each(function(){

           /* alert($(this).text().trim().toLowerCase())
            alert(courseName)*/
            if($(this).text().trim().toLowerCase() == courseName){
                $(this).addClass("active show")
            }else{
                $(this).removeClass("active show")
            }
        });

        $('.findOne').removeClass("btn-danger").addClass('btn-light');
        // alert(student)
        if(student!=""){
            $("#student").val(student)
        }
        if(search0!=""){
            student =search0; 
        }

        if(pending == "true" && pending!=""){
            $('.pending_records').addClass("btn-danger").removeClass('btn-light');
        }
        if(extra == "true" && extra!=""){
            $('.extra_records').addClass("btn-danger").removeClass('btn-light');
        }

        if(workrecord == "true" && workrecord !=""){
            $('.work_record_btn').addClass("btn-danger").removeClass('btn-light');
        }
        if(levelTitle !=""){
           $('.selected_level').html(levelTitle);
        }
      
        table
        .columns(0).search(student!=""?student:"")
        .columns(1).search(search1!=""?search1:"")
        .columns(2).search(search2!=""?search2:"")
        .columns(3).search(search3!=""?search3:"")
        .columns(4).search(search4!=""?search4:"")
        .columns(5).search(level)
        .columns(6).search(course)
        .columns(7).search(extra == "true"?"*&^%$":"")
        .columns(8).search(pending == "true"?"##$$##$$##":"")
        .columns(9).search(workrecord == "true"?"!@#$%":"")
        .draw();


    }

    function getCookie(cname) {
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

   
    function commonButtonsChange(type){
        
        
        if(type == "pending"){

            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(0).search($('#student').val())
            .columns(5).search(level)
            .columns(7).search('')
            .columns(8).search("##$$##$$##")
            .columns(9).search('')
            .draw();

        }else if(type == "extra"){

            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(5).search(level)
            .columns(0).search($('#student').val())
            .columns(7).search('*&^%$')
            .columns(8).search('')
            .columns(9).search('')
            .draw();

        }else if(type == "work"){
            var courseName  = getCommonCourseSelected();
            var level       = getLevelByCourseChange();
            table
            .columns(6).search(courseName)
            .columns(5).search(level)
            .columns(0).search($('#student').val())
            .columns(7).search('')
            .columns(8).search('')
            .columns(9).search('!@#$%')
            .draw();

        }
    }

	function getCommonCourseSelected(){
        return courseName = $('.filterWorkRecordCourse.active').attr('data-courseName')=="ges"?"5bd16843b0dace44d0546c02":"5bd16d03b0dace44d92e7263";
    }

    

    function resetAll(){
        table
        .search( '' )
        .columns()
        .search('')
        .draw();
    }

    function getLevelByCourseChange(courseName = null) {
        var crsname = courseName!=null?courseName:getCommonCourseSelected();
        var levelId = "";
        newLevel[crsname].forEach(function(entry) {
            if(entry.title == $('.selected_level').text()){
                levelId = entry.id
            }
        });
        return levelId;
    }

    function findlevel(courseName,level) {
        var levelName = "";
        newLevel[courseName].forEach(function(entry) {
            if(entry.id == level){
                levelName = entry.title
            }
        });
        return levelName;
    }

    setTimeout(function(){
        $('#myTable_filter').css("display","none")
    },500);

</script>
@endsection