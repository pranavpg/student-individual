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
        $endPoint           = "course_task_list";
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
            $endPoint                           = "topic_list_new";
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
            if(isset($request['n'])) {
                $is_feedback_practice = $this->checkpractice_feedback($request['n']);
                if($is_feedback_practice) {
                    $feedbackRequest = array();
                    $feedbackRequest['token_app_type']    = 'ieuk_new';
                    $feedbackRequest['token']             = Session::get('user_id_new');
                    $feedbackRequest['topic_id']          = $topicId;
                    $feedbackRequest['type']              = 'task_type';
                    $feedbackRequest['student_id']        =  Session::get('user_id_new'); 
                    $feedbackRequest['screen_name']       = '';
                    $endPoint                             = "get-course-feedback_new";
                    $feedback                             = curl_post($endPoint,$feedbackRequest);
                    if(isset($feedback['invalid_token']) && $feedback['invalid_token']){
                        \Session::flush();
                        return redirect('/')->with('message',$feedback['message']); 
                    }
                    $feedbackExits = isset($feedback['feedbackExits'])?$feedback['feedbackExits']:true;
                }
            }else {
                $feedbackExits   = false;
                if($pcount == 1) {
                    $is_feedback_task  =  $this->checktask_feedback($taskId);
                    if($is_feedback_task){
                        $feedbackRequest = array();
                        $feedbackRequest['token_app_type']    = 'ieuk_new';
                        $feedbackRequest['token']             = Session::get('token');
                        $feedbackRequest['topic_id']          = $topicId;
                        $feedbackRequest['type']              = 'task_type';
                        $feedbackRequest['student_id']        = Session::get('user_id_new'); 
                        $feedbackRequest['screen_name']       = '';
                        $endPoint                             = "get-course-feedback_new";
                        $feedback                             = curl_post($endPoint,$feedbackRequest);
                        if(isset($feedback['invalid_token']) && $feedback['invalid_token']){
                            \Session::flush();
                            return redirect('/')->with('message',$feedback['message']); 
                        }

                        $feedbackExits = isset($feedback['feedbackExits'])?$feedback['feedbackExits']:true;
                    }
                }
            }
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
    public function checktask_feedback($task_id){
      $tasks = array("5c52d8ccb0dace55261b4cda","5c2c92a0b0dace7ca17f4cb3","5c52d8c9b0dace57991ebde5","5cbf147db0dace6ff31a7226","5cc03821b0dace03a1046be2","5c6e2957b0dace72205ed357","5c6e2a85b0dace77122380a3","5c6e3cfcb0dace04e44c5bd6","5c6e3e1fb0dace72205ed35c","5c6e764fb0dace07d7584a65","5c6e7bc1b0dace0bba26cef2","5cc05d80b0dace07fb469033","5cc06d8bb0dace07e213d2d2","5cc16e35b0dace192c556752","5cc17077b0dace192d76f5c2","5cc1e8e6b0dace21681172f8","5cc1f917b0dace230001ef52","5c91d3f4b0dace5b29367bb3","5c91d9ecb0dace5f28069af5","5c91f5eeb0dace6f0147f037","5c91f6a2b0dace704c2c7242","5c946154b0dace1ff7052013","61d034d0788c464ab6354cc2","5cc6833cb0dace5c4e10cf42","5cc684f5b0dace630c14b5d2","5cc6e104b0dace74a9503702","5cc6e38ab0dace735f3aaed3","5cc72806b0dace7b8d37a3a3","5cc72a33b0dace7c1245c9a2","5c810024b0dace65ad305283","5c81028db0dace651057b376","5c812257b0dace666744b2d6","5c812531b0dace665053a693","5c820bd5b0dace79c1534a44");
        if(in_array($task_id, $tasks)){
            return true;
        }else{
            return false;
        }
    }
    public function checkpractice_feedback($pid){
      $practices = array("15495346485c5c05b834de3","15560208725cbefe88d509c","15506480485c6d02f0c557a","15560273425cbf17ce65605","15561019245cc03b24dc70a","15566176905cc819da7a184","15566223575cc82c15ca4f7","15567075755cc978f7e9b16","15567082275cc97b8388124","15632974585d2e06b28c6e8","15567380935cc9f02d9580c","15561147745cc06d56382d7","15561154335cc06fe9e160c","15561810705cc1704e5c136","15561818125cc17334216f7","15562693345cc2c916b815e","15562700045cc2cbb4ac746","15567977835ccad9574b164","15568298995ccb56cb10de9","15569680775ccd728dcf51b","15569685325ccd745473bed","15569564025ccd44f2e59a0","15577788175cd9d181053e8","15565139415cc68495bcb40","15565169995cc6908751c52","15565381515cc6e3277530f","15565386225cc6e4fe83e90","15565562805cc729f8ad94f","15716176115dacfb4bde054","15568118805ccb1068208b5","15568290575ccb538187a8d","15568828675ccc25b3523e8","15701008385d95d666955b8","15590583065ced57820e91b");
        if(in_array($pid,$practices)){
            return true;
        }else{
            return false;
        }
    }
}
