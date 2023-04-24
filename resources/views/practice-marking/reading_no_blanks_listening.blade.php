

<p>
	<strong><?php 
	// dd($practise);
	// echo "<pre>";print_r($practise); echo "</pre>";
	echo $practise['title']; ?></strong>
</p>



<?php

if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers" ){
		$depend =explode("_",$practise['dependingpractiseid']);
	?>
	<div class="appendDependantHtmla"> </div>
<?php } ?>
<?php
		$exploded_question = [];
		$answerExists = false;
			// dd($practise);
		if(isset($practise['question'])){
			$exploded_question  =  explode(PHP_EOL, $practise['question']);
			if(isset($practise['user_answer']) && !empty($practise['user_answer'])){	
				$answerExists = true;
				$userAnswer = explode(";",$practise['user_answer'][0]);
				// echo '<pre>'; print_r($exploded_question); exit;
			}
		}
?>
<?php

if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers" ){
		$depend =explode("_",$practise['dependingpractiseid']);
	?>
    <input type="hidden" class="get_answers_put_into_quetions_topic_id" name="get_answers_put_into_quetions_topic_id" value="{{$topicId}}">
    <input type="hidden" class="get_answers_put_into_quetions_task_id" name="depend_task_id" value="{{$depend[0]}}">
	<input type="hidden" class="get_answers_put_into_quetions_practise_id" name="depend_practise_id" value="{{$depend[1]}}">

	<div id="dependant_pr_{{$practise['id']}}" style="display:none; border: 2px dashed gray; border-radius: 12px;">
	<p style="margin: 15px;">In order to do this task you need to have completed <strong>Practice  <?php if($depend[3] == 1){echo "A";} if($depend[3] == 2){echo "B";}if($depend[3] == 3){echo "C";}if($depend[3] == 4){echo "D";}if($depend[3] == 5){echo "E";} if($depend[3] == 6){echo "F";} ?>. </strong> Please complete this first.</p>
	</div>
<?php } ?>

    <div class="table-container">
      <form class="reading-no-blanks_form_{{$practise['id']}} commonFontSize">

      	
		@include('practice.common.audio_player')

        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">


				<ul class="list-unstyled">
					<?php
					// dd($userAnswer);
					$exploded_question = array_filter($exploded_question);
					$exploded_question = array_merge($exploded_question);
					$answerkey=0;
						foreach($exploded_question as $question){

							if(str_contains($question,'@@')){
											             		


										// return '<span class="resizing-input1">\
									 // 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper"  style="min-width:'.$style.' !important;">'+ans[p-1]+'</span>\
									 // 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'+ans[p-1]+'">\
										// 		</span>';



								// $question = str_replace("@@",'<span class="resizing-input"><input type="text" class="form-control form-control-inline" name="blanks[]" style="text-align:left;padding-left:0px!important;padding-right:0px!important;" value="'.$answer.'"><span style="display:none"></span></span>',$question);


								echo $outValue = preg_replace_callback('/@@/', function ($m) use (&$key1, &$ans, &$data, &$question, &$k, &$answer, &$answerkey, &$userAnswer) {
								 		$newans = isset($ans[$k])?trim($ans[$k]):'';

								 		$answer ="";
										if(isset($userAnswer[$answerkey])){
											$answer = $userAnswer[$answerkey];
										}

								 		$value = strlen($newans);
								  		if($value == ""){
											$style = "3ch";
										}else{
										  	if($value == "1" || $value == "2" || $value == "3"){
												$style = "1ch";
										  	}else{
												$style = "3ch";
										  	}
										}

										$str ='<span class="resizing-input1">
									 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper"  style="min-width:'.$style.' !important;">'.$answer.'</span>
									 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$answer.'">
													
												</span>';
			                           	$k++;
			                           	$answerkey++;
										return $str;
									}, $question);


								// $question = str_replace("@@",'<span class="resizing-input1">
								// 	 				<span contenteditable="true" class="enter_disable spandata fillblanks stringProper"  style="min-width:'.$style.' !important;">'.$answer.'</span>
								// 	 				<input type="hidden" class="form-control form-control-inline appendspan" name="blanks[]" value="'.$answer.'">
								// 				</span>',$question);
								
							}else{
								echo $question;			
							}
					?>
							<li><?php //echo $question;?></li>
					<?php }?>
				</ul>

		<?php 
		if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers" ){?>
			<div class="appendDependantHtml"> </div>
    	<?php } ?>

       
		<?php
if($answerExists){
	$userAnswer = $practise['user_answer'][0];
	$userAnswer = explode(";",$userAnswer);
?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		<?php foreach($userAnswer as $k=>$userAns){?>
			jQuery(".reading-no-blanks_form_{{$practise['id']}} ul.list-unstyled input.form-control-inline:eq(<?php echo $k;?>)").val('<?php echo $userAns;?>');
			jQuery(".reading-no-blanks_form_{{$practise['id']}} ul.list-unstyled input.form-control-inline:eq(<?php echo $k;?>)").attr('value','<?php echo $userAns;?>');
		<?php }?>
	})
	</script>
<?php }?> 
	</form>

    </div>

<?php

