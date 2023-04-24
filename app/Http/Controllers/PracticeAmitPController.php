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

class PracticeAmitPController extends Controller {
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
                $temp_ans_pos = $answers['ans_pos'][$key] == null ? "-1" : (int)$answers['ans_pos'][$key];
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
}