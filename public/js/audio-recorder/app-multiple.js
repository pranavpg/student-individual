//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb.
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

// var recordButton = document.getElementById("recordButton");
// var stopButton = document.getElementById("stopButton");
// var pauseButton = document.getElementById("pauseButton");

var recordButton;
var stopButton;
var  pauseButton;

//add events to those 2 buttons
// recordButton.addEventListener("click", startRecording);
// stopButton.addEventListener("click", stopRecording);
// pauseButton.addEventListener("click", pauseRecording);
//==============================================================================
var counter=300
var disableWhenRecord=true
// var interval;
// function setWatch(){
//   console.log('init===>')
//   interval = setInterval(function(){
//     counter--;
//
//     console.log('counter',counter);
//     var success_width = $('.audio__progress__success').attr('data-width');
//     var s_width = parseFloat(success_width)+0.333
//     $('.audio__progress__success').css('width', s_width+'%');
//     $('.audio__progress__success').attr('data-width', s_width);
//     $('.audio__progress__success').attr('data-counter', counter);
//
//     var remaining_width = $('.audio__progress__remaining').attr('data-width');
//     var r_width = parseFloat(remaining_width)-0.333
//     $('.audio__progress__remaining').css('width', r_width+'%');
//     $('.audio__progress__remaining').attr('data-width', r_width);
//     if(counter<=0){
//       clearInterval(interval);
//       return false;
//     }
//   },1000)
// }
// =============================================================================

//=============================================================================
var go 		= false;
var timer2 	= "5:00";
var audioToggle = true;
function timer() {
    	audioToggle = true;
	console.log(go)
    if(!go){
    	disableWhenRecord = true;
    	$('.countdown').css("display","none");
      	return;
    }
/*    if($('.countdown-'+parentId).hasClass("right")){

    }else{

		$('.countdown-'+parentId).fadeIn();
    }*/
	$('.countdown-'+parentId).css("display","block");
    // alert(counter)
    counter--;
    disableWhenRecord = false;
    // console.log(parentId)
/*    var success_width = $('.audio__progress__success').attr('data-width');
    var s_width = parseFloat(success_width)+0.333
    $('.audio__progress__success').css('width', s_width+'%');
    $('.audio__progress__success').attr('data-width', s_width);
    $('.audio__progress__success').attr('data-counter', counter);

    var remaining_width = $('.audio__progress__remaining').attr('data-width');
    var r_width = parseFloat(remaining_width)-0.333
    $('.audio__progress__remaining').css('width', r_width+'%');
    $('.audio__progress__remaining').attr('data-width', r_width);*/

    if(counter<=0){
      stopTimer();
     /* $('.audio__progress__success').css('width', '100%');
      $('.audio__progress__success').attr('data-width', 100);
      $('.audio__progress__remaining').css('width', '0%');
      $('.audio__progress__remaining').attr('data-width', 0);*/
      $(document).find('.stopButton').trigger('click')
    }
    // alert(counter)
		var timer1 = timer2.split(':');
		
		var minutes = parseInt(timer1[0], 10);
		var seconds = parseInt(timer1[1], 10);
		--seconds;
		minutes = (seconds < 0) ? --minutes : minutes;
		seconds = (seconds < 0) ? 59 : seconds;
		seconds = (seconds < 10) ? '0' + seconds : seconds;
		// alert((minutes + ':' + seconds))
		$('.countdown-'+parentId).html(minutes + ':' + seconds);
		timer2 = minutes + ':' + seconds;


    setTimeout(timer, 1000);
  }

