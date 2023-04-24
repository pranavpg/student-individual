@extends('layouts.teacher-app')
@section('content')
@include('common.sidebar')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
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
						<span>
							<img src="{{asset('public/images/icon-marking-logo.png')}}" alt="" class="img-fluid" style="margin-bottom: 9px;" width="27px">
						</span>
						Marking
					</h1>
					<div class="filter">
						<a href="javascript:void(0)" class="btn btn-sm btn-light open-filter filterbtn d-none d-md-inline-block">
							<img src="{{asset('public/images/filter-options-default.png')}}" alt="" class="img-fluid deskonly" width="20px">
						</a>
					</div>
				</div>
				<div class="col-xl-12 d-none d-sm-flex justify-content-between">
					<div class="col-6 col-6 col-sm-4  d-flex justify-content-start pl-0">
						<select class="form-control custom-select2-dropdown-nosearch">	
							<option value="" selected="">advance</option>
						</select>
					</div>
					<div class="col-12 col-sm-8 col-md-8 d-flex justify-content-end pr-0">
						<ul class="list-inline marking-button float-left mb-0">
							<li class="list-inline-item"><a href="javascript:void();" class="findOne btn btn-light" style="width:90px;">Pending</a></li>
							<li class="list-inline-item"><a href="javascript:;" class="findOne btn btn-light" style="width:91px;">Extra</a></li>
							<li class="list-inline-item"><a href="javascript:void(0)" class="findOne btn btn-danger">Work Record</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="main__content pt-0 mb-5">
				<div class="col-xl-12 marking-data-table">
					<div class="row">
						<div class="col-12 col-md-6 text-right" style="display: none;">
							<button type="submit" class="btn btn-primary">Add Marking</button>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table datatable_draw mt-2 ieuktable-sline">
							 <thead>
					            <tr>
					            
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
					        <tfoot>
					            <tr>
					              
									<th scope="col">Student ID</th>
									<th scope="col">Student Name</th>
									<th scope="col">Course</th>
									<th scope="col">Level</th>
									<th scope="col">Task</th>
									<th scope="col">Topic</th>
									<th scope="col">Marking Attempt</th>
									<th>Action</th>
					            </tr>
					        </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
		<aside class="filter-sidebar">
			<div class="heading d-flex flex-wrap justify-content-between">
				<h5><i class="fa fa-filter"></i> Filter</h5>
				<a href="javascript:void(0);" class="close-filter">
					<img src="{{asset('public/images/icon-close-filter-white.svg')}}" alt="" class="img-fluid" style="margin-top: -2px;" width="15px">
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
								<select class="form-control custom-select2-dropdown-nosearch select-class">	
									<option selected="">advance</option>
								</select>
							</div>
						</div>
						<div class="student-dropdown mb-3">
							<span class="sidefilter-heading">
								Marking Type
							</span>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-light" id="topic_1" name="topic-stacked" value="a">
								<label class="custom-control-label" for="topic_1">Pending</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-light" id="topic_2" name="topic-stacked" value="b">
								<label class="custom-control-label" for="topic_2">Extra</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" class="custom-control-input btn-danger" id="topic_3" name="topic-stacked" value="b">
								<label class="custom-control-label" for="topic_3">Work Record</label>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partB">
						<div class="search">
							<form class="pending-marking-search" data-bind="with:$root.SearchModel" action="javascript:;">
								<span class="sidefilter-heading">
									Search
								</span>
								<div class="row">
									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch">
											<option value="">Select Student</option>
											<option value="">Durva Jignesh Prajapati</option>
										</select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch">
											<option value="">Select Course</option>
											<option value="">General English</option>
											<option value="">Academic English</option>
										</select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch">
											<option value="">Select Level</option>
										</select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch">
											<option value="">Select Topic</option>
										</select>
									</div>

									<div class="col-12 mb-3">
										<select class="form-control custom-select2-dropdown-nosearch">
											<option value="">Select Task</option>
										</select>
									</div>

									<div class="col-12 text-center">
										<button type="submit" class="btn btn-primary">Submit</button>
										<button class="btn btn-light ml-1" onclick="window.location.reload();" style="width:74.2px;">Clear</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 filter-bottom">
						<a href="javascript:void(0);" id="moreInfo"><i class="fas fa-info-circle"></i></a>
						<div class="info-details" style="display: none;">
							<div class="link1">
								<span><a href="https://s3.amazonaws.com/imperialenglish.co.uk/static_file/Marking.pdf" target="_black"><i class="fa fa-file-alt"></i> Click to read</a> more information</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</aside>
	</div>
</main>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
	    $('.datatable_draw').DataTable({
	        processing: false,
	        serverSide: true,
	        ajax: $.fn.dataTable.pipeline({
	            url: "{{route('marking_list')}}" ,
	            pages: 5, // number of pages to cache
	        }),
	    });
	});

	$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend({
            pages: 5, // number of pages to cache
            url: '', // script url
            data: null, // function or object with parameters to send to the server
            // matching how `ajax.data` works in DataTables
            method: 'GET', // Ajax HTTP method
        },
        opts
    );
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;
 
        if (settings.clearCache) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        } else if (
            JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
            JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
            JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
        // Store the request for checking next time around
        cacheLastRequest = $.extend(true, {}, request);
 
        if (ajax) {
            // Need data from the server
            if (requestStart < cacheLower) {
                requestStart = requestStart - requestLength * (conf.pages - 1);
 
                if (requestStart < 0) {
                    requestStart = 0;
                }
            }
            cacheLower = requestStart;
            cacheUpper = requestStart + requestLength * conf.pages;
            request.start = requestStart;
            request.length = requestLength * conf.pages;
            // Provide the same `data` options as DataTables.
            if (typeof conf.data === 'function') {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            } else if ($.isPlainObject(conf.data)) {
                // As an object, the data given extends the default
                $.extend(request, conf.data);
            }
            return $.ajax({
                type: conf.method,
                url: conf.url,
                data: request,
                dataType: 'json',
                cache: false,
                success: function (json) {
                    cacheLastJson = $.extend(true, {}, json);
                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    if (requestLength >= -1) {
                        json.data.splice(requestLength, json.data.length);
                    }
                    drawCallback(json);
                },
            });
        } else {
            json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the echo for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);
 
            drawCallback(json);
        }
    };
};
 
// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});
</script>
<script type="text/javascript">
	$(".open-filter").click(function() {
		$("aside.filter-sidebar").addClass("openclose");
	});

	$(".close-filter").click(function() {
		$("aside.filter-sidebar.openclose").removeClass("openclose");
	});
</script>

@endsection