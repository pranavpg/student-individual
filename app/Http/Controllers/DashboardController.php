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
use PDF;

class DashboardController extends Controller {
    public function index() {
        if(Session::get('user_id_new')!="") {
            $request        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
            $endPoint       = "student_courses";
            $data           = curl_get($endPoint, $request);
            if(isset($data['invalid_token']) && $data['invalid_token']){
                \Session::flush();
                return redirect('/')->with('message',$data['message']); 
            }
            if(Session::get('is_enrolled') == false OR Session::get('is_enrolled') == null)
            {
                   $request  = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
                   $endPoint = "individual_course_list";
                   $available_courses = curl_get($endPoint, $request);
                   return view('dashboard.purchase_courses', compact('request','available_courses'));
            }
            $onlyCourse     = $data['student_courses'];
            return view('dashboard.index', compact('onlyCourse'));
        }
        if(env('HIDE_FLAG') == "external"){
            return view('login.remove_login_info');
        }
        return view('login.login-new');
    }
    public function purchase_course()
    {
        $request = array(); 
        if(Session::get('user_id_new')!="") {
          $request  = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
          $endPoint = "individual_course_list";
          $available_courses = curl_get($endPoint, $request);
          return view('dashboard.purchase_courses', compact('request','available_courses'));
        }
        return view('login.login-new');
    }
    public function getTopicList(Request $request) {
        $coursid            = $request['coursid'];
        $expire_flag        = $request['expire_flag'];
        $level_id           = $request->level_id;
        $franchise_code     = Session::get('franchise_code');
        $topic_task_status  = Session::get('topic_task_status');
        $data               = array('level_id' => $level_id,'franchise_code' => $franchise_code,'topic_task_status' => $topic_task_status,'student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint           = "student_topics";
        $topics = curl_get($endPoint, $data);
        $request        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint       = "student_courses";
        $data           = curl_get($endPoint, $request);
        $onlyCourse     = $data['student_courses'];
        echo \View::make('login.topic_html',compact('topics','expire_flag','onlyCourse','coursid'))->render();
    }
    public function purchase(Request $request)
    {
         $params       = $request->all(); 
         $request      = array(); 
         $request['level_id']    =  $params['level_id'];
         $request['student_id']  =  Session::get('user_id_new');
         $request['token']       =  Session::get('token');
         $request['amount'] =  $params['total_price'];
         $request['token_app_type'] = 'ieuk_new';
         $request['email']  = "pranav.gev@yopmail.com";
         //array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
         $level_id = $params['level_id'];//dd($params);
         $endPoint       = "generate_payment_intent";
         $data           = curl_get($endPoint,$request);
    }
    public function register(Request $request)
    {
         return view('dashboard.register');
    }
    public function store(Request $request)
    {
        $endPoint = "student_registration";
        $request['token_app_type']  = 'ieuk_new';
        $request1 = array();
        $request1['title']     = $request['title'];
        $request1['firstname'] = $request['firstname'];
        $request1['lastname']  = $request['lastname'];
        $request1['email']     = $request['email'];
        $request1['password']  = $request['password'];
        $request1['country']   = $request['country'];
        $request1['token_app_type'] = 'ieuk_new';
        $student_registration  = curl_post($endPoint, $request1);
        // $student_info = array(
        //                              'franchisecode'  =>  'FZE3R',
        //                              'student_id'     =>  $student_id,
        //                              'email'          =>  strtolower($params['email']), 
        //                              'token'          =>  $newToken,
        //                              'token_app_type' =>  'ieuk_new',
        //                              'base_url'       =>  "https://s3.amazonaws.com/imperialenglish.co.uk/"
        //                          ); 
        if($student_registration['success'] == true OR $student_registration['success'] == 'true')
        {
              Session::put('franchise_name', isset($student_registration['student_record']['franchise_name'])?$student_registration['student_record']['franchise_name']:'');
              Session::put('franchise_code', $student_registration['student_record']['franchisecode']);
              Session::put('user_id_new', $student_registration['student_record']['student_id']);
              Session::put('first_name', $student_registration['student_record']['firstname']);
              Session::put('last_name', $student_registration['student_record']['lastname']);
              Session::put('token', $student_registration['student_record']['token']);
             return response()->json(['success' => true, 'message' => $student_registration['message']], 200);
        }
        else
        {
             return response()->json(['success' => false, 'message' => $student_registration['message']], 200);
        }
    }
    public function login_post_new(Request $request) {
        $profileStatus= ''; 
        $params = $request->all();
        $request = array();
        if (!isset($params['user_email']) || empty($params['user_email'])) {
            return response()->json(['success' => false, 'message' => 'Please add email.'], 200);
        }
        if (!isset($params['user_password']) || empty($params['user_password'])){ 
            return response()->json(['success' => false, 'message' => 'Please add password.'], 200);
        }
        $request['id'] = $params['user_email'];
        $email  = $params['user_email'];
        if (filter_var($params['user_email'], FILTER_VALIDATE_EMAIL)) {
            $email  = strtolower($params['user_email']);
        }
        $request['email']               = $email;
        $request['password']            = $params['user_password'];
        $request['token_login']         = true;
        $request['token_app_type']      = 'ieuk_new';
        $request['app_device_token']    = 'web';
        $request['device_type']         = 'web';
        $endPoint                       = "student_auth";
      //  dd(json_encode($request));
        $response                       = curl_post($endPoint, $request);
        // dd($response);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if(empty($response)) {
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try after some time.'], 200);
        }elseif (isset($response['success']) && !$response['success']) {
            return response()->json(['success' => false, 'message' => $response['message']], 200);
        }elseif (isset($response['success']) && $response['success']) {
          
            Session::put('franchise_name', isset($response['student_record']['franchise_name'])?$response['student_record']['franchise_name']:'');
            Session::put('franchise_code', $response['student_record']['franchisecode']);
            Session::put('user_id_new', $response['student_record']['student_id']);
            Session::put('first_name', $response['student_record']['firstname']);
            Session::put('last_name', $response['student_record']['lastname']);
            Session::put('token', $response['student_record']['token']);
            Session::put('topic_task_status', 'false');
            $logo_type_new      = isset($response['student_record']['logo_type'])?$response['student_record']['logo_type']:1;
            $logo_img_new       = (isset($response['student_record']['logo_img']) && $response['student_record']['logo_img']!="")?$response['student_record']['logo_img']:1;
            Session::put('logo_type_new', $logo_type_new);
            Session::put('logo_img_new', $logo_img_new);
            Session::put('is_enrolled', $response['student_record']['is_enrolled']);
            $is_enrolled  =  $response['student_record']['is_enrolled'];
            return response()->json(['success' => true, 'message' => "You have been successfully logged in",'is_enrolled' => $is_enrolled], 200);
        }
    }
    public function forgotpassword() {
        return view('login.forgotpassword');
    }
    public function doUpdateProfile(Request $request) {
        if(Session::get('user_id_new')==""){
            return redirect('/');
        }
        $request1 = array();
        $request1['student_id'] = Session::get('user_id_new');
        $request1['token_app_type'] = 'ieuk_new';
        $request1['token'] = Session::get('token');
        $request1['date_of_birth'] = $request['day'];
        $request1['ethnicity']=$request['ethnicity'];
        $request1['gender']=$request['gender'];
        $request1['employment_status']=$request['employmentstatus'];
        $request1['ability_status']=$request['abilitystatus'];
        $request1['address']=$request['address'];
        $request1['country']=$request['country'];
        $request1['state']=$request['state'];
        $request1['city']=$request['city'];
        $request1['post_code']=$request['zipcode'];
        $response = curl_post('updatestudent_new', $request1);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        return response()->json($response);
    }
    public function forgotpassword_post(Request $request) {
        $params = $request->all();
        $request = array();
        if (!isset($params['user_email']) || empty($params['user_email'])) {
            return response()->json(['success' => false, 'message' => 'Please add email.'], 200);
        }
        $request['email'] = $params['user_email'];
        $endPoint = "forgot_password";
        $response = curl_post($endPoint, $request);

        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        return response()->json(['success' => $response['success'], 'message' => $response['message']], 200);
    }
    public function doLogout() {
        if(Session::get('user_id_new') != null ){
            $data['token_login']        =   Session::get('token');
            $data['token_app_type']     = 'ieuk_new';
            $data['student_id']         = Session::get('user_id_new');
            $response = curl_post('logout', $data);
            Session::flush();
            return redirect('/');
        } else {
            Session::flush();
            return redirect('/');
        }
    }
    public function resetAnswer(Request $request) {
        $request_data['student_id']     = Session::get('user_id_new');
        $request_data['practise_id']    = $request['reset_practice_id'];
        $endPoint = "student-practice-delete";
        $response = curl_get($endPoint, $request_data);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }else{  
             return response()->json(['success'=>true,'message'=>'Done'], 200);
        }
    }
    public function getprogressreport() {
        if(Session::get('user_id_new')==""){
            return redirect('/');
        }
        $request = array();
        $request['student']      =   Session::get('user_id_new');  
        $request['level_id']     =   Session('level_id');
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $endPoint  = "studentprogress";
        $response = curl_post($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        $student_details = isset($response['student_details']) ? $response['student_details'] : array();
        $class_record    = isset($response['class_record']) ? $response['class_record'] : array();
        $course_progress_detail = array('total_submission'=>'', 'total_submission_pr'=>'', 'total_achievement'=>'', 'total_achievement_pr'=>'');
        if(isset($response['course_progress_detail'])){
             $course_progress_detail = $response['course_progress_detail'];
        }
        $progress_by_skill    = isset($response['progress_by_skill']) ? $response['progress_by_skill'] : array();
        return view('dashboard.progressreport',compact('student_details','class_record','course_progress_detail','progress_by_skill'));
    }
    public function student_progress(Request $request) {
        if(Session::get('user_id_new')){
            Session::forget('level_id');
            if(empty(Session::get('user_id_new'))) {
                 Session::flush();
                 return redirect('/');
            }
            Session::put('level_id', $_GET['level_id']);
            if(empty(Session('level_id'))) {
                return response()->json(['success' => false, 'message' => "report generated successfully"], 200);
            } else {
                return response()->json(['success' => true, 'message' => "please enter level id"], 200);
            }
        } else {
            $pageName="login_page";
            return view('login.login', compact('pageName'));
        }
    }
    public function porfolio_assessment(Request $request) {
        if(Session::get('user_id_new') != null ){
            $student_id = Session::get('user_id_new');
            $token_ieuk = Session::get('token');
            $request    =  array();
            $request['student_id']          = Session::get('user_id_new');
            $request['token_app_type']      = 'ieuk_new';
            $request['token']               = Session::get('token');
            $endPoint                       = "portfolio_new";
            $response2                      = curl_get($endPoint , $request);
            $instration                     = isset($response2['page_info'])?$response2['page_info']:[];
            $courses                        = $response2['result'];
            return view('dashboard.protfolioassessment',compact('courses','instration'));
        } else {
            $pageName="login_page";
            return view('login.login', compact('pageName'));
        }
    }
}
    
