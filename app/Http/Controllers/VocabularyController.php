<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class VocabularyController extends Controller {
    public function vocabulary(Request $request) {
        $params = $request->all();
        $request = array();
        $request['student_id'] =  Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        if(isset($params['delete_vocabulary']) && !empty($params['delete_vocabulary'])){
            $vocabId = $params['delete_vocabulary'];
            $request['wordid'] = $vocabId;
            $request['word'] = 'DUMMY';
            $request['is_delete'] = true;
            $endPoint = "individual_addvocabulary_new";
            $response = curl_get($endPoint, $request);
            if(isset($response['invalid_token']) && $response['invalid_token']){
                \Session::flush();
                return redirect('/')->with('message',$response['message']); 
            }
            if(empty($response)){
                 return response()->json(['success'=>false,'message'=>'Something went wrong. Please try after some time.'], 200);
            }
            elseif(isset($response['success']) && !$response['success']){
                return response()->json(['success'=>false,'message'=>$response['message']], 200);
            }
            elseif(isset($response['success']) && $response['success']){
                Session::flash('alert-success', $response['message']);
                return response()->json(['success'=>true,'message'=>$response['message']], 200);
            }
        }
        $endPoint = "individual_vocablist_new";
        $response = curl_get($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if (!$response['success']) {
            $response['result'] = array();
        }
        $instration = isset($response['page_info'])?$response['page_info']:[];
        $vocablist = $response['result'];
        $endPoint = "individual_vocabtopiclist_new";
        $response = curl_get($endPoint, $request);
        if (!$response['success']) {
            $response['result'] = array();
        }
        $vocabtopiclist = $response['result'];
        return view('dashboard.vocabulary', compact('vocablist' ,'vocabtopiclist','instration'));
    }
    public function vocab_topic_post(Request $request) {
        $params = $request->all();
        $request = array();
        if(!isset($params['topicname']) || empty($params['topicname'])){
            Session::flash('alert-danger', 'Please add topic name.');
            return redirect('vocabulary');
        }
        $request = array();
        $request['student_id'] =  Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $request['name'] = $params['topicname'];
        if(!empty($params['edit'])){
            $request['topicid'] = $params['topicid'];
        }
        if(!empty($params['is_delete'])){
            $request['is_delete'] = $params['is_delete'];
        }
        $endPoint = "individual_addtopic_new";
        $response = curl_get($endPoint, $request);

        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }


        \Cache::forget('topic_cache'.Session::get('user_id_new'));
        if(empty($response)){
            Session::flash('alert-danger', 'Something went wrong. Please try after some time.');
            return redirect('vocabulary');
        }elseif(isset($response['success']) && !$response['success']){
            Session::flash('alert-danger', $response['message']);
            return redirect('vocabulary');
        }elseif(isset($response['success']) && $response['success']){
            Session::flash('alert-success', $response['message']);
            return redirect('vocabulary');
        }
    }
    public function vocab_post(Request $request) {
        $params = $request->all();
        $request = array();
        if(!isset($params['modal_topic_id']) || empty($params['modal_topic_id'])){
            Session::flash('alert-danger', 'Please select topic.');
            return redirect('vocabulary');
        }
        if(!isset($params['word']) || empty($params['word'])){
            Session::flash('alert-danger', 'Please add word.');
            return redirect('vocabulary');
        }
        if(!isset($params['copytheword']) || empty($params['copytheword'])){
            Session::flash('alert-danger', 'Please add Copy the word.');
            return redirect('vocabulary');
        }
        if(strtolower($params['word']) != strtolower($params['copytheword'])){
            Session::flash('alert-danger', "Ops! Please see the 'Word' and 'copy the word'. they don't match.");
            return redirect('vocabulary');
        }
        if(!isset($params['translationmeaning']) || empty($params['translationmeaning'])){
            Session::flash('alert-danger', 'Please add Meaning.');
            return redirect('vocabulary');
        }
        $request = array();
        $request['student_id'] = Session::get('user_id_new');
        $request['token_app_type'] = 'ieuk_new';
        $request['token'] = Session::get('token');
        $request['topicid'] = $params['modal_topic_id'];
        if(isset($params['id'])){
          $request['wordid'] = $params['id'];
        }
        $request['word'] = $params['word'];
        $request['copytheword'] = $params['copytheword'];
        $request['wordtype'] = $params['wordtype'];
        $request['phonetictranscription'] = isset($params['phonetictranscription'])?$params['phonetictranscription']:'';
        $request['translationmeaning'] = $params['translationmeaning'];
        $request['sentence1'] = $params['sentence1'] ? $params['sentence1'] :'';
        $request['sentence2'] = $params['sentence2'] ? $params['sentence2'] :'';
        $request['sentence3'] = $params['sentence3'] ? $params['sentence3'] :'';
        $request['sentence4'] = $params['sentence4'] ? $params['sentence4'] :'';
        //dd(json_encode($request));
        Session::put('model_topic_id',$request['topicid']);
        $endPoint = "individual_addvocabulary_new";
        $response = curl_get($endPoint, $request);
        if(isset($response['invalid_token']) && $response['invalid_token']){
            \Session::flush();
            return redirect('/')->with('message',$response['message']); 
        }
        if(empty($response)){
            Session::flash('alert-danger', 'Something went wrong. Please try after some time.');
            return redirect('vocabulary');
        }elseif(isset($response['success']) && !$response['success']){
            Session::flash('alert-danger', $response['message']);
            return redirect('vocabulary');
        }elseif(isset($response['success']) && $response['success']){
            Session::flash('alert-success', $response['message']);
            return redirect('vocabulary');
        }
    }
}
    
