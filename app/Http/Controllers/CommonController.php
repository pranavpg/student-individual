<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class CommonController extends Controller {
    public function saveReadingBlanksRoleplay(Request $request)
    {
          //dd($request['text_ans']);
          $new_arg  = array();
          $i = 0;
          $get_count    = count($request['text_ans']['ans'])-1;
          $get_position = $request['text_pos']['ans'];
           // dd($request['text_pos']['ans']);
          foreach($request['text_ans']['ans'] as $key => $value)
          {
                 foreach($value as $key1 => $val)
                 {
                    $new_arg[$i][0][$key1]['ans_pos'] = ($val == null OR $value == "")? "-1" : (int)$get_position[$key][$key1];
                    $new_arg[$i][0][$key1]['ans']     = $val;
                 }
                 if($get_count !== $key)
                 {
                    $i++;
                    $new_arg[$i] = "##";
                    $i++;
                 }
          }
        //--------------------------------------------------------------------
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $new_arg;
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
    public function gettopics(Request $request) {
        $request_data = array();
        $level_id           = $request->level_id;
        $key                = 'get_couser_by_topic_temp'.Session::get('user_id_new').$level_id;
        $value              = \Cache::get($key);
        if(empty($value)){
            $topicdatas = \Cache::remember($key, 60*60*12, function () use($level_id,$request){ 
                $data =        array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new','level_id'=> $level_id);
                $endPoint       = "course_topics";
                $topicdatas     = curl_get($endPoint, $data);
                return  $topicdatas['topic_list'];
            });
        }else{
            $topicdatas = \Cache::get($key);
        }
        return response()->json(['success'=>true,'data'=>$topicdatas], 200);
    }

      public function saveDrawImageWritingEmail(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id']  = Session::get('course_id_new');
        $request_payload['level_id']   = Session::get('level_id_new');
        $request_payload['topic_id']   = $request['topic_id'];
        $request_payload['task_id']  = $request['task_id'];
        $request_payload['practise_id']     = $request['practise_id'];
        $request_payload['save_for_later']  = true;
        $request_payload['is_save']  = ($request['is_save']==1) ? true : false;
        $request_payload['is_file']  = true;
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
    public function gettask(Request $request){
        $topic_id           = $request->topic_id;
        $key                = 'get_task_by_topic_name'.Session::get('user_id_new').$topic_id;
        $value              = \Cache::get($key);
        if(empty($value)){
            $taskname = \Cache::remember($key, 60*60*12, function () use($topic_id,$request){ 
                $data =  array('topic_id' => $topic_id,'student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
                $endPoint     = "course_task_list";
                $taskname     = curl_get($endPoint, $data);
                return  $taskname['topic_task_list'];
            });
        }else{
            $taskname = \Cache::get($key);
        }
        return response()->json(['success'=>true,'data'=>$taskname], 200);
    }
    public function functional_language(Request $request) {
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['page'] = 1;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $endPoint = "get-functional-language";
        $response = curl_get($endPoint, $request_payload);
        $topic = [];
        foreach($response['result'] as $data){
            $topic[$data['_id']]= $data['topic_name'];
        }
        $allData = $response['result'];
        $instration = isset($response['page_info'])?$response['page_info']:[];
        return view('dashboard.functionallanguage',compact('topic','allData','instration'));
    }
    public function profile(Request $request) {
        if(Session::get('user_id_new')==""){
            return redirect('/');
        }
        $data['ethnicity'] = [
            'White British',
            'White Irish',
            'Any other White Background',
            'Mixed White and Black Caribbean',
            'Mixed White and Black African',
            'Mixed White and Asian',
            'Any other Mixed Background',
            'Indian',
            'Pakistani',
            'Bangladeshi',
            'Any other Asian Background',
            'Caribbean',
            'African',
            'Any other Black Background',
            'Chinese',
            'Any Other Ethnic Group',
            'Not stated'
        ];
        $data['employment_status'] = [
            'Not Specified',
            'Full time student',
            'Employed full time',
            'Employed part time',
            'Unemployed and seeking work',
            'Unemployed and not seeking work',
            'Registered Unemployed-Seeking Work'
        ];
        $data['ability_status'] = [
          "Learner considers that they have a disability",
          "Learner consider that they don't have a disability",
          "No information provided"
        ];
        $endPoint = "getcountry_new";
        $response = curl_get($endPoint, $data);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        $countries = $response['result'];
        return view('login.profilecreate',compact('data','countries'));
    }
    public function getstate(Request $request){
        $request=$request->all();
        $endPoint = "getstate";
        $response = curl_post($endPoint,$request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        return response()->json($response);
    }
    public function getCities(Request $request){
        $request=$request->all();
        $endPoint = "getcity";
        $response = curl_post($endPoint,$request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        return response()->json($response);
    }
    
    // practiseAmitcontroller
    
    public function saveFourBlankTableSpeakingWriting(Request $request) {
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        $answer = array_chunk($answer,$request['table_type']);
        $trueFalseArray = $request['true_false'];
        $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
            foreach($ans as $kk=>$a){
                $ansKey = $kk + 1;
                $makeAnswerArray[$k]['col_'.$ansKey] = $a;
            }
        }
        $user_ans=array();
        $fileName = $request['audio_answer'];
        $encoded_data = "";
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            if($fileName!=""){
                $path = public_path('uploads/practice/audio/'.$fileName);
                $encoded_data = base64_encode(file_get_contents($path));
            }
            if(isset($request['four_blank_table_speaking_writing']) && $request['four_blank_table_speaking_writing']=="blank"){
                $encoded_data =  "blank";
            }
            $user_ans[0]['path']=$encoded_data;
            $is_file = true;
        } else {
            $encoded_data ="";
            $is_file = false;
        }
        $user_ans[0]['text_ans'][] = array($makeAnswerArray, $trueFalseArray); //$trueFalseArray;
        $request['block']= str_replace("<div>","\r\n",$request['block']);
        $request['block']= str_replace("<br>","\r\n",$request['block']);
        $request['block']= str_replace("</div>","",$request['block']);
        $request['block']= str_replace("&nbsp;"," ",$request['block']);
        $user_ans[0]['text_ans'][1] = array($request['block']);
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
        $request_payload['is_file'] = $encoded_data !== "" ? true : false;
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
    public function saveMultiChoiceQuestionSpeakingUp(Request $request) {
        $userAnswer = array();
        foreach($request['user_default_answer'] as $key=> $item) {
            if(isset($request['user_answer']) && isset($request['user_answer'][$key]) && !empty($request['user_answer'][$key])){
                $currentAnswer= explode("@@",$request['user_answer'][$key]);
                $userAnswer[$key]['ans_pos']=$currentAnswer[0];
                $userAnswer[$key]['ans']=$currentAnswer[1];
            }else{
                $userAnswer[$key]['ans_pos']=-1;
                $userAnswer[$key]['ans']=null;
            }
        }
        $i=0;
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            if(isset($request['audio_reading']) && $request['audio_reading']=="blank"){
                $encoded_data =  "blank";
            }
        } else {
            $encoded_data =  "";
            if(isset($request['audio_reading']) && $request['audio_reading']=="blank"){
              $encoded_data =  "blank";
            }
        }
        $user_ans[0]['text_ans']= $userAnswer;
        $user_ans[0]['path']=$encoded_data;
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
        $request_payload['is_file'] = ($encoded_data == "") ? false : true;
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveListeningSpeaking(Request $request){
        $request = $request->all();
        $user_ans=array();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            $user_ans[0]['path']=$encoded_data;
        } else {
            $encoded_data ="";
        }
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        $request_payload['user_answer'] = "";
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
    public function savesingleTickWriting(Request $request){
        $userAnswer = array();
        $i=0;
        foreach($request['question'] as $question) {
            if(in_array($question,$request['checkBox'])){
                $userAnswer[$i]['name']=$question;
                $userAnswer[$i]['checked']=true;
            } else{
                $userAnswer[$i]['name']=$question;
                $userAnswer[$i]['checked']=false;
            }
            $i++;
        }
       $user_ans[0]= $userAnswer;
       if(isset($request['text_ans'])) {
          $temp = str_replace( "<br>", "\n", $request['text_ans']);
          $temp = str_replace( "</div>", "\n",  $temp);
          $temp = str_replace( "&nbsp;", " ", $temp);
          $user_ans[1] = array(strip_tags($temp));
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
       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }
    public function saveReadingTotalBlanksSpeakingUp(Request $request){
        $request = $request->all();
        $user_ans=array();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            $user_ans[0]['path']=$encoded_data;
        } else {
            $encoded_data ="";
        }
        $answers = $request['text_ans'];
        if(count($answers) > 0) {
            foreach($answers as $key=> $ans) {
                $temp_ans_pos = $ans['ans_pos'] == null ? -1 : (int)$ans['ans_pos'];
                $temp_ans     = $ans['ans'] == null ? "" : $ans['ans'];
                $temp[$key]   = array('ans_pos'=>(int)$temp_ans_pos, 'ans'=>$temp_ans);
            }
        }
        $user_ans[0] = $temp;
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
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
    public function saveMatchAnswerWriting(Request $request){
        $request = $request->all();
        $is_file = false;
        foreach($request['text_ans'] as $k=>$v) {
            $ans[$k] = is_null($v) ? " ": $v;
        }
        $userans  = implode(';', $ans).';';
        $user_ans[0] = $userans;
        $user_ans[1] = array( isset($request['text_ans_block']) ? $request['text_ans_block'] : "" );
        $response =  $this->commonSaveFunction( $request, $user_ans, $is_file);
        if(empty($response)){
           return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
           return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
           return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveReadingNoBlanksListeningSpeakingDown(Request $request){
        $request = $request->all();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
        } else {
            $encoded_data ="";
        }
        $user_ans=array();
        if(isset($request['audio_reading']) && $request['audio_reading']=="blank"){
          $encoded_data =  "blank";
        }
        $user_ans[] = array('text_ans'=>implode(";" , $request['text_ans']) , 'path'=>$encoded_data); 
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
        $request_payload['is_file'] = !empty($encoded_data) ? true : false;
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
    public function saveMultipleTickWriting(Request $request){
        $userAnswer = array();
        $i=0;
        foreach($request['useranswer'] as $question){
            if(in_array($question,$request['checkbox'])){
                $text_ans = ($request['text_ans'][$i] === null) ? "" : $request['text_ans'][$i];
                $userAnswer[$i]['check']=true;
                $userAnswer[$i]['text_ans'] = $text_ans;
            }else{
                $text_ans = ($request['text_ans'][$i] === null) ? "" : $request['text_ans'][$i];
                $userAnswer[$i]['check']=false;
                $userAnswer[$i]['text_ans']= $text_ans;
            }
            $i++;
        }
        $user_ans[0]= $userAnswer;
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
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
    public function saveUnderLineTextSpeakingDown(Request $request){
        $request = $request->all();
        $user_ans=array();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        $encoded_data ="";
        if(file_exists('public/uploads/practice/audio/'.$fileName)) {
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
        }
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
            if(isset($request['text_ans'])){
                foreach ($request['text_ans'][0][0] as $key => $value) {
                    foreach ($value as $k => $v) {
                        if($k=='word'){
                            $underline[$key][$k] = $v;
                        } else if($k=='foregroundColorSpan'){
                            $underline[$key][$k] = array('mColor'=> (int)$v);
                        } else{
                            $underline[$key][$k] = (int) $v;
                        }
                    }
                }
            }else{
                $underline = [];
            }
            $user_ans[] = array('text_ans'=> array(json_encode($underline)), 'path'=>($encoded_data !== "") ? $encoded_data : "");
            if($request['audio']=="blank"){
                $user_ans[0]['path'] ="blank";
            }
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
        $request_payload['is_file'] = ($encoded_data !== "") ? true : false;
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
    public function saveUploadPPT(Request $request){
        $request = $request->all();
        $user_ans=array();
        $request['text_ans']= str_replace("&nbsp;"," ",$request['text_ans']);
        $request['text_ans']= str_replace("nbsp;"," ",$request['text_ans']);
        $request['text_ans']= str_replace("&amp;"," ",$request['text_ans']);
        $request['text_ans']= str_replace("amp;"," ",$request['text_ans']);
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
        $request_payload['user_answer'] = strip_tags($request['text_ans']);
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
    public function saveWritingLines(Request $request){
        $request = $request->all();
        $user_ans=array();
        foreach ($request['user_answer'] as $key=>$value) {
            $value =  empty($value) ? "" : $value;
             $value= str_replace("<div>"," ", $value);
             $value= str_replace("</div>","", $value);
             $value= str_replace("&nbsp;"," ", $value);
             $ans[$key] = strip_tags($value);
        }
        $user_ans[] = $ans;
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
    public function saveWritingEdit(Request $request){
        $request = $request->all();
        $request['user_answer']= str_replace("<div>","<br>",$request['user_answer']);
        $request['user_answer']= str_replace("</div>","",$request['user_answer']);
        $request['user_answer']= str_replace("&nbsp;"," ",$request['user_answer']);
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
        $request_payload['user_answer'] = $request['user_answer'];
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
    public function saveWritingWordCount(Request $request){
        $request = $request->all();
        $request['user_answer']= str_replace("<div>","\r\n",$request['user_answer']);
        $request['user_answer']= str_replace("<br>","\r\n",$request['user_answer']);
        $request['user_answer']= str_replace("</div>","",$request['user_answer']);
        $request['user_answer']= str_replace("&nbsp;"," ",$request['user_answer']);
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
        $request_payload['user_answer'] = $request['user_answer'];
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
    public function saveThreeBlankTableListeningWriting(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        $answer = array_chunk($answer,$request['table_type']);
        foreach($request['true_false'] as $key=>$value){
            $true_false_array[$key] = filter_var( $value, FILTER_VALIDATE_BOOLEAN);
        }
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
            foreach($ans as $kk=>$a){
                $ansKey = $kk + 1;
                if($ansKey==3 && $k>0){
                    $makeAnswerArray[$k]['col_'.$ansKey] =(isset($a) && $a!="")?$a:"";
                }else{
                    $makeAnswerArray[$k]['col_'.$ansKey] =  !empty($a)?$a:""; //
                }
            }
        }
        $user_ans=array();
        $trueFalseArray = array_chunk($true_false_array,$request['table_type']);
        $user_ans[] = array($makeAnswerArray, $trueFalseArray); //$trueFalseArray;
        if(isset($request['textarea'])){
            $request['textarea']= str_replace("<div>","\r\n",$request['textarea']);
            $request['textarea']= str_replace("<br>","\r\n",$request['textarea']);
            $request['textarea']= str_replace("</div>","",$request['textarea']);
            $request['textarea']= str_replace("&nbsp;"," ",$request['textarea']);
            $user_ans[1] = array($request['textarea']);
        }else{
            $user_ans[1] = array("");
        }
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
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
    public function commonSaveFunction(  $request, $user_ans, $is_file){
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
        if($is_file){
            $request_payload['is_file'] = true;
        }
        if(!empty($request['is_roleplay'])){
            $request_payload['is_roleplay'] = true;
        }
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
            $request_payload['is_roleplay_submit'] = true;
        }
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        return $response;
    }
    public function doUploadAudio(Request $request) {
        if(!empty($request['audio_key'])){
            $fileName = Session::get('user_id_new').'-'.$request->practice_id.'-'.$request['audio_key'].'.wav';
        } else {
            $fileName = Session::get('user_id_new').'-'.$request->practice_id.'.wav';
        }
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            unlink( 'public/uploads/practice/audio/'.$fileName );
        }
        $path = public_path('uploads/practice/audio/');
        $request->audio_data->move( $path, $fileName);
        $data['path'] = url('public/uploads/practice/audio/').'/'.$fileName;
        $data['file_name'] = $fileName;
        return response()->json($data);
    }
    public function doDeleteAudio(Request $request){
        if(!empty($request['audio_key'])){
            $fileName = Session::get('user_id_new').'-'.$request->practice_id.'-'.$request['audio_key'].'.wav';
        } else {
            $fileName = Session::get('user_id_new').'-'.$request->practice_id.'.wav';
        }
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            unlink( 'public/uploads/practice/audio/'.$fileName );
            return response()->json(['deleted'=>true]);
        } else {
            return response()->json(['deleted'=>false]);
        }
    }
    public function saveUnderLineTextWritingAtEnd(Request $request){
        $request = $request->all();
        $user_ans=array();
        $json_array = array();
        $i=0;
        foreach ($request['text_ans'][0] as $key => $value) {
            $value = $value[0] == null ? "" : $value[0];
            $value= str_replace("<div>","\r\n",$value);
            $value= str_replace("<br>","\r\n",$value);
            $value= str_replace("</div>","",$value);
            $value= str_replace("&nbsp;"," ",$value);
            $user_ans[0][$i] = $value;
            $json_array[$i] = "";
            $i++;
        }
        $j=-1;
        if(isset($request['text_ans'][1])) {
          $underline_answers = $request['text_ans'][1];
        }else {
            $underline_answers = [];
        }
        foreach ($underline_answers as $key => $value) {
            $underline=array();
            $j++;
            $underlineans[$j]="";
            $j++;
            foreach ($value as $k => $v) {
                $underline[$key][$v['i']]['i'] = (int)$v['i'];
                $underline[$key][$v['i']]['fColor'] = (int) $v['fColor'];
                $underline[$key][$v['i']]['foregroundColorSpan']['mColor'] =(int) $v['foregroundColorSpan'];
                $underline[$key][$v['i']]['word'] = $v['word'];
                $underline[$key][$v['i']]['start'] =(int) $v['start'];
                $underline[$key][$v['i']]['end'] = (int)$v['end'];
            }
            if($key == 1) {
               if(!isset($underlineans[1])) {
                    $underlineans[1] = '';
                    $underlineans[2] = '';
                    $underlineans[3] = '';
                    $underlineans[4] = '';
                    $underlineans[5] = '';
                }   
            }
            if($key == 3) {
                if(!isset($underlineans[1])) {
                    $underlineans[1] = '';
                }
            }
            if($key == 5) {
               if(!isset($underlineans[1])){
                    $underlineans[1] = '';
                    $underlineans[2] = '';
                    $underlineans[3] = '';
                    $underlineans[4] = '';
                }   
            }
            $underlineans[$key] = json_encode($underline[$key]);
        }
        if(empty($underline_answers)) {
            $user_ans[1]  = [0=>'',1=>'',2=>'',3=>'',4=>'',5=>''];
        } else { 
           $user_ans[1] = array_values($underlineans);
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
        $request_payload['user_answer'] = array($user_ans);
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
    public function saveThreeTableWritingUpBlade(Request $request) {
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        $answer = array_chunk($answer,$request['table_type']);
        foreach($request['true_false'] as $key=>$value){
            $true_false_array[$key] = filter_var( $value, FILTER_VALIDATE_BOOLEAN);
        }
        $trueFalseArray = array_chunk($true_false_array,$request['table_type']);
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
            foreach($ans as $kk=>$a){
                $ansKey = $kk + 1;
                $makeAnswerArray[$k]['col_'.$ansKey] = is_null($a) == true ? "" : $a;
            }
        }
        $user_ans=array();
        $user_ans[] = array($makeAnswerArray, $trueFalseArray);
        if(isset($request['textarea'])){
            if($request['task_type'] === "three_blank_table_writing_at_end") {
                $user_ans[1] = $request['textarea'];
            } else {
                $user_ans[1] = array($request['textarea'][0]);
            }
        }
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
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
    public function saveTwoBlankTableTapeScript(Request $request) {
        $request = $request->all();
        $current_card_ans=array();
        $topicId = $request['topic_id'];
        $x = 0;
        $user_ans=array();
        $answer = $request['col'];
        $answer = array_chunk($answer,$request['table_type']);
        foreach($request['true_false'] as $key=>$value){
            $true_false_array[$key] = filter_var( $value, FILTER_VALIDATE_BOOLEAN);
        }
        $trueFalseArray = array_chunk($true_false_array,$request['table_type']);
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
          foreach($ans as $kk=>$a){
            $ansKey = $kk + 1;
            $makeAnswerArray[$k]['col_'.$ansKey] = $a;
          }
        }
        $makeAnswerArray = array_chunk($makeAnswerArray,6);
        $trueFalseArray = array_chunk($trueFalseArray,6);
        $current_card_ans = array($makeAnswerArray, $trueFalseArray);
        $request['current_card'] = 1;
        $one[0] =$makeAnswerArray[0]; 
        $one[1] =$trueFalseArray[0]; 
        $two[0] =$makeAnswerArray[1]; 
        $two[1] =$trueFalseArray[1]; 
        $three[0] =$makeAnswerArray[2]; 
        $three[1] =$trueFalseArray[2]; 
        $user_ans[0] = array($one); 
        $user_ans[1] = "##"; 
        $user_ans[2] = array($two); 
        $user_ans[3] = "##"; 
        $user_ans[4] = array($three);
        ksort($user_ans);
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = ( $request['is_roleplay_submit'] == 0 ) ? $user_ans : "";
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        if(isset($request['is_roleplay'])) {
            $request_payload['is_roleplay'] = filter_var($request['is_roleplay'], FILTER_VALIDATE_BOOLEAN);
        }
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
            $request_payload['is_roleplay_submit'] = true;
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
    public function saveImageReadingNoBlanks(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $user_answer = array();
        $answer = implode(';', $request['text_ans']);
        $user_answer[] = html_entity_decode($answer);
        $response = $this->commonSaveFunction( $request, $user_answer, false);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function ThreeBlankTableSpeakingUp(Request $request){
        $user_ans=array();
        $request = $request->all();
        $answer = $request['col'];
        $answer = array_chunk($answer,$request['table_type']);
        $trueFalseArray = $request['true_false'];
        $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
            foreach($ans as $kk=>$a){
                $ansKey = $kk + 1;
                $makeAnswerArray[$k]['col_'.$ansKey] = is_null($a) ? "" : $a;
            }
        }
        $encoded_data ="";
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            $user_ans[0]['path']=$encoded_data;
        }
        if($request['task_type'] == "three_blank_table_speaking_up"){
            $user_ans[0]['text_ans'] = array($makeAnswerArray, $trueFalseArray);
        } else {
            $user_ans[0]['text_ans'][0]  = array($makeAnswerArray, $trueFalseArray); //$trueFalseArray;
            $user_ans[0]['text_ans'][1] = array('tHANKS');
            $user_ans[0]['path'] = $encoded_data ;
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
        $request_payload['is_file'] = $encoded_data !== "" ? true : false;
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
    public function saveMultiChoiceQuestion(Request $request) {
        $userAnswer = array();
        foreach($request['user_default_answer'] as $key=> $item) {
            if(isset($request['user_answer_']) && isset($request['user_answer_'][$key]) && !empty($request['user_answer_'][$key])){
                $currentAnswer= explode("@@",$request['user_answer_'][$key]);
                $userAnswer[$key]['ans_pos']=$currentAnswer[0];
                $userAnswer[$key]['ans']=$currentAnswer[1];
            }else{
                $userAnswer[$key]['ans_pos']=-1;
                $userAnswer[$key]['ans']=null;
            }
        }
        $i=0;
        $user_ans[0]= $userAnswer;
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
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveTrueFalseListeningSymbol(Request $request){
        $userAnswer = array();
        $i=0;
        if(!isset($request['user_question'])) {
              $user_ans[0] = [];    
        } else {
            foreach($request['user_question'] as $question){
                if(isset($request['true_false'][$i])){
                    $userAnswer[$i]['question']    = $question."@@";
                    $userAnswer[$i]['true_false']  = $request['true_false'][$i];
                }else{
                    $userAnswer[$i]['question']   = $question."@@";
                    $userAnswer[$i]['true_false'] = "-1";
                }
                $i++;
            }
            $user_ans[0]= $userAnswer;
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
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveSpeakingWritingNew(Request $request){
        $request = $request->all();
        $user_ans=array();
        if(isset($request['role_play']) && isset($request['practice_type']) && $request['practice_type'] == 'writing_at_end_speaking_up'){
            $user_ans=[];
            $audioKey=0;
            foreach($request['user_answer'] as $key=> $item){
                if(is_array($item)){
                    $user_ans[$key]=$item;
                    if(isset($request['user_audio'][$audioKey]) && !empty($request['user_audio'][$audioKey])){
                        if(isset($request['user_audio'][$audioKey]['path']) && !empty($request['user_audio'][$audioKey]['path'])){
                            $fileName = $request['user_audio'][$audioKey]['path'];
                            if(file_exists('public/uploads/practice/audio/'.$fileName)) {
                                $path = public_path('uploads/practice/audio/'.$fileName);
                                $encoded_data = base64_encode(file_get_contents($path));
                            } else {
                                $encoded_data = "";
                            }
                        }
                    } 
                    if(isset($request['writing_at_end_speaking_up']) && $request['writing_at_end_speaking_up']=="blank"){
                        $encoded_data = "blank";
                    }
                    if(isset($encoded_data)){
                        $user_ans[$key]['path'] = $encoded_data;
                    }else{
                        $user_ans[$key]['path'] = "";
                    }
                    $audioKey++;
                }else{
                    $user_ans[$key]=$item;
                }
            }
        }else{
            if(!empty($request['practice_type']) && $request['practice_type']=="listening_speaking") {
            } else if(!empty($request['practice_type']) && $request['practice_type']=="writing_at_end_speaking_up") {
                $user_ans[0]['text_ans']= $request['text_ans'];
            } else {
                foreach($request['text_ans'] as $k=> $v){
                    $v= str_replace("<div>","\r\n",$v);
                    $v= str_replace("<br>","\r\n",$v);
                    $v= str_replace("</div>","",$v);
                    $v= str_replace("&nbsp;"," ",$v);
                    $user_ans[0]['text_ans'][$k] = is_null($v) ? "" : $v;
                }
            }
            if(isset($request['user_audio'][0]) && !empty($request['user_audio'][0])){
                if(isset($request['four_blank_table_speaking_writing']) && $request['four_blank_table_speaking_writing'] == "blank"){
                    $encoded_data = "blank";
                }else{
                    $encoded_data = "";
                }
                if(isset($request['user_audio'][0]['path']) && !empty($request['user_audio'][0]['path'])){
                    $fileName = $request['user_audio'][0]['path'];
                    if(file_exists('public/uploads/practice/audio/'.$fileName)) {
                        $path = public_path('uploads/practice/audio/'.$fileName);
                        $encoded_data = base64_encode(file_get_contents($path));
                        $user_ans[0]['path'] = $encoded_data;
                    } else {
                        $encoded_data = "";
                    }
                }
            } 
            if(isset($request['writing_at_end_speaking_up']) && $request['writing_at_end_speaking_up']=="blank"){
                $encoded_data = "blank";
            }
            if(isset($encoded_data)){
                $user_ans[0]['path'] = $encoded_data;
            }else{
                $user_ans[0]['path'] = "";
            }
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
        $request_payload['is_file'] = !empty($encoded_data) ? true : false;
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
    public function trueFalseListenings(Request $request){
        $request = $request->all();
        if(!isset($request['is_roleplay']) || empty($request['is_roleplay'])){
            $user_ans= $request['user_answer'];
        }elseif(isset($request['is_roleplay']) && ($request['is_roleplay'] == true || $request['is_roleplay'] == "1")) {
            $k=0;
            $answer = $request['user_answer'];
            $answercount = $request['user_answers'];
            ksort($answer);
            $total_answer = count($answer);
            $user_ans=array();
            foreach ($answer as $key => $value) {
                if($value!="#") {
                    if( $key == ($total_answer) && !empty($value) ){
                        if(!empty($value[0][0]['true_false']) && $value[0][0]['true_false']>=0){
                            $user_ans[$k] ="";
                            $user_ans[$k+1] =  "##";
                            foreach($value as $v=>$val){
                                $temp = array();
                                foreach($val as $x=>$p){
                                    $temp1 = array();
                                    if(!array_key_exists('text_ans', $p)){
                                        $temp1['question'] = $p['question'].'@@';
                                        $temp1['true_false'] = isset($p['true_false']) ? $p['true_false'] : "-1";
                                    }else{
                                        $temp1['question'] = $p['question'].'@@';
                                        $temp1['true_false'] = $p['true_false'];
                                        $temp1['text_ans'] = $p['text_ans'];
                                    }
                                    $temp[] = $temp1;
                                }
                            }
                            $user_ans[$key]= array($temp);
                        } else {
                            $user_ans[$key]="";
                        }
                    } else {
                        if(!empty($value[0][0]['true_false']) && $value[0][0]['true_false']>=0){
                            foreach($value as $v=>$val) {
                                $temp = array();
                                foreach($val as $x=>$p){
                                    $temp1 = array();
                                    if(!array_key_exists('text_ans', $p)) {
                                        $temp1['question'] = $p['question'].'@@';
                                        $temp1['true_false'] = isset($p['true_false']) ? $p['true_false'] : "-1";
                                    } else {
                                        $temp1['question'] = $p['question'].'@@';
                                        $temp1['true_false'] = $p['true_false'];
                                        $temp1['text_ans'] = $p['text_ans'];
                                    }
                                    $temp[] = $temp1;
                                }
                            }
                            $user_ans[$k]= array($temp);
                            $user_ans[$k+1] = "##";
                            $user_ans[$k+2] = "";
                        } else {
                            $user_ans[$k+1] = "##";
                            $user_ans[$k+2] = "";
                        }
                    }
                }
            }
            $i=0;
            foreach($request['user_answer'] as $key=>$editData){
                if($editData == "##") continue;
                foreach($editData[0] as $key=>$editData) {
                    $request['user_answer'][$i][0][$key]['question'] = $editData['question']." @@";
                    $request['user_answer'][$i][0][$key]['true_false'] = isset($editData['true_false'])?$editData['true_false']:"-1";
                }
               $i=$i+2;
            }
            $user_ans[0] = $request['user_answer'][0];
            $user_ans[1] = "##";
            $user_ans[2] = $request['user_answer'][2];
            ksort($user_ans);
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
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
            $request_payload['is_roleplay_submit'] = true;
        }
        if(!empty($request['is_roleplay'])){
            $request_payload['is_roleplay'] = true;
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
    public function readingNoBlanksNew(Request $request){
        $request = $request->all();
        $answer = $request['blanks'];
        if(isset($request['ptype']) && $request['ptype'] == "reading_blanks"){
            $makeAnswer = array();
            foreach($answer as $key=>$answerss){
                if($key <= 0){
                    $makeAnswer[$key]['ans_pos'] = "0";
                }elseif(empty($answerss)){
                    $makeAnswer[$key]['ans_pos'] = "-1";
                }else{
                    $makeAnswer[$key]['ans_pos'] = "1";
                }
                $makeAnswer[$key]['ans'] = $answerss;
            }
            $answer = $makeAnswer;
        }else{
            foreach($answer as $key=>$answerss){
                if(empty($answerss)){
                    $answer[$key] = " ";
                }
            }
            $answer = implode(";",$answer);
        }
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $answers = $request['blanks'];
            array_pop($answers);
            $newAnswers = array();
            $i = 0;
            foreach($answers as $answer){
                if($answer == "##"){
                    $i++;
                    $newAnswers[$i] = $answer;
                    $i++;
                }else{
                    if(empty($answer)){
                        $answer = " ";
                    }
                    $newAnswers[$i][] = $answer;
                }
            }
            $answer = array();
            foreach($newAnswers as $k=>$newAnswer){
                if(is_array($newAnswer)){
                    $newAnswersss = implode(";",$newAnswer);
                    $answer[$k][0] = $newAnswersss;
                }else{
                    $answer[$k] = $newAnswer;
                }
            }
        }
        $user_ans=array();
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $user_ans = $answer;
        }elseif(isset($request['ptype']) && $request['ptype'] == "reading_blanks"){
            $user_ans[0] = $answer;
        }else{
            $user_ans[0] = $answer.';';
        }
        $topicId = $request['topic_id'];
        if($request['task_type'] === "reading_no_blanks_speaking") {
            $oldWayUserAns = $user_ans;
            $user_ans=array();
            foreach ($oldWayUserAns as $key => $value) {
                $temp = array();
                $temp['text_ans'] = is_array($value) ? ($value[0]).";" : $value;
                if($value === "##"){
                    $user_ans[$key] = $value;
                    continue;
                }
                if($key==0){
                    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                }else{
                    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-'.$key.'.wav';
                }
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                if(isset($request['reading_no_blanks_speaking'.$key]) && $request['reading_no_blanks_speaking'.$key] == "blank"){
                    $encoded_data= "blank";
                }
                $temp['path'] = $encoded_data;
                $user_ans[$key] = $temp;
            }
        }else{
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }
        }
        if($request['is_roleplay_submit']==1){
          $request['user_ans']=array();
        }
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }
        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }
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
    public function saveSingleImageWritingAtEndSpeakings(Request $request){
        $request = $request->all();
        $user_ans="";
        if(!empty($request['user_answer']) && $request['is_roleplay_submit']==0 ){
            $user_ans = array();
            foreach ($request['user_answer'] as $key => $value) {
                if($value!="##" && is_array($value['text_ans'])) {
                    $temp = array();
                    foreach($value['text_ans'] as $val) {
                        $temp[] = is_null($val) ? "" : $val;
                    }
                    $temp= str_replace("<div>","\r\n",$temp);
                    $temp= str_replace("<br>","\r\n",$temp);
                    $temp= str_replace("</div>","",$temp);
                    $temp= str_replace("&nbsp;"," ",$temp);
                    $user_ans[$key]['text_ans'] = $temp;
                    if(!empty($value['path'])) {
                        if(file_exists('public/uploads/practice/audio/'.$value['path']) ) {
                            $path = public_path('uploads/practice/audio/'.$value['path']);
                            $encoded_data = base64_encode(file_get_contents($path));
                        } else {
                            $encoded_data ="";
                        }
                        if($request['single_image_writing_at_end_speaking'][$key] == "blank"){
                            $encoded_data = "blank";
                        }
                        $user_ans[$key]['path'] =$encoded_data;
                    } else {
                        $encoded_data = "";
                        if($request['single_image_writing_at_end_speaking'][$key] == "blank"){
                            $encoded_data = "blank";
                        }
                        $user_ans[$key]['path'] = $encoded_data;
                    }
                } else {
                    $user_ans[$key]="##";
                }
            }
            $is_file = true;
            ksort($user_ans);
        } else {
            $is_file = false;
            $user_ans=array();
        }
        $userDetails = [];
        $response =  $this->commonSaveFunction( $request, $user_ans, $is_file);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']) {
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']) {
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveDrawMultipleImageTableNew(Request $request){
        $userAnswer=array();
        if(isset($request['drawimage'])){
            foreach($request['drawimage'] as $key=>$item){
                if(!empty($item) && str_contains($item,'data:image/png;base64')){
                    $img = str_replace('data:image/png;base64,', '', $item);
                    $userAnswer[$key] = str_replace(' ', '+', $img);
                }else{
                    $userAnswer[$key]="";
                }
            }
        }
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
        $request_payload['user_answer']=$userAnswer;
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
    public function saveReadingBlanks(Request $request){
        $request = $request->all();
        $user_ans=array();
        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
        if(file_exists('public/uploads/practice/audio/'.$fileName)){
            $path = public_path('uploads/practice/audio/'.$fileName);
            $encoded_data = base64_encode(file_get_contents($path));
            $user_ans[0]['path']=$encoded_data;
        } else {
            $encoded_data ="";
        }
        $answers = $request['text_ans'];
        if(count($answers) > 0) {
            foreach($answers['ans'] as $key=> $ans) {
                if(isset($answers['ans_pos'][$key]))
                {
                    $temp_ans_pos = $answers['ans_pos'][$key] == null ? "-1" : (int)$answers['ans_pos'][$key];
                }
                else
                {
                    $temp_ans_pos = "-1";
                }
                $temp_ans     = $ans == null ? "" : $ans;
                $temp[$key]   = array('ans_pos'=>(int)$temp_ans_pos, 'ans'=>$temp_ans);
            }
        }
        $user_ans[0] = $temp;
        $topicId = $request['topic_id'];
        $request_payload = array();
        $request_payload['student_id'] = Session::get('user_id_new');
        $request_payload['cource_id'] = Session::get('course_id_new');
        $request_payload['level_id'] = Session::get('level_id_new');
        $request_payload['topic_id'] = $topicId;
        $request_payload["task_id"] = $request['task_id'];
        $request_payload["practise_id"] = $request['practise_id'];
        $request_payload['save_for_later'] = true;
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $request_payload['user_answer'] = $user_ans;
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

    // practiseAmitcontroller
    

    // PractiseAnkilController
    
     public function saveWriteAtendUpRolePlay(Request $request){
      if($request['role_play']){
          $newData = [];
          foreach ($request['writeingBox'] as $key => $value) {
            foreach($value as $key2 => $data) {
                $data= str_replace("\r\n","<br>",$data);
                $data= str_replace("<div>","<br>",$data);
                $data= str_replace("</div>","",$data);
                $data= str_replace("&nbsp;"," ",$data);
                $newData[$key][$key2] = $data;
            }
          }
          $user_ans[0][] = $newData[0];
          $user_ans[1] = "##";
          $user_ans[2][] = $newData[1];
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
      // dd( $request_payload );
      $endPoint = "practisesubmit";
      $response = curl_post($endPoint, $request_payload);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
    }
    public function saveWriteAtendUp(Request $request){
        if($request['role_play']){
            $user_ans = [];
            $tempFlag = true;
          

            if($request['practise_type']=='Writing'){
                $request['writeingBox']= str_replace("\r\n","<br>",$request['writeingBox']);
                $request['writeingBox']= str_replace("<div>","<br>",$request['writeingBox']);
                $request['writeingBox']= str_replace("</div>","",$request['writeingBox']);
                $request['writeingBox']= str_replace("&nbsp;"," ",$request['writeingBox']);
                if(!is_array($request['writeingBox'])){
                  $request['writeingBox']= htmlspecialchars_decode($request['writeingBox']);
                }
               
                  $count= @count($request['writeingBox']) * 2;
                  $k = 0;
                  for($i = 0; $i < $count-1; $i++) 
                  { 
                    if ($i & 1 == 1) {  //using bitwise 
                      array_push($user_ans, "##");
                    } else{ 
                      array_push($user_ans, $request['writeingBox'][$k++]);
                    }
                  }
            }else{

                      foreach($request['writeingBox'] as $key => $value) {
                        if($tempFlag){
                            array_push($user_ans, $value);
                            array_push($user_ans, "##");
                            $tempFlag = false;
                        }else{
                            array_push($user_ans, $value);
                            $tempFlag = true;

                        }
                    }
            }
        }else{


            if($request['practise_type']=='Writing'){

                $request['writeingBox']= str_replace("\r\n","<br>",$request['writeingBox']);
                $request['writeingBox']= str_replace("<div>","<br>",$request['writeingBox']);
                $request['writeingBox']= str_replace("</div>","",$request['writeingBox']);
                $request['writeingBox']= str_replace("&nbsp;"," ",$request['writeingBox']);
                $request['writeingBox']= htmlspecialchars_decode($request['writeingBox']);
                // $request['writeingBox']= str_replace("&nbsp;"," ",$request['writeingBox']);
                $user_ans = $request['writeingBox'];

                if(isset($request['writeingBox_dependancy'])){

                    $request['writeingBox_dependancy']= str_replace("\r\n","<br>",$request['writeingBox_dependancy']);
                    $request['writeingBox_dependancy']= str_replace("<div>","<br>",$request['writeingBox_dependancy']);
                    $request['writeingBox_dependancy']= str_replace("</div>","",$request['writeingBox_dependancy']);
                    $request['writeingBox_dependancy']= str_replace("&nbsp;"," ",$request['writeingBox_dependancy']);
                    $request['writeingBox_dependancy']= htmlspecialchars_decode($request['writeingBox_dependancy']);

                    $user_ans = $request['writeingBox_dependancy'];
                }

            }else{
                $user_ans = array();
                $user_ans[0] = $request['writeingBox'];
            }
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
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
          return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
          return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
          return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveListeningWriting(Request $request){
      $user_ans = array();
      if(isset($request['role_play']) && !empty($request['role_play'])){
        $count= count($request['writeingBox']) * 2;
        //echo $count- 1;
        $k=0;
        
        for($ii= 0; $ii < $count-1; $ii++) 
        { 
          if ($ii & 1 == 1) {  //using bitwise 
            array_push($user_ans, "##");
          } else{ 
            array_push($user_ans, $request['writeingBox'][$k++]);
          }
        }
        //pr($user_ans);
      }else{
        $user_ans= $request['writeingBox'];

      }
      // pr($user_ans);
      
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

      $endPoint = "practisesubmit";
      $response = curl_post($endPoint, $request_payload);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
    }
    public function saveMultipleTick(Request $request){
      $userAnswer = array();
      $i=0;
        if(isset($request['checkBox']))
        {
          foreach($request['question'] as $question){
            if(in_array($question,$request['checkBox'])){
              $userAnswer[$i]['name']=$question;
              $userAnswer[$i]['checked']=true;

            }else{
              $userAnswer[$i]['name']=$question;
              $userAnswer[$i]['checked']=false;
            }
            $i++;
          }
       }
       else
       {
         $userAnswer = [];
       }
       $user_ans[0]= $userAnswer;
       
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

       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }

     }

     public function saveSetinOrderVertListening(Request $request){
       //echo '<pre>'; print_r($request->all()); exit;
      $user_ans= implode(';',$request['inOrderAnswer']);
      
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

      $endPoint = "practisesubmit";
      $response = curl_post($endPoint, $request_payload);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
    }
    public function saveTrueFalseSymbolListening(Request $request){
      $userAnswer = array();
      $i=0;
      foreach($request['user_question'] as $question){


          if(isset($request['true_false'][$i])){
            if(strpos($question,"***")){

          $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
          $userAnswer[$i]['true_false'] = $request['true_false'][$i];
         }
        }else{
          // if(!empty($userAnswer[$i])){
          //   $userAnswer[--$i]['question']= $userAnswer[$i]['question'].$question;
          //    $i++;
          // }else{
            if(strpos($question,"***")){
              $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
              $userAnswer[$i]['true_false'] =null;
            }else{
              $userAnswer[--$i]['question']= $userAnswer[$i]['question'].$question;
              $i++;
            }
        }
      $i++;
      }
       $user_ans[0]= $userAnswer;
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

       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }

     }

     

     public function readingNoBlanksNoSpace(Request $request){


        $tempans = [];
        foreach ($request['writeingBox'] as $key => $value) {
          # code...
            $value= str_replace("<div>","\r\n",$value);
            $value= str_replace("<br>","\r\n",$value);
            $value= str_replace("</div>","",$value);
            $value= str_replace("&nbsp;"," ",$value);
            if(!is_null($value)){

              $tempans[$key]  =$value; 
            }
        }
      $user_ans= array();
      $user_ans[0]= implode(';',$tempans);
      // dd($user_ans);
      
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

      $endPoint = "practisesubmit";
      $response = curl_post($endPoint, $request_payload);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      } elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      } elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
    }
    public function saveTrueFalseSymbolReading(Request $request){
      $userAnswer = array();
      $i=0;
      //dd($request);
      // dd($request->all());
      //dd($request['user_question']);
      if(isset($request['customType'])){
        foreach($request['user_question'] as $question){
          if(isset($request['true_false'][$i])){
            $userAnswer[$i]['question']= $question;
            $userAnswer[$i]['true_false'] = $request['true_false'][$i];
          }else{
            $userAnswer[$i]['question']=$question;
            $userAnswer[$i]['true_false'] = -1;
          }
          $i++;
        }
      }else{
          if(isset($request['typeofdependingpractice']) && $request['typeofdependingpractice'] == 'get_speaking_audios_self_marking'){
            foreach($request['user_question'] as $question){
              $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
              $userAnswer[$i]['true_false'] = $request['true_false'][$i];
              if(isset($request['path'][$i])){
                $userAnswer[$i]['path'] = $request['path'][$i];
                $userAnswer[$i]['recorded'] = $request['recorded'][$i];
                $userAnswer[$i]['played'] = $request['played'][$i];
              }
              $i++;
            }
            
          }else{          
            foreach($request['user_question'] as $question){
              if(isset($request['true_false'][$i])){
                  /* if(strpos($question,"***")){
                    $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
                    $userAnswer[$i]['true_false'] = $request['true_false'][$i];
                  }else{
                    $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
                    $userAnswer[$i]['true_false'] = $request['true_false'][$i];
                  } */
                  $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
                  $userAnswer[$i]['true_false'] = $request['true_false'][$i];
              }else{
                  if(strpos($question,"***")){
                    $userAnswer[$i]['question']=str_replace('***',$request['dependan_answer'][$i],$question);
                    $userAnswer[$i]['true_false'] =null;
                  }else{
                    $userAnswer[--$i]['question']= $userAnswer[$i]['question'];
                    $i++;
                  }
              }
              $i++;
            }
          }
      }
      
      // dd($userAnswer);
      $user_ans[0]= $userAnswer;
      //dd($user_ans);
      
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

      $endPoint = "practisesubmit";
      $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }
    public function saveBlankTableWritingEnd(Request $request){
      $request  = $request->all();
      //echo '<pre>'; print_r($request); exit;
      $answer = $request['col'];
      $answer = array_chunk($answer,$request['table_type']);
      foreach($request['true_false'] as $item){
          if($item == "true"){
            $trueFalseArray []=true ;
          }elseif($item == "false"){
            $trueFalseArray []=false ;
          }else{
            $trueFalseArray [] = $item;
          }
      }
      $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
      $makeAnswerArray = array();
      foreach($answer as $k=>$ans){
        foreach($ans as $kk=>$a){
          $ansKey = $kk + 1;
          $makeAnswerArray[$k]['col_'.$ansKey] = $a;
        }
      }
      $user_ans=array();
      $user_ans[0][0] = $makeAnswerArray;
      $user_ans[0][1] = $trueFalseArray;
      foreach($request['writingBox'] as $key=>$writingBox){
        $writingBox= str_replace("<div>","\r\n",$writingBox);
        $writingBox= str_replace("</div>","",$writingBox);
        $writingBox= str_replace("&nbsp;"," ",$writingBox);
        $writingBox= str_replace("<br>","",$writingBox);
        $writingBox= htmlspecialchars_decode($writingBox);
        $user_ans[1][$key]=$writingBox;
      }
      $topicId            = $request['topic_id'];
      $request_payload    = array();
      $request_payload['student_id']            = Session::get('user_id_new');
      $request_payload['token_app_type']        = 'ieuk_new';
      $request_payload['token']                 = Session::get('token');
      $request_payload['cource_id']             = Session::get('course_id_new');
      $request_payload['level_id']              = Session::get('level_id_new');
      $request_payload['topic_id']              = $topicId;
      $request_payload["task_id"]               = $request['task_id'];
      $request_payload["practise_id"]           = $request['practise_id'];
      $request_payload['user_answer']           = $user_ans;
      $request_payload['save_for_later']        = true;
      $request_payload['is_save']               = ($request['is_save']==1) ? true : false;
      $endPoint                                 = "practisesubmit";
      //echo '<pre>'; print_r($request_payload); exit;
      $response = curl_post($endPoint, $request_payload);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      }elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      }elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
    }
    public function saveTrueFalseListeningSimple(Request $request){

      $i=0;
      $user_ans[0]= $request['userans'];
         foreach($user_ans[0] as $key => $value)
         {
            if(!isset($value["true_false"]))
            {
                $not_selected_field = array(
                                                "question"    => $value['question'],
                                                "true_false"  => -1
                                           );
                $user_ans[0][$key]  = $not_selected_field;
            }
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
        $endPoint = "practisesubmit";
        $response = curl_post($endPoint, $request_payload);
      //  pr( $response );
        if(empty($response)){
          return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        } elseif(isset($response['success']) && !$response['success']){
          return response()->json(['success'=>false,'message'=>$response['message']], 200);
        } elseif(isset($response['success']) && $response['success']){
          return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveMultiChoiceMultipulQuestion(Request $request){
      $userAnswer = array();
      foreach($request['user_default_answer'] as $key=> $item)
      {
        if(isset($request['user_answer']) && isset($request['user_answer'][$key]) && !empty($request['user_answer'][$key])){
         $ans=array();
          foreach($request['user_answer'][$key] as $k=>$uans){
            $currentAnswer= explode("@@",$request['user_answer'][$key][$k]);
            $userAnswer[$key]['ans_pos'][$k]=(int)$currentAnswer[0];
            $ans[] = $currentAnswer[1];
          }
          $userAnswer[$key]['ans']= implode(':',$ans);
        }else{
          $userAnswer[$key]['ans_pos']=array();
          $userAnswer[$key]['ans']=null;
        }

      }
      $i=0;


       $user_ans[0]= $userAnswer;

       
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

       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }
    public function saveMultiChoiceQuestionWritingAtEnd(Request $request){
      $userAnswer = array();
      foreach($request['user_default_answer'] as $key=> $item)
      {

        if(isset($request['user_answer']) && isset($request['user_answer'][$key]) && !empty($request['user_answer'][$key])){
         $currentAnswer= explode("@@",$request['user_answer'][$key]);
          $userAnswer[$key]['ans_pos']=$currentAnswer[0];
          $userAnswer[$key]['ans']=$currentAnswer[1];
          $userAnswer[$key]['text_ans']=$request['writingBox'][$key];


        }else{
          $userAnswer[$key]['ans_pos']=-1;
          $userAnswer[$key]['ans']=null;
          $userAnswer[$key]['text_ans']=$request['writingBox'][$key];
        }
      }
      $i=0;


       $user_ans[0]= $userAnswer;

       
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

       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }
    public function saveMultipleTickLiestieng(Request $request){
      $userAnswer = array();
      $i=0;
      foreach($request['question'] as $question){
        if(in_array($question,$request['checkBox'])){
          $userAnswer[$i]['name']=$question;
          $userAnswer[$i]['checked']=true;

        }else{
          $userAnswer[$i]['name']=$question;
          $userAnswer[$i]['checked']=false;
        }
        $i++;
      }


       $user_ans[0]= $userAnswer;

       
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

       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
     //  pr( $response );
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }
    public function saveDrawImageWriting(Request $request){
      $img = str_replace('data:image/png;base64,', '', $request['drawimage']);
      $image_get = str_replace(' ', '+', $img);
      $userAnswer=array();
      $userAnswer[0]['path']=$image_get;
      if(isset($request['text_ans'])){
        if(is_array($request['text_ans'])){
          $userAnswer[0]['text_ans'] = $request['text_ans'];

        }else{
          $userAnswer[0]['text_ans'][0] = $request['text_ans'];

        }
      }

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
      $request_payload['user_answer']=$userAnswer;
      $request_payload['token_app_type'] = 'ieuk_new';
      $request_payload['token'] = Session::get('token');
      // echo '<pre>'; print_r($request_payload); exit;
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
    public function saveDrawImageSpeaking(Request $request){
        $userAnswer=array();
        if(!empty($request['drawimage'])){
          if( !empty($request['is_roleplay'])  ){
              foreach($request['drawimage'] as $key => $value){
                if($value=='##'){
                    $userAnswer[$key]="##";
                } else if(empty($value[0]) && empty($value[1])){
                    if(isset($request['audio_reading_'.$key]) && $request['audio_reading_'.$key] == "blank"){
                      $userAnswer[$key][0]="";
                      $userAnswer[$key][1]="";
                      $encoded_data         = "blank";
                      $userAnswer[$key][0]  = $encoded_data; 
                    }else{
                        $userAnswer[$key]="";
                    }

                    if(isset($request['draw_image_speaking_single_image_'.$key]) && $request['draw_image_speaking_single_image_'.$key] == "blank"){
                      $userAnswer[$key] = array();
                      $encoded_data         = "blank";
                      $userAnswer[$key][0]  = $encoded_data; 
                      $userAnswer[$key][1]  = ""; 
                    }
                    else{
                        $userAnswer[$key]="";
                    }
                } 
                else {
                  $encoded_data ="";
                  if(!empty($value[0])){
                    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                      if(file_exists('public\\uploads\\practice\\audio\\'.$value[0])){
                          $path = public_path('uploads\\practice\\audio\\'.$value[0]);
                          $path = str_replace('\\','/',$path); 
                          $encoded_data = base64_encode(file_get_contents($path));
                      }
                    }else{
                      if(file_exists('public/uploads/practice/audio/'.$value[0])){
                          $path = public_path('uploads/practice/audio/'.$value[0]);
                          $encoded_data = base64_encode(file_get_contents($path));
                      }
                    }
                  }
                  
                  if(isset($request['draw_image_speaking_single_image_'.$key]) && $request['draw_image_speaking_single_image_'.$key] == "blank"){
                    $encoded_data= "blank";
                  }
                  if(isset($request['audio_reading_'.$key]) && $request['audio_reading_'.$key] == "blank"){
                    $encoded_data= "blank";
                  }
                
                  $userAnswer[$key][0] = $encoded_data; 
                  if(!is_null($value[1])){
                    if(str_contains($value[1], 'data:image')){
                      $img = str_replace('data:image/png;base64,', '', $value[1]);
                      $image_get = str_replace(' ', '+', $img);
                      $userAnswer[$key][1]=$image_get;
                    } else {
                      $userAnswer[$key][1] ="";
                    }
                  }else{
                    $userAnswer[$key][1] ="";
                  }
                }
              }
          
          } else {
            $encoded_data ="";
            if(!empty($request['drawimage'][0])){
              if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

                if(file_exists('public\\uploads\\practice\\audio\\'.$request['drawimage'][0])){
                    $path = public_path('uploads\\practice\\audio\\'.$request['drawimage'][0]);
                  $path = str_replace('\\','/',$path); 
                  $encoded_data = base64_encode(file_get_contents($path));
                }
              }else{

                if(file_exists('public/uploads/practice/audio/'.$request['drawimage'][0])){
                  $path = public_path('uploads/practice/audio/'.$request['drawimage'][0]);
                  $encoded_data = base64_encode(file_get_contents($path));
                } 
              }
            }
            if(isset($request['draw_image_speaking']) && $request['draw_image_speaking'] == "blank"){
              $encoded_data= "blank";
            }
            $userAnswer[0] = $encoded_data;
            if(isset($request['drawimage']) && !is_null($request['drawimage'][1])){
              if(str_contains($request['drawimage'][1], 'data:image')){
                $img = str_replace('data:image/png;base64,', '', $request['drawimage'][1]);
                $image_get = str_replace(' ', '+', $img);
                $userAnswer[1] = $image_get;
              } else {
                $userAnswer[1] ="";
              }
            }else{
               $userAnswer[1] ="";
            }
          } 
        } 
        if($request['topic_id'] == "5c2c96b9b0dace7ca0026cf3"){
          array_pop($userAnswer);
        }
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
        $request_payload['user_answer']=$userAnswer;
        $request_payload['token_app_type'] = 'ieuk_new';
        $request_payload['token'] = Session::get('token');
        // echo '<pre>'; print_r($request_payload); exit;
        if(!empty($request['is_roleplay'])){
          $request_payload['is_roleplay'] = true;
        }
    
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
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
    public function saveDrawImagelistening(Request $request){
      $img = str_replace('data:image/png;base64,', '', $request['drawimage']);
      $image_get = str_replace(' ', '+', $img);
      $userAnswer=array();
      $userAnswer[0]=$image_get;
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
      $request_payload['user_answer']=$userAnswer;
      $request_payload['token_app_type'] = 'ieuk_new';
      $request_payload['token'] = Session::get('token');
      // echo '<pre>'; print_r($request_payload); exit;
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
    public function saveDrawImageMultipleTable(Request $request){
      $userAnswer=array();
      if(is_array($request['drawimage'])){
        foreach($request['drawimage'] as $key=>$item){
          if(!empty($item)){
            $img = str_replace('data:image/png;base64,', '', $item);
            $userAnswer[0][$key] = str_replace(' ', '+', $img);
          }else{
            $userAnswer[0][$key]="";
          }
        }
      }
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
      $request_payload['user_answer']=$userAnswer;
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
    public function saveSingleTick(Request $request){
      $request = $request->all();
      $userAnswer = array();
      foreach($request['user_answer'] as $key=> $user_answer){
        $userAnswer[0][$key]['name'] = $user_answer['name'];
        if(isset($request['user_checked']) && !empty($request['user_checked'] == $key)){
          $userAnswer[0][$key]['checked'] = true;
        }else{
          $userAnswer[0][$key]['checked'] = false;
        }
      }
      $topicId = $request['topic_id'];
      $request_payload['student_id'] = Session::get('user_id_new');
      $request_payload['cource_id'] = Session::get('course_id_new');
      $request_payload['level_id'] = Session::get('level_id_new');
      $request_payload['topic_id']  = $request['topic_id'];
      $request_payload['task_id']  = $request['task_id'];
      $request_payload['practise_id']  = $request['practise_id'];
      $request_payload['save_for_later']  = true;
      $request_payload['is_save']  = ($request['is_save']==1) ? true : false;

      $request_payload['user_answer']=$userAnswer;
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
    public function saveTrueFalseAG(Request $request){
      $userAnswer = array();
      $i=0;
      foreach($request['user_question'] as $question){
          if(isset($request['true_false'][$i])){
            if(strpos($question,"@@")){
              $userAnswer[$i]['question']=str_replace('@@','  '.$request['dependan_answer'][$i].' ',$question).' @@';
              $userAnswer[$i]['true_false'] = $request['true_false'][$i];
            }
        }else{
            if(strpos($question,"@@")){
              $userAnswer[$i]['question']=str_replace('@@','  '.$request['dependan_answer'][$i].' ',$question).' @@';
              $userAnswer[$i]['true_false'] = -1;
            }else{
              $userAnswer[--$i]['question']= $userAnswer[$i]['question'].$question.' @@';
              $i++;
            }
        }
      $i++;
      }
       $user_ans[0]= $userAnswer;
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
       $endPoint = "practisesubmit";
       $response = curl_post($endPoint, $request_payload);
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }

    // PractiseAnkilController
    // 
    // 
    // PracticeJayminController.php
    // 
    public function threeBlankTableSpeakingUpNew(Request $request) {
        $request = $request->all();
        $request_payload = array();
        
        $topicId = $request['topic_id'];
        
        $answer = $request['col'];
        

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                  $request_payload['is_file'] = true;
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];

                if(isset($request['three_blank_table_speaking_up_new']) && $request['three_blank_table_speaking_up_new'] == "blank"){
                    $encoded_data = "blank";    
                }
                $user_ans[0]['path']=$encoded_data;
            }

            // if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
            // }
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }else{

            $request_payload['is_file'] = false;
        }
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        // dd($request_payload);
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
    public function saveBlankTableDependancy(Request $request){
        $request = $request->all();
        $request_payload = array();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##"){
                    $seperationKey = $key;
                }
                unset($answer[$seperationKey]);
                unset($trueFalseArray[$seperationKey]);
            }

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];

            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            $user_ans=array();
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $user_ans[0]['text_ans'][0] = $makeAnswerArray[0];
                $user_ans[0]['text_ans'][1] = $trueFalseArray[0];
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                // $user_ans[0]['path'] = $encoded_data;


                $user_ans[1] = "##";


                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-1.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                // $user_ans[2]['path']=$encoded_data;
                $user_ans[2]['text_ans'][0] = $makeAnswerArray[1];
                $user_ans[2]['text_ans'][1] = $trueFalseArray[1];

            }else{
                $user_ans[0][0][0] = $makeAnswerArray[0];
                $user_ans[0][0][1] = $trueFalseArray[0];

                $user_ans[0][1][0] = $makeAnswerArray[1];
                $user_ans[0][1][1] = $trueFalseArray[1];
            }



        } else {
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                // if(file_exists('public/uploads/practice/audio/'.$fileName)){
                //   $path = public_path('uploads/practice/audio/'.$fileName);
                //   $encoded_data = base64_encode(file_get_contents($path));
                // } else {
                //   $encoded_data ="";
                // }
                $encoded_data="";
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    if(file_exists('public\\uploads\\practice\\audio\\'.$fileName)){
                        $path = public_path('uploads\\practice\\audio\\'.$fileName);
                        $path = str_replace('\\','/',$path); 
                        $encoded_data = base64_encode(file_get_contents($path));
                        $request_payload['is_file'] = true;
                    }
                } else {
                    if(file_exists('public/uploads/practice/audio/'.$fileName)){
                        $path = public_path('uploads/practice/audio/'.$fileName);
                        $encoded_data = base64_encode(file_get_contents($path));
                        $request_payload['is_file'] = true;
                    }
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }
            //pr($user_ans);

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                // $request['blanks_up']= str_replace("<div>","<br>",$request['blanks_up']);
                // $request['blanks_up']= str_replace("</div>","",$request['blanks_up']);               
                // $request['blanks_up']= str_replace("&nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("&amp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("amp;"," ",$request['blanks_up']);                
                $user_ans[1] = $request['blanks_up'];
            }
        }

        // dd($user_ans);
        
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        // if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
        //  $request_payload['is_file'] = false;
        // }
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $endPoint = "practisesubmit";
     ///    pr($request_payload);
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function saveBlankTableThreeTableOptionDependancy(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##"){
                    $seperationKey = $key;
                }
                unset($answer[$seperationKey]);
                unset($trueFalseArray[$seperationKey]);
            }

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];

            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            $user_ans=array();
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $user_ans[0]['text_ans'][0] = $makeAnswerArray[0];
                $user_ans[0]['text_ans'][1] = $trueFalseArray[0];
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                // $user_ans[0]['path'] = $encoded_data;


                $user_ans[1] = "##";


                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-1.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                // $user_ans[2]['path']=$encoded_data;
                $user_ans[2]['text_ans'][0] = $makeAnswerArray[1];
                $user_ans[2]['text_ans'][1] = $trueFalseArray[1];

            }else{
                $user_ans[0][0][0] = $makeAnswerArray[0];
                $user_ans[0][0][1] = $trueFalseArray[0];

                $user_ans[0][1][0] = $makeAnswerArray[1];
                $user_ans[0][1][1] = $trueFalseArray[1];
            }



        }else{
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            // if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            //  $oldWayUserAns = $user_ans;
            //  $user_ans=array();
            //  $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
            //  if(file_exists('public/uploads/practice/audio/'.$fileName)){
            //    $path = public_path('uploads/practice/audio/'.$fileName);
            //    $encoded_data = base64_encode(file_get_contents($path));
            //  } else {
            //    $encoded_data ="";
            //  }
            //  $user_ans[0]['text_ans']=$oldWayUserAns[0];
            //  $user_ans[0]['path']=$encoded_data;
            // }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                // $request['blanks_up']= str_replace("<div>","<br>",$request['blanks_up']);
                // $request['blanks_up']= str_replace("</div>","",$request['blanks_up']);               
                // $request['blanks_up']= str_replace("&nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("&amp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("amp;"," ",$request['blanks_up']);                
                $user_ans[1] = $request['blanks_up'];
            }
        }

        // dd($user_ans);
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        // if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
        //  $request_payload['is_file'] = false;
        // }
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        // dd(json_encode($request_payload));
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
    public function saveBlankTable(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        //dd($request['true_false']);
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##" ){
                    if($seperationKey=="") {
                        $seperationKey = $key;
                    }
                    unset($answer[$key]);
                    unset($trueFalseArray[$key]);
                }
            }
        
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];
    
            $makeAnswerArray = array();
            
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                     
                }
            }
        
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey); 
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            
            $user_ans=array();
            $k=0;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                //pr($makeAnswerArray);
                foreach($makeAnswerArray as $key => $value) {
                    if($key <= $request['active_rolecard']){
                        
                    
                        $user_ans[$k]['text_ans'][0] = $makeAnswerArray[$key];
                        $user_ans[$k]['text_ans'][1] = $trueFalseArray[$key];

                        if( !empty($request['audio_path'][$key]) ) { 
                            $fileName = $request['audio_path'][$key];
                            if(file_exists('public/uploads/practice/audio/'.$fileName)){
                                $path = public_path('uploads/practice/audio/'.$fileName);
                                $encoded_data = base64_encode(file_get_contents($path));
                            } else {
                                $encoded_data = "";
                            }
                        } else {
                            $encoded_data = "";
                        } 

                        if(isset($request['three_blank_table_speaking_up_new']) && $request['three_blank_table_speaking_up_new'] == "blank"){
                            $encoded_data= "blank"; 
                        }

                        if(isset($request['three_blank_table_speaking']) && $request['three_blank_table_speaking'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        if(isset($request['four_blank_table_speaking_up']) && $request['four_blank_table_speaking_up'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        if(isset($request['three_table_option_speaking']) && $request['three_table_option_speaking'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        if(isset($request['two_blank_table_speaking_up']) && $request['two_blank_table_speaking_up'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        if(isset($request['two_table_option_speaking_up']) && $request['two_table_option_speaking_up'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        if(isset($request['two_table_option_speaking']) && $request['two_table_option_speaking'] == "blank"){
                            $encoded_data= "blank"; 
                        }
                        $user_ans[$k]['path'] = $encoded_data;
                    } else{
                        $user_ans[$k]="";
                    }
                    array_push($user_ans, '##');
                    $k+=2;
                }
            } else {  
                foreach($makeAnswerArray as $key => $value) {
                    $user_ans[$k]['text_ans'][0] = $makeAnswerArray[$key];
                    $user_ans[$k]['text_ans'][1] = $trueFalseArray[$key]; 
                    array_push($user_ans, '##');
                    $k+=2;
                }
            }

            array_pop($user_ans);
            // dd("call");

        } else {
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];

            foreach($trueFalseArray as $key => $val)
            {
                 $trueFalseArray[$key] = ($val  == "true")?true:false;
            }
            $trueFalseArray  = array_chunk($trueFalseArray,$request['table_type']);
            
            $makeAnswerArray = array();
            
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    if(!empty($a)){
                        $ansKey = $kk + 1;
                        if( $a!="^D^" ) {
                            $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                        }
                    } else {
                        $ansKey = $kk + 1;
                        $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                        //unset($trueFalseArray[$k][$kk] );
                    } 
                }
            }
            //pr($trueFalseArray);
            //  pr($makeAnswerArray);
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                if(isset($request['delete']) && $request['delete'] == "blank"){
                    $encoded_data   = "blank";
                }
                if(isset($request['three_blank_table_speaking_up_new']) && $request['three_blank_table_speaking_up_new'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['three_blank_table_speaking']) && $request['three_blank_table_speaking'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['four_blank_table_speaking_up']) && $request['four_blank_table_speaking_up'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['three_table_option_speaking']) && $request['three_table_option_speaking'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['two_blank_table_speaking_up']) && $request['two_blank_table_speaking_up'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['two_table_option_speaking_up']) && $request['two_table_option_speaking_up'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['two_blank_table_speaking']) && $request['two_blank_table_speaking'] == "blank"){
                    $encoded_data= "blank"; 
                }
                if(isset($request['two_table_option_speaking']) && $request['two_table_option_speaking'] == "blank"){
                    $encoded_data= "blank"; 
                }
                $user_ans[0]['path']=$encoded_data;
                
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){          
                $user_ans[1] = $request['blanks_up'];
            }


        }
        // dd($user_ans);
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function twoTableOptionSpeaking(Request $request){
        $request = $request->all();
        
        
        $topicId = $request['topic_id'];
        $answer = $request['col'];
    
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##" ){
                    if($seperationKey=="") {
                        $seperationKey = $key;
                    }
                    unset($answer[$key]);
                    unset($trueFalseArray[$key]);
                }
            }
        
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];
    
            $makeAnswerArray = array();
            
            foreach($answer as $k=>$ans){

                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    // $a= str_replace("<div>","\r\n",$a);
                    // $a= str_replace("</div>","",$a);
                    // $a= str_replace("&nbsp;"," ",$a);
                    // $a= str_replace("\r\n","\n",$a);
                    $a= htmlspecialchars_decode($a);

                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                     
                }
            }
            // dd($makeAnswerArray);
        
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey); 
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            
            $user_ans=array();
            $k=0;
            $j=0;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                // pr($request);
                // echo "false";
                
                foreach($makeAnswerArray as $key => $value) {
                    // if($key <= $request['active_rolecard']){
                        
                    
                        $user_ans[$k]['text_ans'][0] = $makeAnswerArray[$key];
                        $user_ans[$k]['text_ans'][1] = $trueFalseArray[$key];

                        if( !empty($request['audio_path'][$key]) ) { 
                            $fileName = $request['audio_path'][$key];
                            if(file_exists('public/uploads/practice/audio/'.$fileName)){
                                $path = public_path('uploads/practice/audio/'.$fileName);
                                $encoded_data = base64_encode(file_get_contents($path));
                            } else {
                                $encoded_data = "";
                            }
                        } else {
                            $encoded_data = "";
                        }
                        
                        if(isset($request['two_table_option_speaking_up_'.$j]) && $request['two_table_option_speaking_up_'.$j] =="blank"){
                            $encoded_data = "blank"; 
                        }   
                        $user_ans[$k]['path'] = $encoded_data;
                    // } else{
                    //  $user_ans[$k]="";
                    // }
                    array_push($user_ans, '##');
                    $k+=2;
                    $j+=1;
                }

                    // dd($user_ans);
            } else {
                // pr($makeAnswerArray);
                foreach($makeAnswerArray as $key => $value) {
                    $user_ans[$k]['text_ans'][0] = $makeAnswerArray[$key];
                    $user_ans[$k]['text_ans'][1] = $trueFalseArray[$key]; 
                    array_push($user_ans, '##');
                    $k+=2;
                }
            }

            array_pop($user_ans);

        } else {
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    if(!empty($a)){
                        $ansKey = $kk + 1;
                        if( $a!="^D^" ) {
                            $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                        }
                    }else{
                        unset($trueFalseArray[$k][$kk] );
                    }

                }
            }
            //pr($trueFalseArray);
            //  pr($makeAnswerArray);
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                // $request['blanks_up']= str_replace("<div>","<br>",$request['blanks_up']);
                // $request['blanks_up']= str_replace("</div>","",$request['blanks_up']);               
                // $request['blanks_up']= str_replace("&nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("&amp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("amp;"," ",$request['blanks_up']);                
                $user_ans[1] = $request['blanks_up'];
            }


        }
        // dd($user_ans);
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function saveBlankTableThreeBlaenTable(Request $request){
        $request = $request->all();

        
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##"){
                    $seperationKey = $key;
                }
                unset($answer[$seperationKey]);
                unset($trueFalseArray[$seperationKey]);
            }

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];

            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            $user_ans=array();
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $user_ans[0]['text_ans'][0] = $makeAnswerArray[0];
                $user_ans[0]['text_ans'][1] = $trueFalseArray[0];
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }

                $user_ans[0]['path'] = $encoded_data;


                $user_ans[1] = "##";


                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-1.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                $user_ans[2]['path']=$encoded_data;
                $user_ans[2]['text_ans'][0] = $makeAnswerArray[1];
                $user_ans[2]['text_ans'][1] = $trueFalseArray[1];

            }else{
                $user_ans[0][0][0] = $makeAnswerArray[0];
                $user_ans[0][0][1] = $trueFalseArray[0];

                $user_ans[0][1][0] = $makeAnswerArray[1];
                $user_ans[0][1][1] = $trueFalseArray[1];
            }



        }else{
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            
            $makeAnswerArray = array();

            foreach($answer as $k=>$ans){
            
                foreach($ans as $kk=>$a){
                    // echo $a;
                    // echo "<br>";
                    // if(!empty($a)){
                        $ansKey = $kk + 1;
                        $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                    // }else{
                        // unset($trueFalseArray[$k][$kk] );
                    // }

                }
            }
            
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                // dd($oldWayUserAns[0]);
                $user_ans[0]['text_ans']=$oldWayUserAns[0];


                if(isset($request['three_blank_table_speaking_up_new']) && $request['three_blank_table_speaking_up_new'] == "blank"){
                    $encoded_data= "blank"; 
                }

                $user_ans[0]['path']=$encoded_data;
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                // $request['blanks_up']= str_replace("<div>","<br>",$request['blanks_up']);
                // $request['blanks_up']= str_replace("</div>","",$request['blanks_up']);               
                // $request['blanks_up']= str_replace("&nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("&amp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("amp;"," ",$request['blanks_up']);                
                $user_ans[1] = $request['blanks_up'];
            }


        }

        // dd($user_ans);


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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function saveBlankTableThreeTableOption(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##"){
                    $seperationKey = $key;
                }
                unset($answer[$seperationKey]);
                unset($trueFalseArray[$seperationKey]);
            }

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];

            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
            $user_ans=array();
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $user_ans[0]['text_ans'][0] = $makeAnswerArray[0];
                $user_ans[0]['text_ans'][1] = $trueFalseArray[0];
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['path'] = $encoded_data;


                $user_ans[1] = "##";


                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-1.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                $user_ans[2]['path']=$encoded_data;
                $user_ans[2]['text_ans'][0] = $makeAnswerArray[1];
                $user_ans[2]['text_ans'][1] = $trueFalseArray[1];

            }else{
                $user_ans[0][0][0] = $makeAnswerArray[0];
                $user_ans[0][0][1] = $trueFalseArray[0];

                $user_ans[0][1][0] = $makeAnswerArray[1];
                $user_ans[0][1][1] = $trueFalseArray[1];
            }



        }else{
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;

                    $makeAnswerArray[$k]['col_'.$ansKey] = $a==null?"":$a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                $user_ans[1] = $request['blanks_up'];
            }


        }
        // dd($user_ans);
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function saveBlankTableThreeRoleplay(Request $request){
        $request = $request->all();
        
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        array_pop($answer);
        $seperationKey = '';
        $trueFalseArray = $request['true_false'];
        foreach($answer as $key=>$answerr){
            if($answerr == "##"){
                $seperationKey = $key;
            }
            unset($answer[$seperationKey]);
            unset($trueFalseArray[$seperationKey]);
        }

        $answer = array_chunk($answer,$request['table_type']);
        $answer = array_chunk($answer,13);

        $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
        $trueFalseArray = array_chunk($trueFalseArray,13);
        $seperationKey = $seperationKey / $request['table_type'];
        $makeAnswerArray = array();
        foreach($answer as $k=>$ans){
            foreach($ans as $kk=>$a){
                $data = [];
                $myinc=0;
                foreach($a as $testk=>$tempchange){
                    $myinc++;
                    $data['col_'. $myinc] = is_null($tempchange)?"":$tempchange;
                }
                $ansKey = $kk + 1;
                $makeAnswerArray[$k][] = $data;
            }
        }
        // $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
        // $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);
        $user_ans=array();
            
            $d = 0;
            for($k=0;$k<=8;$k++){


                if($k%2!=0){
                    $user_ans[$k] = "##";
                }else{
                    $user_ans[$k]['text_ans'][0] =  $makeAnswerArray[$d];
                    $user_ans[$k]['text_ans'][1] = $trueFalseArray[$d];
                            // echo $d."<br>";
                    if($d == 0){
                        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';

                    }else{

                        $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-'.$d.'.wav';
                    }
                    if(file_exists('public/uploads/practice/audio/'.$fileName)){
                      $path = public_path('uploads/practice/audio/'.$fileName);
                      $encoded_data = base64_encode(file_get_contents($path));
                    } else {
                      $encoded_data ="";
                    }
                    $user_ans[$k]['path'] = $encoded_data;
                    $d++;
                }

            }

            // dd($user_ans);




        
            // dd($user_ans);
            // dd("asdas");
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
        // dd($request_payload);
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function saveBlankTableFourBlankTableListening(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $trueFalseArray = $request['true_false'];
        if($request['header']== $request['table_type']){
            $answer = $request['col'];
            $temp = array_chunk($answer,$request['table_type']);
            $temp1 = array_chunk($trueFalseArray,$request['table_type']);
        }else{
            $answer = $request['table_type'];
            $temparray1 = array();
            $temp1 = array();
            $final1 = array();
            foreach ($trueFalseArray as $key => $value) {
                if($request['header']<=$key){
                    array_push($temparray1,$value);                 
                }else{
                    array_push($final1,$value);                 

                }
            }
            array_push($temp1,$final1);
            $answer = array_chunk($temparray1,$request['table_type']);
            foreach ($answer as $key => $value) {
                array_push($temp1,$value);
            }
            $answer = $request['col'];
            $temparray = array();
            $temp = array();
            $final = array();
            foreach ($answer as $key => $value) {
                if($request['header']<=$key){
                    array_push($temparray,$value);                  
                }else{
                    array_push($final,$value);                  

                }
            }

            array_push($temp,$final);
            $answer = array_chunk($temparray,$request['table_type']);
            foreach ($answer as $key => $value) {
                array_push($temp,$value);
            }
        }
            $makeAnswerArray = array();
            foreach($temp as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $temp1;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){          
                $user_ans[1] = $request['blanks_up'];
            }


    
        // dd($user_ans);
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function saveBlankTableOne(Request $request){
        $request = $request->all();
        $topicId = $request['topic_id'];
        $answer = $request['col'];
        // dd($request);
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            array_pop($answer);
            $seperationKey = '';
            $trueFalseArray = $request['true_false'];
            foreach($answer as $key=>$answerr){
                if($answerr == "##"){
                    $seperationKey = $key;
                }
                unset($answer[$seperationKey]);
                unset($trueFalseArray[$seperationKey]);
            }

            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $seperationKey = $seperationKey / $request['table_type'];

            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $makeAnswerArray = array_chunk($makeAnswerArray,$seperationKey);
            $trueFalseArray = array_chunk($trueFalseArray,$seperationKey);


            $user_ans=array();
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $user_ans[0]['text_ans'][0] = $makeAnswerArray[0];
                $user_ans[0]['text_ans'][1] = $trueFalseArray[0];
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['path'] = $encoded_data;


                $user_ans[1] = "##";


                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-1.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                } else {
                    $encoded_data ="";
                }
                $user_ans[2]['path']=$encoded_data;
                $user_ans[2]['text_ans'][0] = $makeAnswerArray[1];
                $user_ans[2]['text_ans'][1] = $trueFalseArray[1];

            }else{
                $user_ans[0][0][0] = $makeAnswerArray[0];
                $user_ans[0][0][1] = $trueFalseArray[0];

                $user_ans[0][1][0] = $makeAnswerArray[1];
                $user_ans[0][1][1] = $trueFalseArray[1];
            }
        }else{
            $answer = array_chunk($answer,$request['table_type']);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_ans=array();
            $user_ans[0][0] = $makeAnswerArray;
            $user_ans[0][1] = $trueFalseArray;
            if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
                $oldWayUserAns = $user_ans;
                $user_ans=array();
                $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                $user_ans[0]['text_ans']=$oldWayUserAns[0];
                $user_ans[0]['path']=$encoded_data;
            }

            if(isset($request['blanks_up']) && !empty($request['blanks_up'])){
                // $request['blanks_up']= str_replace("<div>","<br>",$request['blanks_up']);
                // $request['blanks_up']= str_replace("</div>","",$request['blanks_up']);               
                // $request['blanks_up']= str_replace("&nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("nbsp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("&amp;"," ",$request['blanks_up']);
                // $request['blanks_up']= str_replace("amp;"," ",$request['blanks_up']);                
                $user_ans[1] = $request['blanks_up'];
            }


        }

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

        // dd($request_payload);
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
          $request_payload['is_roleplay_submit'] = true;
        }

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function readingNoBlanks(Request $request){
        $request = $request->all();
        $answer = $request['blanks'];
        if(isset($request['ptype']) && $request['ptype'] == "reading_blanks"){
            $makeAnswer = array();
            foreach($answer as $key=>$answerss){
                if($key <= 0){
                    $makeAnswer[$key]['ans_pos'] = "0";
                }elseif(empty($answerss)){
                    $makeAnswer[$key]['ans_pos'] = "-1";
                }else{
                    $makeAnswer[$key]['ans_pos'] = "1";
                }
                $makeAnswer[$key]['ans'] = $answerss;
            }
            $answer = $makeAnswer;
        }else {
            if(!isset($request['is_uniqueExercise'])){
                foreach($answer as $key=>$answerss){
                    if(empty($answerss)){
                        $answer[$key] = " ";
                    }
                }
                $answer = implode(";",$answer);
            }
            if(is_string($answer))
            {
                 $answer = html_entity_decode($answer);
            }
        }
        $newArrayAns = [];
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1" || $request['is_roleplay'] ==true )) {
            if(!isset($request['is_uniqueExercise'])){
                $answers = $request['blanks'];
                $newAnswers = array();
                $i = 0;
                foreach($answers as $answer){
                    if($answer == "##"){
                        $i++;
                        $answer = html_entity_decode($answer);
                        $newAnswers[$i] = $answer;
                        $i++;
                    }else{
                        if(empty($answer)){
                            $answer = " ";
                        }
                        $answer = html_entity_decode($answer);
                        $newAnswers[$i][] = $answer;
                    }
                }
                if(isset($newAnswers[0])){
                    $newArrayAns[0][]   = implode(";", $newAnswers[0]);
                }else{
                    $newArrayAns[0] = "";
                }
                $newArrayAns[1] = $newAnswers[1];
                if(isset($newAnswers[2])){
                    $newArrayAns[2][]   = implode(";", $newAnswers[2]);
                }else{
                    $newArrayAns[2] ="";
                }
            }
        }
        $user_ans=array();
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1" || $request['is_roleplay'] == true)){
            $user_ans =$newArrayAns;
        }elseif(isset($request['ptype']) && $request['ptype'] == "reading_blanks"){
            $user_ans[0] = $answer;
        }else{
            $user_ans[0] = $answer.';';
        }

        $topicId = $request['topic_id'];
        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $oldWayUserAns = $user_ans;
            $user_ans=array();
            $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
            if(file_exists('public/uploads/practice/audio/'.$fileName)){
              $path = public_path('uploads/practice/audio/'.$fileName);
              $encoded_data = base64_encode(file_get_contents($path));
            } else {
              $encoded_data ="";
            }
            $user_ans[0]['text_ans']=$oldWayUserAns[0];
            if(isset($request['audio_reading']) && $request['audio_reading'] == "blank"){
                $encoded_data = "blank";    
            }
            $user_ans[0]['path']=$encoded_data;
        }
        if(isset($request['is_uniqueExercise'])){
            $answers = $request['blanks'];
            if(isset($answers[0])){
                $user_ans[0][0] = implode(";",$answers[0]).";";
            }else{
                $user_ans[0] = "";
            }
            $user_ans[1]    = "##";
            if(isset($answers[1])){
                $user_ans[2][0] = implode(";",$answers[1]).";";
            }else{
                $user_ans[2] = "";
            }
        } 
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }
        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
        $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
        $endPoint = "practisesubmit";
        if(!empty($request['is_roleplay']) && $request['is_roleplay']==true){
            $request_payload['is_roleplay'] = true;
        }
        if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
            $request_payload['is_roleplay_submit'] = true;
        }
        // dd(json_encode($request_payload));
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function trueFalseListening(Request $request){
        $request = $request->all();
        $answer = $request['question'];

        $createAnswerArray = array();
        foreach($answer as $k=>$ans){
            $createAnswerArray[$k]['question'] = $ans;
            if(isset($request['true_false_ticks'][$k]) && $request['true_false_ticks'][$k] == "true"){
                $createAnswerArray[$k]['true_false'] = 1;
            }elseif(isset($request['true_false_ticks'][$k]) && $request['true_false_ticks'][$k] == "false"){
                $createAnswerArray[$k]['true_false'] = 0;
                $createAnswerArray[$k]['text_ans'] = $request['false_why'][$k];
            }else{
                $createAnswerArray[$k]['true_false'] = -1;
            }

        }


        $user_ans[0] = $createAnswerArray;
        
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
        $endPoint = "practisesubmit";
        //  pr($request_payload);
        $response = curl_post($endPoint, $request_payload);
        if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
        }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
        }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
        }
    }
    public function clockSubmit(Request $request){
        $request = $request->all();

        $user_ans=array();
        $user_ans[0]['text_ans'][0] = $request['editableclocks'];
        $user_ans[0]['text_ans'][1] = $request['clock'];
        $user_ans[0]['path'] = '';


        
        $topicId = $request['topic_id'];

        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $oldWayUserAns = $user_ans;
            //$user_ans=array();
            $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
            if(file_exists('public/uploads/practice/audio/'.$fileName)){
              $path = public_path('uploads/practice/audio/'.$fileName);
              $encoded_data = base64_encode(file_get_contents($path));
            } else {
              $encoded_data ="";
            }
            //$user_ans[0]['text_ans']=$oldWayUserAns[0];
            if(isset($request['clock_view_speaking']) && $request['clock_view_speaking'] == "blank"){
                $encoded_data= "blank"; 
            }
            $user_ans[0]['path']=$encoded_data;
        }






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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }
        if(isset($request['speaking_one']) && !empty($request['speaking_one']) && $request['speaking_one'] == "true"){
            $request_payload['is_file'] = true;
        }
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
    public function familyTreeSubmit(Request $request){
        $request = $request->all();

        $user_ans=array();
        $user_ans = $request['tree'];
        
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
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

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
    public function boardGamePost(Request $request){
        $request = $request->all();
        $user_ans = '';
        $getExistingAnswer = getPracticeAnswer($request);
        if(empty($getExistingAnswer)){
            $user_ans = array();
            for($i=0;$i<=56;$i++){
                if($i%2 == 0){
                    $user_ans[$i] = '';
                }else{
                    $user_ans[$i] = '##';
                }
            }
        }else{
            $user_ans = $getExistingAnswer['user_Answer'];
            unset($user_ans['is_complete']);
            unset($user_ans['wholeTaskCompleted']);
            unset($user_ans['topicCompleted']);
        }

        $key = $request['answer_index']*2;

        if($request['practise_type'] == "writing"){
            $user_ans[$key] = $request['writeingBox'][0];
        }elseif($request['practise_type'] == "reading_total_blanks"){
            $answer = $request['blanks'];
            foreach($answer as $keys=>$answerss){
                if(empty($answerss)){
                    $answer[$keys] = " ";
                }
            }
            $answer = implode(";",$answer);
            $user_ans[$key] = array();
            $user_ans[$key][0] = $answer.';';
        }elseif($request['practise_type'] == "four_blank_table"){

            $answer = $request['col'];

            $answer = array_chunk($answer,4);
            $trueFalseArray = $request['true_false'];
            $trueFalseArray = array_chunk($trueFalseArray,4);
            $makeAnswerArray = array();
            foreach($answer as $k=>$ans){
                foreach($ans as $kk=>$a){
                    $ansKey = $kk + 1;
                    $makeAnswerArray[$k]['col_'.$ansKey] = $a;
                }
            }
            $user_anssss=array();
            $user_anssss[0][0] = $makeAnswerArray;
            $user_anssss[0][1] = $trueFalseArray;

            $user_ans[$key] = $user_anssss;
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
        $request_payload['is_roleplay'] = true;

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
    public function saveDragDrop(Request $request){
        $request = $request->all();

        $user_ans=array();
        $user_ans[0] = $request['drag_drop_image'];
        
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
        $request_payload['is_file'] = true;
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

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
    public function saveDragDropSpeaking(Request $request){
        $request = $request->all();

        $getExistingAnswer = getPracticeAnswer($request);
        if(empty($getExistingAnswer)){
            $user_ans = array();
            for($i=0;$i<=2;$i++){
                if($i%2 == 0){
                    $user_ans[$i] = '';
                }else{
                    $user_ans[$i] = '##';
                }
            }
        }else{
            $user_ans = $getExistingAnswer['user_Answer'];
            unset($user_ans['is_complete']);
            unset($user_ans['wholeTaskCompleted']);
            unset($user_ans['topicCompleted']);
        }
        $user_ans = array();
        for($i=0;$i<=2;$i++){
            if($i%2 == 0){
                $user_ans[$i] = array();
            }else{
                $user_ans[$i] = '##';
            }
        }
        if($request['answer_index'] == 0 || $request['answer_index'] == "0"){
            $user_ans[0][1] = '';
            $user_ans[0][2] = $request['drag_drop_image'];
            unset($user_ans[2]);
        }elseif($request['answer_index'] == 1 || $request['answer_index'] == "1"){
            $user_ans[2][1] = '';
            $user_ans[2][2] = $request['drag_drop_image'];
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
        $request_payload['is_file'] = true;
        if(isset($request['is_roleplay']) && ($request['is_roleplay'] == 1 || $request['is_roleplay'] == "1")){
            $request_payload['is_roleplay'] = true;
        }

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



    // PracticeJayminController.php
}
    
