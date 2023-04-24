  //webkitURL is deprecated but nevertheless
  URL = window.URL || window.webkitURL;
  var gumStream; 						//stream from getUserMedia()
  var recorder; 						//WebAudioRecorder object
  var input; 							//MediaStreamAudioSourceNode  we'll be recording
  var encodingType; 					//holds selected encoding for resulting audio (file)
  var encodeAfterRecord = true;       // when to encode

  // shim for AudioContext when it's not avb.
  var AudioContext = window.AudioContext || window.webkitAudioContext;
  var audioContext; //new audio context to help us record
  var recordButton;
  var stopButton;
  var  pauseButton;


  $(document).on('click','.recordButton', function() {
    var  id = $(this).attr('id');
    //alert(id)
    startRecording($(this))
  });
  $(document).on('click','.stopButton', function() {
    var  id = $(this).attr('id');
    stopRecording($(this));
  });

  $(document).on('click','.pauseButton', function() {
    var  id = $(this).attr('id');
    pauseRecording($(this));
  });


  // var recordButtons = document.getElementsByClassName("recordButton");
  // Array.from(recordButtons).forEach((recBtn)=>{
  //   recordButton = 	recBtn;
  //   console.log('recordButton====>',recordButton)
  //   recBtn.addEventListener("click", startRecording);
  // });
  //
  // var stopButtons = document.getElementsByClassName("stopButton");
  // Array.from(stopButtons).forEach((stopBtn)=>{
  //   stopButton = stopBtn;
  //   stopBtn.addEventListener("click", stopRecording);
  // });


 //add events to those 2 buttons


  function startRecording(recEl) {
    console.log("startRecording() called===>");
   /*
     Simple constraints object, for more advanced features see
     https://addpipe.com/blog/audio-constraints-getusermedia/
   */

     var constraints = { audio: true, video:false }

     /*
       We're using the standard promise based getUserMedia()
       https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
   */

   navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
   //	__log("getUserMedia() success, stream created, initializing WebAudioRecorder...");

     /*
       create an audio context after getUserMedia is called
       sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
       the sampleRate defaults to the one set in your OS for your playback device

     */
     audioContext = new AudioContext();

     //update the format
     //document.getElementById("formats").innerHTML="Format: 2 channel "+encodingTypeSelect.options[encodingTypeSelect.selectedIndex].value+" @ "+audioContext.sampleRate/1000+"kHz"

     //assign to gumStream for later use
     gumStream = stream;

     /* use the stream */
     input = audioContext.createMediaStreamSource(stream);

     //stop the input from playing back through the speakers
     //input.connect(audioContext.destination)

     //get the encoding
     encodingType = 'wav';// encodingTypeSelect.options[encodingTypeSelect.selectedIndex].value;

     //disable the encoding selector
     //encodingTypeSelect.disabled = true;

     recorder = new WebAudioRecorder(input, {
       workerDir: workerDirPath+'/', // must end with slash
       encoding: encodingType,
       numChannels:2, //2 is the default, mp3 encoding supports only 2
       onEncoderLoading: function(recorder, encoding) {
         // show "loading encoder..." display
        // __log("Loading "+encoding+" encoder...");
       },
       onEncoderLoaded: function(recorder, encoding) {
         // hide "loading encoder..." display
         //__log(encoding+" encoder loaded");
       }
     });
     recorder.onComplete = function(recorder, blob) {
       console.log('reee',recEl)


       createDownloadLink(blob,recorder.encoding, recEl);
       //encodingTypeSelect.disabled = false;
     }

     recorder.setOptions({
       timeLimit:300,
       encodeAfterRecord:encodeAfterRecord,
         ogg: {quality: 0.5},
         mp3: {bitRate: 160}
       });

     //start the recording process
     recorder.startRecording();

     //__log("Recording started");

   }).catch(function(err) {
     console.log('err-------->',err)
       //enable the record button if getUSerMedia() fails
       recordButton.disabled = false;
       stopButton.disabled = true;

   });

   //disable the record button
     // recordButton.disabled = true;
     // stopButton.disabled = false;
 }

 function pauseRecording(recEl){
 	console.log("pauseButton clicked rec.recording=",recEl.recording );
 	if (recEl.recording){
 		//pause
 		recEl.stopRecording();
    gumStream.getAudioTracks()[0].stop();
 		pauseButton.innerHTML="Resume";
 	}else{
 		//resume
 		recEl.startRecording()
 		pauseButton.innerHTML="Pause";

 	}
 }


 function stopRecording(stopRecEl) {
   console.log("stopRecording() called");

   stopRecEl.stop();
   //stop microphone access
   gumStream.getAudioTracks()[0].stop();

   //disable the stop button
   // stopButton.disabled = true;
   // recordButton.disabled = false;

   //tell the recorder to finish the recording (stop recording + encode the recorded audio)
   recorder.finishRecording();
   $(stopRecEl).parent().parent().find('.delete-icon').show();
   $(stopRecEl).hide();
   $(stopRecEl).parent().parent().find('.record-icon').hide();



 }

 function createDownloadLink(blob,encoding, recEl) {

   var url = URL.createObjectURL(blob);
   var au = document.createElement('audio');
   var li = document.createElement('li');
   var link = document.createElement('a');

   //add controls to the <audio> element
   au.controls = true;
   au.src = url;
   var audio_key = $(recEl).attr('data-key');
   var practice_id = $(recEl).attr('data-pid');
   console.log(audio_key,'url======>',url)
   if(audio_key==undefined){
     audio_key="";
   }
   link.href = url;
   var filename = new Date().toISOString();

   var upload = document.createElement('button');
   //upload.href = "javasript:;";
   upload.type="button";
   upload.innerHTML = "Upload";

   upload.addEventListener("click", function(event) {

       var xhr = new XMLHttpRequest();

      // var practice_id = $(document).find('input.practise_id:hidden').val();
       xhr.onload = function(e) {
           if (this.readyState === 4) {
             console.log('.form_'+practice_id)
               var parse  = JSON.parse(e.target.responseText)
               console.log(audio_key,'practice_id=====>',practice_id)
               $('.record_'+practice_id).find('#answer_audio'+audio_key).attr('src', parse.path);
               $(document).find('.audio_path'+audio_key).val(parse.file_name);
               $('.record_'+practice_id).find('#answer_audio'+audio_key).find('source').attr('src', parse.path);
               $('.record_'+practice_id).find('div.audio-element').css('pointer-events','auto');
               $('.form_'+practice_id).find('.submitBtn').removeAttr('disabled');
               $(document).find('#audio-record-modal').modal('toggle')
           } else {
             console.log('error============>',e)
           }
       };

       var fd = new FormData();
       fd.append("audio_data", blob);
       fd.append("practice_id",practice_id);
       fd.append("audio_key",audio_key);
       xhr.open("POST", upload_url, true);
       xhr.setRequestHeader('X-CSRF-Token', token);
       xhr.send(fd);
   });
   upload.click();
 }