if(isset($practise['is_dependent']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && isset($practise['typeofdependingpractice']) && $practise['typeofdependingpractice']=="get_questions_and_answers" ){
		$depend =explode("_",$practise['dependingpractiseid']);
		?>

		<script type="text/javascript">
			$(document).ready(function(){
				setTimeout(function(){
					getDependingPractises();
				},500)
			})
			function getDependingPractises() {
       			var topic_id= $('.get_answers_put_into_quetions_topic_id').val();
		        var task_id=$('input.get_answers_put_into_quetions_task_id').val();
		        var practise_id=$('input.get_answers_put_into_quetions_practise_id').val();
		        $.ajax({
		            url: "{{url('get-student-practisce-answer')}}",
		            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		            type: 'POST',
		            data:{
		                topic_id,
		                task_id,
		                practise_id
		            },
		            dataType:'JSON',
		            success: function (data) {
		            	var userAns = '<?php echo isset($practise['user_answer'])?$practise['user_answer'][0]:""; ?>';
						var ans = userAns.split(";");
			            if(typeof data.success == "undefined"){
			            	var user_ans = data.user_Answer[0].split(';');
			            	var question = data.question.split("\n");
			             	var text = "";
		            		var datanew = "";
		            		user_ans.forEach(function(item,key) {
		            			if(question[item-1].includes("..........")){
		            					datanew+=question[item-1]+"<br>";
				             	}else{
				             		datanew+=question[item-1]+"<br>";
				             	}
							});
							var finlaFilterQuestion= datanew.split("<br>");
							var p=0;
							finlaFilterQuestion.forEach(function(item,key) {
		            			if(item.includes("..........")) {
				             		text+=item.replace("..........", function (str,p1,offset) {
				            			p++;
				            			if(ans!=""){
				             				return '<span class="resizing-input1">\
				             						<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" >'+ans[p-1]+'</span>\
				             						<input type="hidden" class="form-control form-control-inline disableclass" name="blanks[]" style="text-align:left;width:12%;display: inline-table;padding-left:0px!important;padding-right:0px!important;" value="'+ans[p-1]+'"></span>';
				            			}else{

				            					return '<span class="resizing-input1">\
				             						<span contenteditable="true" class="enter_disable spandata fillblanks stringProper" ></span>\
				             						<input type="hidden" class="form-control form-control-inline disableclass" name="blanks[]" style="text-align:left;width:12%;display: inline-table;padding-left:0px!important;padding-right:0px!important;" ></span>';


				            			}


				            		

				            		});
				             	} else {
									var k 	= item.replace("<b>",'');
									var d 	= k.replace("</b>",'');
				             		text 	+= d;

				             	}
				             	text+="</br>";
							});
			             	$('.appendDependantHtml').html(text)
			            }else{
                    		$("#dependant_pr_{{$practise['id']}}").css("display", "block");
                    		$(".audio-player").css("display", "none");
			            }
		            }
		        });
		    }		
		</script>
	<?php } ?>

<style type="text/css">
	

  	*[contenteditable]:empty:before
	{
	    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}



	.appendspan {
	 	color:red;
	}


</style>

<script type="text/javascript">
	$(".stringProper").on({
	    keydown: function(e) {
	        if(e.key === ";" || e.key === "&" ||e.key === ")" ||e.key === "(" ) {
	            return false;
	        }
	    }
	});
	$('.stringProper').on("cut copy paste",function(e) {
      	e.preventDefault();
   	});
	function commonDataPushInText(){
		$('.spandata').each(function(){
			$(this).next().val($(this).html());
		});
	}

	$('.spandata').each(function(){
		$(this).next().val($(this).val())
	});
	$('.spandata').keyup(function(){
		$(this).next().val($(this).text())
	});
	function addslashes( str ) {  
        return (str+'').replace(/([\\"'])/g, "\\$1").replace(/\0/g, "\\0");  
	}
	function Audioplay(pid){ 
	 
		var supportsAudio = !!document.createElement('audio').canPlayType;
		if (supportsAudio) {
			$('.modal').find('.plyr__controls:first').remove()
            var i;
            var player = new Plyr(".modal .audio_"+pid, {
                controls: [
                    'play',
                    'progress',
                    'current-time'
                ]
            }); 
        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        } 
	}


	jQuery(function ($) {
        'use strict'
        var supportsAudio = !!document.createElement('audio').canPlayType;
        if (supportsAudio) {
            // initialize plyr
            var i;

               var player = new Plyr(".audio_{{$practise['id']}}", {
                controls: [

                    'play',
                    'progress',
                    'current-time',

                ]
            });


        } else {
            // no audio support
            $('.column').addClass('hidden');
            var noSupport = $('#audio1').text();
            $('.container').append('<p class="no-support">' + noSupport + '</p>');
        }
    });

	$(document).on('keyup','.spandata',function() {
			var value = $(this).html().trim().length
			if(value == ""){
			$(this).css("min-width","3ch");
		}else{
		  	if(value == "1" || value == "2" || value == "3"){
		  		$(this).css("min-width","1ch");
		  	}else{
		  		if(flag){
					flag = false;
					$(this).css("min-width","3ch");
		  		}
		  	}
		}
	})

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<style type="text/css">
  	*[contenteditable]:empty:before
	{
	    content: "\feff"; /* ZERO WIDTH NO-BREAK SPACE */
	}
	.appendspan {
	 	color:red;
	}
</style>
