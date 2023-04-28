<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;
use Session;
use Storage;
use Auth;
use PDF;
class ProfileController extends Controller {
	public function index() {
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = array();
		$request['student_id'] =  Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] =  Session::get('token');
		$endPoint = "individual_student_details_new";
		$response = curl_get($endPoint,$request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
		$instration = isset($response['page_info'])?$response['page_info']:'';
		$profile = $response['result'];
		$endPoint = "getcountry_new";
	   	$response = curl_get($endPoint, $request);
	   	if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
      	$countries = $response['result'];
       // dd($profile);
		return view('profile.index',compact('profile','countries','instration'));
    }
    public function contactUs(Request $request) {
    	$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$request['franchise_code'] = Session::get('franchise_code');
		$request['type'] = "student";
		//dd(json_encode($request));
		$endPoint = "individual_user_data";
		$response = curl_get($endPoint,$request);
		if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
		if(!$response['success']){
			$response['result'] = array();
		}
		$userdata = $response['result'];
		$ieuk_socialmedia = isset($response['ieuk_socialmedia'])?$response['ieuk_socialmedia']:"";
        return view('dashboard.contactus',compact('userdata','ieuk_socialmedia'));
    }
	public function update_profile(Request $request) {
		$filedata = [];
		if(!empty($request['file_data'])){
			$img = str_replace('data:image/jpeg;base64,', '', $request['file_data']);
			$filedata = str_replace(' ', '+', $img);
		}
		$requestPayLoad = array();
		$requestPayLoad = $request->all();
		$requestPayLoad['student_id'] 		= Session::get('user_id_new');
		$requestPayLoad['token_app_type'] 	= 'ieuk_new';
		$requestPayLoad['token'] 			= Session::get('token');
		$requestPayLoad['student_image']    = $filedata;
		$endPoint = "individual_updatestudent_new";
		$response = curl_post($endPoint,$requestPayLoad);
		if(empty($response)){
			return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200); 
		}elseif(isset($response['success']) && !$response['success']){
			return response()->json(['success'=>false,'message'=>$response['message']], 200); 
		}elseif(isset($response['success']) && $response['success']){
			Session::put('first_name', $request['firstname']);
            Session::put('last_name', $request['lastname']);
			return response()->json(['success'=>true,'message'=>"You have successfully updated your profile."], 200); 
		}
    }
	public function reset_password(Request $request) {
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$params = $request->all();
		$request = array();
		if(!isset($params['old_password']) || empty($params['old_password'])){
			return response()->json(['success'=>false,'message'=>'Please add current password.'], 200); 
		}
		if(!isset($params['new_password']) || empty($params['new_password'])){
			return response()->json(['success'=>false,'message'=>'Please add new password.'], 200); 
		}
		if(!isset($params['new_password_c']) || empty($params['new_password_c'])){
			return response()->json(['success'=>false,'message'=>'Please confirm new password.'], 200); 
		}
		if($params['new_password'] !== $params['new_password_c']){
			return response()->json(['success'=>false,'message'=>'Passwords do not match.'], 200); 
		}
		$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$request['old_password'] = $params['old_password'];
		$request['new_password'] = $params['new_password'];
		$endPoint = "individual_update_student_password";
		$response = curl_post($endPoint,$request);
		if(empty($response)){
			return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200); 
		}elseif(isset($response['success']) && !$response['success']){
			return response()->json(['success'=>false,'message'=>$response['message']], 200); 
		}elseif(isset($response['success']) && $response['success']){
			return response()->json(['success'=>true,'message'=>"You have successfully reset your password."], 200); 
		}
    }
    public function course() {
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$endPoint = "individual_course";
		$response = curl_get($endPoint,$request);
		if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
		if(!$response['success']){
			$response['result'] = array();
		}
		$instration = isset($response['page_info'])?$response['page_info']:[];
		$response = $response['result'];
		return view('profile.course',compact('response','instration'));
    }
    public function ilps() { 
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$request['type'] = "student";
		$endPoint = "individual_student_ilps_new";
		$response = curl_get($endPoint,$request);
		if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
		if(!$response['success']){
			$response['result'] = array();
		}
		$instration = isset($response['page_info'])?$response['page_info']:[];
		if(!$response['success']) {
            $response['result'] = array();
        }
        $student_ilps = $response['result'];
		$stdtname = "";
		$request        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint       = "individual_course_topic_list_new";
        $data     		= curl_get($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
        $onlyCourse     = $data['new_result'];
		$newArray = array();
		foreach($onlyCourse as $key => $data){
			$newArray[$key]['course_id'] = $data['course']['_id'];
			$newArray[$key]['course_name'] = $data['course']['coursetitle'];
			$newArray[$key]['levals']['courseid']  = $data['course']['_id'];
			$newArray[$key]['levals']['levalid']  = $data['level']['_id'];	
			$newArray[$key]['levals']['levalname']  = $data['level']['leveltitle'];	
		}
	    return view('profile.ilps',compact('student_ilps','stdtname','instration','onlyCourse','newArray'));
    }
    public function downloadilps_pdf() {
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$request['type'] = "student";	
		$endPoint = "individual_student_ilps_new";
		$response = curl_get($endPoint,$request);
		if(isset($response['invalid_token']) && $response['invalid_token']){
        	\Session::flush();
        	return redirect('/')->with('message',$response['message']); 
        }
		if(!$response['success']){
			$response['result'] = array();
		}
		if(isset($response['result'])){
			$student_ilps = $response['result'];
		}else{
			$student_ilps='';
		}
		if(isset($response['teacher_ilps'])){
			$teacher_ilps = $response['teacher_ilps'];
		}else{
			$teacher_ilps='';
		}
      	$pdf = PDF::loadView('profile.downloadilps_pdf',  compact('student_ilps','teacher_ilps'));
      	$pdf->setPaper('A4', 'landscape');  
      	return $pdf->download('ilps.pdf');
    }
	public function add_ilps(Request $request){
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = $request->all();
		foreach($request['ilpCheckbox'] as $key=>$value){
			$skillData = strtolower(str_replace(" ","",$value));
			if(isset($request['skill_'.$skillData])){
				$subSkilldata[$value]['values'] = $request['skill_'.$skillData];
			}
		}
		$requestPayLoad['student_id'] = Session::get('user_id_new');
		$requestPayLoad['skill_area'] = json_encode($subSkilldata);
		$requestPayLoad['course_id'] = $request['course_id'];
		$requestPayLoad['level_id'] = $request['level_id'];
		$requestPayLoad['what_did_you_do'] = $request['What_did_you_do'];
		$requestPayLoad['how_did_this_help'] = $request['How_did_this_help_you'];
		$requestPayLoad['comments'] = $request['comments'];
		$requestPayLoad['score'] = $request['ilp_rate'];
		$requestPayLoad['total_score'] = 10;
		$requestPayLoad['ilp_id']= $request['ilp_id'];
		$requestPayLoad['token_app_type'] = "ieuk_new";
		$requestPayLoad['token'] = Session::get('token');
		if($request['deleteilpFlag']!=""){
			$requestPayLoad['is_delete'] = "true";
		}
		if(!empty($request['is_delete']) && $request['is_delete']==1 ){
				$requestPayload["is_delete"] =true;
		}
		$endPoint = "individual_add_ilp_new";
		$response = curl_post($endPoint,$requestPayLoad);
		if(empty($response)){
			return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
		}elseif(isset($response['success']) && !$response['success']){
			return response()->json(['success'=>false,'message'=>$response['message']], 200);
		}elseif(isset($response['success']) && $response['success']){
			return response()->json(['success'=>true,'message'=>$response['message']], 200);
		}
	}
	public function certificatedetails() {
		if(Session::get('user_id_new')==""){
			return redirect('/');
		}
		$request = array();
		$request['student_id'] = Session::get('user_id_new');
		$request['token_app_type'] = 'ieuk_new';
		$request['token'] = Session::get('token');
		$endPoint   =  "individual_portfolio_cron";
		$response = curl_get($endPoint,$request);
		$instration = isset($response['page_info'])?$response['page_info']:[];
	    $award_arg = array();
	    $award_by_id = array();
		if(!empty($response['student']['award_details'])) {
			foreach($response['student']['award_details'] as $key => $value) {
				$award_arg[$value['award_id']]   = $value['award_id']; 
				$award_by_id[$value['award_id']] = $value;           
			}
		}
	    $student_name =  isset($response['student']['firstname'])?$response['student']['firstname'].' '.$response['student']['lastname']:'';
		return view('profile.certificate1', compact('award_arg','award_by_id','student_name','instration'));
	}
	public static function checkCertificateStatus($string) {
		$return = false;
		if(!empty($string)) {
			$str = strtolower($string);	
			if($str == 'pending ieuk verification' || $str == 'ieuk pending verification' || $str == 'Pending IEUK Verification') {
				$return = true;
			}
		}
		return $return;
	}
	public function viewFeedback(Request $request) {
		$request_data['feedback_id'] = $request->feedback_id;
		$endPoint = 'view-feedback';
		$response = curl_post($endPoint,$request_data);
		return response()->json(['success'  => true,'html' => $response['html']]);
	}
}