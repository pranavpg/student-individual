<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Infrastructure\ServiceResponse;
use Session, Response;
class StudentWorkRecordController extends Controller{
    public function GetJsonResponse($serviceResponse,$code = 200){
       $jsonResponse = Response::make(json_encode($serviceResponse), $code);
       $jsonResponse->header('Content-Type', 'application/json');
       return $jsonResponse;
    }
    public function getExcercise(Request $request) {
        $studentID                  =  Session::get('user_id_new');
        $curlData                   = array();
        $curlData['token']          = Session::get('token');
        $curlData['token_app_type'] = 'ieuk_new';
        $curlData['student_id']     = $studentID;
        $curlData['course_id']      = $request['couseId'];
        $curlData['level_id']       = $request['levelId'];
        $curlData['filter']         = $request['taskS'];
        //$endPoint                   = "student-work-records-new";
        // dd(json_encode($curlData));
        $endPoint                   = "individual-student-work-records-new"; 
        $records                    = curl_get($endPoint, $curlData);
        // dd($records);
        echo \View::make('work-record.table_view',compact('records'))->render();
    }
    public function work(Request $request) {
        if(Session::get('user_id_new')==""){
            \Session::flush();
           return redirect('/');
        }
        $request                    = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint                   = "individual_student_course";
        $coursesDataList            = curl_get($endPoint, $request);
        return view('work-record.work-record', compact('coursesDataList'));
    }
    public function ajaxView(Request $request){
        $sessionAll                     = Session::all();
        $request1                       = array();
        $request1['student_id']         = $sessionAll['user_id_new'];
        $request1['token_app_type']     = 'ieuk_teacher';
        $request1['token']              = $sessionAll['token'];
        $request1['course_id']          = $request['course'];
        $request1['level_id']           = $request['level'];
        $request1['task_id']            = $request['taskId'];
        $request1['practice_id']        = $request['practice_id'];
        $request1['flag']               = 1;
      //  $endPoint                       = "work_record_data";
        $endPoint                       = "individual_work_record_data";
        $response                       = curl_get($endPoint, $request1);
        $data                           = $response['result'];
        $count                          = $response['total_count'];
        $tabs                           = $response['tabs'];
        $markingmethods                 = $response['markingmethod'];
        $teacherBook                    = isset($data['teacherbook'][0]['teacherbookdescription'])?$data['teacherbook'][0]['teacherbookdescription']:[];
        $courseBook                     = isset($data['description'])?$data['description']:[];
        $taskId                         = $request['taskId'];
        $topicId                        = "";
        $flag_for_tab                   = $request['flag_for_tab'];
        echo \View::make('work-record.marking_view',compact('teacherBook','courseBook','taskId','topicId','markingmethods','count','flag_for_tab','tabs'))->render();
    }
    public function getpractise(Request $request) {
        $sessionAll   = Session::all();
        $request1     = array();
        $request1['student_id']       = $request['studenId'];
        $request1['token_app_type']   = 'ieuk_teacher';
        $request1['token']            = $sessionAll['token'];
        $request1['course_id']        = $request['course'];
        $request1['level_id']         = $request['level'];
        $request1['task_id']          = $request['taskId'];
        $request1['practice_id']      = $request['practice_id'];
        $request1['flag']             = $request['flag'];
        $endPoint                     = "single_practice";
        $response                     = curl_get($endPoint, $request1);
        $practises                    = $response['result']['practise'];
        $taskId                       = $request['taskId'];
        $topicId                      = "";
        echo \View::make('work-record.practise_view',compact('practises','taskId','topicId'))->render();
    }
    public static function checkRequestData($params,$request_data){
        $response = '';
        if(is_array($params)){
            if(!empty($request_data)){
                foreach($params as $value){
                    if(!empty($request_data[$value])){
                        $response = 'SUCC100';
                    }else{
                        $response = ucfirst($value)." field missing";
                        break;
                    }
                }
            }else{
                $response = "You have not pass any data";
            }
        }else{
            $response = "Request data is not in array";
        }
        return $response;
    }
    public function index(){
        $taskIds   =  $topicIds = $courses = [];
        $studentID =  Session::get('user_id_new');
        if(empty($studentID)) {
             Session::forget('user_id_new');
             return redirect('/');
        }
        $curlData = array();
        $curlData['token'] =  Session::get('token');
        $curlData['token_app_type'] =  'ieuk_new';
        $curlData['student_id'] = $studentID;
        $endPoint = "student-courses";
        $curlResponse = curl_post($endPoint, $curlData);
        if(isset($curlResponse['invalid_token'])){
            $this->commonRedirect($curlResponse);
        }
        if(!empty($curlResponse['IsSuccess'])){
            $courses = $curlResponse['Data']['web'];
        }
        $endPoint = "student-work-details";
        $curlResponse = curl_post($endPoint, $curlData);
        if(isset($curlResponse['invalid_token'])){
            $this->commonRedirect($curlResponse);
        }
        if(!empty($curlResponse['IsSuccess'])){
            $topicIds = $curlResponse['Data']['topicIds'];
            $taskIds = $curlResponse['Data']['taskIds'];
        }
        $instration = isset($curlResponse['Data']['page_info'])?$curlResponse['Data']['page_info']:[];
        return view('work-record/index-new',[
            'courses'    => $courses,
            'taskIds'    => $taskIds,
            'topicIds'   => $topicIds,
            'instration' => $instration
        ]);
    }
    public function ajaxList(Request $request){
        $response = new ServiceResponse();
        $reqData = $request->all();
        $checkFields = array('course_id');    
        $checkRequiredField = $this->checkRequestData($checkFields,$reqData);
        
        if($checkRequiredField == 'SUCC100'){
            $reqData = $request->all();
            $courseId = $reqData['course_id'];
            $studentID =  Session::get('user_id_new');
            $pageIndex = !empty($reqData['page']) ? $reqData['page'] : 1;
            $limit = 5;
            $offset = $pageIndex - 1;
            $curlData = array();
            $curlData['student_id'] = $studentID;
            $curlData['token'] =  Session::get('token');
            $curlData['token_app_type'] =  'ieuk_new';
            $curlData['course_id'] = $courseId;
            $curlData['limit'] = $limit;
            $curlData['offset'] = $offset;
            if(!empty($reqData['mark_filter'])){
                $curlData['mark_filter'] = $reqData['mark_filter'];
            }
            if(!empty($reqData['task_sorting'])){
                $curlData['task_sorting'] = $reqData['task_sorting'];
            }
            if(!empty($reqData['topic_sorting'])){
                $curlData['topic_sorting'] = $reqData['topic_sorting'];
            }
            if(!empty($reqData['teacher_review'])){
                $curlData['teacher_review'] = $reqData['teacher_review'];
            }
            if(!empty($reqData['student_review'])){
                $curlData['student_review'] = $reqData['student_review'];
            }
            $endPoint = "student-work-records";
            $curlResponse = curl_post($endPoint, $curlData);
            if(isset($curlResponse['invalid_token'])){
                $this->commonRedirect($curlResponse);
            }
            $total = [];
            if(!empty($curlResponse['IsSuccess'])){
                $practiseAnswers = $curlResponse['Data'];
                $total = $curlResponse['total'];
            }
            $response->IsSuccess = true; 
            $response->Data = !empty($practiseAnswers) ? $practiseAnswers : []; 
            $response->total = !empty($total) ? $total : []; 
        }else{
            $response->Message = $checkRequiredField;
        }
        return $this->GetJsonResponse($response);
    }
    public function getTaskPractise(Request $request){
        $response = new ServiceResponse();
        $reqData = $request->all();
        $checkFields = array('topic_id','task_id');    
        $checkRequiredField = $this->checkRequestData($checkFields,$reqData);
        if($checkRequiredField == 'SUCC100'){
            $reqData = $request->all();
            $topicId = $reqData['topic_id'];
            $taskId = $reqData['task_id'];
            $sessionData = Session::all();
            $studentID = $sessionData['user_id_new'];
            $curlData = array();
            $curlData['student_id'] = $studentID;
            $curlData['topic_id'] = $topicId;
            $curlData['task_id'] = $taskId;
            $endPoint = "student-task-practise";
            $curlResponse = curl_post($endPoint, $curlData);
            if(isset($curlResponse['invalid_token'])){
                $this->commonRedirect($curlResponse);
            }
            if(!empty($curlResponse['IsSuccess'])){
                $practiseAnswers = $curlResponse['Data'];
            }
            $response->IsSuccess = true; 
            $response->Data = !empty($practiseAnswers) ? $practiseAnswers : []; 
        }else{
            $response->Message = $checkRequiredField;
        }
        return $this->GetJsonResponse($response);
    }
    public function commonRedirect($response){
        \Session::flush();
        return redirect('/')->with('message',$response['message']); 
    }
}
