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

class PracticeJayminController extends Controller
{
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
		// 	$request_payload['is_file'] = false;
		// }
		$request_payload['is_save'] = ($request['is_save']==1) ? true : false;
		$endPoint = "practisesubmit-individual";
	 ///	pr($request_payload);
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
			// 	$oldWayUserAns = $user_ans;
			// 	$user_ans=array();
			// 	$fileName = Session::get('user_id_new').'-'.$request['practise_id'].'.wav';
			// 	if(file_exists('public/uploads/practice/audio/'.$fileName)){
			// 	  $path = public_path('uploads/practice/audio/'.$fileName);
			// 	  $encoded_data = base64_encode(file_get_contents($path));
			// 	} else {
			// 	  $encoded_data ="";
			// 	}
			// 	$user_ans[0]['text_ans']=$oldWayUserAns[0];
			// 	$user_ans[0]['path']=$encoded_data;
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
		// 	$request_payload['is_file'] = false;
		// }
		$request_payload['is_save'] = ($request['is_save']==1) ? true : false;
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
	public function saveBlankTable(Request $request){
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
			
			$trueFalseArray = array_chunk($trueFalseArray,$request['table_type']);
			
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
			//	pr($makeAnswerArray);
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
					$encoded_data	= "blank";
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
					// 	$user_ans[$k]="";
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
			//	pr($makeAnswerArray);
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
					$user_ans[$k]['text_ans'][0] = 	$makeAnswerArray[$d];
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
					$newArrayAns[0][]	= implode(";", $newAnswers[0]);
				}else{
					$newArrayAns[0]	= "";
				}
				$newArrayAns[1] = $newAnswers[1];
				if(isset($newAnswers[2])){
					$newArrayAns[2][]	= implode(";", $newAnswers[2]);
				}else{
					$newArrayAns[2]	="";
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
			$user_ans[1] 	= "##";
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
		$endPoint = "practisesubmit-individual";
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
		$endPoint = "practisesubmit-individual";
		//	pr($request_payload);
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
}
