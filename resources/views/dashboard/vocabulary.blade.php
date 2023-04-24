@extends('layouts.app')
@section('content')
<style type="text/css">
	.topic_name_edit {
		position: relative;
	}
	.topic_name_edit span img {
		position: absolute;
		right: 20px;
		width: 20px;
	}
	#word-error, #wordtype-error, #translationmeaning-error {
		display: block;
		/* position: absolute; */
		top: 34px;
		left: 25px;
		width:auto;
	}
	#copytheword-error {
		display: block;
		/* position: absolute; */
		top: 34px;
		left: 45px;
		width:auto;
	}
	.fa-solid.fa-keyboard{
		font-size:1.4rem;
		color: #3e5971;
	}
	.new-btn{
		position: absolute;
		top: 20px;
		right: 15px;
	}
</style>
@include('messages')
<div class="filter d-block d-md-none">
	<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
		<span class="mobonly"><img src="{{asset('public/images/filter-options-mobile.png')}}" alt="" class="img-fluid" width="24px"></span>
	</a>
</div>
<aside class="filter-sidebar">
	<div class="heading d-flex flex-wrap justify-content-between">
		<h5><i class="fa fa-filter"></i> Filter</h5>
		<a href="javascript:void(0);" class="close-filter">
			<img src="{{asset('public/images/icon-close-filter-white.svg')}}" alt="" class="img-fluid" width="15px" style="margin-top: -2px;">
		</a>
	</div>
	<div class="filter-body">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-block d-sm-none partA">
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="topic_1" name="topics" value="a">
					<label class="custom-control-label" for="topic_1">Topics</label>
				</div>
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="topic_2" name="topics" value="b">
					<label class="custom-control-label" for="topic_2">A - Z</label>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-0 partB">
				<div class="filter-action-buttons">
					<a href="javascript:void(0)" class="btn btn-classic" data-toggle="modal" id="addmodel">
						<span><i class="fa fa-plus" aria-hidden="true"></i></span> Add word
					</a>
				</div>
				<div class="filter-action-buttons">
					<?php  
					$allvocablist = $vocabularies = $allvocabe = array();                                    
					if(!empty($vocablist)){
						foreach($vocablist as $vocab){

							foreach($vocab['vocabs'] as $tm){
								array_push($allvocabe,$tm);
							}

							$allvocablist[$vocab['id']] = $vocab['vocabs'];
							if(isset($vocab['vocabs']) && !empty($vocab['vocabs'])){
								foreach($vocab['vocabs'] as $vocabsss){
									$vocabularies[] = $vocabsss;
								}   
							}  
						}
					} 
					?>
					<?php  if($vocabularies) { ?>
						<a href="vocabulary/downloadvocabulary_pdf" class="btn btn-classic">
							<span><i class="fa fa-download" aria-hidden="true"></i> Download</span>
						</a> 
					<?php } else { ?>
						<a href="javascript:void()" class="btn btn-classic" id="nodownload">
							<span><i class="fa fa-download" aria-hidden="true"></i> Download</span>
						</a> 
					<?php } ?> 
				</div>
			</div>
			@if(empty(isset($instration['getdocument']) OR isset($instration['getvideo'])))
			@else
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
				<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
				<div class="info-details">
					@foreach($instration['getdocument'] as $ins_doc)
					<div class="link1">
						<span><a href="#" id="openmodal" data-id="{{$ins_doc['document_url']}}"><i class="fa fa-file-alt"></i> Click to read</a> <span>{{$ins_doc['document_name']}}</span></span>
					</div>
					@endforeach
					@foreach($instration['getvideo'] as $ins_video)
					<div class="link1">
						<span><a href="#" id="openmodal_forvideo" data-id="{{$ins_video['video_url']}}" data-id2="{{$ins_video['video_id']}}"><i class="fa fa-file-alt"></i> Click to watch</a> <span>{{$ins_video['video_name']}}</span></span>
					</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
	</div>
