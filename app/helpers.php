<?php
	function curl_get($endPoint, $requestParams){
		ini_set('memory_limit','1024M');
		set_time_limit(0);
	    $curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => env("PRODUCTION_URL")."/".$endPoint.'?'.http_build_query($requestParams),
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_CUSTOMREQUEST => "GET",
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response,true);
		return $response;
	}
	function curl_post($endPoint, $requestParams){
	  $curl = curl_init();
	  curl_setopt_array($curl, array(
		  	CURLOPT_URL => env("PRODUCTION_URL")."/".$endPoint,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_CUSTOMREQUEST => "POST",
	    	CURLOPT_HTTPHEADER=> array('Content-Type:application/json'),
		  	CURLOPT_POSTFIELDS => json_encode($requestParams),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($response,true);
		return $response;
	}

	function pr($data){
	  	echo "<pre>";
	  	print_r($data);
	  	die;
	}
	function checkAudioFileExists($student_id, $practise_id, $file_extension='.wav'){
		if(empty($student_id) && !isset($student_id)){
			return false;
		}
		if(empty($practise_id) && !isset($practise_id)){
			return false;
		}
		$fileName = $student_id.'-'.$practise_id.$file_extension;
		if(file_exists('public/uploads/practice/audio/'.$fileName)){
			$path = public_path('uploads/practice/audio/'.$fileName);
			$encoded_data = base64_encode(file_get_contents($path));
			return $encoded_data;
		} else {
			return false;
		}
	}
	function getPracticeAnswer($request) {
	    $sessionAll = Session::all();
	    if (!isset($sessionAll['user_data']) || empty($sessionAll['user_data'])){
	        return false;
	    }
	    $userDetails = $sessionAll['user_data'];
	    $request_payload = array();
	    $request_payload['student_id'] = $userDetails['student_id'];
	    $request_payload['token_app_type'] = 'ieuk';
	    $request_payload['token'] = $userDetails['token_ieuk'];
	    $request_payload['course_id'] = $sessionAll['course_id_new'];
	    $request_payload['level_id'] = $sessionAll['level_id_new'];
	    $request_payload['task_id'] = $request['task_id'];
	    $request_payload['practise_id'] = $request['practise_id'];
	    $request_payload['topic_id'] = $request['topic_id'];
	    $endPoint = "student-practice-answer";
	    $response = curl_get($endPoint, $request_payload);
	    if (!$response['success']){
	        return false;
	    }
	    return $response['result'];
  	}
	function commonDeleteFileFromPublic($files) {
		foreach ($files as $key => $value) {
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				if(file_exists('public\\uploads\\practice\\audio\\'.$value)){
					\File::delete(public_path('uploads\\practice\\audio\\'.$value));
				}
			}else{
				if(file_exists('uploads/practice/audio/'.$value)){
					\File::delete(public_path('uploads/practice/audio/'.$value));
				}
			}
		}
	}
	function get_total_course() {
		$onlyCourse = [];
		if (!Cache::has('course_list_'.Session::get('user_id_new'))) {
		    $onlyCourse 		= \Cache::remember('course_list_'.Session::get('user_id_new'), 60*60*24, function () {
	            $request        = array('student_id' => Session::get('user_id_new'),'token' => Session::get('token'),'token_app_type' => 'ieuk_new');
	            $endPoint       = "course_topic_list_new";
	            $data     		= curl_get($endPoint, $request);
	            if($data['success'] == false){
	            	return redirect('/login');
	            }
	            return $data;
            });
            return $onlyCourse['new_result'];
        }else{
            $onlyCourse = \Cache::get('course_list_'.Session::get('user_id_new'));
            return $onlyCourse['new_result'];
        }
	}


?>
