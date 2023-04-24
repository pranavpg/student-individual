<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Session;
use Storage;
use Auth;

class WorkRecordController extends Controller
{

  public function getCourseData($cource_id){
    $courses = Session::get('courses');
    return $courses ?  $courses[$cource_id]['title'] : '';
  }

  public function getTopicData($topic_id){
    $topics = Session::get('topics');
    return $topics ? $topics[$topic_id]['sorting'] : '';
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
              return $task_num;
            }
          } else {
            $gkpos++;
          }
        }
      }
      return $topic_tasks;
    }
  }
  public function index(Request $request){

    $levels = Session::get('levels');
    $topics = Session::get('topics');
    $sessionAll = Session::all();
    //   pr($sessionAll);
    // if (!isset($sessionAll['user_data']) || empty($sessionAll['user_data']))
    // {
    //     //echo "=============>if";die;
    //     return redirect('/');
    // }
    // // pr($sessionAll);
    $request = array();
    $request['student_id'] = Session::get('user_id_new');
    $request['token_app_type'] = 'ieuk_new';
    $request['token'] = Session::get('token');
    $endPoint = "feedbacklist";
    $workRecordList = curl_get($endPoint, $request);

    $sessionAll = Session::all();
    $request = array();
    $request['student_id'] = Session::get('user_id_new');
    $request['token_app_type'] = 'ieuk_new';
    $request['token'] = Session::get('token');
    $endPoint = "course_topic_list";
    $course = curl_get($endPoint, $request);

    if(!empty($workRecordList)){
      $recordList = array();

     // dd($workRecordList);
      foreach($workRecordList['result']['feedbacks'] as $fkey => $fvalue) {

        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['student_task_emoji'] = $fvalue['student_task_emoji'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['student_task_comment'] = $fvalue['student_task_comment'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['task_emoji'] = $fvalue['task_emoji'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['task_comment'] = $fvalue['task_comment'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['teacher_emoji'] = $fvalue['teacher_emoji'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['teacher_comment'] = $fvalue['teacher_comment'];
        $feedback[$fvalue['topic_id']][$fvalue['task_id']]['teacher_audio'] = $fvalue['teacher_audio'];
        if(isset($fvalue['ieuk_comment']) && !empty($fvalue['ieuk_comment'])){
          $feedback[$fvalue['topic_id']][$fvalue['task_id']]['ieuk_comment'] = $fvalue['ieuk_comment'];
        }else{
          $feedback[$fvalue['topic_id']][$fvalue['task_id']]['ieuk_comment'] = ' ';
        }
      }

      $taskArray= array();
      $markedTaskArray =array();
      $awaitingMarkedTaskArray =array();

     //pr($workRecordList['result']['answers']);
      $topicNumberArray = array();
      $taskNumberArray = array();
      $i = 0;
      $marksGainedArray = array();
      $originalMarksArray=array();
      if(isset($workRecordList['result']['answers'])){
      foreach ($workRecordList['result']['answers'] as $key => $value) {

        $course_type = $this->getCourseData($value['cource_id']);
        $topicNumber = $this->getTopicData( $value['topic_id'] );
        $taskNumber = $this->getTaskFromTopicId($course, $value['cource_id'], $value['topic_id'], $value['task_id']);
        // dd($taskNumber);
        if(!in_array($value['task_id'], $taskArray)){
          $marks_gained = 0;
          $original_marks = 0;
          $marksGainedArray[$value['task_id']] = array();
          $originalMarksArray[$value['task_id']] = array();

          $i = 0;

          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['counter'] = $i;
          $ctr = $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['counter'];

          array_push($topicNumberArray, $topicNumber);
          array_push($taskNumberArray, $taskNumber);
          array_push($taskArray,$value['task_id']);
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['topic_id'] = $value['topic_id'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['task_id'] = $value['task_id'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice_id'] = $value['practise_id'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['updated_at'] = strtotime($value['updated_at']);
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['topic_no'] = $topicNumber; //$this->getTopicData( $value['topic_id'] );
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['task_no'] = $taskNumber; //$this->getTaskFromTopicId($course, $value['cource_id'], $value['topic_id'], $value['task_id']); // $this->getTaskFromTopicId($course,  $value['cource_id'], $value['topic_id'], $value['level_id'] );
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['student_task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_emoji']:0;
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['task_emoji']:0;
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['task_comment']:"";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['teacher_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_emoji']:0;
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['teacher_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_comment'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_comment']:"";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['teacher_audio'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_audio'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_audio']:"";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['ieuk_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['ieuk_comment'])?$feedback[$value['topic_id']][$value['task_id']]['ieuk_comment']:"";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['student_task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_comment']:"";
          
          
          if(!empty($value['marks_gained']) && $value['marks_gained']!='-'){
            $marks_gained = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
            array_push($marksGainedArray[$value['task_id']], $marks_gained );
          } else{
            $marks_gained = 0;
          }
          if(!empty($value['original_marks']) && $value['original_marks']!='-'){
            $original_marks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
            array_push($originalMarksArray[$value['task_id']], $original_marks );
          } else {
            $original_marks = 0;
          }
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks']>0 )?$value['original_marks']:"-";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained']>0 )?$value['marks_gained']:"-";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['practice_no'] = $value['sorting'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['practice_id'] = $value['practise_id'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['updated_at'] = strtotime($value['updated_at']);
        }
        else
        {
          $i =$recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['counter'];
          $i++;
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['counter']=$i;
          $ctr = $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['counter'];

          if(!empty($value['marks_gained']) && $value['marks_gained']!='-'){
            $marks_gained = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
            array_push($marksGainedArray[$value['task_id']], $marks_gained );
          } else{
            $marks_gained = 0;
          }

          if(!empty($value['original_marks']) && $value['original_marks']!='-'){
            $original_marks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
            array_push($originalMarksArray[$value['task_id']], $original_marks );
          } else {
            $original_marks = 0;
          }

          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained'] > 0 )?$value['marks_gained']:"-";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks'] > 0)? $value['original_marks']:"-";
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['practice_no'] = $value['sorting'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['practice_id'] = $value['practise_id'];
          $recordList[$course_type]['all_submitted_tasks'][$value['task_id']]['practice'][$ctr]['updated_at'] = strtotime($value['updated_at']);

        }

        if(!empty($value['is_marked']) && $value['is_marked'] ==1){

          if(!in_array($value['task_id'], $markedTaskArray)){
            $marks_gained_marked_tasks = 0;
            $original_marks_marked_tasks = 0;
            $marksGainedMarkedTasksArray[$value['task_id']] = array();
            $originalMarksMarkedTasksArray[$value['task_id']] = array();

            $j = 0;
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['counter'] = $j;
            $ctrj = $recordList[$course_type]['marked_tasks'][$value['task_id']]['counter'];
            array_push($markedTaskArray,$value['task_id']);
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['topic_id'] = $value['topic_id'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['task_id'] = $value['task_id'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['updated_at'] = strtotime($value['updated_at']);
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['topic_no'] = $topicNumber; //$this->getTopicData( $value['topic_id'] );
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['task_no'] = $taskNumber; //$this->getTaskFromTopicId($course, $value['cource_id'], $value['topic_id'], $value['task_id']); // $this->getTaskFromTopicId($course,  $value['cource_id'], $value['topic_id'], $value['level_id'] );
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['student_task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_emoji']:0;
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['task_emoji']:0;
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['task_comment']:"";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['teacher_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_emoji']:0;
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['teacher_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_comment'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_comment']:"";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['ieuk_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['ieuk_comment'])?$feedback[$value['topic_id']][$value['task_id']]['ieuk_comment']:"";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['student_task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_comment']:"";


            if( !empty($value['marks_gained']) && $value['marks_gained'] != '-' ) {
              $marks_gained_marked_tasks = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
              array_push($marksGainedMarkedTasksArray[$value['task_id']], $marks_gained_marked_tasks );
            } else{
              $marks_gained_marked_tasks = 0;
            }
            if(!empty($value['original_marks']) && $value['original_marks']!='-'){
              $original_marks_marked_tasks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
              array_push($originalMarksMarkedTasksArray[$value['task_id']], $original_marks_marked_tasks );
            } else {
              $original_marks_marked_tasks = 0;
            }
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksMarkedTasksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedMarkedTasksArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks']>0 )?$value['original_marks']:"-";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained']>0 )?$value['marks_gained']:"-";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['practice_no'] = $value['sorting'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['updated_at'] = strtotime($value['updated_at']);

          }
          else
          {

            $j = $recordList[$course_type]['marked_tasks'][$value['task_id']]['counter'];
            $j++;
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['counter'] = $j;
            $ctrj = $recordList[$course_type]['marked_tasks'][$value['task_id']]['counter'];

            if(!empty($value['marks_gained']) && $value['marks_gained']!='-'){
              $marks_gained_marked_tasks = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
              array_push($marksGainedMarkedTasksArray[$value['task_id']], $marks_gained_marked_tasks );
            } else{
              $marks_gained_marked_tasks = 0;
            }

            if(!empty($value['original_marks']) && $value['original_marks']!='-'){
              $original_marks_marked_tasks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
              array_push($originalMarksMarkedTasksArray[$value['task_id']], $original_marks_marked_tasks );
            } else {
              $original_marks_marked_tasks = 0;
            }

            $recordList[$course_type]['marked_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksMarkedTasksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedMarkedTasksArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained'] > 0 )?$value['marks_gained']:"-";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks'] > 0)? $value['original_marks']:"-";
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['practice_no'] = $value['sorting'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['marked_tasks'][$value['task_id']]['practice'][$ctrj]['updated_at'] = strtotime($value['updated_at']);


          }
        }
        else
        {
          if(!in_array($value['task_id'],$awaitingMarkedTaskArray)){
            $marks_gained_awaiting_marked_tasks = 0;
            $original_marks_awaiting_marked_tasks = 0;
            $marksGainedAwaitingMarkedTasksArray[$value['task_id']] = array();
            $originalMarksAwaitingMarkedTasksArray[$value['task_id']] = array();

            $k = 0;
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['counter'] = $k;
            $ctrk = $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['counter'];
            array_push($awaitingMarkedTaskArray,$value['task_id']);
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['topic_id'] = $value['topic_id'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['task_id'] = $value['task_id'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['updated_at'] = strtotime($value['updated_at']);
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['topic_no'] = $topicNumber; //$this->getTopicData( $value['topic_id'] );
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['task_no'] = $taskNumber; //$this->getTaskFromTopicId($course, $value['cource_id'], $value['topic_id'], $value['task_id']); // $this->getTaskFromTopicId($course,  $value['cource_id'], $value['topic_id'], $value['level_id'] );
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['student_task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_emoji']:0;
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['task_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['task_emoji']:0;
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['task_comment']:"";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['teacher_emoji'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_emoji'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_emoji']:0;
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['teacher_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['teacher_comment'])?$feedback[$value['topic_id']][$value['task_id']]['teacher_comment']:"";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['student_task_comment'] = !empty($feedback[$value['topic_id']][$value['task_id']]['student_task_comment'])?$feedback[$value['topic_id']][$value['task_id']]['student_task_comment']:"";


            if( !empty($value['marks_gained']) && $value['marks_gained'] != '-' ) {
              $marks_gained_awaiting_marked_tasks = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
              array_push($marksGainedAwaitingMarkedTasksArray[$value['task_id']], $marks_gained_awaiting_marked_tasks );
            } else{
              $marks_gained_awaiting_marked_tasks = 0;
            }
            if(!empty($value['original_marks']) && $value['original_marks']!='-'){
              $original_marks_awaiting_marked_tasks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
              array_push($originalMarksAwaitingMarkedTasksArray[$value['task_id']], $original_marks_awaiting_marked_tasks );
            } else {
              $original_marks_awaiting_marked_tasks = 0;
            }
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksAwaitingMarkedTasksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedAwaitingMarkedTasksArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks']>0 )?$value['original_marks']:"-";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained']>0 )?$value['marks_gained']:"-";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['practice_no'] = $value['sorting'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['updated_at'] = strtotime($value['updated_at']);

          }
          else
          {
            $k = $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['counter'];
            $k++;
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['counter'] = $k;
            $ctrk = $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['counter'];

            if(!empty($value['marks_gained']) && $value['marks_gained']!='-'){
              $marks_gained_awaiting_marked_tasks = !empty($value['marks_gained'])? (int)$value['marks_gained'] : 0;
              array_push($marksGainedAwaitingMarkedTasksArray[$value['task_id']], $marks_gained_awaiting_marked_tasks );
            } else{
              $marks_gained_awaiting_marked_tasks = 0;
            }

            if(!empty($value['original_marks']) && $value['original_marks']!='-'){
              $original_marks_awaiting_marked_tasks = !empty($value['original_marks'])? (int)$value['original_marks'] : 0;
              array_push($originalMarksAwaitingMarkedTasksArray[$value['task_id']], $original_marks_awaiting_marked_tasks );
            } else {
              $original_marks_awaiting_marked_tasks = 0;
            }

            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['original_marks'] = array_sum($originalMarksAwaitingMarkedTasksArray[$value['task_id']]); //(is_int($original_marks)) ? $original_marks :'-';
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['marks_gained'] = array_sum($marksGainedAwaitingMarkedTasksArray[$value['task_id']]);//(is_int($marks_gained))?$marks_gained:'-';

            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['marks_gained'] = ( !empty($value['marks_gained']) && $value['marks_gained']!='-'  && $value['marks_gained'] > 0 )?$value['marks_gained']:"-";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['original_marks'] = ( !empty($value['original_marks']) && $value['original_marks']!='-' && $value['original_marks'] > 0)? $value['original_marks']:"-";
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['practice_no'] = $value['sorting'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['practice_id'] = $value['practise_id'];
            $recordList[$course_type]['awaiting_marked_tasks'][$value['task_id']]['practice'][$ctrk]['updated_at'] = strtotime($value['updated_at']);
          }
        }
      }
    }
    }
 
    if(!empty($topicNumberArray)){
      sort($topicNumberArray);  
    }
    
    if(!empty($taskNumberArray)){
      sort($taskNumberArray);
    }
    $skills = [];//$sessionAll['skills'];
    $newArray = [];
    foreach($taskNumberArray as $data){
      if(!is_array($data)){
        array_push($newArray, $data);
      }
    }
    return view('work-record/index',['recordList' => $recordList, 'all_topics' => array_unique($topicNumberArray), 'all_tasks' => array_unique($newArray), 'skills'=>$skills,'sessionAll'=>$sessionAll]);
  }

  public function savePracticeFeedback(Request $request){
        $request = $request->all();
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['topicid'] = $request['topicid'];
        $request_payload["taskid"] = $request['taskid'];

        $request_payload["student_task_emoji"] = !empty($request['student_task_emoji'])?$request['student_task_emoji']:"0";
        $request_payload["student_task_comment"] = !empty($request['student_task_comment'])?$request['student_task_comment']:"";
        $request_payload["task_level"] = !empty($request['task_level'])?$request['task_level']:"";
        $request_payload["feedbackid"] = !empty($request['feedbackid'])?$request['feedbackid']:"";
        $request_payload["task_emoji"] = !empty($request['task_emoji'])?$request['task_emoji']:"";
        $request_payload["task_comment"] = !empty($request['task_comment'])?$request['task_comment']:"";
        //pr(json_encode($request_payload));
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
}
?>