</aside>
<!-- instruction popup -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_video">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<div id="datas"></div>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" data-dismiss="modal" id="close_video">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- end instruction video -->
<main class="dashboard">
	<div class="container-fluid">
		<div class="row">
			@include('common.sidebar')
			<!-- /. Sidebar-->
			<section class="main ieuk-vocabulary col-sm-12">
				<div class="col-12 d-flex justify-content-md-start justify-content-between pt-3 pb-3">
					@if(isset($_REQUEST['type']) && $_REQUEST['type']=="task")
					<a href="{{Session::get('lastTask1')}}" class="btn btn-primary btn-icon position-absolute d-none d-md-block">
						<img src="{{ asset('public/images/icon-button-topic-white.png') }}" alt="resume icon" class="img-fluid" width="20px">
						{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Back to Task' }}
					</a>
					<a href="{{Session::get('lastTask1')}}" class="backtotaskbtn d-block d-md-none">
						<img src="{{ asset('public/images/icon-button-topic-grey.png') }}" alt="resume icon" class="img-fluid default-img" width="20px">
						<img src="{{ asset('public/images/icon-button-topic-white.png') }}" alt="resume icon" class="img-fluid hover-img d-none" width="20px">
						{{Session::get('lastTaskName') ? Session::get('lastTaskName') : 'Back to Task' }}
					</a>
					@else
					<!-- <a href="{{url('vocabulary')}}" class="back-button position-absolute"><i class="fa-solid fa-caret-left"></i> back</a> -->
					@endif
					<h1 class="pageheading m-auto"><span><i class="fa fa-book" aria-hidden="true"></i></span> Vocabulary</h1>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row justify-content-center">
						<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block">
							<ul class="nav nav-pills nav-pills_switch" id="pills-tab" role="tablist">
								<li class="nav-item mr-3">
									<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
									role="tab" aria-controls="pills-home" aria-selected="true">Topics</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
									role="tab" aria-controls="pills-profile" aria-selected="false">A-Z</a>
								</li>
							</ul>
						</div>
						<div class="col-8 col-sm-5 col-md-6 col-lg-4 col-xl-4">
							<div class="row">
								<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
									<div class="search-form">
										<div class="form-group mb-0">
											<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="myInput" aria-label="Search">
											<span class="icon-search">
												<img src="https://teacher.englishapp.uk/public/teacher/images/icon-search-pink.svg" alt="Search" class="img-fluid">
											</span>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3 col-xl-2">
									<div class="filter">
										<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
											<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /. Management Slider-->
				<!-- <div class="ilp-heading align-items-center justify-content-between row pb-0"></div> -->
				<?php 
               // dd(session()->get('model_topic_id'));
				?>
				<hr class="hr">
				<div class="main__content main-vocab pt-1">
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
							<div class="row">
								<div class="col-12 col-sm-6 col-lg-3 col-xl-3 vocal-nav">
									<p><a class="btn btn-primary btn-topic"><i class="fa fa-plus" aria-hidden="true"></i> Add Topic</a></p>

									<div class="write-here" style="display:none;">
										<div class="example-text">e.g. Family, Work etc..</div>
										<form id="my_form" action="{{ URL('vocab_topic_post') }}" method="post">
											{{ csrf_field() }}
											<div class="form-group">
												<input type="text" name="topicname" id="topicname" class="form-control p-0" placeholder="Write Here">  
												<input type="hidden" id="topicname1" class="form-control" value="<?php echo isset($vocabtopic['name'])?$vocabtopic['name']:'';?>">
											</div>
											<ul class="list-inline mb-0">
												<li class="list-inline-item">
													<!-- <input type="submit" value="ok"> -->
													<button type="submit" style="border: 0; background: none; outline: none;">
														<img src="{{ asset('public/images/icon-green-check.svg') }}" alt="right sign" class="img-fluid" width="20px" style="vertical-align: text-bottom;"> Add
														<!-- <a class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add</a> -->
													</button>
												</li>
											</ul>
										</form>
									</div>
									<div class="edit-here" style="display:none">
									</div>

									<fieldset>
										<legend>Topic List</legend>
										<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
											<?php if(!empty($vocabtopiclist)){ ?>                                                            
												<?php foreach($vocabtopiclist as $i=>$vocabtopic){ 
													//dump($vocabtopic["id"]);
													$class= "";
													if(session()->get('model_topic_id')){
														if($vocabtopic["id"] == session()->get('model_topic_id')){
															$class = "active show";
														}
													}else{
														if($i==0){
															$class= "active show";
														}
													}
													?>
													<a class="nav-link topic__name topic_name_edit {{$class}}" data-vocabname="<?php echo $vocabtopic['name'];?>" data-vacabid = "<?php echo $vocabtopic['id'];?>" id="v-pills-<?php echo $vocabtopic['id'];?>-tab" data-toggle="pill" href="#v-pills-<?php echo $vocabtopic['id'];?>" role="tab" aria-controls="v-pills-<?php echo $vocabtopic['id'];?>"><?php echo $vocabtopic['name'];?>
													<?php if(env("PRODUCTION_URL") == 'https://admin.englishapp.uk/api' && $vocabtopic['id'] == "5e7b4d0329cd5f3a805cdff2"){
														continue;
													}elseif(env("PRODUCTION_URL") == 'https://imperialenglish.co.uk/api' && $vocabtopic['id'] == "5e7a0960ee2f8e3fdc7cfd85"){
														continue;
													}else{?>
														@if($vocabtopic['id'] == "5e7a0960ee2f8e3fdc7cfd85")
														@else
														<span>
															<img src="{{ asset('public/images/icon-table-edit.png') }}" alt=""  class="img-fluid edit-topic" data-vocabname="<?php echo $vocabtopic['name'];?>" data-id = "{{$i}}" id="myBtn_{{$i}}">
														</span>
														@endif
													<?php } ?>                                    
												</a>
											<?php } }?>
										</div>
									</fieldset>


								</div>
								<?php 
								$allvocablist = $vocabularies = array();

								if(!empty($vocablist)){
									foreach($vocablist as $vocab){
										$allvocablist[$vocab['id']] = $vocab['vocabs'];
										if(isset($vocab['vocabs']) && !empty($vocab['vocabs'])){
											foreach($vocab['vocabs'] as $vocabsss){
												$vocabularies[] = $vocabsss;
											}   
										}  
									}
									?> 
								<?php }
								?>
								<!-- Vocab-topic-left-->
								<div class="col-12 col-lg-9 col-xl-9 vocal-table" >
									<div class="tab-content" id="v-pills-tabContent">
										<?php foreach($vocabtopiclist as $i=>$vocabtopic){
											$class= "";
											if(session()->get('model_topic_id')){
												if($vocabtopic["id"] == session()->get('model_topic_id')){
													$class = "active show";
												}
											}else{
												if($i==0){
													$class= "active show";
												}
											}
											?>
											<div class="tab-pane fade {{$class}}" id="v-pills-<?php echo $vocabtopic['id'];?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $vocabtopic['id'];?>-tab">
												<div class="vocab-table-container">
													<?php if(isset($allvocablist[$vocabtopic['id']]) && !empty($allvocablist[$vocabtopic['id']])){?>
														<table class="table table-borderless ieuktable-sline">
															<thead>
																<tr>
																	<th scope="col">Word</th>
																	<th scope="col">Word Type</th>
																	<th scope="col">Meaning</th>
																	<th scope="col">Phonetic Transcription</th>
																	<th scope="col">Actions</th>
																</tr>
															</thead>
															<tbody>
																<?php 
																$abcdWise = array();
																foreach($allvocablist[$vocabtopic['id']] as $vocabulary){
																	$word = $vocabulary['word'];

																	$abcdWise[strtoupper($word)] = $vocabulary;
																}
																$abcdKeys = array_keys($abcdWise);
																ksort($abcdWise);
																foreach($abcdWise as $voc){?>
																	<tr>
																		<td title="Word" scope="row"><?php echo $voc['word'];?></td>
																		<td title="Word Type"><span title="word Type"></span><?php echo $voc['wordtype'];?></td>
																		<td title="Meaning" style="word-break: break-all;"><span title="Meaning"></span><?php echo $voc['translationmeaning'];?></td>
																		<td title="Phonetic Transcription"><span title="Phonetic Transcription"></span><?php echo $voc['phonetictranscription'];?></td>
																		<td>
																			<a href="#" onclick="viewvocab('<?php echo  $voc['id']; ?>','view')"><img src="{{ asset('public/images/icon-small-eye.png') }}" alt="" class=" " width="26px"> </a>
																			&nbsp;&nbsp;&nbsp;
																			<a href="#"  onclick="viewvocab('<?php echo  $voc['id']; ?>','edit')"><img src="{{ asset('public/images/icon-table-edit.png') }}" alt="" class=" " width="21px"> </a>
																			&nbsp;&nbsp;&nbsp;
																			<a href="javascript:void(0);" title="Delete" 
																			class="action-button open-delete-voc-log-modal delete_voc_log_{{$voc['id']}}"data-voc_id="{{$voc['id']}}">
																			<img src="{{ asset('public/images/icon-trash.png') }}" alt="Edit" class="img-fluid" width="21px">
																		</td>
																	</tr>
																<?php }?>
															</tbody>
														</table>
													<?php }else{?>
														<div class=" w-100 norecorddata">
															<div class="main__content" id="image_class" style="display: block;">
																<div class="row text-center">
																	<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
																		<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
																		<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
																	</div>
																</div>
															</div>
														</div>
													<?php }?>
												</div>
											</div>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
						<?php $abcdWise = array();
						foreach($vocabularies as $vocabulary){
							$word = $vocabulary['word'];
							$wordFirstCharacter = $word[0];
							$vocabulary['character'] = strtoupper($wordFirstCharacter);
							$abcdWise[strtoupper($wordFirstCharacter)][] = $vocabulary;
						}
						?>
						<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
							<div class="vocal-atoz d-flex flex-wrap" >
								<div class="vocab-table-container">
									<?php if(!empty($abcdWise)){?>
										<table class="table table-borderless ieuktable-sline">
											<thead>
												<tr>
													<th scope="col" class="pl-4">#</th>
													<th scope="col">Word</th>
													<th scope="col">Word Type</th>
													<th scope="col">Meaning</th>
													<th scope="col">Phonetic Transcription</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $abcdKeys = array_keys($abcdWise);
												sort($abcdKeys);

												?>
												<?php foreach($abcdKeys as $key){
													foreach($abcdWise[$key] as $i=>$voc){
														?>
														<tr>
															<td scope="row" class="vocab-sorter">
																<?php if($i == 0){?>
																	<span id="scrollto_<?php echo $voc['character'];?>" class="d-flex justify-content-center align-items-center badge-danger big-badge rounded-circle"><?php echo $voc['character'];?></span>
																<?php }?>
															</td>
															<td><span title="Word"></span><?php echo $voc['word'];?></td>
															<td><span title="Word Type"></span><?php echo $voc['wordtype'];?></td>
															<td style="word-break: break-all;"><span title="Meaning"></span><?php echo $voc['translationmeaning'];?></td>
															<td class="td-full"><span title="Phonetic Transcription"></span><?php echo $voc['phonetictranscription'];?></td>
															<td>
																<a href="#"  onclick="viewvocab('<?php echo  $voc['id']; ?>','view')"><img src="{{ asset('public/images/icon-small-eye.png') }}" alt="" class="" width="26px"> </a>
																<a href="#"  onclick="viewvocab('<?php echo  $voc['id']; ?>','edit')"><img src="{{ asset('public/images/icon-table-edit.png') }}" alt="" class="" width="21px"> </a>
																<a href="{{ URL('vocabulary')}}?delete_vocabulary=<?php echo $voc['id'];?>" onclick="return confirm('Are you sure you want to delete?')" >
																	<img src="{{ asset('public/images/icon-trash.png') }}" alt="" class=" " width="21px">
																</a>
															</td>
														</tr>
													<?php }
												}?>
											</tbody>
										</table>
										<center>
											<p id="book" style="display:none;">No Record Found</p>
										</center>
									<?php }else{?>
										<p style="text-align:center;" class="col-12">No words added for this topic.</p>
									<?php }?>
								</div>
								<?php if(!empty($abcdWise)){?>
									<div class="table-sorter">
										<?php $abcdKeys = array_keys($abcdWise);
										sort($abcdKeys);
										?>
										<ul class="list-unstyled text-uppercase">
											<?php foreach($abcdKeys as $i=>$abcdKey){?>
												<li class="list-item">
													<a href="javascript:void(0);" <?php if($i == 0){?>class="active"<?php }?> data-scrollto="scrollto_<?php echo $abcdKey;?>"><?php echo $abcdKey;?></a>
												</li>
											<?php }?>
										</ul>
									</div>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<form id="my_form2" action="{{ URL('vocab_post') }}" method="post">
			@csrf
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					<i class="fa fa-book" aria-hidden="true"></i>
					Vocabulary
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group mr-4 maxw-300">
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
					<div class="col-12 col-sm-6  form-group form-group-inline align-items-end">
						<h6>Word</h6>
						<input type="hidden" name="id" id="wordid" class="form-control">
						<textarea type="text" name="word" id="word" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
					</div>
					<div class="col-12 col-sm-6  form-group form-group__copy form-group-inline align-items-end">
						<h6>Copy the word</h6>
						<textarea type="text" name="copytheword" id="copytheword" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
					</div>
					<div class="col-12 col-sm-6  form-group form-group-inline align-items-end">
						<h6>Word Type</h6>
						<textarea type="text" name="wordtype" id="wordtype" class="form-control" placeholder="write here..." onkeyup="textAreaAdjust(this)"></textarea>
					</div>
					<div class="col-12 col-sm-6  form-group form-group__phonetic form-group-inline align-items-end">
						<h6>Phonetic Transcription</h6>
						<input type="text" name="phonetictranscription" id="phonetictranscription" class="form-control" readonly="true">
						<button id="phonetic_keyboard" class="btn btn-sm pl-0 pt-1"><i class="fa-solid fa-keyboard"></i></button>
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
						<h6>Meaning</h6>
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
			<div class="modal-footer justify-content-center" id="hide">
				<button type="submit" class="btn  btn-primary">
					<i class="fa-regular fa-floppy-disk" id="textname"></i>
				</button>
				<button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
			</div>
		</form>
	</div>
</div>
</div>
<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title">Delete Record</h5>
			</div>
			<div class="modal-body m-5 text-center">
				<p>Are you sure you want to delete ?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<form id="deleteClassLogForm">
					<input type="hidden" name="id" class="voc_id" >
					<input type="hidden" name="delete_vocabulary" class="voc_id">
					<button type="button" class="btn btn-primary delete-voc-log-record mr-1">Yes</button>
					<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="download_popup" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				<i class="fa fa-book" aria-hidden="true"></i>
				Vocabulary1
			</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">
			<p style="text-align: center;">You don't have any vocabulary to download.</p>
		</div>
	</div>
</div>
</div>



<!-- script -->
<script type="text/javascript">
	var topicList = '<?php echo json_encode($vocabtopiclist) ?>';
	$(document).ready(function(){

		$('.edit-topic').click(function(){
			var data = JSON.parse(topicList);
			var key = $(this).attr("data-id");

			var topicLst = data[key];
			$('.edit-here').html("");
			$('.edit-here').append('<div class="example-text" id="editBox">e.g. Family, Work etc..</div>'
				+'<form id="my_form" class="my_form" action="" method="post">@csrf<div class="form-group">'
				+'<input type="text" name="topicname" id="topicname{{$i}}" class="form-control" value="'+topicLst.name+'">'
				+'<input type="hidden" name="topicid" id="topicid" value="'+topicLst.id+'">'
				+'<input type="hidden" name="edit" id="edit" value="edit">'
				+'</div><ul class="list-inline mb-0"><li class="list-inline-item">'
				+'<button type="reset" onclick="remove()" style="border: 0; background: none; outline: none;">'
				+'<img src="{{ asset('public/images/icon-circle-trash.svg') }}" alt="" class="img-fluid" width="20px" style="vertical-align: text-bottom;"> Remove</button></li>'
				+'<li class="list-inline-item">'
				+'<button type="button" id="edit_btn" onclick="topic()" style="border: 0; background: none; outline: none;"><img src="{{ asset('public/images/icon-green-check.svg') }}" alt="" class="img-fluid" width="20px" style="vertical-align: text-bottom;"> Update</button></li></ul></form>');
		});

		$(".table-sorter ul li a").on('click',function(){
			$(".table-sorter ul li a").removeClass("active");
			$(this).addClass("active");
			var scrollToDiv = $(this).attr("data-scrollto");
			$('html, body').animate({
				scrollTop: $("#"+scrollToDiv).offset().top
			}, 1000);
		})

		$(".btn-topic").on("click",function(){
			$(".write-here").slideToggle();
		});

		$(".edit-topic").on("click",function(){
			$(".edit-here").slideToggle();
		});

	})
	function topic(){
		$.ajax({
			url: "{{ URL('vocab_topic_post') }}",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data: $(".my_form").serialize(), 
			success: function (data) {
				console.log(data);
				$("#edit_btn").removeAttr('disabled');
				window.location.reload();         
				if(data.success){
					setTimeout(function(){ 
						window.location.reload();
					},1000);                          
					$('.alert-danger').hide();
					$('.alert-success').show().html(data.message).fadeOut(1000);
				}else{
					$('.alert-success').hide();
					$('.alert-danger').show().html(data.message).fadeOut(1000);
				}
			}
		});
	}

	function remove(){ 
		var check = confirm("Are you sure you want to delete?");
		if (check == true) {
			$.ajax({
				url: "{{ URL('vocab_topic_post') }}",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				type: 'POST',
				data: $(".my_form").serialize() + '&is_delete=true',       
				success: function (data) {        
					$("#edit_btn").removeAttr('disabled');         
					setTimeout(function(){ window.location.reload(); },1000);  

					if(data.success){    

						$('.alert-danger').hide();
						$('.alert-success').show().html(data.message).fadeOut(1000);               
					}else{
						$('.alert-success').hide();
						$('.alert-danger').show().html(data.message).fadeOut(1000);
					}
				}
			});
		}  
	}
</script>
<script>
	$(".backtotaskbtn").hover(function () {
		$(".hover-img").toggleClass("d-none");
		$(".default-img").toggleClass("d-none");
	});
	$(".hidden-tr-opner").click(function () {
		$(this).toggleClass("open");
		$(".hidden-tr").slideToggle("slow");
	});
	$(".close-filter").click(function () {
		$(".filter-sidebar").toggleClass("openclose");
	});
</script>
<script type="text/javascript">
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

	$(".summary_box").on('click',function(){
		$('#topic_id').val($(this).find('input[name="topic_id"]').val());
		$('#listening_summary').val($(this).find('input[name="listening_summary"]').val());
		$('#reading_summary').val($(this).find('input[name="reading_summary"]').val());
		$('#writing_summary').val($(this).find('input[name="writing_summary"]').val());
		$('#speaking_summary').val($(this).find('input[name="speaking_summary"]').val());
		$('#grammar_summary').val($(this).find('input[name="grammar_summary"]').val());
		$('#vocabulary_summary').val($(this).find('input[name="vocabulary_summary"]').val());
		$('#topic_id').prop("readonly",true);
		$("#success_message").hide();
		$("#error_message").hide();
	})

	$("#my_form").validate({
		rules: {
			topicname: {
				required: !0,
			}	
		},
		errorElement: "div",
		errorClass: "invalid-feedback",
		submitHandler: function(form) {
			$("#my_form").find("input[type='submit']").prop("disabled",true);
			$("#my_form").find("button[type='submit']").prop("disabled",true);
			form.submit();
			return false;								
		}
	})

	$("#my_form2").validate({
		rules: {
			modal_topic_id: {
				required: !0,
			},
			word: {
				required: !0,
			},
			wordtype: {
				required: !0,
			},
			copytheword: {
				required: !0,            
				equalToIgnoreCase: "#word"
			},
			translationmeaning: {
				required: !0,
			}	
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
			$("#my_form").find("input[type='submit']").prop("disabled",true);
			$("#my_form").find("button[type='submit']").prop("disabled",true);
			form.submit();
			return false;								
		}
	})
</script>
<script>
	$(function() {
		$('input').on('keydown', function(e) {
     //console.log(this.value);
     if (e.which === 32 &&  e.target.selectionStart === 0) {
     	return false;
     }  
   });
	});
</script>
<script type="text/javascript">
	function auto_grow(element) {
		element.style.height = "5px";
		element.style.height = (element.scrollHeight)+"px";
	}
</script>
<script>
	$(document).ready(function(){
     // Get value on button click and show alert
     $(".edit-topic").click(function(){ 
     	var str = $(this).attr('data-vocabname');
     	$('.edit-topic').text(str);
     }); 

     var tempdata = "";
     $(document).ready(function(){ 
     	$("#phonetic_keyboard , #phonetictranscription").click(function(){	 
     		$( "#phonetic_keyboard1" ).slideToggle( "slow");	
     	});	
     	$('.phonetic_keyboard_keys a').click(function(){
     		tempdata += $(this).children().attr("value");		
     		$('#phonetictranscription').val(tempdata);
     	});
     });
     $('#phonetictranscription').keyup(function(){
     	tempdata = $(this).val();        
     	document.getElementById("#phonetictranscription").focus();
     });

     $.validator.addMethod("equalToIgnoreCase", function (value, element, param) {
     	return this.optional(element) || 
     	(value.toLowerCase() == $(param).val().toLowerCase());
     });
   });
 </script>
 <!-- update -->
 <script>
 	$(document).ready(function(){
      // Get value on button click and show alert
      $(".edit-topic").click(function(){ 
      	var str = $(this).attr('data-vocabname');
      	$('.edit-topic').text(str);
      }); 


     //Keyboard showhide.
     var tempdata = "";
     $(document).ready(function(){ 
     	$("#phonetic_keyboard_update").click(function(){
     		$( "#phonetic_keyboard1_update" ).slideToggle( "slow");	
     	});	
     	$('.rr a').click(function(){
     		tempdata += $(this).children().attr("value");		
     		$('#phonetictranscription1').val(tempdata);
     	});
     });
     $('#phonetictranscription1').keyup(function(){
     	tempdata = $(this).val();        
     	document.getElementById("#phonetictranscription1").focus();
     });

     $.validator.addMethod("equalToIgnoreCase", function (value, element, param) {
     	return this.optional(element) || 
     	(value.toLowerCase() == $(param).val().toLowerCase());
     });

     $('#nodownload').click(function(){
     	$('#download_popup').modal("show")
     });


   });
 </script>
 <!-- view model -->
 <script type="text/javascript">
 	$(document).ready(function(){
 		$("#topic_1").prop('checked',true);
 		$('#exampleModal').on('hidden.bs.modal', function () {
 			$('#exampleModal #my_form2')[0].reset();
 			var validator = $( "#my_form2" ).validate();
 			$("div").removeClass('invalid-feedback');
 			validator.resetForm();
 		});
 	});
 </script>
 <script type="text/javascript">
 	$(document).keypress(
 		function(event){
 			if(event.which == '13') {
 				event.preventDefault();
 			}
 		});
 	</script>
 	<script>
 		$('.alert-success').fadeOut(3000);
 		$('.alert-danger').fadeOut(3000);
 	</script>
 	<script>
 		$('textarea').each(function(){
 			$(this).css("height",'auto');
 			$(this).css('overflow','hidden');
 		});
 	</script>
<!-- <script>
   $(document).on('change',"#topic_2",function(){
   	$("#pills-profile").addClass('active show');
   	$("#pills-home").removeClass('active show');
   });
   $(document).on('change',"#topic_1",function(){
   	$("#pills-home").addClass('active show');
   	$("#pills-profile").removeClass('active show');
   });
 </script> -->
 <!-- needful code and working -->
 <script>
 	$(".open-filter").click(function(){
 		$("aside.filter-sidebar").addClass("openclose");
 	});

 	$(".close-filter").click(function(){
 		$("aside.filter-sidebar.openclose").removeClass("openclose");
 	});
 </script>
 <script>
 	$(document).on('click','.open-delete-voc-log-modal', function(){
 		var voc_id = $(this).attr('data-voc_id');
 		$('#deleteClassLogForm').find('.voc_id').val(voc_id);
 		$('#deleteModal').modal('toggle');
 	});

 	$(document).on('click','.delete-voc-log-record', function(){
 		var $this = $(this);
 		var voc_id = $('#deleteClassLogForm').find('.voc_id').val()
 		$.ajax({
 			url: "{{url('vocabulary')}}",
 			headers: {
 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 			},
 			type: 'get',
 			data: $('#deleteClassLogForm').serialize(),
 			success: function(data) {
 				if(!data.success){
 					$("#error_message .error-text").text(data.message);
 					$("#error_message").show();
 					$("#success_message").hide();
 					$("#my_form").find("input[type='submit']").prop("disabled",false);
 					$("#my_form").find("input[type='submit']").attr("value","Save");
 					$("#my_form").find("button[type='submit']").prop("disabled",false);
 					$("#my_form").find("button[type='submit']").text("Sign In");
 				}else{
 					$("#success_message .success-text").text(data.message);
 					$("#error_message").show();
 					$("#error_message").hide();
 					setTimeout(function(){
 						window.location.reload();
 					},1000);
 				}
 			}
 		});

 	});
 </script>
 <script>
 	$(document).ready(function(){
 		$("#myInput").on("keyup", function() {
 			var value = $(this).val().toLowerCase();
 			$("tbody tr:not('.no-records')").filter(function() {
 				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
 			});
 			var trSel =  $("tbody tr:not('.no-records'):visible")
      // Check for number of rows & append no records found row
      if(trSel.length == 0){
      	$("p").fadeIn();
      }
      else{
      	$("p").fadeOut();
      }

    });
 	});
 </script>

 <script>	
 	$("#addmodel").on("click", function() {
 		$('#exampleModal').modal("show")
 		$('#hide').show()
 		$('#textname').text('Save');
 		$("#my_form2 :input").prop("disabled", false);
 		$('#wordid').val('');
 	});
 </script>
 <script>
 	var vocaabDataOr = "<?php echo addslashes(json_encode($allvocabe))?>";
 	function viewvocab(id,type){
 		if(type == "view"|| "edit")
 		{
 			var objconvertOrValur = JSON.parse(vocaabDataOr);
 			for (let key in objconvertOrValur)
 			{
 				if(id == objconvertOrValur[key]['id'])
 				{
 					$('#exampleModal #wordid').val(objconvertOrValur[key]['id']);
 					$('#exampleModal #modal_topic_id').val(objconvertOrValur[key]['topicid']);
 					$('#exampleModal #word').val(objconvertOrValur[key]['word']);
 					$('#exampleModal #copytheword').val(objconvertOrValur[key]['copytheword']);
 					$('#exampleModal #wordtype').val(objconvertOrValur[key]['wordtype']);
 					$('#exampleModal #phonetictranscription').val(objconvertOrValur[key]['phonetictranscription']);
 					$('#exampleModal #translationmeaning').val(objconvertOrValur[key]['translationmeaning']);
 					$('#exampleModal #sentence1').val(objconvertOrValur[key]['sentence1']);
 					$('#exampleModal #sentence2').val(objconvertOrValur[key]['sentence2']);
 					$('#exampleModal #sentence3').val(objconvertOrValur[key]['sentence3']);
 					$('#exampleModal #sentence4').val(objconvertOrValur[key]['sentence4']);
 					if(type == "view"){
 						$('#hide').hide();
 						$("#my_form2 :input").prop("disabled", true);
 						$("#my_form2 :button").prop("disabled", false);
 					}
 					if(type == "edit"){
 						$('#hide').show();
 						$("#my_form2 :input").prop("disabled", false);
 						$('#textname').text('Update');
 					}
 				}
 			}
 			$('#exampleModal').modal("show");	
 		}
 	}
 </script>
 @endsection