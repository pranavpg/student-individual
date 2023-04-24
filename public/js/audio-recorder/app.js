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
  //var encodingTypeSelect = document.getElementById("encodingTypeSelect");

  var recordButtons = document.getElementsByClassName("recordButton");
console.log(recordButtons)
  Array.from(recordButtons).forEach((recBtn)=>{
    console.log('===========++>')
      //if(recBtn.getAttribute('visible')=='yes'){
  			recordButton = 	recBtn;
   			recBtn.addEventListener("click", startRecording);
    //  }
  });

  var stopButtons = document.getElementsByClassName("stopButton");
  Array.from(stopButtons).forEach((stopBtn)=>{
  	//if(stopBtn.getAttribute('visible')=='yes'){
  		stopButton = stopBtn;
  		stopBtn.addEventListener("click", stopRecording);
  	// }else{
  	// 	console.log(0)
  	// }
  });

  //add events to those 2 buttons


  function startRecording() {
  	console.log("startRecording() called");
      // $(document).find('.audio-row.active').find('.recordButton').hide();
      $(document).find('.stop-button').show();
      recordButton.currentTime=0;
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

         $('.page-loader-wrapper').fadeIn();
  			createDownloadLink(blob,recorder.encoding);
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
  	  	//enable the record button if getUSerMedia() fails
      	recordButton.disabled = false;
      	stopButton.disabled = true;

  	});

  	//disable the record button
      recordButton.disabled = true;
      stopButton.disabled = false;
  }

  function stopRecording() {
  	console.log("stopRecording() called");

  	//stop microphone access
  	gumStream.getAudioTracks()[0].stop();

  	//disable the stop button
  	stopButton.disabled = true;
  	recordButton.disabled = false;

  	//tell the recorder to finish the recording (stop recording + encode the recorded audio)
  	recorder.finishRecording();
    $('.delete-icon').show();

    //$('.recording-icon').hide();
    console.log('===================> HERE <=====================')
  //  $('.stopButton').parent().parent().find('.mic-icon').css('background-color','#264B82');
    //$('.timer-question').hide();
  	///__log('Recording stopped');
  }

  function createDownloadLink(blob,encoding) {

  	var url = URL.createObjectURL(blob);
  	var au = document.createElement('audio');
  	var li = document.createElement('li');
  	var link = document.createElement('a');

  	//add controls to the <audio> element
  	au.controls = true;
  	au.src = url;
    console.log('url======>',url)

  	link.href = url;
  	var filename = new Date().toISOString();

  	var upload = document.createElement('button');
  	//upload.href = "javasript:;";
    upload.type="button";
    upload.innerHTML = "Upload";

  	upload.addEventListener("click", function(event) {

  	    var xhr = new XMLHttpRequest();

        var practice_id = $(document).find('input.practise_id:hidden').val();
  	    xhr.onload = function(e) {
  	        if (this.readyState === 4) {
  	            console.log("Server returned: ", e.target.responseText);
                var parse  = JSON.parse(e.target.responseText)
                $('.practice_audio').attr('src', parse.path);
                $('.practice_audio').find('source').attr('src', parse.path);
                $('div.audio-element').css('pointer-events','auto');
                $('.submitBtn').removeAttr('disabled');
                // $('.next-btn').addClass('active');
                // $('.stopButton').parent().hide();
                // $('.recording-icon').hide();
                // $('.timer-question').hide();
                 $('.page-loader-wrapper').fadeOut();
  	        } else {
  						console.log('error============>',e)
  					}
  	    };

  	    var fd = new FormData();
  	    fd.append("audio_data", blob);
        fd.append("practice_id",practice_id);
  	    xhr.open("POST", upload_url, true);
        xhr.setRequestHeader('X-CSRF-Token', token);
  	    xhr.send(fd);
  	});
  	upload.click();
  }
