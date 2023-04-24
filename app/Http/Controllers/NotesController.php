<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class NotesController extends Controller {
    public function downloadvocabulary_pdf() {
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        
        $endPoint = "vocablist";
        $response = curl_get($endPoint, $request);
        if (!$response['success']) {
            $response['result'] = array();
        }
        $vocablist = $response['result'];
        $endPoint = "vocabtopiclist";
        $response = curl_get($endPoint, $request);
        if (!$response['success']) {
            $response['result'] = array();
        }
        $vocabtopiclist = $response['result'];
        $pdf = PDF::loadView('dashboard.downloadvocabulary_pdf',compact('vocablist' ,'vocabtopiclist'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('vocabulary.pdf');
    }
    public function downloadnotes_pdf(Request $request) {   
        $request_data = $request;
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $request['course_id'] = $request_data['course_id'];
        $request['level_id'] = $request_data['level_id'];
        $request['topic_id'] = $request_data['topic_id'];
        $request['task_id'] = $request_data['task_id'];
        $request['skill_id'] = $request_data['skill_id'];
        $request['search'] = $request_data['search'];
        $endPoint = "individual_notelist";
        $response = curl_get($endPoint, $request);
        if (!$response['success']) {
           $response['result'] = array();
        }
        $notes = $response['result'];
        $pdf = PDF::loadView('dashboard.downloadnotes_pdf',  compact('notes'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('notes.pdf');
    }
    public function notes(Request $request) {
        if(Session::get('user_id_new')==""){
            return redirect('/');
        }
        $request1        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
        $endPoint       = "individual_course_topic_list_new";
        $data           = curl_get($endPoint, $request1);
        if(isset($data['invalid_token']) && $data['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$data['message']); 
        }
        $onlyCourse     = $data['new_result'];
        $student_id = Session::get('user_id_new');
        $token_ieuk =  Session::get('token');
        if(isset($request->delete_note) && !empty($request->delete_note)){
            $noteId = $request->delete_note;
            $request = array();
            $request['student_id'] = Session::get('user_id_new');
            $request['token_app_type'] = 'ieuk_new';
            $request['token'] = Session::get('token');
            $request['noteid'] = $noteId;
            $endPoint = "individual_notedelete_new";
            $response = curl_get($endPoint, $request);
            \Cache::forget('notelist'.$student_id);
            if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
            }elseif(isset($response['success']) && !$response['success']){
                return response()->json(['success'=>false,'message'=>$response['message']], 200);
            }elseif(isset($response['success']) && $response['success']){
                Session::flash('alert-success', $response['message']);
                return response()->json(['success'=>true,'message'=>$response['message']], 200);
            }
        }
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $endPoint = "individual_notelist_new"; // newapi
        $response = curl_get($endPoint, $request);
        $instration = isset($response['page_info'])?$response['page_info']:'';
        if (!$response['success']) {
            $response['result'] = array();
        }
        $notes = $response['result'];
        $skillsdata = \Cache::get('skilldata');
        return view('dashboard.notes', compact('notes','skillsdata','onlyCourse','instration'));
    }
    public function note_post(Request $request) {
        $params = $request->all();
        $request = array();
        if(!isset($params['title']) || empty($params['title'])){
            return response()->json(['success'=>false,'message'=>'Please add title.'], 200);
        }
        if(!isset($params['description']) || empty($params['description'])){
            return response()->json(['success'=>false,'message'=>'Please add description.'], 200);
        }
        if(!isset($params['course_id']) || empty($params['course_id'])){
            return response()->json(['success'=>false,'message'=>'Please select course.'], 200);
        }
        if(!isset($params['level_id']) || empty($params['level_id'])){
            return response()->json(['success'=>false,'message'=>'Please select level.'], 200);
        }
        if(!isset($params['topic_id']) || empty($params['topic_id'])){
            return response()->json(['success'=>false,'message'=>'Please select topic.'], 200);
        }
        if(!isset($params['task_id']) || empty($params['task_id'])){
            return response()->json(['success'=>false,'message'=>'Please select task.'], 200);
        }
        if(!isset($params['skill_id']) || empty($params['skill_id'])){
            return response()->json(['success'=>false,'message'=>'Please select skill.'], 200);
        }
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $request['title'] = $params['title'];
        $request['description'] = $params['description'];
        $request['course_id'] = $params['course_id'];
        $request['level_id'] = $params['level_id'];
        if(isset($params['note_id']) && !empty($params['note_id'])){
            $request['noteid'] = $params['note_id'];
            \Cache::forget('notelist'.Session::get('user_id_new'));    
        }
        $request['topicid'] = $params['topic_id'];
        $request['taskid'] = $params['task_id'];
        $request['skillid'] = $params['skill_id'];
        $endPoint = "individual_addnote_new";
        Session::put('course_id', $params['course_id']);
        \Cache::forget('notelist'.Session::get('user_id_new'));
        $response = curl_post($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            Session::flash('alert-success', $response['message']);
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
}
    
