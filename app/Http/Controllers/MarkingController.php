<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Infrastructure\ServiceResponse;
use App\Infrastructure\PageModel;
use Validator, Response, Session, Storage, Auth;
class MarkingController extends Controller {
  public function newmarking(Request $request , $classId=null, $studentId=null) {
    $sessionAll                   = Session::all();
    $studentID =  Session::get('user_id_new');
    if(empty($studentID)) {
         Session::forget('user_id_new');
         return redirect('/');
    }
    $reqData = [];
    $reqData['token'] =  Session::get('token');
    $reqData['token_app_type'] =  'ieuk_new';
    $reqData['student_id'] = $studentID;
    $endPoint                     = "individual_student_list_new";
    $studentsData                 = curl_get($endPoint, $reqData);
    $students                     = [];
    $teacher_id                   = '';
    if(!empty($studentsData) && $studentsData['success'] == 1){
        $students = $studentsData['students'];
    }
    return view('marking/new_marking',compact('students','studentsData','teacher_id','studentId'));
  }
  public function markingList(Request $request,$classId =null) {
    $studentID =  Session::get('user_id_new');
    if(empty($studentID)) {
         Session::forget('user_id_new');
         return redirect('/');
    }
    $requestdata                      = array();
    $requestdata['token'] =  Session::get('token');
    $requestdata['token_app_type'] =  'ieuk_new';
    $requestdata['student_id'] = $studentID;
    $course   = isset($request->course)?$request->course:"";
    $level    = isset($request->level)?$request->level:"";
    $topic    = isset($request->topic)?$request->topic:"";
    $task     = isset($request->task)?$request->task:"";
    $practise = isset($request->practice_id)?$request->practice_id:"";
      $flag = $request->type_data;
      $serach_filter                    = isset($request['order'][0])?$request['order'][0]['column']:"";
      $serach_directory                 = isset($request['order'][0])?$request['order'][0]['dir']:"";
      $serach                           = isset($request['search']['value'])?$request['search']['value']:"";
      $requestdata['filter']            = $serach;
      $requestdata['column']            = $serach_filter;
      $requestdata['ace_desc']          = $serach_directory;
      $requestdata['course_id']         = $course;
      $requestdata['level_id']          = $level;
      $requestdata['topic_id']          = $topic;
      $requestdata['task_id']           = $task;
      $requestdata['practise_id']       = $practise;
      $requestdata['per_page']          = $request->per_page;
      $requestdata['page']              = $request->page;
      $requestdata['student_id']        = $studentID;
      $requestdata['student_new']       = $studentID;//$request['student_new'];
      $requestdata['is_marked_by']      = $request['is_manual'];
      if($flag == 1){
        $endPoint                       = "pending_list_individual";
      }elseif($flag == 2){
        $endPoint                       = "student_work_individual";
        $requestdata['is_extra']        = "true";
      }elseif($flag == 3){
        $endPoint                       = "student_work_individual";
        $requestdata['is_extra']        = "false";
      }
      $classList                    = curl_get($endPoint,$requestdata);
      $jsondata                     = []; 
      $jsondata['page']             = isset($request->draw)?$request->draw:1;
      $jsondata['recordsTotal']     = (int)$classList['result']['total'];
      $jsondata['recordsFiltered']  = (int)$classList['result']['total'];
      $alldata                      = [];
      $ABCSArray = array("A","B","C","D","E","F","G","H","I","J","K");
      foreach ($classList['result']['data'] as $key => $value) {
        $sorting = $value['sorting']==0?$value['sorting']:$ABCSArray[$value['sorting']-1]; 
        $name = "";
        if($value['get_task']['taskname'] == "Grammar Practice"){
            $name = "GP";
        }
        $alldata[$key][]  = $value['student_id']."<input type='hidden' value='".$value['student_id']."' id='std_id'><input type='hidden' value='".$value['practice_id']."' id='pra_id'>";
        $alldata[$key][]  = $value['get_student']['firstname']." ".$value['get_student']['lastname'];
        $alldata[$key][]  = $value['get_course']['coursetitle'];
        $alldata[$key][]  = $value['get_level']['leveltitle'];
        $alldata[$key][]  = "Topic : ".$value['get_topic']['sorting']."<br>".$value['get_topic']['topicname'];
        $alldata[$key][]  = "<span class='complaint__description'>Task : ".$value['get_task']['sorting']."  ".$name."  ( ".$sorting.") "."</span><br>".$value['get_task']['taskname'];
        $alldata[$key][]  = '<a href="javascript:void(0)" class="hidden-tr-opner click" practice_id="'.$value['practice_id'].'" studentId="'.$value['student_id'].'" course_id="'.$value['course_id'].'" level_id="'.$value['level_id'].'"  taskId="'.$value['task_id'].'" ><img src="https://student.englishapp.uk/public/images/icon-table-opener.svg" alt="" class="img-fluid"></a>';
      }
      $jsondata['data']   = $alldata;
      echo json_encode($jsondata);
  }
  public function ajaxView(Request $request){
    $sessionAll   = Session::all();
     $studentID =  Session::get('user_id_new');
    if(empty($studentID)) {
         Session::forget('user_id_new');
         return redirect('/');
    }
    $request1     = array();
    $request1['token'] =  Session::get('token');
    $request1['token_app_type'] =  'ieuk_new';
    $request1['student_id'] = $request['studenId'];
    $request1['student_id']       = $request['studenId'];
    $request1['token_app_type']   = 'ieuk_student';
    $request1['token']            = "ewfwesf";
    $request1['course_id']        = $request['course'];
    $request1['level_id']         = $request['level'];
    $request1['task_id']          = $request['taskId'];
    $request1['practice_id']      = $request['practice_id'];
    $request1['flag']             = 1;
    $endPoint                     = "individual_student_marking_detail";
    $response                     = curl_get($endPoint, $request1);
    $data                         = $response['result'];
    $count                        = $response['total_count'];
    $tabs                         = $response['tabs'];
    $markingmethods               = $response['markingmethod'];
    $teacherBook                  = isset($data['teacherbook'][0]['teacherbookdescription'])?$data['teacherbook'][0]['teacherbookdescription']:[];
    $courseBook                   = isset($data['description'])?$data['description']:[];
    $taskId                       = $request['taskId'];
    $topicId                      = "";
    $flag_for_tab                 = $request['flag_for_tab'];

    echo \View::make('marking.marking_view',compact('teacherBook','courseBook','taskId','topicId','markingmethods','count','flag_for_tab','tabs'))->render();
  }
  public function getpractise(Request $request) { 
    $sessionAll   = Session::all();
    $request1     = array();
    $studentID =  Session::get('user_id_new');
    if(empty($studentID)) {
         Session::forget('user_id_new');
         return redirect('/');
    }
    $request1     = array();
    $request1['token'] =  Session::get('token');
    $request1['token_app_type'] =  'ieuk_new';
    $request1['student_id'] = $request['studenId'];
    $request1['course_id']        = $request['course'];
    $request1['level_id']         = $request['level'];
    $request1['task_id']          = $request['taskId'];
    $request1['practice_id']      = $request['practice_id'];
    $request1['flag']             = $request['flag'];
    $endPoint                     = "individual_single_practice";
    $response                     = curl_get($endPoint, $request1);
    $practises                    = $response['result']['practise'];
    $taskId                       = $request['taskId'];
    $topicId                      = "";
    session::put('final_student_id',$request['studenId']);
    $urlFlag = false; 
    echo \View::make('marking.practise_view',compact('practises','taskId','topicId','urlFlag'))->render();
  }
  public function getlevel(Request $request) {
    $request1                     = array();
    $request1['course_id']        = $request['course_id'];
    $response                     = curl_get("course_by_level",$request1);
    echo json_encode($response);
  }
  public function gettopic(Request $request) {
    $request1                     = array();
    $request1['level_id']         = $request['level_id'];
    $response                     = curl_get("level_by_topic",$request1);
    echo json_encode($response);
  }
  public function gettask(Request $request) {
    $request1                     = array();
    $request1['topic_id']         = $request['topic_id'];
    $response                     = curl_get("topic_by_task",$request1);
    echo json_encode($response);
  }
  public function getpractice(Request $request) {
    $request1                     = array();
    $request1['task_id']          = $request['task_id'];
    $response                     = curl_get("task_by_practise",$request1);
    echo json_encode($response);
  }
  public function teacherMarking(Request $request) {
    $request_payload = array();
    $request_payload['student_id']          = $request->student_id;
    $request_payload['practise_id']         = $request->practise_id;
    $request_payload['answer_id']           = $request->student_practise_id;
    $request_payload['marking_type']        = $request->markingmethod;
    $request_payload['teacher_id']          = $request->teacher_id;
    $request_payload['marks_gained']        = $request->mark;
    $request_payload['teacher_comment']     = $request->comment;
    $request_payload['submit_again']        = $request->subsmitAgain;
    $request_payload['teacher_emoji']       = $request->teacher_emoji;
    $request_payload['token_app_type']      = 'ieuk_new';
    $request_payload['token']               = Session::get('token');
    // dd(json_encode($request_payload));
    $endPoint = "practisesubmitmarking_new";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
    } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function getCourseData($cource_id){
    $courses = Session::get('courses');
    return $courses[$cource_id]['title'];
  }
  public function getTopicData($topic_id){
    $topics = Session::get('topics');
    return $topics[$topic_id]['sorting'];
  }
  public function getTaskFromTopicId( $course,$course_id, $topic_id, $task_id ) {

    if(!empty( $course['result'] )){
      $topic_tasks = array();
      foreach ($course['result']['tasks'] as $key => $value) {
        $topic_tasks[$value['topic_id']][]=$value;
      }
      usort($topic_tasks[$topic_id], function($a, $b) {
          return $a['sorting'] <=> $b['sorting'];
      });
      $gkpos=0;
      $taskNameMap = array();
      if(!empty($topic_tasks[$topic_id])){
        for($m=0; $m<count($topic_tasks[$topic_id]); $m++ ){
          $tp_task = $topic_tasks[$topic_id][$m];
          if($tp_task['title'] != 'Grammar Key'  ){

            $task_num = (int) $tp_task['sorting'] - $gkpos;
            $topic_tasks[$topic_id][$m]['sorting'] = $task_num;
            if($tp_task['id'] == $task_id){
              $task_data['title'] = $tp_task['title'];
              $task_data['number'] = $task_num;
              return   $task_data;
            }
          } else {
            $gkpos++;
          }
        }
      }
      return $topic_tasks;
    }
  }
  public function getCourseTopicList(){
    $sessionAll = Session::all();
    if(!empty($sessionAll['user_data'])){
      $userDetails = $sessionAll['user_data'];
      $request['student_id'] = $userDetails['id'];
      $request['token_app_type'] = 'ieuk_teacher';
      $request['token'] = $userDetails['token_ieuk_teacher'];
      $endPoint = "course_topic_list";
      $course = curl_get($endPoint, $request);
      return $course;
    } else {
      return  true;
    }
  }
  public function getStudentList($class_id, $course) {
    $sessionAll = Session::all();
    $userDetails = $sessionAll['user_data'];
    $request = array();
    $request['teacher_id'] = $userDetails['id'];
    $request['token_app_type'] = 'ieuk_teacher';
    $request['token'] = $userDetails['token_ieuk_teacher'];
    $request['login_teacher_id']=$userDetails['id'];
    $request['class_id'] = $class_id;
    $endPoint = "ieuk_student_list";
    $studentList = curl_get($endPoint, $request);
    $practise_calculate = array();
    $studentListArray = array();
    $mapTopicNumber = array();
    $mapTaskTitle = array();
    $studentsArray = array();
    $topicNumberArray =array();
    $taskNumberArray =array();
    $taskArray =array();
    $i=0;
    $flagForPopup = false; 
    $is_extra_calculate = [];
    $is_marked_calculate = [];
    if(!empty($studentList)){
       foreach ($studentList['result'] as $key => $value) {
            foreach ( $value['answers'] as $k => $v ) {
                $is_extra_flag = "";
                if(isset($v['is_extra'])){
                    $is_extra_flag = false;
                    if($v['is_extra'] == "true" || $v['is_extra'] === true){
                        $is_extra_flag = true;
                    }
                }
                $is_marked_flag = "";
                if(isset($v['is_marked'])){
                    $is_marked_flag = false;
                    if($v['is_marked'] == "true" || $v['is_marked'] === true){
                        $is_marked_flag = true;
                    }
                }
                $is_extra_calculate[$value['studentid']][$v['task_id']][] = $is_extra_flag;
                $practise_calculate[$value['studentid']][$v['task_id']][] = $v;
                $is_marked_calculate[$value['studentid']][$v['task_id']][] = $is_marked_flag;
            }
        }
        foreach ($studentList['result'] as $key => $value) {
        $studentsArray[$value['studentid']] = $value['firstname'].' '.$value['lastname'];
            foreach ( $value['answers'] as $k => $v ) {
            $flagForPopup = true; 
            $course_type = $this->getCourseData($v['cource_id']);
            $studentListArray[$course_type][$i]['studentid'] = $value['studentid'];
            $studentListArray[$course_type][$i]['studentname'] = $value['firstname'].' '.$value['lastname'];
                if( !in_array($v['task_id'], $taskArray) ) {
                    $topicNumber = $this->getTopicData( $v['topic_id'] );
                    $taskData = $this->getTaskFromTopicId($course, $v['cource_id'], $v['topic_id'], $v['task_id']);
                    $taskNumber = isset($taskData['number'])?$taskData['number']:0;
                    $taskTitle = isset($taskData['title'])?$taskData['title']:"";
                    $mapTopicNumber[$v['topic_id']] = $topicNumber;
                    $mapTaskNumber[$v['task_id']] = $taskNumber;
                    $mapTaskTitle[$v['task_id']] = isset($taskData['title'])?$taskData['title']:"";
                    array_push($taskArray, $v['task_id']);
                } else {
                    $topicNumber = $mapTopicNumber[$v['topic_id']];
                    $taskNumber = $mapTaskNumber[$v['task_id']];
                    $taskTitle = $mapTaskTitle[$v['task_id']];
                } 
                array_push($topicNumberArray, $topicNumber);
                array_push($taskNumberArray, $taskNumber);
                $flag_is_extra = 0;
                if(is_array($is_extra_calculate[$value['studentid']][$v['task_id']])){
                    if (in_array(true, $is_extra_calculate[$value['studentid']][$v['task_id']])){
                        $flag_is_extra = 1;
                    }
                }
                $flag_is_mark = 0;
                if(is_array($is_marked_calculate[$value['studentid']][$v['task_id']])){
                    if (in_array(true, $is_marked_calculate[$value['studentid']][$v['task_id']])){
                        $flag_is_mark = 1;
                    }
                }
                $studentListArray[$course_type][$i]['course_type']  = $course_type;
                $studentListArray[$course_type][$i]['topic_id']     = $v['topic_id'];
                $studentListArray[$course_type][$i]['task_id'] = $v['task_id'];
                $studentListArray[$course_type][$i]['level_id'] = $v['level_id'];
                $studentListArray[$course_type][$i]['practice_id'] = $v['practise_id'];
                $studentListArray[$course_type][$i]['is_extra'] =  $flag_is_extra;
                $studentListArray[$course_type][$i]['is_marked'] = $flag_is_mark; 
                $studentListArray[$course_type][$i]['is_extra_old'] =  (!empty($v['is_extra']) && ($v['is_extra']==1 || $v['is_extra']=="1" || $v['is_extra']==true || $v['is_extra']=="true") )?1:0;
                $studentListArray[$course_type][$i]['is_marked_old'] = (!empty($v['is_marked']) && ($v['is_marked']==1 || $v['is_marked']=="1" || $v['is_marked']==true || $v['is_marked']=="true" ) )? $v['is_marked'] : 0;
                $studentListArray[$course_type][$i]['topic_no'] = $topicNumber;
                $studentListArray[$course_type][$i]['task_no'] = $taskNumber;
                $studentListArray[$course_type][$i]['task_title'] = $taskTitle;
                $studentListArray[$course_type][$i]['created_at'] = strtotime($v['created_at']);
                $studentListArray[$course_type][$i]['updated_at'] = strtotime($v['updated_at']);
                $studentListArray[$course_type][$i]['created_date'] = $v['created_at'];
                $studentListArray[$course_type][$i]['updated_date'] = $v['updated_at']; 
                $studentListArray[$course_type][$i]['id'] = $v['id']; 
                $studentListArray[$course_type][$i]['is_marked_by'] = $v['is_marked_by'];
                $i++;
            }
        }
    } 
    sort($topicNumberArray);
    sort($taskNumberArray);
    $records['studentListArray']    = $studentListArray;
    $records['topicNumberArray']    = array_unique($topicNumberArray);
    $records['taskNumberArray']     = array_unique($taskNumberArray);
    $records['studentsArray']       = $studentsArray;
    $records['flag']                = $flagForPopup;
    $records['practise_calculate']   = $practise_calculate;
    return $records;
  }
  public function index(Request $request, $class_id=""){
    $sessionAll = Session::all();
    $topics = Session::get('topics');
    $classList = $this->getClassList();
    $course = $this->getCourseTopicList();
    if(!empty($course['result']['course'])){
      $allCourse = $course['result']['course'];
      $levels = $course['result']['levels'];
      $levelArray = array();
      if(!empty($allCourse)) {
        foreach ($allCourse as $key => $value) {
          $m=0;
          foreach($levels as $k => $v) {
            if($value['id']==$v['course_id']) {
              $levelArray[$value['title']][$m]['title'] = $v['title'];
              $levelArray[$value['title']][$m]['id'] = $v['id'];
              $m++;
            }
          }
        }
      }
      if(!empty($class_id)){
        $selected_class = "Select Class";
        foreach ($classList as $key => $value) {
          if($value['id'] == $class_id){
            $selected_class = $value['class_name'];
          }
        }
        $studentListArray = $this->getStudentList($class_id, $course); 
        Session::put('preClass', $class_id);
        return view('marking/index', [ 'classListArray' => $classList,
                      'studentListArray' => $studentListArray['studentListArray'],
                      'studentsArray' => $studentListArray['studentsArray'],
                      'all_topics' => $studentListArray['topicNumberArray'],
                      'all_tasks' => $studentListArray['taskNumberArray'],
                      'selected_class' => $selected_class,
                      'levels' => $levelArray,
                      'sessionAll'=> $sessionAll,
                      'practise_calculate' => $studentListArray['practise_calculate'],
                    ]
        );
      } else {
          $selected_class = "Select Class";
          $studentListArray = [];
          return view('marking/index', [ 'classListArray' => $classList, 'selected_class' => $selected_class, 'levels' => $levelArray, 'studentListArray' => $studentListArray,'sessionAll'=> $sessionAll]);
      }
    } else {
      return redirect('/');
    }
  }
  public function index_new(Request $request, $class_id=""){
        $reqData = $request->all();
        $sessionAll = Session::all();
        $topics = Session::get('topics');
        $classList = $this->getClassList();
        $course = $this->getCourseTopicList();
        if(!empty($course['result']['course'])){
            $allCourse = $course['result']['course'];
            $levels = $course['result']['levels'];
            $levelArray = array();
            if(!empty($allCourse)) {
                foreach ($allCourse as $key => $value) {
                    $m=0;
                    foreach($levels as $k => $v) {
                        if($value['id']==$v['course_id']) {
                            $levelArray[$value['title']][$m]['title'] = $v['title'];
                            $levelArray[$value['title']][$m]['id'] = $v['id'];
                            $m++;
                        }
                    }
                }
            }
            if(!empty($class_id)){
                $selected_class = "Select Class";
                foreach ($classList as $key => $value) {
                    if($value['id'] == $class_id){
                        $selected_class = $value['class_name'];
                    }
                }
                $studentListArray = [];
                $studentListArray = $this->getStudentList($class_id, $course); 
                Session::put('preClass', $class_id);
                return view('marking/index_new', [ 'classListArray' => $classList,
                    'studentListArray' => $studentListArray['studentListArray'],
                    'studentsArray' => $studentListArray['studentsArray'],
                    'all_topics' => $studentListArray['topicNumberArray'],
                    'all_tasks' => $studentListArray['taskNumberArray'],
                    'selected_class' => $selected_class,
                    'levels' => $levelArray,
                    'sessionAll'=> $sessionAll,
                    'practise_calculate' => $studentListArray['practise_calculate'],
                ]);
            } else {
                $selected_class = "Select Class";
                $studentListArray = [];
                return view('marking/index', [ 'classListArray' => $classList, 'selected_class' => $selected_class, 'levels' => $levelArray, 'studentListArray' => $studentListArray,'sessionAll'=> $sessionAll]);
            }
        } else {
            return redirect('/');
        }
  }
  public function GetJsonResponse($serviceResponse,$code = 200){
    $jsonResponse = Response::make(json_encode($serviceResponse), $code);
    $jsonResponse->header('Content-Type', 'application/json');
    return $jsonResponse;
  }
  public function kk_index_new(Request $request, $class_id = null){
        $reqData = $request->all();
        $sessionAll = Session::all();
        if(!empty($sessionAll['user_data'])){
            $userDetails = $sessionAll['user_data'];
            $reqData['teacher_id'] = $userDetails['id'];
            $classList = $this->getClassList();
            $selected_class = "Select Class";

            if(!empty($classList)){
                foreach ($classList as $key => $value) {
                    if($value['id'] == $class_id){
                        $selected_class = $value['class_name'];
                    }
                }    
            }
            
            $endPoint = "ieuk_courses";
            $responseCURLData = curl_get($endPoint, $reqData);
            $courses = array();

            if($responseCURLData['success'] == 1){
                $courses = $responseCURLData['result'];
            }

            if(!empty($courses)){
                foreach($courses as $key => $course){
                    if(!empty($course['topic'])){
                        foreach($course['topic'] as $key2 => $topic){
                            $courses[$key]['topic'][$key2]['k_topicname'] = (!empty($topic['sorting']) ? ($topic['sorting'].' '): '').$topic['topicname'];
                        }

                        usort($course['topic'], function ($item1, $item2) {
                            $item1['sorting'] = (int)!empty($item1['sorting']) ? $item1['sorting'] : 0;
                            $item2['sorting'] = (int)!empty($item2['sorting']) ? $item2['sorting'] : 0;
                            return $item1['sorting'] <=> $item2['sorting'];
                        });
                    }
                }
            }

            if(!empty($courses)){
                foreach($courses as $key => $course){
                    if(!empty($course['task'])){
                        foreach($course['task'] as $key2 => $task){
                            $courses[$key]['task'][$key2]['k_taskname'] = (!empty($task['sorting']) ? ($task['sorting'].' '): '').$task['taskname'];
                        }

                        usort($course['task'], function ($item1, $item2) {
                            $item1['sorting'] = (int)!empty($item1['sorting']) ? $item1['sorting'] : 0;
                            $item2['sorting'] = (int)!empty($item2['sorting']) ? $item2['sorting'] : 
                            0;
                            return $item1['sorting'] <=> $item2['sorting'];
                        });
                    }
                }
            }
            /*//Cache::pull('courses');
            echo "<pre>";
            print_r($courses);
            exit;*/
            Session::put('preClass', $class_id);
            $reqData['class_id'] = $class_id;            
            $reqData['token_app_type'] = 'ieuk_teacher';
            $reqData['token'] = $userDetails['token_ieuk_teacher'];
            $reqData['login_teacher_id']=$userDetails['id'];
            $endPoint = "ieuk_student_list_new";

            $studentsData = curl_post($endPoint, $reqData);
            $students = [];
            // dd($studentsData);
            if(!empty($studentsData) && $studentsData['success'] == 1){
                $students = $studentsData['students'];
            }

            return view('marking/index_kk_new',[
                'classId'           => $class_id,
                'classList'         => $classList,
                'students'          => $students,
                'selected_class'    => $selected_class,
                'courses'           => $courses
            ]);    
        }
        return redirect()->route('login');
  }
  public function getMarkingRecords(Request $request){
        $response = new ServiceResponse();
        $reqData = $request->all();

        $pageIndex = $reqData['Data']['PageIndex'];
        $pageSize = $reqData['Data']['PageSize'];
        $limit = $pageSize;
        $offset = ($pageIndex - 1) * $pageSize;

        $sessionAll = Session::all();
        $userDetails = $sessionAll['user_data'];
        
        $reqData['Data']['SearchParams']['teacher_id'] = $userDetails['id'];
        $reqData['Data']['SearchParams']['token_app_type'] = 'ieuk_teacher';
        $reqData['Data']['SearchParams']['token'] = $userDetails['token_ieuk_teacher'];
        $reqData['Data']['SearchParams']['login_teacher_id'] = $userDetails['id'];

        $endPoint = "ieuk_student_marking_list_new";
        $endPoint = "ieuk_student_marking_list_new2";
        $responseCURLData = curl_post($endPoint, $reqData);

        if(!empty($responseCURLData) && count($responseCURLData['records'])>0) {
            $index = ($pageSize * ($pageIndex-1)) + 1;
            foreach ($responseCURLData['records'] as $key => $item) {
                $responseCURLData['records'][$key]['total_attempt'] = !empty($item['total_attempt']) ? $item['total_attempt'] : '';
                $responseCURLData['records'][$key]['checked'] = false;
                $responseCURLData['records'][$key]['edit_url'] = route('practice_detail',[$item['topic_id'],$item['task_id'],$item['student_id']]);
            }
        }
        $pageModel = new PageModel();
        $pageModel->CurrentPage = $pageIndex;
        $pageModel->TotalItems = $responseCURLData['countQueryCount'];
        $pageModel->ItemsPerPage = $pageSize;
        $pageModel->TotalPages = ceil($pageModel->TotalItems / $pageModel->ItemsPerPage);
        $pageModel->Items = $responseCURLData['records'];

        $response->Data = $pageModel;
        $response->IsSuccess = true;
        return $this->GetJsonResponse($response);
  }
  public function bulkMarking(Request $request){
        $response = new ServiceResponse();
        $reqData = $request->all();
        $sessionAll = Session::all();
        $userDetails = $sessionAll['user_data'];
        
        $reqData['Data']['SearchParams']['teacher_id'] = $userDetails['id'];
        $reqData['Data']['SearchParams']['token_app_type'] = 'ieuk_teacher';
        $reqData['Data']['SearchParams']['token'] = $userDetails['token_ieuk_teacher'];
        $reqData['Data']['SearchParams']['login_teacher_id'] = $userDetails['id'];

        $endPoint = "ieuk_student_bulk_marking";
        $responseCURLData = curl_post($endPoint, $reqData);

        $response->Message = "Something went wrong. Try after sometime";

        if(!empty($responseCURLData) && $responseCURLData['success'] == 1){
            $response->IsSuccess = true;
            $response->Message = "Successfully Marking";
        }   
        return $this->GetJsonResponse($response);
  }
  public function savePracticeFeedback(Request $request){
        $request = $request->all();
        $sessionAll = Session::all();
        $userDetails = $sessionAll['user_data'];
        $request_payload = array();
        $request_payload['student_id'] = $userDetails['student_id'];
        $request_payload['token_app_type'] = 'ieuk';
        $request_payload['token'] = $userDetails['token_ieuk'];
        $request_payload['topicid'] = $request['topicid'];
        $request_payload["taskid"] = $request['taskid'];

        $request_payload["student_task_emoji"] = !empty($request['student_task_emoji'])?$request['student_task_emoji']:"0";
        $request_payload["student_task_comment"] = !empty($request['student_task_comment'])?$request['student_task_comment']:"";
        $request_payload["task_level"] = !empty($request['task_level'])?$request['task_level']:"";
        $request_payload["feedbackid"] = !empty($request['feedbackid'])?$request['feedbackid']:"";
        $request_payload["task_emoji"] = !empty($request['task_emoji'])?$request['task_emoji']:"";
        $request_payload["task_comment"] = !empty($request['task_comment'])?$request['task_comment']:"";

        $endPoint = "addfeedback";
        $response = curl_post($endPoint, $request_payload);
        return $response;

        if(empty($response)){
          return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
          return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
          return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
  }
  public function getPracticeDetail(Request $request, $topicId = '', $taskId = '' , $studentId='',$showPrevious = 0) {
        $sessionAll = Session::all();
        $teacher_courses = get_teacher_course();

        if(!empty($sessionAll) && !empty($sessionAll['user_data']) && !empty($teacher_courses) && !empty($taskId) && !empty($topicId)){
            $userDetails = $sessionAll['user_data'];
            $courseLists = $teacher_courses;

            foreach($courseLists as $courseList){
                $levelLists = $courseList['levels'];
                if(!empty($levelLists)){
                    foreach($levelLists as $levelList){
                        $topicLists = $levelList['topic'];
                        if(!empty($topicLists)){
                            foreach($topicLists as $topic){
                                if($topic['_id'] == $topicId){
                                    $topicNumber = $topic['sorting'];
                                    $course_id = $topic['course_id'];
                                    $level_id = $topic['level_id'];
                                    break; 
                                }
                            }
                        }
                    }
                }
            }
            if(!empty($showPrevious)){
                $showPrevious = $showPrevious;
            }
            $request = array();
            $request['teacher_id'] = $userDetails['id'];
            $request['student_id'] = $studentId;
            $request['token_app_type'] = 'ieuk_teacher';
            $request['token'] = $userDetails['token_ieuk_teacher'];
            $request['course_id'] = $course_id;
            $request['level_id'] = $level_id;
            $request['taskid'] = $taskId;
            $request['show_previous'] = $showPrevious;
            $endPoint = "taskcheck";
            
            $response = curl_get($endPoint, $request);


            if(!$response['success']){
                Session::put('message', $response['message']);
                return redirect('/');
            }
            $topic_tasks = $response['result'];
            $levelTitle = $topic_tasks['level_name'];
            $courseName = $topic_tasks['course_name'];
            $taskNumber = !empty($topic_tasks['sorting']) ? $topic_tasks['sorting'] : '';
            $taskName   = isset($topic_tasks['task_name'])?$topic_tasks['task_name']:'';
            return view('marking.topic-index', compact('topic_tasks', 'topicId', 'taskId', 'sessionAll','studentId', 'taskNumber','taskName','topicNumber','courseName','levelTitle','showPrevious'));
        }
          return redirect('/');
  }
  public function savePracticeSubmitMarking(Request $request) {
      $sessionAll = Session::all();
      $userDetails = $sessionAll['user_data'];
      $request_payload = array();
      $request_payload['teacher_id'] = $userDetails['id'];
      $request_payload['student_id'] = $request['student_id'];
      $request_payload['teacher_emoji'] = $request['teacher_emoji'];
      $request_payload['practise_id'] = $request['practise_id'];
      $request_payload['teacher_comment'] = $request['teacher_comment'];
      $request_payload['marks_gained'] = $request['marks_gained'];
      if(isset($request['feedbackid']) && !empty($request['feedbackid'])){
        $request_payload['feedbackid'] = $request['feedbackid'];
      }
      if(!empty($request['comment_image'])) {
        $request_payload['comment_image']= $request['comment_image'];
        $is_file = !empty( $request['comment_image ']) ? true : false;
        $request_payload['is_file'] = $is_file;
      }
      $fileName = $request['marking_audio_path'];
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
        $path = public_path('uploads/practice/audio/'.$fileName);
        $encoded_data = base64_encode(file_get_contents($path));
      } else {
        $encoded_data ="";
      }
      $request_payload['teacher_audio']=$encoded_data;
      $request_payload['answers']=$request['answers'];
      
      $request_payload['token_app_type'] = 'ieuk_teacher';
      $request_payload['token'] = $userDetails['token_ieuk_teacher'];
      //  pr (json_encode($request_payload)); exit;
      $endPoint = "practisesubmitmarking";
      $response = curl_post($endPoint, $request_payload);

      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
  }
  public function renameAudio(Request $request){
      $sessionAll = Session::all();
      $userDetails = $sessionAll['user_data'];
    
      if(!empty($request['audio_key'])){
        $fileName = $request['student_id'].'-'.$request['practice_id'].'-'.$request['audio_key'].'.wav';
      } else {
        $fileName = $request['student_id'].'-'.$request['practice_id'].'.wav';
      }
      $old_file = public_path('uploads/practice/audio/').$request['filename'];
      $new_file = public_path('uploads/practice/audio/').$fileName;
      rename( $old_file, $new_file );
      $data['path'] = url('public/uploads/practice/audio/').'/'.$fileName;
      $data['file_name'] =$fileName;
      $data['audio_key'] = $request['audio_key'];
      $data['practice_id'] = $request['practice_id'];
      $data['student_id'] = $request['student_id'];
      return response()->json($data);
  }
  public function showPreviousMarking(Request $request){
        $response = new ServiceResponse();
        $reqData = $request->all();

        $showPrevious = Session::get('show_previous');

        if($showPrevious == 1){
            Session::forget('show_previous');    
        }else{
            Session::put('show_previous', 1);
        }
        $response->IsSuccess = true;
        $response->Message = "Successfully Marking";
        return $this->GetJsonResponse($response);
  }
}
?>
