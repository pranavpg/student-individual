@extends('layouts.teacher-app')
@section('style')
<style type="text/css">
	.custom-header .show-record{
		transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
		font-size:.875rem;
		line-height:1.5;
		height:calc(1.8125rem + 2px);
		padding:.25rem 1.75rem .25rem .75rem;
		border-radius:.25rem;
		background:#fff url('data:image/svg+xml;charset=utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 4 5\'><path fill=\'%2332325d\' d=\'M2 0L0 2h4zm0 5L0 3h4z\'/></svg>') no-repeat right .75rem center;
		background-size:8px 10px;
		box-shadow:inset 0 1px 2px rgba(0,0,0,.075);
		-webkit-appearance:none;
		width:auto;
		display:inline-block;
	}
	.custom-header .show-record:focus{
		color:#8898aa;
		outline:0;
		box-shadow:none;border-color:rgb(169,89,255,0.2)
	}
	.cyColor{background-color: #f7e4e4;}
	/* .pending-marking-search {display: none;} */
	.mob-filter{
		position:absolute;
		top: 5px;
		right: 8px;
		z-index: 3;
	}
	.mob-filter .open-filter{
		background-color:#30475e;
	}
	.mob-filter .open-filter img:hover{
		filter: invert(25%) sepia(17%) saturate(1172%) hue-rotate(169deg) brightness(91%) contrast(89%);
	}
	
</style>
@endsection
@section('content')
@include('common.sidebar')
<div class="filter d-block d-md-none">
	<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn">
		<span class="mobonly"><img src="{{asset('public/images/filter-options-mobile.png')}}" alt="" class="img-fluid" width="24px"></span>
	</a>
</div>  
<main class="main">
	<div class="container-fluid">

		<div class="alert alert-success mt-3" role="alert" style="display:none"></div>
		<div class="alert alert-danger mt-3" role="alert" style="display:none"></div>

		<div class="row">
			<div class="main__content d-sm-flex flex-wrap align-items-center w-100 pb-3 pt-3">
				<div class="col-12 d-flex flex-column flex-sm-row justify-content-center justify-content-md-between align-items-center mb-3">
					<h1 class="pageheading mr-1 mb-0">
						<span style="">
							<img src="{{asset('public/images/icon-marking-logo.png')}}" alt="" class="img-fluid" width="27px" style="margin-bottom: 9px;">
                        </span>
                        Marking
					</h1>
					<!-- <div class="mr-md-auto d-none d-md-block">
						<a href="https://s3.amazonaws.com/imperialenglish.co.uk/static_file/Marking.pdf" target="_black" class="" style="min-width:auto;">
							<i class="fa fa-info-circle" aria-hidden="true" style="color: #d55b7d;"></i>
						</a>
					</div> -->
					<!-- <div class="search-form comman-search mr-0 mr-md-3 ml-auto">
						<div class="form-group">
							<input type="search search_box" class="form-control form-control-lg search_work_record newsearch" placeholder="Search" id="searchbox" aria-label="Search">
							<span class="icon-search">
								<img src="https://teacher.englishapp.uk/public/teacher/images/icon-search-pink.svg" alt="Search" class="img-fluid">
							</span>
						</div>
					</div> -->
					<div class="filter">
						<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn d-none d-md-inline-block">
							<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
						</a>
					</div>
				</div>
				<div class="col-xl-12 d-none d-sm-flex justify-content-between">
					<div class="col-6 col-6 col-sm-4  d-flex justify-content-start pl-0">
						<!-- <a href="javascript:void(0)" class="btn btn-light" style="background-color:#d55b7d;color:white;;" data-toggle="modal" data-target="#selectClass">
							{{$selected_class}}
						</a> -->

						@if(!empty($classList))
							<select class=" form-control custom-select2-dropdown-nosearch select-class">	
								@foreach($classList as $key => $value)
								<option value="{{url('/marking-new/').'/'.$value['id']}}" <?php if(Request::segment(2) == $value['id']) echo "selected"; ?>>{{$value['class_name']}}</option>
								@endforeach
							</select>
						@else
							<select class="custom-select2-dropdown-nosearch">
								<option value="">You have not been assigned to a class</option>
							</select>
						@endif

					</div>
					<div class="col-12 col-sm-8 col-md-8 d-flex justify-content-end pr-0">

						<!-- <h1 class="fu_1">Marking</h1> -->
						<ul class="list-inline marking-button float-left mb-0">
							<li class="list-inline-item"><a href="javascript:;" data-bind="click:$root.practiseFilter.bind($data,'is_marked_by'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_marked_by', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_marked_by' }" class="findOne btn btn-light" style="width:90px;">Pending</a></li>
							<li class="list-inline-item"><a href="javascript:;" data-bind="click:$root.practiseFilter.bind($data,'is_extra'),css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_extra', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_extra' }" class="findOne btn btn-light" style="width:91px;">Extra</a></li>
							<li class="list-inline-item"><a href="javascript:void(0)" data-bind="click:$root.practiseFilter.bind($data,'work_record'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'work_record', 'btn-light': $root.SearchModel().practise_opt_id() != 'work_record'}" class="findOne btn btn-light">Work Record</a></li>
						</ul>

					</div>
					
					
					
				</div>
			</div>


			<!-- <div class="main__content pt-0 pt-xl-4 pb-1">
				<div class="col-xl-12">
					<ul class="list-inline marking-button float-left">
						<li class="list-inline-item"><a href="javascript:;" data-bind="click:$root.practiseFilter.bind($data,'is_marked_by'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_marked_by', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_marked_by' }" class="findOne btn btn-light" style="width:90px;">Pending</a></li>
						<li class="list-inline-item"><a href="javascript:;" data-bind="click:$root.practiseFilter.bind($data,'is_extra'),css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_extra', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_extra' }" class="findOne btn btn-light" style="width:91px;">Extra</a></li>
						<li class="list-inline-item"><a href="javascript:void(0)" data-bind="click:$root.practiseFilter.bind($data,'work_record'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'work_record', 'btn-light': $root.SearchModel().practise_opt_id() != 'work_record'}" class="findOne btn btn-light">Work Record</a></li>
					</ul>
				</div>
			</div> -->

			@if(!empty($classId))
			<div class="main__content pt-0 mb-5">
				<div class="col-xl-12">
					<div class="row">

						<div class="col-12 col-md-6 text-right" data-bind="visible:$root.selectedPractiseIDs().length > 0">
							<button type="submit" class="btn btn-primary" data-bind="click:$root.addMarking">Add Marking</button>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table mt-2 ieuktable-sline">
							<thead class="thead-dark">
								<tr>
									<!-- <th>
										<div class="checkbox">
											<input type="checkbox" id="checkbox1" class="checkbox-input" data-bind="checked:$root.selectProductCheck" />
											<label for="checkbox1"></label>
										</div>
									</th> -->
									<th scope="col">#</th>
									<th scope="col">Student ID</th>
									<th scope="col">Student Name</th>
									<th scope="col">Course</th>
									<th scope="col">Level</th>
									<th scope="col">Task</th>
									<th scope="col">Topic</th>
									<th scope="col">Marking Attempt</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody data-bind="visible:$root.Records().length > 0, foreach:$root.Records">
								<tr data-bind=" css: {'cyColor': ($root.SearchModel().practise_opt_id() == 'work_record' && $data.status() == 1)}">
									<!-- <td>
										<div class="checkbox">
											<input type="checkbox" class="checkbox-input" data-bind="checked:$data.checked, attr:{'id':'checkbox'+ $data._id()},click: $root.productCheckboxCheck.bind($data)" />
											<label data-bind="attr:{'for':'checkbox'+ $data._id()}"></label>
										</div>
									</td> -->
									<td class="d-none d-sm-none d-md-table-cell"><span title="ieuk"></span><span data-bind="text:$data.Index"></span></td>
									<td class="complaint-table">
										<span class="d-md-none" data-bind="text:$data.student_name"></span>
										<span class="d-md-none">( </span>
										<span data-bind="text:$data.student_id"></span>
										<span class="d-md-none"> )</span>
										<span class="complaint__description d-none d-sm-none d-md-block">Submitted At: <span data-bind="text:$data.updated_at"></span></span>
									</td>
									<td class="d-none d-sm-none d-md-table-cell"><span class="d-none d-sm-none d-md-block" data-bind="text:$data.student_name"></span></td>
									<td><span title="Course / Level"><span data-bind="text:$data.course_name"></span><span class="d-md-none"> / </span><span class="d-md-none" data-bind="text:$data.level_name"></span></td>
									<td class="d-none d-sm-none d-md-table-cell"><span title="Level"><span data-bind="text:$data.level_name"></span></td>
									<td class="complaint-table">
										<span class="complaint__description d-md-none">Topic: <span data-bind="text:$data.topic_sorting"></span></span>
										<span class="d-md-none"> / </span>
										<span class="complaint__description">Task No: <span data-bind="text:$data.task_sorting"></span></span>
										<span class="complaint__heading d-none d-sm-none d-md-block" data-bind="text:$data.task_name"></span>
										<span class="complaint__description d-block d-md-none">Submitted At: <span data-bind="text:$data.updated_at"></span></span>
									</td>
									<td class="complaint-table d-none d-sm-none d-md-table-cell">
										<span class="complaint__description">Topic: <span data-bind="text:$data.topic_sorting"></span></span>
										<span class="complaint__heading" data-bind="text:$data.topic_name"></span>
									</td>
									<td><span title="Marking Attempt"></span><span data-bind="text:$data.total_attempt"></span></td>
									<td>
										<a href="javascript:;" data-bind="click:$root.editMarking" class="action-button">
											<img src="{{asset('public/images/icon-table-edit.png')}}" alt="Edit" class="img-fluid" width="21px">
										</a>
									</td>
								</tr>
							</tbody>
							
						</table>

						<div data-bind="visible:$root.Records().length == 0">
							<div class="text-center">
								<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
									<img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
									<p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
								</div>
							</div>
						</div>

							<!-- <tbody data-bind="visible:$root.Records().length == 0">
								<div style="text-align: center;">
									<img src="https://localhost/teacher-imperial/public/images/no_record_found.svg" style="width:15%">
									<p style="text-align: center;margin-top: 10px;font-weight: 600;font-size: 20px;margin-left: 25px;">no Record found</p>
								</div>
							</tbody> -->
					</div>

					<div class="row dataTables_wrapper">
						<div class="col-sm-12 col-md-12 col-lg-5 col-xl-5" data-bind="with:pager, visible: $data.Records().length > 0">
							<div class="showing-text dataTables_info">
								Showing <!-- ko text:FirstItemIndex() --><!-- /ko --> to <!-- ko text:LastItemIndex() --><!-- /ko --> of <!-- ko text:iTotalRecords() --><!-- /ko --> entries
							</div>
						</div>

						<div class="col-sm-12 col-md-5 col-lg-3 col-xl-3 custom-header" data-bind="with:pager">
							<div class="dataTables_length">
								<label>Show
									<select class="show-record" data-bind="options:$data.pageSizeOptions(),value:$data.selectedPageSize"></select>
									entries
								</label>
							</div>
						</div>

						<div class="col-sm-12 col-md-7 col-lg-4 col-xl-4 pl-0 dataTables_paginate paging_simple_numbers" data-bind="with:pager, visible: $data.Records().length > 0">
							<ul class="pagination justify-content-center justify-content-md-end mb-0">
								<li class="page-item previous" data-bind="css:{'disabled':currentPage()== 1}">
									<a class="page-link" data-bind="click: firstPage">
										First
									</a>
								</li>
								<li class="page-item previous" data-bind="css:{'disabled':currentPage()== 1}">
									<a class="page-link" data-bind="click: previousPage">
										Previous
									</a>
								</li>
								<!-- ko foreach: $data.pagesToShow() -->
								<li class="page-item" data-bind="css: { active: $data.pageNumber == $parent.currentPage() }">
									<a class="page-link" data-bind="attr: {title:$data.pageNumber},text: $data.pageNumber, click: $parent.gotoPage,attr:{disabled:$data.pageNumber === $parent.currentPage()}"></a>
								</li>
								<!-- /ko -->

								<li class="page-item next" data-bind="css:{'disabled':currentPage() == allPages().length}">
									<a class="page-link" data-bind="click: nextPage">
										Next
									</a>
								</li>
								<li class="page-item next" data-bind="css:{'disabled':currentPage() == allPages().length}">
									<a class="page-link" data-bind="click: lastPage">
										Last
									</a>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
			@endif
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
						<div class="student-dropdown mb-3">
							<span class="sidefilter-heading">
								Select Student
							</span>
							<div class="col-12 px-0">
								@if(!empty($classList))
									<select class="form-control custom-select2-dropdown-nosearch select-class">	
										@foreach($classList as $key => $value)
										<option value="{{url('/marking-new/').'/'.$value['id']}}" <?php if(Request::segment(2) == $value['id']) echo "selected"; ?> >{{$value['class_name']}}</option>
										@endforeach
									</select>
								@else
									<select class="form-control custom-select2-dropdown-nosearch">
										<option value="">You have not been assigned to a class</option>
									</select>
								@endif
							</div>
						</div>
						<div class="student-dropdown mb-3">
							<span class="sidefilter-heading">
								Marking Type
							</span>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" data-bind="click:$root.practiseFilter.bind($data,'is_marked_by'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_marked_by', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_marked_by' }" class="findOne btn btn-light" id="topic_1" name="topic-stacked" value="a">
								<label class="custom-control-label" for="topic_1">Pending</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input"data-bind="click:$root.practiseFilter.bind($data,'is_extra'),css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'is_extra', 'btn-light': $root.SearchModel().practise_opt_id() != 'is_extra' }" id="topic_2" name="topic-stacked" value="b">
								<label class="custom-control-label" for="topic_2">Extra</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input" data-bind="click:$root.practiseFilter.bind($data,'work_record'), css: {'btn-danger': $root.SearchModel().practise_opt_id() == 'work_record', 'btn-light': $root.SearchModel().practise_opt_id() != 'work_record'}" id="topic_3" name="topic-stacked" value="b">
								<label class="custom-control-label" for="topic_3">Work Record</label>
							</div>
						</div>
						<!-- <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 sub-options-details">
							<select class="form-control custom-select2-dropdown-nosearch" data-bind="foreach:$root.students">
								<option data-bind="click:$root.studentFilter.bind($data),text:$data.name" ></option>						
							</select>
						</div> -->
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partB">
						<div class="search">
							@if(!empty($classId))
							<form class="pending-marking-search" data-bind="with:$root.SearchModel" action="javascript:;">
								<span class="sidefilter-heading">
									Search
								</span>
								<div class="row">
									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch" data-bind="options:$root.students, optionsText:'name', optionsValue:'studentid', value:$data.student_id, optionsCaption:'Select Student'"></select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch" data-bind="options:$root.courses, optionsText:'coursetitle', optionsValue:'_id', value:$data.course_id, optionsCaption:'Select Course'"></select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch" data-bind="options:$root.courseLevels, optionsText:'leveltitle', optionsValue:'_id', value:$data.level_id, optionsCaption:'Select Level'"></select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch" data-bind="options:$root.courseTopics, optionsText:'k_topicname', optionsValue:'_id', value:$data.topic_id, optionsCaption:'Select Topic'"></select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch" data-bind="options:$root.courseTasks, optionsText:'k_taskname', optionsValue:'_id', value:$data.task_id, optionsCaption:'Select Task'"></select>
									</div>

									<!-- <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
										<select class="form-control" data-bind="options:$root.practiseOpt, optionsText:'name', optionsValue:'id', value:$data.practise_opt_id, optionsCaption:'Select Practise Opt'"></select>
									</div> -->

									<!-- <div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
										<input type="text" class="form-control" data-bind="value:$data.student_name" placeholder="Enter Student Name" />
									</div> -->

									<div class="col-12 text-center">
										<button type="submit" class="btn btn-primary " data-bind="click:$root.ApplyFilter">Submit</button>
										<button class="btn btn-light ml-1" onClick="window.location.reload();" style="width:74.2px;">Clear</button>
									</div>
								</div>
							</form>
							@endif
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
						<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
						<div class="info-details">
							<div class="link1">
								<span><a href="https://s3.amazonaws.com/imperialenglish.co.uk/static_file/Marking.pdf" target="_black" ><i class="fa fa-file-alt"></i> Click to read</a> more information</span>
							</div>
							<!-- <div class="link2">
								<span><a href="#"><i class="fa fa-play-circle"></i> Click to</a> watch video instructions</span>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</aside>
	</div>
