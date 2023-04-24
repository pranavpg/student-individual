$(document).on('ready', function() {
  //webkitURL is deprecated but nevertheless
  // $(document).on('click', '.next-btn', function() {
  //       var prefs = {
  //         element: ".circlebar"
  //     };
  //     new Circlebar(prefs);
  //     $('.stopButton').parent().show();
  // });
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

  Array.from(recordButtons).forEach((recBtn)=>{
      if(recBtn.getAttribute('visible')==='true'){
  			recordButton = 	recBtn;
   			recBtn.addEventListener("click", startRecording);
      }else{
  			console.log(0)
  		}
  });

  var stopButtons = document.getElementsByClassName("stopButton");
  Array.from(stopButtons).forEach((stopBtn)=>{
  	if(stopBtn.getAttribute('visible')==='true'){
  		stopButton = stopBtn;
  		stopBtn.addEventListener("click", stopRecording);
  	}else{
  		console.log(0)
  	}
  });

  //add events to those 2 buttons


  function startRecording() {
  	console.log("startRecording() called");

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
        createDownloadLink(blob,recorder.encoding);
  			//encodingTypeSelect.disabled = false;
  		}

  		recorder.setOptions({
  		  timeLimit:5,
  		  encodeAfterRecord:encodeAfterRecord,
  	      ogg: {quality: 0.5},
  	      mp3: {bitRate: 160}
  	    });

  		//start the recording process
  		recorder.startRecording();
  		//__log("Recording started");
      $('.timer').show();
      var prefs = {
          element: ".circlebar"
      };

      new Circlebar(prefs);

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
  //  $('.stopButton').parent().hide();
      $('.timer').hide();
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
  	// var a = document.createElement('a');
  	// a.href = url;
  	// a.download = 'audio.wav';
  	// document.body.append(a);
  	// a.click();
  	// a.remove();
  	// window.URL.revokeObjectURL(url);

  	//link the a element to the blob
  	link.href = url;
  	var filename = new Date().toISOString();
  	// link.download =  filename+ '.'+encoding;

  	// link.innerHTML = link.download;

  	//add the new audio and a elements to the li element
  	// li.appendChild(au);
  	// li.appendChild(link);



  	//filename to send to server without extension
  	//upload link
  	var upload = document.createElement('a');
  	upload.href = "javascript:void(0)";
  	upload.innerHTML = "Upload";

  	upload.addEventListener("click", function(event) {
  	    var xhr = new XMLHttpRequest();
  	    xhr.onload = function(e) {
  	        if (this.readyState === 4) {
  	            console.log("Server returned: ", e.target.responseText);
                var parse  = JSON.parse(e.target.responseText);
                $('.answer_audio0').attr('src', parse.path);
                // $('.stopButton').parent().hide();
                // $('.timer').hide();
  	        } else {
  						console.log('error============>',e)
  					}
  	    };

  	    var fd = new FormData();
  	    fd.append("audio_data", blob, filename);
  	    xhr.open("POST", upload_url, true);
        xhr.setRequestHeader('X-CSRF-Token', token);
  	    xhr.send(fd);
  	})
  	upload.click()

  	// li.appendChild(document.createTextNode(" ")) //add a space in between
  	// li.appendChild(upload) //add the upload link to li

  	//add the li element to the ordered list
  //	recordingsList.appendChild(li);
  }



  function Circlebar(prefs) {
      this.element = $(prefs.element);
      this.element.append('<div class="spinner-holder-one animate-0-25-a"><div class="spinner-holder-two animate-0-25-b"><div class="loader-spinner" style=""></div></div></div><div class="spinner-holder-one animate-25-50-a"><div class="spinner-holder-two animate-25-50-b"><div class="loader-spinner"></div></div></div><div class="spinner-holder-one animate-50-75-a"><div class="spinner-holder-two animate-50-75-b"><div class="loader-spinner"></div></div></div><div class="spinner-holder-one animate-75-100-a"><div class="spinner-holder-two animate-75-100-b"><div class="loader-spinner"></div></div></div>');
      this.value, this.maxValue,this.minValue, this.counter, this.dialWidth, this.size, this.fontSize, this.fontColor, this.skin, this.triggerPercentage, this.type, this.timer;
      // var attribs = this.element.find("div")[0].parentNode.dataset;
      //console.log( '',this.element[0].dataset)
      var attribs = this.element[0].dataset,
          that = this;
      this.initialise = function() {
          that.value = parseInt(attribs.circleStarttime) || parseInt(prefs.startTime) || 0;
          that.maxValue = parseInt(attribs.circleMaxvalue) || parseInt(prefs.maxValue) || 0;
          that.counter = parseInt(attribs.circleCounter) || parseInt(prefs.counter) || 1000;
          that.dialWidth = parseInt(attribs.circleDialwidth) || parseInt(prefs.dialWidth) || 5;
          that.size = attribs.circleSize || prefs.size || "150px";
          that.fontSize = attribs.circleFontsize || prefs.fontSize || "20px";
          that.fontColor = attribs.circleFontcolor || prefs.fontColor || "rgb(135, 206, 235)";
          that.skin = attribs.circleSkin || prefs.skin || " ";
          that.triggerPercentage = attribs.circleTriggerpercentage || prefs.triggerPercentage || false;
          that.type = attribs.circleType || prefs.type || "timer";


          that.element.addClass(that.skin).addClass('loader');
          that.element.find(".loader-bg").css("border-width", that.dialWidth + "px");
          that.element.find(".loader-spinner").css("border-width", that.dialWidth + "px");
          that.element.css({ "width": that.size, "height": that.size });
          that.element.find(".loader-bg .text")
              .css({ "font-size": that.fontSize, "color": that.fontColor });
      };
      this.initialise();
      this.renderProgress = function(progress) {
          progress = Math.ceil(progress);
          var angle = 360;
          console.log('progress=====>',progress   )
          if (progress < 25) {
              angle = -90 + (progress / 100) * 360;
              that.element.find(".animate-0-25-b").css("transform", "rotate(" + angle + "deg)");
              if (that.triggerPercentage) {
                  that.element.addClass('circle-loaded-0');
              }

          } else if (progress >= 25 && progress < 50) {
              angle = -90 + ((progress - 25) / 100) * 360;
              that.element.find(".animate-0-25-b").css("transform", "rotate(0deg)");
              that.element.find(".animate-25-50-b").css("transform", "rotate(" + angle + "deg)");
              if (that.triggerPercentage) {
                  that.element.removeClass('circle-loaded-0').addClass('circle-loaded-25');
              }
          } else if (progress >= 50 && progress < 75) {
              angle = -90 + ((progress - 50) / 100) * 360;
              that.element.find(".animate-25-50-b, .animate-0-25-b").css("transform", "rotate(0deg)");
              that.element.find(".animate-50-75-b").css("transform", "rotate(" + angle + "deg)");
              if (that.triggerPercentage) {
                  that.element.removeClass('circle-loaded-25').addClass('circle-loaded-50');
              }
          } else if (progress >= 75 && progress <= 100) {
              angle = -90 + ((progress - 75) / 100) * 360;
              that.element.find(".animate-50-75-b, .animate-25-50-b, .animate-0-25-b")
                  .css("transform", "rotate(0deg)");
              that.element.find(".animate-75-100-b").css("transform", "rotate(" + angle + "deg)");
              if (that.triggerPercentage) {
                  that.element.removeClass('circle-loaded-50').addClass('circle-loaded-75');
              }
          }
      };
      this.textFilter = function() {
          var percentage = 0,
              date = 0,
              i=0,
              text = that.element.find(".text");
          if (that.type == "timer") {
              var examTime = that.value
              that.timer = setInterval(function() {
                  i++;

                  if (that.value > that.maxValue) {
                      that.value -= parseInt(that.counter / 1000);
                      percentage = (100*i)/examTime;//(that.maxValue * 100) / that.value;
                      console.log('===>',percentage)
                      that.renderProgress(percentage);
                      text[0].dataset.value = that.value;
                      date = new Date(null);
                      date.setSeconds(that.value); // specify value for seconds here
                      text.html(date.toISOString().substr(14, 5) + ' min');

                  } else {
                    console.log('================clear interval===================')
                      clearInterval(that.timer);
                  }
              }, (that.counter));
          }
          if (that.type == "progress") {
              function setDeceleratingTimeout(factor, times) {
                  var internalCallback = function(counter) {
                      return function() {
                          if (that.value > that.maxValue && that.value < 100) {
                              that.value += 1;
                              that.renderProgress(that.value);
                              text[0].dataset.value = that.value;
                              text.html(Math.floor(that.value) + "%");
                              setTimeout(internalCallback, ++counter * factor);
                          }
                      }
                  }(times, 0);
                  setTimeout(internalCallback, factor);
              };
              setDeceleratingTimeout(0.1, 100);
          }
      }
      this.textFilter();
      this.setValue = function(val) {
          text = that.element.find(".text");
          that.value = val;
          that.renderProgress(that.value);
          text[0].dataset.value = that.value;
          text.html(that.value);
      }
  }

  $.fn.Circlebar = function(prefs) {
      prefs.element = this.selector;
      new Circlebar(prefs);
  };

});


//helper function
// function __log(e, data) {
// 	log.innerHTML += "\n" + e + " " + (data || '');
// }