function stopTimer(){
    go = false;
}
function startTimer(){
    go = true;
    timer();
}
// =============================================================================
  $(document).on('click','.recordButton', function() {
    var  audio_key = $(this).attr('data-key');
    var  pid = $(this).attr('data-pid');
    //alert(pid)

    $('.record_'+pid).find('#answer_audio'+audio_key).find('source').prop('src', '');
    //setWatch();

    startRecording($(this))
  });
  $(document).on('click','.stopButton', function() {

    var  id = $(this).attr('id');

    $('.page-loader-wrapper_upload').fadeIn();
    stopRecording($(this));
    console.log("")
    stopTimer()
  });

  $(document).on('click','.pauseButton', function() {
  	if(audioToggle){
  		audioToggle = false;
	    var  id = $(this).attr('id');
	    pauseRecording($(this));
  	}

  });

function startRecording() {
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/

    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia()
	*/
	//
	// recordButton.disabled = true;
	// stopButton.disabled = false;
	// pauseButton.disabled = false

	/*
    	We're using the standard promise based getUserMedia()
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		//update the format
		//	document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;

		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/*
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})


		//start the recording process
		rec.record();
		startTimer();
		$(this).find('.practice_audio').prop('src','');
		console.log("Recording started");

	}).catch(function(err) {
		console.log('error=====<>>',err)
	  	//enable the record button if getUserMedia() fails
    	// recordButton.disabled = false;
    	// stopButton.disabled = true;
    	// pauseButton.disabled = true
	});
}

function pauseRecording(){
	console.log("pauseButton clicked rec.recording=",rec.recording );
	// alert(rec.recording)
	if (rec.recording){
		//pause
		rec.stop();
		stopTimer();
	 	$('.mic__icon').show();
      	$('.new__pause__button-'+parentId).hide();
     	$('.new__resume__button-'+parentId).show();

      	$('.displayOnly-'+parentId).hide();
      	$('.displayOnlyOld-'+parentId).show();

		//pauseButton.innerHTML="Resume";
	}else{
		//resume
		rec.record();
    	startTimer()

    	$('.mic__icon').hide();
      	// $('.animated__mic__icon').show();
      	$('.new__resume__button-'+parentId).hide();
      	$('.new__pause__button-'+parentId).show();
      
      	$('.displayOnly-'+parentId).show();
      	$('.displayOnlyOld-'+parentId).hide();

		//	pauseButton.innerHTML="Pause";

	}
}

function stopRecording(stopRecEl) {
	console.log("stopButton clicked");

	//disable the stop button, enable the record too allow for new recordings
	// stopButton.disabled = true;
	// recordButton.disabled = false;
	// pauseButton.disabled = true;

	//reset button just in case the recording is stopped while paused
	//pauseButton.innerHTML="Pause";

	//tell the recorder to stop the recording
	rec.stop();
  stopTimer();
	// $('.cover-spin').fadeIn()
	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	$(stopRecEl).parent().parent().find('.delete-icon').show();
	$(stopRecEl).hide();
	// $(stopRecEl).parent().parent().find('.record-icon').hide();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);
}

function createDownloadLink_old(blob) {
	
	var url = URL.createObjectURL(blob);
  console.log(url,'====www=>',blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	//add controls to the <audio> element
	au.controls = true;
	au.src = url;

	var audio_key = $(document).find('.active_recording').attr('data-key');
	var practice_id = $(document).find('.active_recording').attr('data-pid');
	console.log(audio_key,'url======2>',url)
	if(audio_key==undefined){
		audio_key="";
	}


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
            var parse  = JSON.parse(e.target.responseText)

            // $('.cover-spin').fadeIn()

            $.ajax({
        			type: "POST",
        			url: rename_audio,
              		headers: {
      				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      			  	},
        			data :{filename: parse.file_name,'audio_key':parse.audio_key, 'practice_id':parse.practice_id},
        			dataType: "json",
        			success: function(res) {
        				
						console.log('res==============================+++>')
						var noCache =  '?noCache=' + Math.floor(Math.random() * 1000000);
						$('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).attr('src', res.path+noCache);
						$('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).find('source').prop('src',res.path+noCache);
						$(document).find('.audio_path'+audio_key).val(res.file_name);
						$('.record_'+practice_id).find('div.audio-element').css('pointer-events','auto');
						$('.form_'+practice_id).find('.submitBtn').removeAttr('disabled');
						$(document).find('#audio-record-modal').modal('toggle');
						$(document).find('.close__modal').removeClass('stopButton');
						$('.submitBtn_'+practice_id ).prop("disabled", false);

						setTimeout(function(){
        					// $('.cover-spin').fadeOut()
        				},2000);
						
        			}
        		});

						// $('.close__modal').attr('data-dismiss','modal')
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



function createDownloadLink(blob) {
	
	var url = URL.createObjectURL(blob);
  	console.log(url,'====www=>',blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	//add controls to the <audio> element
	au.controls = true;
	au.src = url;

	var audio_key = $(document).find('.active_recording').attr('data-key');
	var practice_id = $(document).find('.active_recording').attr('data-pid');
	console.log(audio_key,'url======2>',url)
	if(audio_key==undefined){
		audio_key="";
	}


	var filename = new Date().toISOString();

  	var upload = document.createElement('button');
  	//upload.href = "javasript:;";
  	upload.type="button";
  	upload.innerHTML = "Upload";


	
  	var text = "";

	upload.addEventListener("click", function(event) {

 		 var xhr = new XMLHttpRequest();

 		// var practice_id = $(document).find('input.practise_id:hidden').val();
 		 xhr.onload = function(e) {
 				  if (this.readyState === 4) {
            var parse  = JSON.parse(e.target.responseText)
            console.log(parse);
          
			$('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).attr('src', url);
			$('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).find('source').prop('src',url);
			
			
            // $('.cover-spin').fadeIn()

            $.ajax({
        			type: "POST",
        			url: rename_audio,
              		headers: {
      				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      			  	},
        			data :{filename: parse.file_name,'audio_key':parse.audio_key, 'practice_id':parse.practice_id},
        			dataType: "json",
        			error: function (xhr, ajaxOptions, thrownError) {},
        			success: function(res) {
        				
						console.log('res==============================+++>')
						// var noCache =  '?noCache=' + Math.floor(Math.random() * 1000000);
						// $('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).attr('src', res.path+noCache);
						// $('.record_'+practice_id).find('.answer_audio-'+parse.practice_id+'-'+audio_key).find('source').prop('src',res.path+noCache);
						$(document).find('.audio_path'+audio_key).val(res.file_name);
						$('.record_'+practice_id).find('div.audio-element').css('pointer-events','auto');
						$('.form_'+practice_id).find('.submitBtn').removeAttr('disabled');
						$(document).find('#audio-record-modal').modal('toggle');
						$(document).find('.close__modal').removeClass('stopButton');
						$('.submitBtn_'+practice_id ).prop("disabled", false);

						setTimeout(function(){
        					// $('.cover-spin').fadeOut()
        				},2000);

        				$('.page-loader-wrapper_upload').fadeOut();
						
        			}
        		});

						// $('.close__modal').attr('data-dismiss','modal')
          } else {
            console.log('error============>',e)
          }
 		 };
 		 $('.progressbar-'+practice_id+'-'+audio_key).fadeIn();
 		 var fd = new FormData();
 		 fd.append("audio_data", blob);
 		 fd.append("practice_id",practice_id);
 		 fd.append("audio_key",audio_key);
 		 xhr.open("POST", upload_url, true);
 		 xhr.setRequestHeader('X-CSRF-Token', token);
 		 xhr.upload.onprogress = function(e) {
		    var percentComplete = Math.ceil((e.loaded / e.total) * 100);
 		 	$('.progressbar-'+practice_id+'-'+audio_key).css("--value",percentComplete)
		  	if(percentComplete >=100){
 		 	$('.progressbar-'+practice_id+'-'+audio_key).fadeOut();

		  	}
		    // $("#progress").css("display","");
		    // $("#progressText").text((loopGallery+1)+" z "+cList);
		    // $("#progressBar").css("width",percentComplete+"%");
		 };
 		 xhr.send(fd);


 		

  });
  upload.click();
}



