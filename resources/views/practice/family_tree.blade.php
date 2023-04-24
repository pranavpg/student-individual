<script src="{{ asset('public/analog/src/clock-1.1.0.js') }}"></script>
<style type="text/css">
	.rowwrapper{ margin-bottom:50px;}
	.borderdiv{ border:1px solid #d55b7d; padding:0; color:#d55b7d; text-align:center; height:56px; line-height:56px; font-weight:bold;}
	.borderdiv input{
		    border: 0;
			width: 100%;
			height: 100%;
			display: block;
			padding: 0 5px;	
			text-align:center;
			 font-weight:normal;
	}
	.bottomlong::after{
		content:' ';
		background:#d55b7d;
		display:block;
		position:absolute;
		width:5px;
		height: 52px;
		right: 63px;
	}
	.bottomlongcustom::before{
		content: ' ';
		background: #d55b7d;
		display: block;
		position: absolute;
		width: 5px;
		height: 75px;
		left: 36px;
		bottom: -133%;
	}
	.bottomside::after{
		content: ' ';
		background: #d55b7d;
		display: block;
		position: absolute;
		width: 31px;
		height: 5px;
		right: 63px;
		top: 45%;
		right: -16px;
	}
	
</style>
<p>
	<strong><?php
	echo $practise['title'];
	?></strong>
	<?php 
	$userAnswer = array();
	if(isset($practise['user_answer']) && !empty($practise['user_answer'])){
		$userAnswer = $practise['user_answer'];
	}?>
</p>
    <div class="table-container">
      <form class="family_tree" id="family_tree_<?php echo $practise['id'];?>">
        <input type="hidden" class="topic_id" name="topic_id" value="{{$topicId}}">
        <input type="hidden" class="task_id" name="task_id" value="{{$taskId}}">
        <input type="hidden" class="is_save" name="is_save" value="">
        <input type="hidden" class="practise_id" name="practise_id" value="{{$practise['id']}}">
        <div class="container" style="width:669px; margin:0 auto;">
			<?php $questions = explode(PHP_EOL, $practise['question']);
				$trees = explode("@@ ",$questions[0]); ?>
			<div class="row rowwrapper" style="padding-left:105px; margin-bottom:20px;">
				
				<div class="col-3">
					<div class="borderdiv"><?php echo $trees[0];?></div>
				</div>
				<div class="col-3">
					<div class="borderdiv "><input type="text" name="tree[0]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[0];}?>" /></div>
				</div>
				<div class="col-3"></div>
				<div class="col-3"></div>
			</div>
			
			<div class="row rowwrapper" style="padding-left:105px;">
				
				<div class="col-3 bottomlong">
					<div class="borderdiv"><input type="text" name="tree[1]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[1];}?>" /></div>
				</div>
				<div class="col-3 bottomlong">
					<div class="borderdiv"><?php echo $trees[1];?></div>
				</div>
				<div class="col-3"></div>
				<div class="col-3"></div>
			</div>
			
			<div class="row rowwrapper" style=" margin-bottom:20px;">
				<div class="col-3">
					<div class="borderdiv"><?php echo $trees[2];?></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[2]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[2];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[3]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[3];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><?php echo $trees[3];?></div>
				</div>
			</div>
			
			<div class="row rowwrapper">
				<div class="col-3 bottomlong">
					<div class="borderdiv"><input type="text" name="tree[4]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[4];}?>" /></div>
				</div>
				<div class="col-3 bottomlongcustom bottomside">
					<div class="borderdiv"><input type="text" name="tree[5]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[5];}?>" /></div>
				</div>
				<div class="col-3 bottomside">
					<div class="borderdiv"><input type="text" name="tree[6]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[6];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><?php echo $trees[4];?></div>
				</div>
			</div>
			
			<div class="row rowwrapper" style="padding-left:50px; margin-bottom:20px;">
				<div class="col-3 bottomside">
					<div class="borderdiv"><?php echo $trees[5];?></div>
				</div>
				<div class="col-3 bottomside">
					<div class="borderdiv"><input type="text" name="tree[7]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[7];}?>" /></div>
				</div>
				<div class="col-3 bottomside">
					<div class="borderdiv"><input type="text" name="tree[8]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[8];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[9]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[9];}?>" /></div>
				</div>
			</div>
			
			<div class="row rowwrapper" style="padding-left:50px;">
				<div class="col-3">
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[10]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[10];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[11]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[11];}?>" /></div>
				</div>
				<div class="col-3">
					<div class="borderdiv"><input type="text" name="tree[12]" placeholder="write here.." value="<?php if(!empty($userAnswer)){ echo $userAnswer[12];}?>" /></div>
				</div>
			</div>
			
			
			
			
		</div>
		
		
		
		<br /><br />
		
		
		<div class="alert alert-success" role="alert" style="display:none"></div>
		<div class="alert alert-danger" role="alert" style="display:none"></div>
		<input type="hidden" name="speaking_one" value="true" />

		<ul class="list-inline list-buttons">
        <li class="list-inline-item"><button type="button" class="save_btn btnSubmits_{{$practise['id']}} btn btn-primary" data-toggle="modal" data-is_save="0" data-target="#exitmodal" >Save</button>
        </li>
        <li class="list-inline-item"><button type="button" class="submit_btn btnSubmits_{{$practise['id']}} btn btn-primary" data-is_save="1" >Submit</button>
        </li>
    </ul>
        <!-- <input type="button" class="btnSubmits btn btn-primary" value="Save" data-is_save="0">
        <input type="button" class="btnSubmits btn btn-primary" value="Submit" data-is_save="1"> -->
		
		
      </form>
		@if(isset($practise["markingmethod"]) && $practise["markingmethod"] == "student_self_marking")

			@include('practice.common.student_self_marking')

		@endif
		@php
			$lastPractice=end($practises);
		@endphp
		@if($lastPractice['id'] == $practise['id'])
			@include('practice.common.review-popup')
			@php
				$reviewPopup=true;
			@endphp
		@else
			@php
				$reviewPopup=false;
			@endphp
		@endif	  
    </div>