</main>
@endsection

@section('popup')
<div class="modal fade" id="selectClass" tabindex="-1" role="dialog" aria-labelledby="selectClassLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="selectClassLabel">Select Class</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if(!empty($classList))
			<div class="modal-body scrollbar">
				<ul class="list-unstyled text-center selection-body popup_list_option mb-0">
					@foreach($classList as $key => $value)
					<li class="list-item">
						<a href="{{url('/marking-new/').'/'.$value['id']}}"  >{{$value['class_name']}}</a>
					</li>
					@endforeach
				</ul>
			</div>
			@else
			<div class="modal-body selection-body scrollbar">
				<center><h2>You have not been assigned to a class.</h2>
					<h2> Please contact your academy administrator.</h2></center>
				</div>
				@endif
			</div>
		</div>
	</div>

	<div class="modal fade add-summary-modal" id="bulkMarking" tabindex="-1" role="dialog"    aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" data-bind="with:$root.bulkMarkingRecords">
			<div class="modal-content">
				<div class="d-flex justify-content-end w-100"><button type="button" class="btn btn-secondary  btn-sm mb-2" data-dismiss="modal">&times;</button></div>
				<div class="modal-header align-items-center">
					<h5 class="modal-title" id="exampleModalLabel">
						Bulk Marking
					</h5>
				</div>
				<div class="modal-body" style="color:#000;">
					<h3>Comment</h3>
					<div class="form-group">
						<input type="text" id="title" name="title" class="form-control" placeholder="write here..." data-bind="value:$data.comment" />
					</div>

				</div>
				<div class="modal-footer justify-content-center">
					<button type="submit" class="btn btn-primary" data-bind="click:$root.saveBulkMarking">Save</button>
					<button type="button" class="btn btn-secondary" data-bind="click:$root.closeBulkMarking">Cancel</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="selectStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Select Student</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body selection-body popup_list_option scrollbar pt-0 mb-0">
					<!-- ko if:$root.students().length > 0 -->
					<ul class="list-unstyled text-center pt-3 mb-0" data-bind="foreach:$root.students">
						<li class="list-item">
							<a href="javascript:;" data-bind="click:$root.studentFilter.bind($data),text:$data.name" ></a>
						</li>
					</ul>
					<!-- /ko -->
				</div>
			</div>
		</div>
	</div>
	@endsection

	@section('script')
	@if(!empty($classId))
	<script type="text/javascript" src="{{asset('public/vendors/select2/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.mapping.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/vendors/knockout/knockout.validation.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/vendors/bootstrap-notify.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/js/pagejs/pager.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/js/pagejs/common.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/js/pagejs/marking.js?'.time())}}"></script>
	<script type="text/javascript">
		var getRecords = "{{route('marking_records')}}", classId="{{$classId}}", courses=@json($courses), classList=@json($classList), students=@json($students), bulkMarkingURL="{{route('bulk_marking')}}";
	</script>
	@else
	<script type="text/javascript">
		$(document).ready(function(){
			$("#selectClass").modal();
		});
	</script>
	@endif

	<script>
    $(".open-filter").click(function(){
	//	alert('hi');
        $("aside.filter-sidebar").addClass("openclose");
    });

    $(".close-filter").click(function(){
        $("aside.filter-sidebar.openclose").removeClass("openclose");
    });
</script>
<!-- <script>
    $(document).on('change',"#class_dropdown_redirect",function(){
    var data = $(this).val();
    if(data) 
    { 
        window.location = data; // redirect
    }
    return false;
    });
</script> -->

<script>
    $(document).on('change',".select-class",function(){
    var data = $(this).val();
    if(data) 
    { 
        window.location = data;
    }
	// var value = $(data).val();
    return false;
    });
</script>

<script>
    $(document).ready(function(){
        $("#moreInfo").click(function(){
            $(".info-details").slideDown("slow");
        });
        $(function() {
            $('body').on('mouseup', function() {
                $('.info-details').hide();
            });
        });
    });

    $(document).ready(function(){
        $("#topic_1").click(function(){
            $(".sub-options-details").slideUp("slow");
        });
        $("#topic_2").click(function(){
            $(".sub-options-details").slideUp("slow");
        });
        $("#topic_3").click(function(){
            $(".sub-options-details").slideDown("slow");
        });
    });

    // $(document).ready(function() {
    //     $('#datatable').DataTable({
    //         "ordering": false
    //     });
    // });
</script>

<script>
    $(document).on('change',"#aryan",function(){
    // var data = $(".aryan2").val();
			$('.aa').click();
    });
</script>
@endsection