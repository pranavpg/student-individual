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

class PractiseNewController extends Controller
{
  public function saveBlankTableSpeaking(Request $request){
    $request = $request->all();
   
    
    $user_ans=array();

    $user_ans[0]['text_ans']= $request['text_ans'];
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    } else {
      $encoded_data ="";
    }
    $user_ans[0]['path']=$encoded_data;
    $is_file = !empty($encoded_data) ? true : false;
    $response =  $this->commonSaveFunction(  $request, $user_ans, $is_file);

    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveSpeakingWriting(Request $request){

    $request = $request->all();

    
    
    $user_ans=array();



    if(!empty($request['practice_type']) && ($request['practice_type']=="listening_speaking" || $request['practice_type']=="listening_Speaking") ) {
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      $encoded_data="";
      $tempaudio="";
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
          $tempaudio = base64_encode(file_get_contents($path));
      }
      if(isset($request['listening_speaking']) && $request['listening_speaking'] =="blank"){
          $tempaudio = "blank"; 
          $user_ans[0]['path']= $tempaudio;
      }else{
          $user_ans[0]['path']= $tempaudio;

      }
    } else if(!empty($request['practice_type']) && $request['practice_type']=="writing_at_end_speaking_up") {
       foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
       }
      $user_ans[0]['text_ans'][]= $request['text_ans'];
    } else {
      if(!empty($request['answer']) && is_array($request['answer'])) {
       

        foreach($request['answer'] as $key=>$val){
          $ans= str_replace("<div>","\r\n",$val['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $encoded_data="";
          $user_ans[$key]['text_ans'] =  $ans;

          if(!empty($val['path'])){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
              if(file_exists('public\\uploads\\practice\\audio\\'.$val['path'])){
                  $path = public_path('uploads\\practice\\audio\\'.$val['path']);
                $path = str_replace('\\','/',$path); 
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }else{
              if(file_exists('public/uploads/practice/audio/'.$val['path'])){
                $path = public_path('uploads/practice/audio/'.$val['path']);
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }
          }
    
          if(isset($request['writing_at_end_up_speaking_up']) && $request['writing_at_end_up_speaking_up'] == "blank"){
            $encoded_data = "blank";  
          }

            $user_ans[$key]['path'] = $encoded_data;
          
        }
      }
      elseif(!empty($request['text_ans']) && is_array($request['text_ans'])){

        foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
            $user_ans[0]['text_ans']= $request['text_ans'];
        }
      } else {
        if(isset($request['practise_type']) && $request['practise_type'] == 'speaking_writing'){
       
          if(isset($request['is_roleplay']) && !empty($request['is_roleplay'])){
            //Roleplay
            
            foreach($request['user_answer'] as $key=>$val){
            
              if(isset($val['text_ans']) || isset($val['path'])){
                $encoded_data="";
                $user_ans[$key]['text_ans'] =  $val['text_ans'];
              
                if(!empty($val['path'])){
                  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    if(file_exists('public\\uploads\\practice\\audio\\'.$val['path'])){
                        $path = public_path('uploads\\practice\\audio\\'.$val['path']);
                      $path = str_replace('\\','/',$path); 
                      $encoded_data = base64_encode(file_get_contents($path));
                    }
                  }else{
                    if(file_exists('public/uploads/practice/audio/'.$val['path'])){
                      $path = public_path('uploads/practice/audio/'.$val['path']);
                      $encoded_data = base64_encode(file_get_contents($path));
                    }
                  }
                }
                /*if(isset($request['writing_at_end_up_speaking_up']) && $request['writing_at_end_up_speaking_up'] == "blank"){
                  $encoded_data = "blank";  
                }*/
                $user_ans[$key]['path'] = $encoded_data;
              }else{
                if($val == "#"){
                   $user_ans[$key]="##";
                }else{
                  $user_ans[$key] = "";
                  //$user_ans[$key]['path']="";
                }
              }
            }
            // $user_ans=$request['user_answer'];
          }
          // pr($user_ans);
        }else{
          $ans= str_replace("<div>","\r\n",$request['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $request['text_ans'] = $ans;
          $user_ans[0]['text_ans']= $request['text_ans'];
        }
      } 
    }

  
    if( !empty($request['text_ans']) ){
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        if(file_exists('public\\uploads\\practice\\audio\\'.$fileName)){
          $path = public_path('uploads\\practice\\audio\\'.$fileName);
          $path = str_replace('\\','/',$path); 
          $encoded_data = base64_encode(file_get_contents($path));
        }else {
          $encoded_data = "";
        }

      }else{
        if(file_exists('public/uploads/practice/audio/'.$fileName)) {
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
        
        } else {
          $encoded_data = "";
        }
      }
      if(isset($request['writing_at_end_up_speaking_up']) && $request['writing_at_end_up_speaking_up'] == "blank"){
        $encoded_data = "blank";  
      }

      if(isset($request['listening_speaking']) && $request['listening_speaking'] =="blank"){
          $encoded_data = "blank"; 
      }
      if(isset($request['speaking_writing']) &&  $request['speaking_writing'] == "blank"){
        $encoded_data="blank";
      } 
      $user_ans[0]['path'] = $encoded_data;
    }else{

      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        if(file_exists('public\\uploads\\practice\\audio\\'.$fileName)){
          $path = public_path('uploads\\practice\\audio\\'.$fileName);
          $path = str_replace('\\','/',$path); 
          $encoded_data = base64_encode(file_get_contents($path));
        }else {
          $encoded_data = "";
        }

      }else{
        if(file_exists('public/uploads/practice/audio/'.$fileName)) {
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
        
        } else {
          $encoded_data = "";
        }
      }
      if(isset($request['writing_at_end_up_speaking_up']) && $request['writing_at_end_up_speaking_up'] == "blank"){
        $encoded_data = "blank";  
      }
      if((isset($request['listening_speaking']) && $request['listening_speaking'] == "blank") ||  (isset($request['listening_Speaking']) && $request['listening_Speaking'] == "blank") ){
        $encoded_data = "blank";  
      }
      if( !empty($request['text_ans']) ){
        // $user_ans[0]['text_ans'][] = array();
        $user_ans[0]['text_ans'][]= "";
      }
      if(isset($request['speaking_writing']) &&  $request['speaking_writing'] == "blank"){
        $encoded_data="blank";
      } 
      $user_ans[0]['path'] = $encoded_data;
    }
    // speaking_writing
    // dd($user_ans);
    // $user_ans[0][1] = $trueFalseArray;
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    $request_payload['is_file'] = "true";//!empty($encoded_data) ? true : false;
    // dd(json_encode($request_payload));
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
 
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }


  public function saveSpeakingWritingUp(Request $request){
    $request = $request->all();
    $user_ans=array();
    if(!empty($request['practice_type']) && ($request['practice_type']=="listening_speaking" || $request['practice_type']=="listening_Speaking") ) {
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      $encoded_data="";
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
      }
      $user_ans[0]['path']= $encoded_data;
    } else if(!empty($request['practice_type']) && $request['practice_type']=="writing_at_end_speaking_up") {
       foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
       }
      $user_ans[0]['text_ans'][]= $request['text_ans'];
    } else {
      if(!empty($request['answer']) && is_array($request['answer'])) {
        foreach($request['answer'] as $key=>$val){
          $ans= str_replace("<div>","\r\n",$val['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $encoded_data="";
          $user_ans[$key]['text_ans'] =  $ans;
          if(!empty($val['path'])){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
              if(file_exists('public\\uploads\\practice\\audio\\'.$val['path'])){
                  $path = public_path('uploads\\practice\\audio\\'.$val['path']);
                $path = str_replace('\\','/',$path); 
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }else{
              if(file_exists('public/uploads/practice/audio/'.$val['path'])){
                $path = public_path('uploads/practice/audio/'.$val['path']);
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }
          }
          if(isset($request['speaking_writing_up_'.$key]) &&  $request['speaking_writing_up_'.$key] == "blank"){
            $encoded_data="blank";
          } 
            $user_ans[$key]['path'] = $encoded_data;
        }
      }
      elseif(!empty($request['text_ans']) && is_array($request['text_ans'])){
        foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
            $user_ans[0]['text_ans']= $request['text_ans'];
        }
      } else {
          $ans= str_replace("<div>","\r\n",$request['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $request['text_ans'] = $ans;
          $user_ans[0]['text_ans']= $request['text_ans'];
          $encoded_data = "";
          if(isset($request['speaking_writing_up_0']) &&  $request['speaking_writing_up_0'] == "blank"){
            $encoded_data="blank";
          } 
          $user_ans[0]['path']= $encoded_data;
      } 
    }
  
    $request['text_ans'] = $request['text_ans']==""?" ":$request['text_ans'];
    if( !empty($request['text_ans']) ){
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        if(file_exists('public\\uploads\\practice\\audio\\'.$fileName)){
          $path = public_path('uploads\\practice\\audio\\'.$fileName);
          $path = str_replace('\\','/',$path); 
          $encoded_data = base64_encode(file_get_contents($path));
        }else {
          $encoded_data = "";
        }
        if(isset($request['speaking_writing_up_0']) &&  $request['speaking_writing_up_0'] == "blank"){
          $encoded_data="blank";
        } 
      }else{
        if(file_exists('public/uploads/practice/audio/'.$fileName)) {
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
        } else {
          $encoded_data = "";
        }
      }
      $user_ans[0]['path'] = $encoded_data;
    }else{
        $encoded_data = "";
        if(isset($request['speaking_writing_up']) &&  $request['speaking_writing_up'] == "blank"){
          $encoded_data="blank";
        } 
        $user_ans[0]['path'] = $encoded_data;
    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    $request_payload['is_file'] = !empty($encoded_data) ? true : false;
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveTrueFalseSpeaking(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if($request['practice_type']=='true_false_simple_left_align_listening' || $request['practice_type']=='true_false_writing_at_end' || $request['practice_type']=='true_false_writing_at_end_simple'){
        $user_ans[0]  = $request['text_ans'];
    } else {
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
        $path = public_path('uploads/practice/audio/'.$fileName);
        $encoded_data = base64_encode(file_get_contents($path));
      }
      $user_ans[0]['text_ans'] = isset($request['text_ans'])?$request['text_ans']:"";
          if(isset($request['true_false_speaking_up_simple']) &&  $request['true_false_speaking_up_simple'] == "blank"){
            $encoded_data="blank";
          } 
            $user_ans[0]['path']=$encoded_data;
    }
    if($request['practice_type'] == "true_false_writing_at_end" || $request['practice_type'] == "true_false_writing_at_end_simple"){
      if(isset($request['is_roleplay']) && !empty($request['is_roleplay'])){
            foreach($user_ans[0] as $key1=>$data){
                foreach($data as $key=>$data1){
                    if(!isset($user_ans[0][$key1][$key]['true_false']) ) {
                        $user_ans[0][$key1][$key]['true_false']= "-1";
                    }
                    if(is_null($user_ans[0][$key1][$key]['text_ans'])) {
                        $user_ans[0][$key1][$key]['text_ans']= "";
                    }
                    $user_ans[0][$key1][$key]['question']= $user_ans[0][$key1][$key]['question']. "@@";
                }
            }
            $newArray = array();
            $l=0; 
            foreach($user_ans[0] as $key=>$data){
                if($l == 1){
                  $newArray[$l] = "##";
                  $newArray[$l+1][0] = $data;
                }else{
                  $newArray[$l][0] = $data;
                }
                $l++;
            }
            $user_ans = $newArray;
          }else{
            $finalArray=array();
              foreach($user_ans[0] as $ans){
                if(is_null($ans['text_ans'])){
                  $ans['text_ans'] = '';
                }
                if(!isset($ans['true_false'])){
                  $ans['true_false']='-1';
                }
                $finalArray[0][]=$ans;
              }
              $user_ans=$finalArray;
          }
    }elseif($request['practice_type'] == "true_false_simple_left_align_listening"){
            $user_ans = array($request['text_ans']);
    }else{
        foreach($user_ans as $data){
              foreach($data['text_ans'] as $key=>$data1){
                  if(!isset($data1['true_false'])){
                      $user_ans[0]['text_ans'][$key]['true_false']= '-1';
                  }
              }
          }

    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    if(!empty($encoded_data)){
      $request_payload['is_file'] = true;
    }
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveTrueFalseWritingSimple(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    }
    $user_ans[0]['text_ans'] = $request['text_ans'];
    $user_ans[0]['path']=$encoded_data;
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    // dd($request_payload);
    if(!empty($encoded_data)){
      $request_payload['is_file'] = true;
    }
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveWritingMultiplevideo(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if($request['practice_type']=='true_false_simple_left_align_listening' || $request['practice_type']=='true_false_writing_at_end' || $request['practice_type']=='true_false_writing_at_end_simple'){
      $user_ans[0]  = $request['text_ans'];
    } else {
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
        $path = public_path('uploads/practice/audio/'.$fileName);
        $encoded_data = base64_encode(file_get_contents($path));
      }
      $user_ans[0]['text_ans'] = $request['text_ans'];
      $user_ans[0]['path']=$encoded_data;
    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    if(!empty($encoded_data)){
      $request_payload['is_file'] = true;
    }
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
   public function saveUnderlineText(Request $request){
    $request = $request->all();
    $user_ans=array();
    $answer=array();
    if($request['practice_type'] == 'underline_text_writing_at_end'){
      $user_ans[0][0] =  $request['text_ans'][0][0];
      $user_ans[0][1] =  [];
      if(isset($request['text_ans'][0][1])){
        foreach ($request['text_ans'][0][1] as $key => $value) {
            $underline=array();
            if(!empty($value)){
              foreach ($value as $k => $v) {
                $underline["n_".$v['i']]['i'] = (int) $v['i'];
                $underline["n_".$v['i']]['fColor'] = (int)$v['fColor'];
                $underline["n_".$v['i']]['foregroundColorSpan'] =array();
                $underline["n_".$v['i']]['word'] = $v['word'];
                $underline["n_".$v['i']]['start'] =(int) $v['start'];
                $underline["n_".$v['i']]['end'] = (int)$v['end'];
              }
              $user_ans[0][1][$key]  =json_encode($underline,JSON_FORCE_OBJECT);
            }
            else {
              array_push($underline,"");
              $user_ans[0][1][$key]  = "";
            }
          }
      }
      foreach($user_ans[0][0] as $key=>$nedata){
        if(!array_key_exists($key, $user_ans[0][1])){
          $user_ans[0][1][$key] = "";
        }
      }
      ksort($user_ans[0][1]);
    }
    else if($request['practice_type'] == 'underline_text_multiple' ){
            $user_ans[0][0] =  $request['text_ans'][0];
            foreach ($request['text_ans'][0]  as $key => $value) {
                $underline=array();
                if(!empty($value['image'])){
                  $answer[$key]['image'] = $value['image'];
                }
                $answer[$key]['title'] = str_replace("<br />", "<br>", $value['title']);
                $answer[$key]['text'] = str_replace("<br />", "<br>", $value['text']);
                if(!empty($value['underline'])) {
                    foreach ($value['underline'] as $k => $v) {
                        $underline["n_".$v['i']]['end'] = (int)$v['end'];
                        $underline["n_".$v['i']]['fColor'] = (int)$v['fColor'];
                        $underline["n_".$v['i']]['foregroundColorSpan'] =array();
                        $underline["n_".$v['i']]['i'] = (int) $v['i'];
                        $underline["n_".$v['i']]['start'] =(int) isset($v['start'])?$v['start']:"";
                        $underline["n_".$v['i']]['word'] = $v['word'];
                    }
                    $answer[$key]['underline']  = json_encode($underline,JSON_FORCE_OBJECT);
                } else {
                  $answer[$key]['underline']="";
                }
            }
            $user_ans[0] = $answer;
    }
    else if($request['practice_type'] == 'underline_text_image' ){
            $user_ans[0][0] =  $request['text_ans'][0];
            foreach ($request['text_ans'][0]  as $key => $value) {
                $underline=array();
                if(!empty($value['image'])){
                  $answer[$key]['image'] = $value['image'];
                }
                $answer[$key]['title'] = str_replace("<br />", "<br>", $value['title']);
                $answer[$key]['text'] = str_replace("<br />", "<br>", $value['text']);
                if(!empty($value['underline'])) {
                    foreach ($value['underline'] as $k => $v) {
                        $underline["n_".$v['i']]['end'] = (int)$v['end'];
                        $underline["n_".$v['i']]['fColor'] = (int)$v['fColor'];
                        $underline["n_".$v['i']]['foregroundColorSpan'] =array();
                        $underline["n_".$v['i']]['i'] = (int) $v['i'];
                        $underline["n_".$v['i']]['start'] =(int) $v['start'];
                        $underline["n_".$v['i']]['word'] = $v['word'];
                    }
                    $answer[$key]['underline']  = json_encode($underline,JSON_FORCE_OBJECT);
                } else {
                  $answer[$key]['underline']="";
                }
            }
            $user_ans[0] = $answer;
    }
    else if($request['practice_type'] == 'underline_text_listening' ){
      foreach ($request['text_ans'][0][0] as $key => $value) {
        foreach ($value as $k => $v) {
          if($k=='word'){
            $underline["n_".$key][$k] = $v;
          } else if($k=='foregroundColorSpan'){
            $underline["n_".$key][$k] = array();
          }
          else{
            $underline["n_".$key][$k] = (int) $v;
          }
        }
      }
      $user_ans[0][0]  = json_encode($underline);
      if( !empty( $request['text_ans'][1][0] )) {
        $user_ans[1][0]  = $request['text_ans'][1][0];
      }
    }else {
      if(!isset($request['text_ans'][0][0]) OR empty($request['text_ans'][0][0]))
      {
         $user_ans[0][0] = '';
         if( !empty( $request['text_ans'][1][0] )) {
          $user_ans[1][0]  = $request['text_ans'][1][0];
          }else{
           $user_ans[1][0]  = "";
         }
      }
      else
      {
      foreach ($request['text_ans'][0][0] as $key => $value) {
        foreach ($value as $k => $v) {
          if($k=='word'){
            $underline["n_".$key][$k] = $v;
          } else if($k=='foregroundColorSpan'){
            $underline["n_".$key][$k] = array('mColor'=> (int)$v);
          }
          else{
            $underline["n_".$key][$k] = (int) $v;
          }
        }
      }
      $user_ans[0][0]  = json_encode($underline);
      if( !empty( $request['text_ans'][1][0] )) {
        $user_ans[1][0]  = $request['text_ans'][1][0];
      }else{
        $user_ans[1][0]  = "";
      }
    }
  }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveUnderlineTextRoleplay(Request $request){
    $request = $request->all();
    $user_ans=array();
    $answer=array();
    if(!empty($request['text_ans']) && $request['is_roleplay_submit']==0 ){
      if(empty($request['text_ans'][0])){
        $underline[0]="";
      }
      foreach ($request['text_ans'] as $key => $value) {
        $underline_text=array();
        if($value=="##"){
            $underline[$key]="##";
        } else {
          foreach ($value[0][0] as $k => $v) {
            foreach($v as $ki=> $vi){
              if($ki=='word'){
                $underline_text["n_".$k][$ki] = $vi;
              } else if($ki=='foregroundColorSpan'){
                $underline_text["n_".$k][$ki] = array('mColor'=> (int)$vi);
              }
              else{
                $underline_text["n_".$k][$ki] = (int) $vi;
              }
            }
          }
          $underline[$key][0][0] = json_encode($underline_text);
        }
      }
     if(empty($request['text_ans'][2])){
        $underline[2]="";
      }
    } else {
      $underline=array(); 
    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$underline;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    if(!empty($request['is_roleplay'])){
      $request_payload['is_roleplay'] = true;
    }
    if(!empty($request['is_roleplay_submit']) && $request['is_roleplay_submit']==1 ){
      $request_payload['is_roleplay_submit'] = true;
    }
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveWritingAtEndSpeaking(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if(isset($request['role_play'])){
      if(isset($request['practice_type']) && $request['practice_type'] == 'writing_at_end_speaking_multiple'){
        if(isset($request['user_answer']) && !empty($request['user_answer'])){
          foreach($request['user_answer'] as $key=>$item){
            if(isset($item['text_ans']) || isset($item['path'])){
              $fileName = $item['path'];
              $encoded_data="";
              if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
              }
              $user_ans[$key]['text_ans'] = $item['text_ans'];
              $user_ans[$key]['path'] = $encoded_data;
            }else{
              $user_ans[$key]='##';
            }
          }
        }
      }else{
        if(isset($request['role_play']) && isset($request['practice_type'])&& $request['practice_type'] == 'writing_at_end_speaking'){
          $count= count($request['text_ans']) * 2;
          $k=0;
          $s=0;
          for($i=0; $i < $count-1; $i++) 
          { 
            if ($i & 1 == 1) {
              array_push($user_ans, "##");
            } else{ 
              foreach ($request['text_ans'][$k] as $key1 => $new) {
                if($new ==="#####")
                {
                  $user_ans[$i]['text_ans'][$key1] = "";
                }else{
                  $user_ans[$i]['text_ans'][$key1] = $new;

                }
            }
            $encoded_data='';
            if(isset($request['user_audio'][$k]) && !empty($request['user_audio'][$k])){
              if(isset($request['user_audio'][$k]['audio_deleted']) && $request['user_audio'][$k]['audio_deleted'] == 'blank'){
                $encoded_data='blank';
              }else{
                 $encoded_data='';
              }
              if(isset($request['writing_at_end_speaking_role_play'.$s]) && $request['writing_at_end_speaking_role_play'.$s] == 'blank'){
                $encoded_data='blank';
              }
              if(isset($request['user_audio'][$k]['path']) && !empty($request['user_audio'][$k]['path'])){
                $fileName = $request['user_audio'][$k]['path'];
                  if(file_exists('public/uploads/practice/audio/'.$fileName)) {
                    $path = public_path('uploads/practice/audio/'.$fileName);
                    $encoded_data = base64_encode(file_get_contents($path));
                  } else {
                    $encoded_data = "";
                  }
              }
            }
            $user_ans[$i]['path']=$encoded_data;
            $k++;
            $s=$s+2;
            }
          }
        }else{
          $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
          if(file_exists('public/uploads/practice/audio/'.$fileName)){
              $path = public_path('uploads/practice/audio/'.$fileName);
              $encoded_data = base64_encode(file_get_contents($path));
          }
          foreach ($request['text_ans'] as $key => $value) {
              foreach ($value as $key1 => $new) {
                  if($new ==="#####")
                  {
                      $request['text_ans'][$key][$key1] = "";
                  }else{
                      $request['text_ans'][$key][$key1] = $new;

                  }
              }
          }
          $user_ans[0]['text_ans'] = $request['text_ans'][0];
          $user_ans[0]['path'] = $encoded_data;
          $user_ans[1] = "##";
          $user_ans[2]['text_ans'] = $request['text_ans'][1];
          $user_ans[2]['path'] = $encoded_data;
        }
      }
    }elseif($request['practice_type']=='writing_at_end_speaking'){
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
        $path = public_path('uploads/practice/audio/'.$fileName);
        $encoded_data = base64_encode(file_get_contents($path));
      }
      $user_ans[0]['text_ans'] = $request['text_ans'];
       if(isset($request['writing_at_end_speaking']) && $request['writing_at_end_speaking'] == "blank"){
          $encoded_data = "blank";
        }
      $user_ans[0]['path'] = $encoded_data;
    } else {
      if(isset($request['text_ans']) && !empty($request['text_ans'])){
        foreach ($request['text_ans'] as $key => $value) {
          $encoded_data="";
          if($value['audio_deleted']=='blank'){
            $encoded_data = 'blank';
          }elseif(isset($value['path']) && !empty($value['path'])){
            if(file_exists('public/uploads/practice/audio/'.$value['path'])){
              $path = public_path('uploads/practice/audio/'.$value['path']);
              $encoded_data = base64_encode(file_get_contents($path));
            }
          } else {
            $encoded_data = '';
          }
          $user_ans[$key]['text_ans'] = $value['text_ans'];
          $user_ans[$key]['path'] = $encoded_data;
        }
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, true);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }


  public function saveWritingAtEndUpSpeakingMultiple(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if(!empty($request['text_ans'])){
      foreach ($request['text_ans'] as $key => $value) {
        if($value['audio_deleted']=='blank'){
          $encoded_data = 'blank';
        } else if(!empty($value['path']) && file_exists('public/uploads/practice/audio/'.$value['path'])){
          $path = public_path('uploads/practice/audio/'.$value['path']);
          $encoded_data = base64_encode(file_get_contents($path));
        } else {
          $encoded_data = '';
        }
        $value['text_ans']= str_replace("<div>"," ",  $value['text_ans']);
        $value['text_ans']= str_replace("&nbsp;"," ",  $value['text_ans']);
        $value['text_ans'] = strip_tags($value['text_ans']);
        $user_ans[$key]['text_ans'] = $value['text_ans'];
        $user_ans[$key]['path'] = $encoded_data;
      }
    }
    $ua = array();
    for($i=0;$i<count($user_ans);$i++) {
      for($j=0;$j<count($user_ans);$j++) {
        $ua[$j] =$user_ans[$j];
        if($i!=$j){
          $ua[$j]['path']="";
        }
      }
      $response =  $this->commonSaveFunction($request, $ua, true);
    }
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveWritingAtEndOption(Request $request){
    $request = $request->all();
    $tempArray = array();
    $is_file = false;
    if(!empty($request['user_answer'])){
      $req_ans[0] = array_values($request['user_answer']);
      $tempArray = $req_ans;
    }
    if(is_array($tempArray[0][0]) && !empty($tempArray[0][0])) {
      foreach ($tempArray[0][0] as $key => $value) {
          $temp= str_replace("<div>","\r\n",$value);
          $temp= str_replace("</div>","",$temp);
          $temp= str_replace("&nbsp;"," ",$temp);
          $temp= htmlspecialchars_decode($temp);
          $temp = iconv('UTF-8', 'ASCII//TRANSLIT', $temp);
          $tempArray[$key]= trim($temp);
      }
    } else {
      foreach ($tempArray[0] as $key => $value) {
          $temp= str_replace("<div>","\r\n",$value);
          $temp= str_replace("</div>","",$temp);
          $temp= str_replace("&nbsp;"," ",$temp);
          $temp= htmlspecialchars_decode($temp);
          $temp = iconv('UTF-8', 'ASCII//TRANSLIT', $temp);
          $tempArray[$key]= trim($temp);
      }
    }
    if(is_array($tempArray[0])){
      $user_ans = $tempArray;
    }else{
      $user_ans[0] = $tempArray;
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSingleImageWriting(Request $request){
    $request = $request->all();
    $is_file = false;
  if(isset($request['is_roleplay']) && !empty($request['is_roleplay'])){
    $user_ans= $request['user_answer'];
  }else{
    foreach ($request['user_answer'] as $key => $value) {
        $value= str_replace("<div>","\r\n",$value);
        $value= str_replace("<br>","\r\n",$value);
        $value= str_replace("</div>","",$value);
        $value= str_replace("&nbsp;"," ",$value);
        $request['user_answer'][$key] = $value;
      }
      $user_ans[0] = $request['user_answer'];
  }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveTrueFalseRadio(Request $request){
    $request = $request->all();
    $is_file = false;
    foreach($request['text_ans'] as $key=>$item){
      $user_ans[0][$key]['question']=$item['question'];
      if(isset($item['selection'])){
        $user_ans[0][$key]['selection']=$item['selection'];
      }else{
        $user_ans[0][$key]['selection']=-1;
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSpeakingMultipleUp (Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if(isset($request['single_audio']) && !empty($request['single_audio'])){
        if(isset($request['user_answer']) && !empty($request['user_answer'])){
          foreach($request['user_answer'] as $key=> $value) {
            if(isset($value['path']) && !empty($value['path'])){
              if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                if(file_exists('public\\uploads\\practice\\audio\\'.$value['path'])){
                    $path = public_path('uploads\\practice\\audio\\'.$value['path']);
                  $path = str_replace('\\','/',$path); 
                  $encoded_data = base64_encode(file_get_contents($path));
                }
              }else{
                if(file_exists('public/uploads/practice/audio/'.$value['path'])){
                  $path = public_path('uploads/practice/audio/'.$value['path']);
                  $encoded_data = base64_encode(file_get_contents($path));
                }
            }
          } 
          if(isset($request['speaking_multiple_up']) && $request['speaking_multiple_up'] == "blank"){
            $encoded_data = "blank";  
          }
          $user_ans[$key] = $encoded_data;
        }
      }
     }elseif(!empty($request['text_ans'])){
      foreach($request['text_ans'] as $key => $value) {
        if(!empty($value['path'])){
          if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if(file_exists('public\\uploads\\practice\\audio\\'.$value['path'])){
                $path = public_path('uploads\\practice\\audio\\'.$value['path']);
              $path = str_replace('\\','/',$path); 
              $encoded_data = base64_encode(file_get_contents($path));
            }
          }else{
            if(file_exists('public/uploads/practice/audio/'.$value['path'])){
              $path = public_path('uploads/practice/audio/'.$value['path']);
              $encoded_data = base64_encode(file_get_contents($path));
            }
          }
        } else {
          $encoded_data ="";
        }
        $user_ans[$key] = $encoded_data;
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, true);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSpeakingMultipleListening (Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if(!empty($request['text_ans'])){
      foreach ($request['text_ans'] as $key => $value) {
        if(!empty($value['path'])){
          if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if(file_exists('public\\uploads\\practice\\audio\\'.$value['path'])){
                $path = public_path('uploads\\practice\\audio\\'.$value['path']);
              $path = str_replace('\\','/',$path); 
              $encoded_data = base64_encode(file_get_contents($path));
            }
          }else{
            if(file_exists('public/uploads/practice/audio/'.$value['path'])){
              $path = public_path('uploads/practice/audio/'.$value['path']);
              $encoded_data = base64_encode(file_get_contents($path));
            }
          }
        } else {
          if(!empty($request['text_ans'][$key]['audio_deleted']) && $request['text_ans'][$key]['audio_deleted'] =='blank' ){
            $encoded_data = "blank";
          }else{
            $encoded_data ="";
          }
        }
        $user_ans[$key] = $encoded_data;
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, true);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveMatchAnswerSingleImage(Request $request){
    $request = $request->all();
    if($request['practice_type']=='match_answer_speaking'){
        $tempArray = array();
        foreach($request['text_ans'] as $data){
            array_push($tempArray, $data==""?" ":$data);
        }
      $is_file = true;
      if($this->is_array_empty($request['text_ans'])){
        $user_ans[0]['text_ans']= implode( ' ;',$tempArray ).' ;';
      }else{
        $user_ans[0]['text_ans']= implode(';',$tempArray ).';';
      }
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
        $path = public_path('uploads/practice/audio/'.$fileName);
        $encoded_data = base64_encode(file_get_contents($path));
      } else {
        $encoded_data ="";
      }
      if(isset($request['match_answer_single_image']) && $request['match_answer_single_image'] == "blank"){
        $encoded_data = "blank";
      }
      $user_ans[0]['path']=$encoded_data;
    } else {
        $is_file = false;
        foreach($request['text_ans'] as $k=>$v) {
            $ans[$k] = is_null($v) ? " ": $v;
        }
        $user_ans  = implode(';', $ans).';';
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function is_array_empty($arr){
     if(is_array($arr)){
        foreach($arr as $value){
           if(!empty($value)){
              return false;
           }
        }
     }
     return true;
  }

  public function saveMatchAnswerSingleImageSpeakingUp(Request $request){
    $request = $request->all();
    $user_ans =array();
    $is_file = false;
    if(!empty($request['user_ans']) && $request['is_roleplay_submit']==0 ){
      $is_file = true;
      if(!empty($request['user_ans'])){
        ksort($request['user_ans']);
        $i=0;
        foreach ( $request['user_ans'] as $key => $value) {
          if($value!="##"){
            if(!empty($value['text_ans'])){
            $tempArray = array();
            foreach($value['text_ans'] as $data){
                array_push($tempArray, is_null($data)?" ":$data);
            }
            if($this->is_array_empty($value['text_ans'])){
                $user_ans[$key]['text_ans']= !empty($value['text_ans']) ? implode( ';',$tempArray ).';' : "";
            }else{
                $user_ans[$key]['text_ans']= !empty($value['text_ans']) ? implode( ';',$tempArray ).';' : "";
            }
                if($key==0){
                  $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
                } else{
                  $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'-2.wav';
                }
                if(file_exists('public/uploads/practice/audio/'.$fileName)){
                  $path = public_path('uploads/practice/audio/'.$fileName);
                  $encoded_data = base64_encode(file_get_contents($path));
                } else {
                  $encoded_data ="";
                }
                if(isset($request['match_answer_single_image_speaking_up'.$key]) && $request['match_answer_single_image_speaking_up'.$key] =="blank"){
                    $encoded_data = "blank"; 
                }
                $user_ans[$key]['path']=$encoded_data;
            } else {
              $user_ans[$key]="";
            }

          } else {
            $user_ans[$key]="##";
          }
        }
      }
    } else {
      $request['user_ans']=array();
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveWritingAtEndUpSingleUnderlineTextSelection(Request $request){
    $request = $request->all();
    $user_ans=array();
    $finalTextareaValueTemp = array();
    foreach ($request['user_answer'] as $key => $text) {
        $textareaValueTemp = array();
        foreach ($text as $key => $value) {
            $value['text_ans']= str_replace("<div>","\r\n",$value['text_ans']);
            $value['text_ans']= str_replace("</div>","",$value['text_ans']);
            $value['text_ans']= str_replace("&nbsp;"," ",$value['text_ans']);
            $value['text_ans']= str_replace("<br>"," ",$value['text_ans']);
            array_push($textareaValueTemp,$value['text_ans']); 
        }
        array_push($finalTextareaValueTemp,$textareaValueTemp);
    }
    $selectionTask = array();
    if(isset($request['text_ans'])){
        foreach($finalTextareaValueTemp as $key=>$finalMakeArray){
             $selectionTask[]=isset($request['text_ans'][$key])?$request['text_ans'][$key][1][0]:array();
        }
    }
    $finalAnsArray = [];
    foreach($finalTextareaValueTemp as $key=>$finalMakeArray){
        $finalAnsArray[$key][]=$finalMakeArray;
        $final = "";
        if(!empty($selectionTask)){
            if(isset($selectionTask[$key])){
              $tempArray = [];
              foreach($selectionTask[$key] as $data){
                $tempArray["n_".$data['i']] = $data;
                $final = array(json_encode($tempArray));
              }
            }else{
                $final = array("");
            }
        }else{
            $final = array("");
        }
        $finalAnsArray[$key][]=$final;
    }
    $finalAnsArrayF = [];
    $flag = true;
    foreach($finalAnsArray as $newkey=>$value){
        array_push($finalAnsArrayF,$value);
        if($flag){
            $flag = false;
            array_push($finalAnsArrayF,"##");
        }else{
            $flag = true;
        }
    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$finalAnsArrayF;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveWritingAtEndUpSingleUnderlineText(Request $request){
    $request = $request->all();
    $user_ans=array();
    if(isset($request['blanks'])){
      $obj1 = array_map('strval', $request['blanks']);
      $user_ans[0] = $obj1;
    }
    if(isset($request['text_ans'])){
      foreach ($request['text_ans'][0][0] as $key => $value) {
        foreach ($value as $k => $v) {
          if($k=='word'){
            $underline["n_".$key][$k] = $v;
          } else if($k=='foregroundColorSpan'){
            $underline["n_".$key][$k] = array();
          }
          else{
            $underline["n_".$key][$k] = (int) $v;
          }
        }
      }
      $user_ans[1][0]  = json_encode($underline);
    }
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload['cource_id'] =  Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
    $request_payload['topic_id'] = $topicId;
    $request_payload["task_id"] = $request['task_id'];
    $request_payload["practise_id"] = $request['practise_id'];
    $request_payload['user_answer'] =$user_ans;
    $request_payload['save_for_later'] = true;
    $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveUnderlineTextMultiColor(Request $request){
    $request = $request->all();
    $user_ans=array();
    if(isset($request['text_ans']) && is_array($request['text_ans'])){
          foreach ($request['text_ans'][1][0] as $key => $value) {
            foreach ($value as $k => $v) {
              if($k=='word'){
                $underline[$key][$k] = $v;
              } else if($k=='foregroundColorSpan'){
                $underline[$key][$k] = array('mColor'=> (int)$v);
              }
              else{
                $underline[$key][$k] = (int) $v;
              }
            }
          }
          $user_ans[0][0]  = json_encode($underline);
          $topicId = $request['topic_id'];
          $request_payload = array();
          $request_payload['student_id'] = Session::get('user_id_new');
          $request_payload['token_app_type'] = 'ieuk_new';
          $request_payload['token'] = Session::get('token');
          $request_payload['cource_id'] =  Session::get('course_id_new');
          $request_payload['level_id'] =  Session::get('level_id_new');
          $request_payload['topic_id'] = $topicId;
          $request_payload["task_id"] = $request['task_id'];
          $request_payload["practise_id"] = $request['practise_id'];
          $request_payload['user_answer'] =$user_ans;
          $request_payload['save_for_later'] = true;
          $request_payload['is_save'] = ($request['is_save']==1) ? true : false;
          $endPoint = "practisesubmit-individual";
          $response = curl_post($endPoint, $request_payload);
          if(empty($response)){
            return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
          }elseif(isset($response['success']) && !$response['success']){
            return response()->json(['success'=>false,'message'=>$response['message']], 200);
          }elseif(isset($response['success']) && $response['success']){
            return response()->json(['success'=>true,'message'=>$response['message']], 200);
          }
    }else{
      return response()->json(['success'=>true,'message'=>"All answers successfully submitted."], 200);
    }
  }
  public function saveCanDoStatements(Request $request){
    $request = $request->all();
    $is_file = false;
    foreach ($request['text_ans'] as $key => $value) {
      $text_ans[$key]['question'] = $value['question'];
      $text_ans[$key]['selection'] = !empty($value['selection'])?$value['selection']:0;
      $text_ans[$key]['extra_text'] = !empty($value['extra_text'])?$value['extra_text']:"";
    }
    $user_ans[0] = $text_ans;
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveImageBoxWriting(Request $request) {
    $request = $request->all();
    $is_file = false;
    $user_ans = $request['text_ans'];
    foreach ($user_ans as $key => $value) {
      $temp= str_replace("<div>","\r\n",$value[0]);
      $temp= str_replace("</div>","",$temp);
      $temp= str_replace("&nbsp;"," ",$temp);
      $temp= str_replace("<br>"," ",$temp);
      $user_ans[$key][0]= $temp;
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveCreateQuiz(Request $request) {
    $request = $request->all();
    $is_file = false;
    $user_ans[0] = $request['text_ans'];
    if(!empty($user_ans[0]))
    {
       foreach($user_ans[0] as $key => $val)
       {
          $user_ans[0][$key]['question']  = str_replace(["&nbsp;","&amp;","amp;","nbsp;"]," ",$val['question']);
          $user_ans[0][$key]['option_a']  = str_replace(["&nbsp;","&amp;","amp;","nbsp;"]," ",$val['option_a']);
          $user_ans[0][$key]['option_b']  = str_replace(["&nbsp;","&amp;","amp;","nbsp;"]," ",$val['option_b']);
          $user_ans[0][$key]['option_c']  = str_replace(["&nbsp;","&amp;","amp;","nbsp;"]," ",$val['option_c']);
       }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveConversationSimpleMultiBlank(Request $request) {
    $request = $request->all();
    $is_file = false;
    if(!empty($request['text_ans'])){
      $answer =array();
      foreach ($request['text_ans'] as $key => $value) {
        $answer[$key] = implode(' ;',$value).' ;';
      }
    }
    $response =  $this->commonSaveFunction($request, $answer, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveImageReadingNoBlanksNoSpace(Request $request) {
    $request = $request->all();
    $is_file = false;
    $user_ans[0] = implode(';', $request['text_ans']);
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveMultiImageOption(Request $request) {
    $request = $request->all();
    $is_file=false;
    $user_ans = $request['user_answer'];
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveMultiImageSelection(Request $request) {
    $request = $request->all();
    $is_file=false;
    if(!empty($request['text_ans'])){
      foreach ($request['text_ans'][0] as $key => $value) {
        $request['text_ans'][0][$key]['image'] = $value['image'];
        if($request['text_radio'][0]['checked']==$key){
            $request['text_ans'][0][$key]['checked'] = true;
        }else{
            $request['text_ans'][0][$key]['checked'] = false;
        }
      }
    }
    $user_ans = $request['text_ans'];
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
   public function saveSingleSpeakingWriting (Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    $k=0;
    $is_file = false;
    $audio_exist_flag = true;
    $total_blank_audio = 0;
    ksort($request['user_answer']);
    if(!empty($request['user_answer']) && !empty($request['is_roleplay']) ){
      if(!empty($request['user_answer']) && $request['is_roleplay_submit']==0 ){
        if(empty($request['is_roleplay'])){
          unset($request['is_roleplay']);
          unset($request['is_roleplay_submit']);
        }
             $encoded_data ="";
        $temp = 0;
        // dump($request);
        foreach ($request['user_answer'] as $key => $value) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
              if( !empty($value['path']) ) {
                echo "test";
                if(file_exists('public\\uploads\\practice\\audio\\'.$value['path'])){
                  $path = public_path('uploads\\practice\\audio\\'.$value['path']);
                  $path = str_replace('\\','/',$path); 
                  $encoded_data = base64_encode(file_get_contents($path));
                  $is_file = true;
                }  
              } else {
                $total_blank_audio++;
              }
            } else {
              if( !empty($value['path']) &&  $value['path']!="null") {
                // echo $key;
                if( file_exists('public/uploads/practice/audio/'.$value['path'])) {
                  $path = public_path('uploads/practice/audio/'.$value['path']);
                  $encoded_data = base64_encode(file_get_contents($path));
                  $is_file = true;
                } 
              } else {
                $total_blank_audio++;
              }
            }
            if( !empty($value['path'])  &&  $value['path']!="null" ) {
              $user_ans[$k]['text_ans'][0] = $value['text_ans'];
              $user_ans[$k]['path'] = $encoded_data;
              $user_ans[$k+1] = "##";
              $k+=2;
            } else {
                $total_answer = count($request['user_answer']);
                if(isset($request['single_speaking_writing_roleplay'.$temp]) && $request['single_speaking_writing_roleplay'.$temp] == "blank"){
                    $user_ans[$k]['path'] = "blank";
                    $user_ans[$k]['text_ans'][0] =  $value['text_ans'];
                }else{
                    $user_ans[$k]['path'] = $encoded_data;
                    $user_ans[$k]['text_ans'][0] =  $value['text_ans'];
                }
                $user_ans[$k+1] = "##";
                $k+=2;
            }
            $temp = $temp+2;
        }
        if($audio_exist_flag){
          array_pop($user_ans);
          $is_file = true;
        }
       $audioCheck = count($request['user_answer']) != $total_blank_audio;
      }
    }  else {
      $encoded_data = "";
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $is_file = true;
        if( !empty($request['user_answer'][0]['path']) ) {
          if(file_exists('public\\uploads\\practice\\audio\\'.$request['user_answer'][0]['path'])){
            $path = public_path('uploads\\practice\\audio\\'.$request['user_answer'][0]['path']);
            $path = str_replace('\\','/',$path); 
            $encoded_data = base64_encode(file_get_contents($path));
            $audio_exist_flag=true;
          }  
        } else {
          $total_blank_audio++;
          $audio_exist_flag=false;
        }
        $audioCheck =true;
      }else{
        $is_file = true;
        if( !empty($request['user_answer'][0]['path']) ) {
          if( file_exists('public/uploads/practice/audio/'.$request['user_answer'][0]['path'])) {
            $path = public_path('uploads/practice/audio/'.$request['user_answer'][0]['path']);
            $encoded_data = base64_encode(file_get_contents($path));
            $is_file = true;
            $audio_exist_flag=true;
          }
        } else {
          $total_blank_audio++;
          $audio_exist_flag =false;
            $encoded_data = "";
          if(!empty($request['user_answer'][0]['audio_deleted'] ) && $request['user_answer'][0]['audio_deleted'] =='blank' ){
            $encoded_data = "blank";
          }
          if(!empty($request['single_speaking_writing'] ) && $request['single_speaking_writing'] =='blank' ){
            $encoded_data = "blank";
          }
        } 
        $audioCheck =true;
      }
      if(  !empty( $request['user_answer'][0]['audio_record'] ) ){
        $audio_exist_flag=true;
      }
      $user_ans[0]['text_ans'][0] = $request['user_answer'][0]['text_ans'][0];
      if(!empty($request['user_answer'][0]['audio_deleted']) && $request['user_answer'][0]['audio_deleted'] =='blank' ){
        $encoded_data = "blank";
        $audio_exist_flag=true;
      }
      if(!empty($request['single_speaking_writing'] ) && $request['single_speaking_writing'] =='blank' ){
        $encoded_data = "blank";
      }
      $user_ans[0]['path'] = $encoded_data;
    }
 
    // dd($user_ans);
      $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
      if(empty($response)){
        return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
      }elseif(isset($response['success']) && !$response['success']){
        return response()->json(['success'=>false,'message'=>$response['message']], 200);
      }elseif(isset($response['success']) && $response['success']){
        return response()->json(['success'=>true,'message'=>$response['message']], 200);
      }
  }

  public function saveHideShowAnswerSpeakingUp (Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    } else {
      $encoded_data ="";
    }
    $user_ans = $encoded_data;
   if($request['hide_show_answer_speaking_up'] == "blank"){
    $user_ans = "blank";
   }
    $response =  $this->commonSaveFunction($request, $user_ans, true);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=> 'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveSingleSpeakingUpConversationSimpleView(Request $request ){
    $request = $request->all();
    $user_ans=array();
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    } else {
      $encoded_data ="";
    }
    if(isset($request['single_speaking_up_conversation_simple_view']) && $request['single_speaking_up_conversation_simple_view'] == "blank"){
      $encoded_data = "blank";
      $user_ans[0]=$encoded_data;
    }else{
      $user_ans[0]=$encoded_data;
    }
    $is_file = !empty($encoded_data) ? true : false;
    $response =  $this->commonSaveFunction(  $request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveMultiImageWritingAtStartUpEnd(Request $request){
    $request = $request->all();
    $user_ans = $request['user_answer'];
    foreach($user_ans as $key=>$data){
        foreach($data as $key1=>$data1){
            $data1['start']= str_replace("<div>","\r\n",$data1['start']);
            $data1['start']= str_replace("<br>","\r\n",$data1['start']);
            $data1['start']= str_replace("</div>","",$data1['start']);
            $data1['start']= str_replace("&nbsp;"," ",$data1['start']);
            $data1['end']= str_replace("<div>","\r\n",$data1['end']);
            $data1['end']= str_replace("<br>","\r\n",$data1['end']);
            $data1['end']= str_replace("</div>","",$data1['end']);
            $data1['end']= str_replace("&nbsp;"," ",$data1['end']);
            $user_ans[$key][$key1]['start'] = $data1['start'];
            $user_ans[$key][$key1]['end'] = $data1['end'];
            $user_ans[$key][$key1]['end'] = $data1['end'];
        }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, false);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSpeakingMultipleSingleImageRoleplay(Request $request){
    $request = $request->all();
      if(!empty($request['user_answer'])){
      $user_ans = array();
      $s=0;
      $i = 0;
      $j = 0;
      $new_arg = array();
      foreach($request['user_answer'] as $key => $value)
      {
          if($key == $request['split_count'][$j])
          {
             $new_arg[$i] = "##";
             $j++;
             $i++;
          } 
             $new_arg[$i] = $value;
             $i++;
      }
     // dd($request['user_answer']);
      $i = 0;
      foreach($new_arg as $key => $value) {
        if($value=="##") {
          $user_ans[$i] = "##";
        } 
        else 
        {
          if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if( !empty($value['path']) && file_exists('public\\uploads\\practice\\audio\\'.$value['path']) ){
              $path = public_path('uploads\\practice\\audio\\'.$value['path']);
              $path = str_replace('\\','/',$path); 
              $encoded_data = base64_encode(file_get_contents($path));
            }else {
              if(isset($request['speaking_multiple_single_image'.$key]) && $request['speaking_multiple_single_image'.$key] == "blank"){
                $encoded_data = "blank";
              }else{
                $encoded_data = "";
              }
            }
          }
          else{
            if( !empty($value['path']) &&  file_exists('public/uploads/practice/audio/'.$value['path']) ) {
              $path = public_path('uploads/practice/audio/'.$value['path']);
              $encoded_data = base64_encode(file_get_contents($path));
            } else {
              if(!empty($value['audio_deleted']) && $value['audio_deleted'] =='blank' ){
                $encoded_data = "blank";
              }else{
                $encoded_data = "";
              }
            }
          }
          if(isset($request['speaking_multiple_up'.$s]) && $request['speaking_multiple_up'.$s] == "blank"){
            $encoded_data = "blank";
          }
          $user_ans[$i] = $encoded_data;
          //array_push($user_ans,$encoded_data );
          $s++;
        }
        $i++;
      }
      // array_pop($user_ans); 
      ksort($user_ans);
      $is_file=true;
    } else {
      $is_file = false;
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file );
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    } elseif(isset($response['success']) && !$response['success']) {
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    } elseif(isset($response['success']) && $response['success']) {
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSpeakingMultipleSingleImage(Request $request){
    $request = $request->all();
    $user_ans="";
    $commongPath = array();
    if(!empty($request['user_answer']) && $request['is_roleplay_submit']== 0 ){
      $user_ans = array();
      $s=0;
      $i = 0;
     // dump($request['user_answer']);
      foreach ($request['user_answer'] as $key => $value) {
        if($value=="##") {
          array_push($user_ans,'##' );
        } else {
          if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            if( !empty($value['path']) && file_exists('public\\uploads\\practice\\audio\\'.$value['path']) ){
              $path = public_path('uploads\\practice\\audio\\'.$value['path']);
              $path = str_replace('\\','/',$path); 
              $encoded_data = base64_encode(file_get_contents($path));
            }else {
              if(isset($request['speaking_multiple_single_image'.$key]) && $request['speaking_multiple_single_image'.$key] == "blank"){
                $encoded_data = "blank";
              }else{
                $encoded_data = "";
              }
            }
          }else{
            if(!empty($value['path']) &&  file_exists('public/uploads/practice/audio/'.$value['path']) ) {
              $path = public_path('uploads/practice/audio/'.$value['path']);
              $encoded_data = base64_encode(file_get_contents($path));
            } else {
               if(isset($request['speaking_multiple_single_image'.$key]) && $request['speaking_multiple_single_image'.$key] == "blank"){
                $encoded_data = "blank";
              }else{
                $encoded_data = "";
              }
            }
          }
          if(isset($request['speaking_multiple_up'.$s]) && $request['speaking_multiple_up'.$s] == "blank"){
            $encoded_data = "blank";
          }
          //add static condition for multiple audio practice+level 0
          if($request['practise_id'] == "1663929017632d8ab9d9046" || $request['practise_id'] == "16655831236346c81316db0")
          {
             $user_ans[$s] = $encoded_data;
          }
          else
          {
             array_push($user_ans,$encoded_data);
          }
        $s++;
        }
      }
      //here add static condition for ges ges level 0 topic 8 task 9
      if($request['practise_id'] != "1663929017632d8ab9d9046"  && $request['practise_id'] != "16655831236346c81316db0")
      {
         array_pop($user_ans);
      } 
      ksort($user_ans);
      $is_file = true;
    } else {
      $is_file = false;
    }
    // dd($user_ans);
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file );
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    } elseif(isset($response['success']) && !$response['success']) {
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    } elseif(isset($response['success']) && $response['success']) {
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
 public function saveSingleImageWritingAtEndSpeaking(Request $request){
    $request = $request->all();
    $user_ans="";
    if(!empty($request['user_answer']) && $request['is_roleplay_submit']==0 ){
      $user_ans = array();
      foreach ($request['user_answer'] as $key => $value) {
        if( !empty($value['path']) ){
          if( file_exists('public/uploads/practice/audio/'.$value['path']) ) {
            $path = public_path('uploads/practice/audio/'.$value['path']);
            $encoded_data = base64_encode(file_get_contents($path));
          } else {
            $encoded_data ="";
          }
          $user_ans[$key]['text_ans'] = isset($value['text_ans'])?$value['text_ans']:'';
          if($request['audio_reading_'.$key] == "blank"){
            $encoded_data= "blank";
          }
          $user_ans[$key]['path'] =$encoded_data;
        }else if( empty($value['path']) && $value!="##" ){
          $user_ans[$key]['text_ans'] = isset($value['text_ans'])?$value['text_ans']:'';
          $encoded_data = '';
          if($request['audio_reading_'.$key] == "blank"){
            $encoded_data= "blank";
          }
          $user_ans[$key]['path'] =$encoded_data;
        } else{
          $user_ans[$key]="##";
        }
      }
      
      $is_file = true;
        ksort($user_ans);
    } else {
      $is_file = false;
    }
    $response =  $this->commonSaveFunction($request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    } elseif(isset($response['success']) && !$response['success']) {
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    } elseif(isset($response['success']) && $response['success']) {
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveSetInSequence(Request $request){
    $request = $request->all();
    $user_ans[0] = $request['options'];
    $response =  $this->commonSaveFunction($request, $user_ans, false);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveSpeakingMultipleSingleWriting(Request $request){
    $request = $request->all();
    $user_ans=array();
    $encoded_data ="";
    if(!empty($request['text_ans'])){
      foreach ($request['text_ans'] as $key => $value) {
        if($value['audio_exists']){
            $encoded_data =''; //$value['path'];
        } else {
          if(file_exists('public/uploads/practice/audio/'.$value['path'])){
          $path = public_path('uploads/practice/audio/'.$value['path']);
          $encoded_data = base64_encode(file_get_contents($path));
        }
        }
        $user_ans[$key]['text_ans'][0] = !empty($value['text_ans'][0])?$value['text_ans'][0]:"";
          if(isset($request['speaking_multiple_single_writing_'.$key]) && $request['speaking_multiple_single_writing_'.$key]=="blank"){
            $encoded_data =  "blank";
          }
        $user_ans[$key]['path'] = $encoded_data;
      }
    }
    $ua = array();
    for($i=0;$i<count($user_ans);$i++) {
      for($j=0;$j<count($user_ans);$j++) {
        $ua[$j] =$user_ans[$j];
        if($i!=$j){
          $ua[$j]['path']="";
          $ua[$j]['text_ans']="";
        }
      }
      $response =  $this->commonSaveFunction($request, $ua, true);
    }
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveMultiChoiceQuestionMultipleSpeaking(Request $request){
    $request = $request->all();
    $user_ans=array();
      $userAnswer = array();
      foreach($request['user_default_answer'] as $key=> $item)
      {
        if(isset($request['user_answer']) && isset($request['user_answer'][$key]) && !empty($request['user_answer'][$key])){
         $ans=array();
          foreach($request['user_answer'][$key] as $k=>$uans){
            $currentAnswer= explode("@@",$request['user_answer'][$key][$k]);
            $userAnswer[$key]['ans_pos'][$k]= $currentAnswer[0];
            $ans[] = $currentAnswer[1];
          }
          $userAnswer[$key]['ans']= implode(':',$ans);
        }else{
          $userAnswer[$key]['ans_pos']=array();
          $userAnswer[$key]['ans']=null;
        }

      }
    $user_ans[0]['text_ans'] = $userAnswer;
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    } else {
      $encoded_data ="";
    }
    if($request['multi_choice_question_multiple_speaking'] == "blank"){
      $encoded_data =   "blank";
    }
    $user_ans[0]['path']=$encoded_data;
      $response =  $this->commonSaveFunction(  $request, $user_ans, true);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveMultiChoiceQuestionMultipleWritingAtEndNoOption(Request $request){
    $request = $request->all();
    $user_ans = array();
    if(!empty($request['user_answer'])){
      for($i=0;$i<$request['total_que'];$i++) {
        if(!empty($request['user_answer'][$i])){
          if(str_contains($request['user_answer'][$i],'@@')){
            $exp_value = explode('@@',$request['user_answer'][$i]);
            $user_ans[0][$i]['ans_pos'] = $exp_value[0];
            $user_ans[0][$i]['ans'] = $exp_value[1];
            $user_ans[0][$i]['text_ans'] = ""; 
          } else {
            $user_ans[0][$i]['ans_pos'] = -1;
            $user_ans[0][$i]['ans'] = "";
            $user_ans[0][$i]['text_ans'] =$request['user_answer'][$i];
          }
        } else {
          $user_ans[0][$i]['ans_pos'] = -1;
          $user_ans[0][$i]['text_ans'] = ""; 
          $user_ans[0][$i]['ans'] = "";
        }
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, false);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }

  public function saveMultiChoiceQuestionSelfMarking(Request $request){
    $request = $request->all();
    if(!empty($request['user_answer'])){
      foreach ($request['user_answer'] as $key => $value) {
        if(str_contains($value['user_selected_answer'], '@@')){
          $ans = explode( '@@', $value['user_selected_answer'] );
          $user_ans[0][$key]['ans_pos'] =$ans[0];
          $user_ans[0][$key]['ans'] = $ans[1];
        }
        $user_ans[0][$key]['question'] = $value['question'];
        $user_ans[0][$key]['total_option'] = $value['total_option'];
        $user_ans[0][$key]['option_a'] = $value['option_a'];
        $user_ans[0][$key]['option_b'] = $value['option_b'];
        $user_ans[0][$key]['option_c'] = $value['option_c'];

        $user_ans[0][$key]['correct_ans'] = $value['correct_ans'];
        $user_ans[0][$key]['answer'] = $value['answer'];
      }
    }
    $response =  $this->commonSaveFunction($request, $user_ans, false);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveReadingNoBlanksListeningSpeakingDown(Request $request) {
    $request = $request->all();
    $user_ans[0]['text_ans']= implode(';',$request['text_ans']).';';
    $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      $path = public_path('uploads/practice/audio/'.$fileName);
      $encoded_data = base64_encode(file_get_contents($path));
    } else {
      $encoded_data ="";
    }
    if(isset($request['audio_reading']) && $request['audio_reading']=="blank"){
      $encoded_data =  "blank";
    }
    $user_ans[0]['path']=$encoded_data;
    $is_file = !empty($encoded_data) ? true : false;
    $response =  $this->commonSaveFunction(  $request, $user_ans, $is_file);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function saveTrueFalseCorrectIncorrect(Request $request){
    $k=0;
    if(!empty($request['user_answer']) && $request['is_roleplay_submit']==0 ){
      $user_answer = $request['user_answer'];
       ksort($user_answer);
       $total_answer = count($user_answer);
      foreach ($user_answer as $key => $value) {
        if($value!="#"){
          if( $key == ($total_answer) && !empty($value) ){
            $user_ans=array();
            $user_ans[$k]= "";
            $user_ans[$k+1] = "##";
            $user_ans[$k+2]= $value;
              $response =  $this->commonSaveFunction($request, $user_ans, false);
          }
          else {
            $user_ans=array();
            $user_ans[$k]= $value;
            $user_ans[$k+1] = "##";
            $user_ans[$k+2] = "";
              $response =  $this->commonSaveFunction($request, $user_ans, false);
          }
        }
      }
    }
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
  public function commonSaveFunction($request, $user_ans, $is_file){
    $topicId = $request['topic_id'];
    $request_payload = array();
    $request_payload['student_id'] =  Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token']          = Session::get('token');
    $request_payload['cource_id'] = Session::get('course_id_new');
    $request_payload['level_id'] =  Session::get('level_id_new');
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
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    return $response;
  }
  public function doUploadAudio(Request $request){
    $exp_temp_name =  explode('/',$request->audio_data->getPathName());
    if(count($exp_temp_name)==1){
      $exp_temp_name =  explode('\\',$request->audio_data->getPathName());
    }
    if(!empty($request['audio_key'])){
      $fileName = Session::get('user_id_new').'-'.$request->practice_id.'-'.$request['audio_key'].'.wav';
    } else {
      $fileName = Session::get('user_id_new').'-'.$request->practice_id.'.wav';
    }
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      unlink( public_path('uploads/practice/audio').'/'.$fileName );
    }
    $path = public_path('uploads/practice/audio');
    $request->audio_data->move( $path, $path.'/'.end($exp_temp_name).'.wav' );
    $data =array();
    $data['path'] = url('public/uploads/practice/audio/').'/'.end($exp_temp_name).'.wav';
    $data['file_name'] = end($exp_temp_name).'.wav';
    $data['audio_key'] = ( !empty($request['audio_key']) && $request['audio_key']>0 )?$request['audio_key']:"";
    $data['practice_id'] = $request->practice_id;
    return response()->json($data);
  }

  public function renameAudio(Request $request){
    if(!empty($request['audio_key'])){
      $fileName = Session::get('user_id_new').'-'.$request['practice_id'].'-'.$request['audio_key'].'.wav';
    } else {
      $fileName = Session::get('user_id_new').'-'.$request['practice_id'].'.wav';
    }
    $old_file = public_path('uploads/practice/audio/').$request['filename'];
    $new_file = public_path('uploads/practice/audio/').$fileName;
    rename( $old_file, $new_file );
    $data['path'] = url('public/uploads/practice/audio/').'/'.$fileName;
    $data['file_name'] =$fileName;
    $data['audio_key'] = $request['audio_key'];
    $data['practice_id'] = $request->practice_id;
    return response()->json($data);
  }

  public function doDeleteAudio(Request $request){
    if(!empty($request['audio_key'])){
      $fileName = Session::get('user_id_new').'-'.$request->practice_id.'-'.$request['audio_key'].'.wav';
    } else {
      $fileName = Session::get('user_id_new').'-'.$request->practice_id.'.wav';
    }
    if(file_exists('public/uploads/practice/audio/'.$fileName)){
      unlink( public_path('uploads/practice/audio/').$fileName );
      return response()->json(['deleted'=>true]);
    } else {
      return response()->json(['deleted'=>false]);
    }
  }

  public function saveStudentSelfMarkingReviewForm(Request $request){
    $request = $request->all();
    $request_payload['student_id'] = Session::get('user_id_new');
    $request_payload['token_app_type'] = 'ieuk_new';
    $request_payload['token'] = Session::get('token');
    $request_payload["topicid"] = $request['topic_id'];
    $request_payload["taskid"] = $request['task_id'];
    $request_payload["task_emoji"] = (int) $request['task_emoji'];
    $request_payload["task_level"] = (int) $request['task_level'];
    $request_payload["task_comment"] = $request['task_comment'];
    $request_payload["student_task_comment"] =  $request['student_task_comment'];
    $request_payload["ieuk_comment"] =  $request['ieuk_comment'];
    $request_payload["student_task_emoji"] = 0;
    $endPoint = "addfeedback";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>false,'message'=>$response['message']], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
   public function saveSpeakingWritingUpNew(Request $request){
    $request = $request->all();
    $user_ans=array();
    if(!empty($request['practice_type']) && ($request['practice_type']=="listening_speaking" || $request['practice_type']=="listening_Speaking") ) {
      $fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
      $encoded_data="";
      if(file_exists('public/uploads/practice/audio/'.$fileName)){
          $path = public_path('uploads/practice/audio/'.$fileName);
          $encoded_data = base64_encode(file_get_contents($path));
      }
      $user_ans[0]['path']= $encoded_data;
    } else if(!empty($request['practice_type']) && $request['practice_type']=="writing_at_end_speaking_up") {
       foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
       }
      $user_ans[0]['text_ans'][]= $request['text_ans'];
    } else {
      if(!empty($request['answer']) && is_array($request['answer'])) {
        foreach($request['answer'] as $key=>$val){
          $ans= str_replace("<div>","\r\n",$val['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $encoded_data="";
          $user_ans[$key]['text_ans'] =  $ans;
          if(!empty($val['path'])){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
              if(file_exists('public\\uploads\\practice\\audio\\'.$val['path'])){
                  $path = public_path('uploads\\practice\\audio\\'.$val['path']);
                $path = str_replace('\\','/',$path);
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }else{
              if(file_exists('public/uploads/practice/audio/'.$val['path'])){
                $path = public_path('uploads/practice/audio/'.$val['path']);
                $encoded_data = base64_encode(file_get_contents($path));
              }
            }
          }
          if(isset($request['speaking_writing_up_'.$key]) &&  $request['speaking_writing_up_'.$key] == "blank"){
            $encoded_data="blank";
          }
            $user_ans[$key]['path'] = $encoded_data;
        }
      }
      elseif(!empty($request['text_ans']) && is_array($request['text_ans'])){
        foreach($request['text_ans'] as $key=>$ans){
            $ans= str_replace("<div>","\r\n",$ans);
            $ans= str_replace("<br>","\r\n",$ans);
            $ans= str_replace("</div>","",$ans);
            $ans= str_replace("&nbsp;"," ",$ans);
            $request['text_ans'][$key] = $ans;
            $user_ans[0]['text_ans']= $request['text_ans'];
        }
      } else {
          $ans= str_replace("<div>","\r\n",$request['text_ans']);
          $ans= str_replace("<br>","\r\n",$ans);
          $ans= str_replace("</div>","",$ans);
          $ans= str_replace("&nbsp;"," ",$ans);
          $request['text_ans'] = $ans;
          $user_ans[0]['text_ans']= $request['text_ans'];
          $encoded_data = "";
          if(isset($request['speaking_writing_up_0']) &&  $request['speaking_writing_up_0'] == "blank"){
            $encoded_data="blank";
          }
          $user_ans[0]['path']= $encoded_data;
      }
    }
        if(!isset($request['text_ans']) || empty($request['text_ans'])){
            $request['text_ans'] = "";
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
    $endPoint = "practisesubmit-individual";
    $response = curl_post($endPoint, $request_payload);
    if(empty($response)){
      return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
    }elseif(isset($response['success']) && !$response['success']){
      return response()->json(['success'=>true,'message'=>'Answer submit successfully '], 200);
    }elseif(isset($response['success']) && $response['success']){
      return response()->json(['success'=>true,'message'=>$response['message']], 200);
    }
  }
}
