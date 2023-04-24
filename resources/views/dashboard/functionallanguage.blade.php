@extends('layouts.app')
@section('content')

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
			<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partA">
				<select class="form-control custom-select2-dropdown-nosearch" id="TopicChnagea">
					<option value="all">All</option>
					@foreach($topic as $key=>$value)
					<option value="{{$key}}">{{$value}}</option>
					@endforeach
				</select>
			</div>
			<!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-0 partB">
				<div class="filter-action-buttons">
					<div class="ilp-student-options">
						<a href="javascript:void(0)" class="btn btn-classic" id="openmodal"><i class="fas fa-file-alt"></i> Instructions</a>
					</div>
				</div>
			</div> -->
			@if(isset($instration['getdocument']))
				@if(empty($instration['getdocument'] OR $instration['getvideo']))

				@else
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
						<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
						<div class="info-details page-info-details">
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
			<section class="main col-sm-12">
				<div class="col-12 d-flex justify-content-center p-3">
					<h1 class="pageheading"><i class="fa fa-globe"></i> Functional Language</h1>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block">
							<select class="form-control custom-select2-dropdown-nosearch" id="TopicChnage" style="max-width: 400px;">
								<option value="all">All</option>
								@foreach($topic as $key=>$value)
								<option value="{{$key}}">{{$value}}</option>
								@endforeach
							</select>
						</div>
						<!-- <div class="col-6 d-sm-none">
							<h6 id="getFirstClassName"></h6>
						</div> -->
						<div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
							<div class="row">
								<div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
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
				<div class="main__content main__content_full pt-sm-3 px-md-3 px-0">
					<div class="tab-content" id="pills-tabContent">
						<div class="row">
							<div class="col-md-12" style="word-break:break-word">
								@foreach($allData as $key=>$value)
								<div class="panel panel-primary allfunction" id="{{$value['_id']}}">
									<div class="panel-heading">{{$value['topic_name']}}</div>
									<div class="panel-body">{!!$value['word']!!}</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-file-alt"></i> Instruction</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>You do not have a lot of time in class so it is important to use your English as much as you can. This app can help you do this.  When you are in class you should try to use English all the time. When you listen to and talk to the teacher and the other students in your class.  If you do this, you will not only practise grammar and vocabulary but the ‘functions’ of English. For example, how to make a suggestion or ask for information politely.</p>
				<p>So please use this app. Sometimes your teachers will ask you to look at it in class to use the language when you have a speaking activity or to practise the pronunciation of phrases.</p>
				<p>This app can also help you outside class.  It has phrases and grammar structures for many different situations so it can be helpful if you need to speak to international visitors to your country.  Please make notes and add other phrases you learn. This is for you, to help you and for you to help yourself</p>
				<p>If you watch movies in English, you will hear some of the language in this app. It is ‘real’ English. It is to help you communicate with other people, not only to pass English language tests.</p>
			</div>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#openmodal').click(function(){
			$('#myModal').modal("show")
		});	

		$('#TopicChnage').change(function(){
			var newval = $(this).val();
			if($(this).val()!=""){
				if($(this).val() == "all"){
					$('.allfunction').css("display","block");
					$("#TopicChnagea option[value='"+'all'+"']" ).prop('selected', true);
                    $("#select2-TopicChnagea-container").text('All');
				}else{
					$('.allfunction').css("display","none");	
					$('#'+$(this).val()).css("display","block");
					var get_rec     = $( "#TopicChnagea option[value='"+newval+"']" ).text();
					$("#TopicChnagea option[value='"+newval+"']" ).prop('selected', true);
                    $("#select2-TopicChnagea-container").text(get_rec);
				}
			}

		});
		$('#TopicChnagea').change(function(){
			var newval = $(this).val();
			if($(this).val()!=""){
				if($(this).val() == "all"){
					$('.allfunction').css("display","block");
					$("#TopicChnage option[value='"+'all'+"']" ).prop('selected', true);
                    $("#select2-TopicChnage-container").text('All');
				}else{
					$('.allfunction').css("display","none");	
					$('#'+$(this).val()).css("display","block");
					var get_rec     = $( "#TopicChnage option[value='"+newval+"']" ).text();
					$("#TopicChnage option[value='"+newval+"']" ).prop('selected', true);
                    $("#select2-TopicChnage-container").text(get_rec);
				}
			}

		});
	});
</script>

<script type="text/javascript">
	// $(document).ready(function() {
	// 	$("#TopicChnage").select2();
	// 	$('#TopicChnage').on("select2:open", function () {
	// 		$('.select2-results__options').addClass('d-scrollbar');
	// 		$('.select2-results__options').scrollbar();
	// 	});
	// });
</script> 
@endsection