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

class TopicController extends Controller {
   
    public function index(Request $request, $topicId = '', $taskId = '') {
        if(Session::get('user_id_new')==""){
            \Session::flush();
           return redirect('/');
        }
  
        $CourseDetails      = "";
        $practiceId         = $request['n'];
        $endPoint           = "topic_task_list";
        $data               = [];
        $franchise_code     = Session::get('franchise_code');
        $topic_task_status  = Session::get('topic_task_status');
        $data               = array('topic_id' => $topicId,'student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' =>'ieuk_new','franchise_code' => $franchise_code,'topic_task_status' => $topic_task_status);
        $taskinfo           = curl_get($endPoint, $data);
        if(isset($taskinfo['invalid_token']) && $taskinfo['invalid_token']){
          \Session::flush();
          return redirect('/')->with('message',$taskinfo['message']); 
        }
        $taskIdNew          = "";
        $topic_tasks_new    = "";
        $tasks_new          = "";
        $feedback           = [];
        $feedbackExits      = false;
        if(isset($taskId) && !empty($taskId)) {
            $topicRequest = array();
            $topicRequest['student_id']         = Session::get('user_id_new');
            $topicRequest['token_app_type']     = 'ieuk_new';
            $topicRequest['token']              = Session::get('token');
            $topicRequest['topic_id']           = $topicId;
            $topicRequest['task_id']            = $taskId;
            $endPoint                           = "individual_topic_list_new";
            $response                           = curl_get($endPoint, $topicRequest);
            if(isset($response['invalid_token']) && $response['invalid_token']){
              \Session::flush();
              return redirect('/')->with('message',$response['message']);
            }
            $taskIdNew                          = $taskId;
            $tasks_new                          = $response['result'][0];
            $topic_tasks_new                    = isset($tasks_new['sorting'])?$tasks_new['sorting']:"";
            $pcount                             = isset($tasks_new['tasks'][0]['practise'])?count($tasks_new['tasks'][0]['practise']):0;
            $CourseDetails                      = "";
        }
        Session::put('course_id_new',$taskinfo['topic_detail']['course_id']);
        Session::put('level_id_new',$taskinfo['topic_detail']['level_id']);
        $topic_no = $taskinfo['topic_detail']['sorting'];
        $topicname = $taskinfo['topic_detail']['topicname'];
        // dd($taskinfo);
        return view('topics.index_topic_new', compact('topicname','taskinfo','topic_no','taskIdNew','topicId','tasks_new','taskId','topic_tasks_new','practiceId','CourseDetails','feedbackExits','feedback'));
    }
    public function  get_progress_task(Request $request) {

        $topicRequest['topic_id']           = $request->topicId;
        $topicRequest['student_id']         = Session::get("user_id_new");
        $endPoint                           = "get_task_progress";
        $response                           = curl_get($endPoint, $topicRequest);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }

