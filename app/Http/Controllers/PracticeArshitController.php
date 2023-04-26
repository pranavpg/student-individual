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

class PracticeArshitController extends Controller {
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
      $endPoint = "practisesubmit-individual";
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
        $endPoint = "practisesubmit-individual";
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

      $endPoint = "practisesubmit-individual";
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

       $endPoint = "practisesubmit-individual";
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

      $endPoint = "practisesubmit-individual";
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

       $endPoint = "practisesubmit-individual";
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

     public function saveMultiChoiceQuestion(Request $request){
       pr($request->all());
      $userAnswer = array();
      foreach($request['user_answer_'] as $key=> $item)
      {

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

       $endPoint = "practisesubmit-individual";
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

      $endPoint = "practisesubmit-individual";
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

      $endPoint = "practisesubmit-individual";
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
      $endPoint                                 = "practisesubmit-individual";
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
        $endPoint = "practisesubmit-individual";
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

       $endPoint = "practisesubmit-individual";
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

       $endPoint = "practisesubmit-individual";
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

       $endPoint = "practisesubmit-individual";
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
       $endPoint = "practisesubmit-individual";
       $response = curl_post($endPoint, $request_payload);
       if(empty($response)){
         return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
       } elseif(isset($response['success']) && !$response['success']){
         return response()->json(['success'=>false,'message'=>$response['message']], 200);
       } elseif(isset($response['success']) && $response['success']){
         return response()->json(['success'=>true,'message'=>$response['message']], 200);
       }
    }


}
