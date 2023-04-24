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
use Illuminate\Support\Arr;
class PracticeAnkilController extends Controller{
    public function saveDrawImageWritingEmail(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['is_file'] = true;
        $img = str_replace('data:image/png;base64,', '', $request['image_get']);
        $image_get = str_replace(' ', '+', $img);
        $request_payload['user_answer'][0]['path']  = $image_get;
        $request_payload['user_answer'][0]['text_ans'][0] = $request['text_ans'];
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveRecordVideo(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $request['text_ans'];
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveSingleTickReading(Request $request){
        $request = $request->all();
        $finalAns = [];
        $first = array("",$request['question_new'][1][0]);
        $second = array("",$request['question_new'][1][1]);
        $third = array("",$request['question_new'][1][2]);
        $four = array();
        $five = array($request['question_new'][0][4],$request['question_new'][1][4]);
        $six = array();
        $seven = array($request['question_new'][0][6]);
        $finalAns = [$first,$second,$third,$four,$five,$six,$seven];
        $array = array();
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] =$finalAns;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveSingleTickReadingDiff(Request $request) {
        $request = $request->all();
        $finalAns = [];
        $ans = [];
        if(isset($request['checked'])){
            if($request['checked'] == "Incorrect"){
                $ans[0]['name'] = "Correct";
                $ans[0]['checked'] = false;
                $ans[1]['name'] = "Incorrect";
                $ans[1]['checked'] = true;
            }else{
                $ans[0]['name'] = "Correct";
                $ans[0]['checked'] = true;  
                $ans[1]['name'] = "Incorrect";
                $ans[1]['checked'] = false;
            }
        }
        $array = array();
        $finalAns[0] =$ans; 
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] =$finalAns;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveSingleTickSpeaking(Request $request){
        $request = $request->all();
        $dataArray = [];
        $ans = [];
        foreach($request['question'] as $key=>$value){
            if(isset($request['checkBox'][0])){
                if($value == $request['checkBox'][0]){
                    $ans = true;
                }else{
                    $ans = false;
                }
            }else{
                $ans = false;
            }
            $dataArray['text_ans'][] = [
                'name' => $value,
                'checked' => $ans,
            ];
        }
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            if($request['audio_single'] == "blank"){
                $encoded_data = "blank";
            }
            $user_ans[0]['path']=$encoded_data;
        } else {
            $encoded_data = "";
            if($request['audio_single'] == "blank"){
                $encoded_data = "blank";
            }
        }
        $is_file = checkAudioFileExists(Session::get('user_id_new'),$request['practise_id']);
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        $request_payload['user_answer'][0] = $dataArray;
        $request_payload['user_answer'][0]['path'] = $encoded_data;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveTrueFalseSimple(Request $request){
        $request = $request->all();
        $user_ans=array();
        $encoded_data ="";
        if($request['practice_type']=='true_false_simple'){
          $user_ans[0]  = $request['text_ans'];
        }
        foreach($request['text_ans'] as $key=>$data) {
            if(!array_key_exists("true_false",$data)) {
                $request['text_ans'][$key]['true_false'] = "-1";            
            }
        }
        $user_ans[0]  = $request['text_ans'];
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');    
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'] = $user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        if(!empty($encoded_data)){
          $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveTrueFalseSymbol(Request $request){
        $request = $request->all();
        $user_ans=array();
        $encoded_data ="";
        if($request['practice_type']=='true_false_symbol'){
            foreach ($request['text_ans'] as $key => $value) {
              $answer[$key]['question'] = $value['question'].' '.$value['answer'].' @@';
              $answer[$key]['true_false'] =isset($value['true_false'])?$value['true_false']:-1;
            }
            $user_ans[0]  = $answer;
        }
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'] = $user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        if(!empty($encoded_data)){
            $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveTrueFalseWritingAtEndSelectOption(Request $request){    
        $request = $request->all();
        $user_ans=array();
        foreach($request['text_ans'] as $key=>$value){
            if(Arr::exists($value, 'true_false')){
                $true_false =  $value['true_false'];
            }else{
                $true_false =  -1;
            }
            if(Arr::exists($value, 'text_ans')){
                $text_ans = (string) $value['text_ans'];
            }else{
                $text_ans =  "";
            }
            if(Arr::exists($value,'ans')){
                $ans =  $value['ans'];
                $ans_pos = (string) $value['ans']-1;
            }else{
                $ans =  -1;
                $ans_pos = -1;
            }
            $text_ans= str_replace("<div>","\r\n",$text_ans);
            $text_ans= str_replace("<br>","\r\n",$text_ans);
            $text_ans= str_replace("</div>","",$text_ans);
            $text_ans= str_replace("&nbsp;"," ",$text_ans);
            $user_ans[$key] = [
                'question' => $value['question'],
                'true_false' => $true_false,
                'text_ans' => $text_ans,
                'ans' => $ans,
                'ans_pos' => $ans_pos
            ];
        }
        $encoded_data ="";
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'][0] =$user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        if(!empty($encoded_data)){
            $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);

        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveTrueFalseWritingAtEndAllSymbol(Request $request){
        $request = $request->all();
        $user_ans=array();
        foreach($request['text_ans'] as $key=>$value){
            if(Arr::exists($value, 'true_false')){
                $true_false =  $value['true_false'];
            }else{
                $true_false =  0;
            }
            if(Arr::exists($value, 'text_ans')){
                $ans= str_replace("&nbsp;"," ",$value['text_ans']);
                $text_ans = (string) $ans;
            }else{
                $text_ans =  "";
            }
            $user_ans[] = [
                'question' => $value['question'],
                'true_false' => $true_false,
                'text_ans' => $text_ans,
            ];
        }
        $pointsAns[0] = $request['points_ans'];
        $encoded_data ="";
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'][0] =$user_ans;
        $request_payload['user_answer'][1] =$pointsAns;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        if(!empty($encoded_data)){
            $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveSpeakingUpOption(Request $request){
        $request = $request->all();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            $user_ans[0]['path']=$encoded_data;
        } else {
            $encoded_data ="";
        }
        $is_file = checkAudioFileExists(Session::get('user_id_new'), $request['practise_id']);
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        if(isset($request['speaking_up_option']) && $request['speaking_up_option'] == "blank"){
            $request_payload['user_answer'][] = "blank";
            $request_payload['is_file']  = true;
        }else{
            $request_payload['user_answer'][0] = $is_file;
        }
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveHideShowAnswer(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $encoded_data = "";
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id']  = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']  = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        if(!empty($encoded_data)){
            $request_payload['is_file'] = !empty($encoded_data) ? true : false;
        }
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveImageWritingAtEndUp(Request $request){
        $request = $request->all();
        $user_ans=array();
        if($request['practice_type'] == 'underline_text_speaking_at_end') {
            $user_ans[0][0] =  $request['text_ans'][0][0];
            foreach ($request['text_ans'][0][1] as $key => $value) {
                $underline=array();
                foreach ($value as $k => $v) {
                    $underline[$v['i']]['i'] = $v['i'];
                    $underline[$v['i']]['fColor'] = (int)$v['fColor'];
                    $underline[$v['i']]['foregroundColorSpan']['mColor'] =(int) $v['foregroundColorSpan'];
                    $underline[$v['i']]['word'] = $v['word'];
                    $underline[$v['i']]['start'] =(int) $v['start'];
                    $underline[$v['i']]['end'] = (int)$v['end'];
                }
                $user_ans[0][1][$key]  =json_encode($underline,JSON_FORCE_OBJECT);
            }
        } else {
            foreach ($request['text_ans'][0][0] as $key => $value) {
                foreach ($value as $k => $v) {
                    if($k=='word'){
                        $underline[$key][$k] = $v;
                    } else if($k=='foregroundColorSpan'){
                        $underline[$key][$k] = array('mColor'=> (int)$v);
                    }else{
                        $underline[$key][$k] = (int) $v;
                    }
                }
            }
            $user_ans[] = array( array(json_encode($underline)) );
        }
        $topicId = $request['topic_id'];
        $user_ans[1]="##";
        $user_ans[2]="";
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'] =$user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveImageWritingAtEndUpNew(Request $request){
        $request = $request->all();
        if(isset($request['is_roleplay'])) {
            if(isset($request['writeingBox'][0])){
                  $user_ans[0][0] = $request['writeingBox'][0];
            }else{
                $user_ans[0] = "";
            }
            $user_ans[1] = "##";
            if(isset($request['writeingBox'][1])){
                $user_ans[2][0] = $request['writeingBox'][1];
            }else{
                $user_ans[2] = "";
            }
        } else {
            $user_ans[0] = $request['writeingBox'];
        }
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'] =$user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveConversationSimpleMultiBlankNoSubmit(Request $request) {
        $request = $request->all();
        $is_file = false;
        $user_ans = '';
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['user_answer'] = $user_ans;
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        if(!empty($request['is_roleplay'])){
          $request_payload['is_roleplay'] = true;
        }
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }
        if($is_file){
          $request_payload['is_file'] = true;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
}