<script type="text/javascript">
$(document).on('click','#family_tree_<?php echo $practise['id'];?> .btnSubmits_{{$practise['id']}}' ,function() {
			if($(this).attr('data-is_save') == '1'){
		        $(this).closest('.active').find('.msg').fadeOut();
		    }else{
		        $(this).closest('.active').find('.msg').fadeIn();
		    }

	var reviewPopup = '{!!$reviewPopup!!}';
    var markingmethod = '<?php echo isset($practise["markingmethod"])?$practise["markingmethod"]:""; ?>';
            if(markingmethod =="student_self_marking"){
                if($(this).attr('data-is_save') == '1'){
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
                    var fullView= $('#family_tree_<?php echo $practise['id'];?> ').clone();
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.family_tree').attr("id","");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').html("");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('#practise_div').append(fullView);
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").modal('toggle');
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.list-buttons').css("display","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.family_tree').css("pointer-events","none");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').css("display","none !important");
					$("#selfMarking_{{isset($practise['id'])?$practise['id']:''}}").find('.alert').remove();
                }
            }
            if($(this).attr('data-is_save') == '1' && reviewPopup == true && markingmethod !='student_self_marking'){
                $("#reviewModal_{{$practise['id']}}").modal('toggle');

            }
  $('#family_tree_<?php echo $practise['id'];?> .btnSubmits').attr('disabled','disabled');
  var is_save = $(this).attr('data-is_save');
  $('.is_save:hidden').val(is_save);
  $.ajax({
      url: '<?php echo URL('family_tree_submit'); ?>',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'POST',
      data: $('#family_tree_<?php echo $practise['id'];?> ').serialize(),
      success: function (data) {
        $('#family_tree_<?php echo $practise['id'];?> .btnSubmits').removeAttr('disabled');
		if(data.success){
			$('.alert-danger').hide();
			$('.alert-success').show().html(data.message).fadeOut(8000);
		}else{
			$('.alert-success').hide();
			$('.alert-danger').show().html(data.message).fadeOut(8000);
		}
        
      }
  });
});
</script>

