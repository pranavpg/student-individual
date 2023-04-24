<!--Vocabulary Modal-->
<style>#word-error, #wordtype-error, #translationmeaning-error {
        display: block;
        position: absolute;
        top: 34px;
        left: 115px;
    }
    #copytheword-error {
        display: block;
        position: absolute;
        top: 34px;
        left: 155px;
    }
	.fa-solid.fa-keyboard{
		font-size:1.4rem;
		color: #3e5971;
	}
	 </style>
<div class="modal fade" id="vocabularyModal" tabindex="-1" role="dialog"
        aria-labelledby="vocabularyModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
				<form id="my_form2" action="{{ URL('vocab_post') }}" method="post">
				@csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="vocabularyModalLabel">
					<i class="fa fa-book" aria-hidden="true"></i>
                        Vocabulary
                    </h5>
					
                    <div class="modal-title__right form-inline">
                        

                    </div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
                </div>
                <div class="modal-body vocabulary-body">
					<div class="form-group mb-3 maxw-300">
						<select name="modal_topic_id" id="modal_topic_id" class="form-control">
							<option value="">Please Select Topic</option>
							<?php if(!empty($vocabtopiclist)){?>
							<?php foreach($vocabtopiclist as $i=>$vocabtopic){?>
								<option value="<?php echo $vocabtopic['id'];?>"><?php echo $vocabtopic['name']?></option>
							<?php }?>
							<?php }?>
						</select>
					</div>
                    <div class="row">
                        <div class="col-12 col-sm-6 form-group form-group-inline align-items-end">
                            <h6>Word </h6>
                            <textarea type="text" name="word" id="word" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 col-sm-6 form-group form-group__copy form-group-inline align-items-end">
                            <h6>Copy the word </h6>
                            <textarea type="text" name="copytheword" id="copytheword" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 col-sm-6 form-group form-group-inline align-items-end">
                            <h6>Word Type </h6>
                            <textarea type="text" name="wordtype" id="wordtype" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 col-sm-6 form-group form-group__phonetic form-group-inline align-items-end">
                            <h6>Phonetic Transcription</h6>
                            <input type="text" name="phonetictranscription" id="phonetictranscription" class="form-control" readonly="true">
                            <!-- <img src="{{ asset('public/images/keyboard-icon/keyboard.png') }}" alt="keyboard icon"  class="img-fluid"/> -->
							<i class="fa-solid fa-keyboard" id="phonetic_keyboard"></i>
                            <img src="{{ asset('public/images/keyboard-icon/close.png') }}" alt="close icon" id="phonetic_keyboard_close" class="img-fluid collapse">
                        </div>

						
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12" id="phonetic_keyboard1" style="display:none">
                          						<ul class="nav nav-fill nav-tabs" role="tablist">
												    <li class="nav-item">
												      <a class="nav-link active" data-toggle="tab" href="#tab1">Short Vowels</a>
												    </li>
												    <li class="nav-item">
												      <a class="nav-link" data-toggle="tab" href="#tab2">Long Vowels</a>
												    </li>
												    <li class="nav-item">
												      <a class="nav-link" data-toggle="tab" href="#tab3">Dipthongs</a>
												    </li>
												    <li class="nav-item">
												      <a class="nav-link" data-toggle="tab" href="#tab4">Consonants</a>
												    </li>
												</ul>
												  <div class="tab-content phonetic_keyboard_keys">
												    <div id="tab1" class="container tab-pane active">
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a1.svg') }}" alt="" value="æ"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a2.svg') }}" alt="" value="e"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a3.svg') }}" alt="" value="ɒ"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a4.svg') }}" alt="" value="I"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a5.svg') }}" alt="" value="ʊ"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a6.svg') }}" alt="" value="ə"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-a7.svg') }}" alt="" value="ʌ"></a>
												    </div>
												    <div id="tab2" class="container tab-pane fade">
												    	<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-b1.svg') }}" alt="" value="i:"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-b2.svg') }}" alt="" value="ɑ:"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-b3.svg') }}" alt="" value="ɜ:"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-b4.svg') }}" alt="" value="ɔ:"></a>
															<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-b5.svg') }}" alt="" value="u:"></a>
												    </div>
												    <div id="tab3" class="container tab-pane fade">
												    	<a href="javascript:void(0)"><img class="keybrd" src="{{ asset('public/images/keyboard-icon/icon-c1.svg') }}" alt="" value="eɪ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c2.svg') }}" alt="" value="aɪ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c3.svg') }}" alt="" value="əʊ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c4.svg') }}" alt="" value="aʊ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c5.svg') }}" alt="" value="eə"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c6.svg') }}" alt="" value="ɪə"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-c7.svg') }}" alt="" value="ɔɪ"></a>
												    </div>
												    <div id="tab4" class="container tab-pane fade">
												    	<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d1.svg') }}" alt="" value="p"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d2.svg') }}" alt="" value="b"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d3.svg') }}" alt="" value="k"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d4.svg') }}" alt="" value="g"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d5.svg') }}" alt="" value="f"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d6.svg') }}" alt="" value="V"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d7.svg') }}" alt="" value="t"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d8.svg') }}" alt="" value="d"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d9.svg') }}" alt="" value="s"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d10.svg') }}" alt="" value="z"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d11.svg') }}" alt="" value="ʃ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d12.svg') }}" alt="" value="ʒ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d13.svg') }}" alt="" value="θ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d14.svg') }}" alt="" value="ð"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d15.svg') }}" alt="" value="ʈʃ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d16.svg') }}" alt="" value="dʒ"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d17.svg') }}" alt="" value="h"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d18.svg') }}" alt="" value="l"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d19.svg') }}" alt="" value="r"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d20.svg') }}" alt="" value="w"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d21.svg') }}" alt="" value="j"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d22.svg') }}" alt="" value="m"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d23.svg') }}" alt="" value="n"></a>
															<a href="javascript:void(0)"><img src="{{ asset('public/images/keyboard-icon/icon-d24.svg') }}" alt="" value="ŋ"></a>
												    </div>
												  </div>
                        </div>
							<div class="col-12 form-group form-group-inline align-items-end">
                            <h6>Meaning </h6>
                            <textarea type="text" name="translationmeaning" id="translationmeaning" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline align-items-end">
                            <h6>Sample Sentence 1</h6>
                            <textarea type="text" name="sentence1" id="sentence1" class="form-control w-100" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline align-items-end">
                            <h6>Sample Sentence 2</h6>
                            <textarea type="text" name="sentence2" id="sentence2" class="form-control w-100" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                        <div class="col-12 form-group form-group__full form-group-inline align-items-end">
                            <h6>Sample Sentence 3</h6>
                            <textarea type="text" name="sentence3" id="sentence3" class="form-control w-100" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
						<div class="col-12 form-group form-group__full form-group-inline align-items-end">
                            <h6>Sample Sentence 4</h6>
                            <textarea type="text" name="sentence4" id="sentence4" class="form-control w-100" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn  btn-primary">
					<i class="fa-regular fa-floppy-disk"></i>
                        Save
                    </button>
                    <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
                </div>
				</form>
            </div>
        </div>
    </div>
    