        echo json_encode($response);
     
    }
    public function  getIframeContent(Request $request, $topicId = '', $taskId = '', $practiceId='', $showPrevious = '') {
      // dd($practiceId);
      if (!isset($topicId) || empty($topicId)) {
          return redirect('/');
      }
      $topicSelect = [];
      $curuntCourseKey = 0;
      $course_id = "";
      $level_id = "";
      $topic_id = "";
      $CourseDetails = "";
      $request = array();
      $request['student_id']      = Session::get('user_id_new') ;
      $request['token_app_type']  = 'ieuk_new';
      $request['token']           = Session::get('token');
      $request['practice_id']     = $practiceId;
      $request['flag']            = $showPrevious;
      $request['topic_id']        = $topicId;
      /* if(!empty($showPrevious)){
        $request['show_marking'] = $showPrevious;
      }*/
      if(isset($taskId) && !empty($taskId)) {
          $request['task_id'] = $taskId;
      }
      $endPoint = "topic_list_new1";
      // dd(json_encode($request));
      $response = curl_get($endPoint, $request);
      if(isset($response['invalid_token']) && $response['invalid_token']){
          \Session::flush();
          return redirect('/')->with('message',$response['message']); 
      }
      $taskIdNew               = $taskId;
      $tasks_new               = $response['result'][0];
      $topic_tasks_new         = isset($tasks_new['sorting'])?$tasks_new['sorting']:"";
      $CourseDetails = "";
      if(!$response['success']) {
          Session::put('user_data', $response['message']);
          return redirect('/');
      }
      $topic_tasks = $response['result'];
      $one = "";
      $two = "";
      foreach ($tasks_new['tasks'][0]['practise'] as $key => $value) {
        if($value['id'] == $practiceId){
          $one   = isset($value['mark'])?$value['mark']:"0";
          $two    = $value['marks_gained'];
          Session::put('totalMark', isset($value['mark'])?$value['mark']:"0");
          Session::put('markGained', $value['marks_gained']);
        }
      }
      return view('work-record.topic-index', compact('topic_tasks', 'topicId', 'taskId', 'practiceId' ,'CourseDetails','topic_tasks_new','taskIdNew','tasks_new','one','two'));
    }
    public function topic_aim_new(Request $request, $topicId = '', $taskId = '') {
        $sessionAll = Session::all();
        if(!isset($sessionAll['user_data']) || empty($sessionAll['user_data'])){
            return redirect('/');
        }
        if(!isset($topicId) || empty($topicId)){
            return redirect('/');
        }
        if(Session::get('course_id_new')==""){
           return redirect('/');
        }
        $request = array();
        $request['student_id']        =   Session::get('user_id_new');
        $request['token_app_type']    =   'ieuk_new';
        $request['token']             =   Session::get('token');
        $request['course_id']         =   Session::get('course_id_new');//isset(Session::get('course_id_new'))?Session::get('course_id_new'):'';
        $request['level_id']          =   Session::get('level_id_new');
        $request['topic_id']          =   $sessionAll['topic_id_new'];
        if (isset($taskId) && !empty($taskId))
        {
            $request['task_id'] = $taskId;
        }
         $endPoint = "topic_list";
        //dd($request);
        $response = curl_get($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        $topic_tasks = $response['result'];
        $aim = $topic_tasks[0]['aim'];
        $aim = str_replace("<p></p>", "", $aim);
        $aim = str_replace("<p></p>", "", $aim);
        if(isset($taskId) && !empty($taskId))
        {
            $desc = '';
            if(isset($topic_tasks[0]['tasks'])){
              foreach ($topic_tasks[0]['tasks'] as $task)
              {
                  if ($task['id'] == $taskId)
                  {
                      $desc = '<h1>' . $task['name'] . '</h1>' . $task['description'] . '<style type="text/css">body{ background:none !important; }</style>';
                  }
              }
            }
            echo $desc;
            exit;
        }
        else
        {
            $aim = '<h1>AIM</h1>' . $aim . '<style type="text/css">body{ background:none !important; }</style>';
        }
        echo $aim;
    }
    public function topic_aim(Request $request, $topicId = '', $taskId = '') {
       $sessionAll = Session::all();
        if (!isset($sessionAll['user_data']) || empty($sessionAll['user_data'])) {
            return redirect('/');
        }
        if (!isset($topicId) || empty($topicId)) {
            return redirect('/');
        }
        if(Session::get('course_id_new')=="") {
           return redirect('/');
        }
        $request = array();
        $request['student_id']      =  Session::get('user_id_new');
        $request['token_app_type']  =  'ieuk_new';
        $request['token']           =  Session::get('token');
        $request['course_id']       =  Session::get('course_id_new');//isset(Session::get('course_id_new'))?Session::get('course_id_new'):'';
        $request['level_id']        =  Session::get('level_id_new');
        $request['topic_id']        =  $sessionAll['topic_id_new'];
        if (isset($taskId) && !empty($taskId)){
            $request['task_id'] = $taskId;
        }
        $endPoint = "topic_list_new";
        $response = curl_get($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        $topic_tasks = $response['result'];
        $aim = $topic_tasks[0]['aim'];
        $aim = str_replace("<p></p>", "", $aim);
        $aim = str_replace("<p></p>", "", $aim);
        if(isset($taskId) && !empty($taskId)){
            $desc = '';
            if(isset($topic_tasks[0]['tasks'])){
              foreach ($topic_tasks[0]['tasks'] as $task){
                  if ($task['id'] == $taskId){
                      $desc = '<h1>' . $task['name'] . '</h1>' . $task['description'] . '<style type="text/css">body{ background:none !important; }</style>';
                  }
              }
            }
            echo $desc;
            exit;
        }else{
            $aim = '<h1>AIM</h1>'.$aim.'<style type="text/css">body{ background:none !important; }</style>';
        }
        echo $aim;
    }
}
