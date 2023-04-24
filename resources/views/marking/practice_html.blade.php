<div class="course-content bg-white mb-4 course-content_shrink p-2 pcs" id="top-book">
	<div class="course-tab-fixed-heading w-100 d-flex flex-wrap align-items-center justify-content-between">
		<div class="title mb-1">Practice Book</div>
		<?php
			$azRange = range('A', 'Z');
			
			if(isset($topic_tasks['practise'])) {
				$practises = $topic_tasks['practise'];
		?>
		<ul class="nav nav-pills nav-mwidth" id="pills-teacher-tab" role="tablist">
			<?php foreach($practises as $i=>$practise){?>
				<li class="nav-item mb-1">
					<a data-key="{{$i}}" class="nav-link  {{ $markingmethod == 'markingmethod' ? 'practice__link allow__draw' : 'practice__link' }} {{ (!empty($practise['markingmethod']) && $practise['markingmethod'] == 'manual') ? '' : '' }}"   data-markingmethod="{{$markingmethod}}" id="abc-<?php echo $practise['id'];?>-tab" data-toggle="pill" href="#abc-<?php echo $practise['id'];?>" role="tab" aria-controls="abc-<?php echo $practise['id'];?>" data-pid="{{$practise['id']}}" aria-selected="true">
						<?php echo $azRange[$i]. ' : ' . $practise['mark'];?>
					</a>
				</li>
			<?php } $practise_id_1 = $practise['id']; // pr($topic_tasks['id']); ?>
		</ul>
		<div class="expand-option-course">
			<ul class="list-inline">
				<li class="list-inline-item">
					<a href="javascript:void(0);" class="expand-collapse-practice" title="Maximize"> <img src="https://student.englishapp.uk/public/images/ic_expand.png" alt="edit" class="img-fluid rotate-expand-icon"> </a>
				</li>
			</ul>
		</div>
		<?php } ?>
	</div>
	<div class="course-tab-content"> 
		<div class="tab-content scrollbar pl-2" id="pills-teacher--tabContent">
			<?php
				foreach($practises as $i=>$practise) {
					$top_book_class="";
					$content_shrink_class = "";
					if($i == 0) {
						$top_book_class = "active show";
						$bottom_book_class = "";
					}
					if( empty( $practise['marks_gained'] ) ) {
						$save_btn_class = "justify-content-center";
					} else {
						$save_btn_class = "justify-content-end";
						$content_shrink_class = "course-content_shrink";
					}
					?>
					<div class="tab-pane fade {{ $top_book_class }}" id="abc-<?php echo $practise['id'];?>" role="tabpanel" aria-labelledby="abc-<?php echo $practise['id'];?>-tab">
						<fieldset class="practice-fieldset">
							<div class="mb-4 pr-3 allow_draw" id="{{$markingmethod=='manual'?'allow_draw_'.$i:''}}">
								@include('common.practice-types')
							</div>
							@if( $markingmethod=='manual' )
							<img style="display:none;" class="getDrawMarkingImage">
							@endif
						</fieldset>
						<footer class="tab-footer d-flex flex-wrap justify-content-center mb-4">
							<div class="row w-100">
								<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-2">
									<div class="row">
										<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
											@if(!empty($practise['highest_score_attempt_id']))
											<a href="javascript:;" class="btn {{(!empty($showPrevious) && $showPrevious == 1) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getPreviousMarking.bind($data,1)" data-id="{{$practise['answer_id']}}">Highest Score</a>
											@endif
										</div>
										<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
											@if(!empty($practise['second_score_attempt_id']))
											<a href="javascript:;" class="btn {{(!empty($showPrevious) && $showPrevious == 2) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getPreviousMarking.bind($data,2)" data-id="{{$practise['answer_id']}}">Second Score</a>
											@endif
										</div>
										<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 overall-feedback">
											@if(!empty($practise['highest_score_attempt_id']) || !empty($practise['second_score_attempt_id']))
											<a href="javascript:;" class="btn {{ empty($showPrevious) ? 'btn-danger practice-marking-btn' : 'btn-secondary practice-marking-btn'}}" data-bind="click:$root.getCurrentMarking">Latest Marking</a>
											@endif
										</div>
									</div>
								</div>
								<input type="hidden" name="answers[{{$i}}][answer_id]" value="{{$practise['answer_id']}}">
								@php
								$selfMarkingArray = array('automated','read_only','no_marking');
								@endphp
								<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 overall-feedback">
									<div class="editable-box ml-auto mr-auto w-100 d-flex align-items-center flex-wrap {{$save_btn_class}}">
										@if(in_array($practise['markingmethod'], $selfMarkingArray))

										<input type="hidden"  value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" name="answers[{{$i}}][marks_gained]">
										<input type="hidden" name="answers[{{$i}}][comment_image]" value="" class="marking_comment_image">
										<input type="hidden" name="answers[{{$i}}][is_file]" value="false" class="is_marking_file">

										<span>Score: &nbsp;&nbsp;</span>
										<div class="form-group mb-0 d-flex align-items-center" style="max-width: 100px;">
											<input type="text" {{ ( in_array($markingmethod, $selfMarkingArray))?'disabled=disabled':'' }}  class="form-control input-marks-gained {{ ( !in_array($markingmethod, $selfMarkingArray))?'allow_marking':'' }} " data-maxMarks="{{ !empty($practise['mark'])?$practise['mark']:'0' }}" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" style="width: 42px;{{ ( in_array($markingmethod, $selfMarkingArray))?'width: 42px;background-color: #e4dada;text-align: center;padding-right: 13px;':'' }}" name="answers[{{$i}}][marks_gained]">
											<span class="task-marks ml-2">  / {{ !empty($practise['mark'])?$practise['mark']:"0" }}</span>
											<!--{{ <?php //(!empty($practise['marks_gained'])? $practise['marks_gained'] :'0').' / '.($practise['mark']) ?>}}-->
										</div>
										@else
										<span>Add Score: &nbsp;&nbsp;</span>
										<div class="form-group mb-0 d-flex align-items-center" style="{{ ( in_array($markingmethod, $selfMarkingArray))?'max-width: 100px;background-color: #e4dada;text-align: center;padding-right: 13px;':'max-width: 100px;' }}">

											<?php if(in_array($markingmethod, $selfMarkingArray)) { ?>
												<input type="hidden" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}"  name="answers[{{$i}}][marks_gained]">
											<?php } ?>

											<input type="text" {{ ( in_array($markingmethod, $selfMarkingArray))?'disabled=disabled':'' }}  class="form-control input-marks-gained {{ ( !in_array($markingmethod, $selfMarkingArray))?'allow_marking':'' }} " data-maxMarks="{{ !empty($practise['mark'])?$practise['mark']:'0' }}" value="{{ !empty($practise['marks_gained'])?$practise['marks_gained']:'0' }}" style="width: 42px;{{ ( in_array($markingmethod, $selfMarkingArray))?'width: 42px;background-color: #e4dada;text-align: center;padding-right: 13px;':'' }}" name="answers[{{$i}}][marks_gained]">
											<span class="task-marks ml-2">  / {{ !empty($practise['mark'])?$practise['mark']:"0" }}</span>
											<input type="hidden" name="answers[{{$i}}][comment_image]" value="" class="marking_comment_image">
											<input type="hidden" name="answers[{{$i}}][is_file]" value="false" class="is_marking_file">
										</div>
										@endif
									</div>
								</div>
							</div>
						</footer>
					</div>
			<?php } ?>
		</div>
	</div>
</div>