<script type="text/javascript">
 var tempdata = "";
 $(document).ready(function(){ 
	$("#phonetic_keyboard").click(function(){	 
	$( "#phonetic_keyboard1" ).slideToggle( "slow");	
	});	
	$('.phonetic_keyboard_keys a').click(function(){
		tempdata += $(this).children().attr("value");		
		$('#phonetictranscription').val(tempdata);
	});
});
$('#phonetictranscription').keyup(function(){
	tempdata = $(this).val();
});



$('#addsummary').on('click', function (e) {
	var activeCourse = $("#pills-tab li.nav-item .nav-link.active").attr("href");
	
	var activeCourseName = $("#pills-tab li.nav-item .nav-link.active").text();
	var activeCourseId = activeCourse.replace("#pills-","");

	$("#exampleModal #course_id").val(activeCourseId);
	$('#topic_id').val('');
	$('#topic_id option').hide();
	$('#topic_id option').first().show();
	$('#topic_id option[data-courseid="'+activeCourseId+'"]').show();
	$('#listening_summary').val('');
	$('#reading_summary').val('');
	$('#writing_summary').val('');
	$('#speaking_summary').val('');
	$('#grammar_summary').val('');
	$('#vocabulary_summary').val('');
	$('#topic_id').prop("readonly",false);
})
$("#my_form2").validate({
	rules: {
		modal_topic_id: {
			required: !0,
		},
		word: {
			required: !0,
		},		
		copytheword: {
			required: !0,            
            equalToIgnoreCase: "#word"
		},	
        wordtype: {
			required: !0,
		},
        translationmeaning: {
			required: !0,
		},

	},
  messages: {
  modal_topic_id: "Please select topic",  
  word: "Please enter word name",    
  copytheword: 
        { 
            required: "Please enter word copy",
            equalToIgnoreCase: "Ops! Please see the 'Word' and 'copy the word'. they don't match." 
        },
  wordtype: "Please enter word type",  
  translationmeaning: "Please enter Translation/Meaning",          
             
  },
	errorElement: "div",
	errorClass: "invalid-feedback",
	submitHandler: function(form) {
		$("#my_form2").find("input[type='submit']").prop("disabled",true);
		$("#my_form2").find("input[type='submit']").attr("value","Submitting...");
		$("#my_form2").find("button[type='submit']").prop("disabled",true);
		$("#my_form2").find("button[type='submit']").text("Submitting...");
	 
		//form.submit();
		$.ajax({
			type: "POST",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '{{ URL("vocab_post") }}',
			data : $("#my_form2").serialize(),
			//dataType: "json",
			success: function(data) {
				setTimeout(function(){ window.location.reload() },2000);
            //alert("success");
            if(data.success){
                setTimeout(function(){ window.location.reload() },2000);
                
                $('.alert-danger').hide();
                $('.alert-success').show().html(data.message).fadeOut(6000);
            }else{
                $('.alert-success').hide();
                $('.alert-danger').show().html(data.message).fadeOut(6000);
            }
			
				$("#my_form2").find("input[type='submit']").prop("disabled",false);
				$("#my_form2").find("input[type='submit']").attr("value","Save");
				$("#my_form2").find("button[type='submit']").prop("disabled",false);
				// $("#my_form2").find("button[type='submit']").text("Sign In");
			}
		});
		return false;								
	}
})

$.validator.addMethod("equalToIgnoreCase", function (value, element, param) {
        return this.optional(element) || 
             (value.toLowerCase() == $(param).val().toLowerCase());
});
</script>

