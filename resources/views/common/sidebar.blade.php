<aside class="sidebar-menu" id="sidebar">
	<div class="navbar-profile d-flex align-items-center">
		<a href="javascript:void(0);" class="navbar-brand expand-chat-support" title="Chat Support" style="cursor: pointer;">
			<center><img src="{{ asset('/public/images/contactus-04.svg') }}" alt="Chat Support" style="width:29px;margin-top:-4px"></center>
		</a>
		<a href="javascript:void(0);" class="nav-opener"></a>
	</div>
	<nav class="navbar">
		<ul class="navbar-nav">
			<li class="nav-item <?php if(empty(request()->segment(1))){ echo "active"; }?>">
				<a class="nav-link"  href="{{ URL('/') }}">
					<span class="nav-icon" title="Courses">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.28 27.38" width="27"
						height="27">
						<defs />
						<g data-name="Layer 2">
							<path fill="#fff"
							d="M15.74.79a2.93 2.93 0 00-4 0L.19 11.49a.57.57 0 00-.15.64.59.59 0 00.55.37H3v12a2.93 2.93 0 002.93 2.93H21.2a2.93 2.93 0 002.93-2.93v-12h2.56a.6.6 0 00.55-.37.57.57 0 00-.15-.64zm1 25.42h-6.3v-4.88a1.75 1.75 0 011.76-1.75H15a1.75 1.75 0 011.76 1.75zM23 24.45a1.76 1.76 0 01-1.76 1.76H18v-4.88a2.93 2.93 0 00-3-2.92h-2.75a2.93 2.93 0 00-2.93 2.92v4.88H5.94a1.76 1.76 0 01-1.76-1.76V12.5H23zM2.08 11.33l10.45-9.69a1.76 1.76 0 012.4 0l10.29 9.68z"
							data-name="Layer 1" />
						</g>
					</svg>
				</span>
				<span class="nav-link__name">
					Courses 
				</span>
			</a>
		</li>
		<li class="nav-item <?php if(request()->segment(1) == "notes"){ echo "active"; }?>">
			<a class="nav-link"   href="{{ URL('notes') }}">
				<span class="nav-icon" title="Notes">
					<svg xmlns="http://www.w3.org/2000/svg" width="19" height="25">
						<defs />
						<g fill="none" fill-rule="evenodd">
							<path d="M-6-3h30v30H-6z" />
							<g>
								<path fill="#FFF" fill-rule="nonzero"
								d="M6.42 15.16a.2.2 0 00.2 0l2.25-.92a.18.18 0 00.13-.05l2.94-3.8.37-.48A1.28 1.28 0 0012 8.09l-.38-.29a1.3 1.3 0 00-1.77.2l-3.33 4.35a.21.21 0 000 .11L6.33 15a.21.21 0 00.09.18M13.54 16H5.08a.2.2 0 00-.21.2c0 .116.094.21.21.21h8.46a.2.2 0 00.2-.21.2.2 0 00-.2-.2" />
								<rect width="17.86" height="23.66" x=".38" y=".38" stroke="#FFF"
								stroke-width="1" rx="2.49" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Notes</span>
			</a>
		</li>
		<li class="nav-item <?php if(request()->segment(1) == "work"){ echo "active"; }?>">
			<a class="nav-link" href="{{url('work')}}">
				<span class="nav-icon" title="Work Record">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="25">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-5-3h30v30H-5z" />
							<g fill="#FFF">
								<path fill="#fff"
								d="M10.93 24.19h-9A1.88 1.88 0 010 22.31V4.08A1.88 1.88 0 011.89 2.2h13.19A1.89 1.89 0 0117 4.08v14.11a.64.64 0 01-.19.44L11.37 24a.63.63 0 01-.44.22v-.03zm-9-20.7a.63.63 0 00-.63.62v18.2c0 .348.282.63.63.63h8.79l5-5V4.08a.63.63 0 00-.63-.62l-13.16.03z" />
								<path
								d="M4.24 13.67H3a.63.63 0 110-1.26h1.24a.63.63 0 110 1.26M13.35 13.67H6.13a.63.63 0 110-1.26h7.22a.63.63 0 110 1.26M4.24 16.81H3a.63.63 0 110-1.26h1.24a.63.63 0 110 1.26M13.35 16.81H6.13a.63.63 0 110-1.26h7.22a.63.63 0 110 1.26M4.24 10.53H3a.63.63 0 010-1.26h1.24a.63.63 0 010 1.26M13.35 10.53H6.13a.63.63 0 110-1.26h7.22a.63.63 0 11.02 1.26M4.24 7.38H3a.63.63 0 010-1.25h1.24a.63.63 0 110 1.25M13.35 7.38H6.13a.63.63 0 110-1.25h7.22a.63.63 0 110 1.25" />
								<path
								d="M18.54 17.88a.63.63 0 01-.63-.63V2.51a1.25 1.25 0 00-1.26-1.25H2.83a.63.63 0 010-1.26h13.82a2.51 2.51 0 012.52 2.51v14.74a.63.63 0 01-.63.63" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Work Record</span>
			</a>
		</li>
		<li class="nav-item <?php if(request()->segment(1) == "summary"){ echo "active"; }?>">
			<a class="nav-link" href="{{ URL('summary') }}">
				<span class="nav-icon" title="Summary">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="25">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-6-3h30v30H-6z" />
							<g fill="#FFF">
								<path
								d="M19.41 1.5H1.93a.41.41 0 00-.43.4v22.55c.01.23.2.41.43.41h13.35a.42.42 0 00.3-.13l4.12-4.3a.36.36 0 00.1-.28V1.9a.38.38 0 00-.37-.4h-.02zm-17.09.82H19v17.43h-3.7a.41.41 0 00-.43.4V24H2.32V2.32zm16.12 18.26l-2.76 2.84v-2.84h2.76z" />
								<path
								d="M4.82 16.55h11.39a.41.41 0 000-.82H4.82a.41.41 0 000 .82M11.42 18.51h-6.6a.42.42 0 00-.42.42.41.41 0 00.42.41h6.6a.41.41 0 00.41-.41.42.42 0 00-.41-.42M16.61 4.9a.41.41 0 00-.42-.41H4.8a.41.41 0 00-.42.41v8.15a.42.42 0 00.42.41h11.39a.42.42 0 00.42-.41V4.9zm-11.4.41h10.57v7.33H5.21V5.31z" />
								<path
								d="M18.29.41a.41.41 0 00-.42-.41H.39A.39.39 0 000 .41V23c0 .226.184.41.41.41A.41.41 0 00.83 23V.82h17a.41.41 0 00.42-.41" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Summary</span>
			</a>
		</li>
		<li class="nav-item <?php if(request()->segment(1) == "porfolio_assessment"){ echo "active"; }?> <?php if(request()->segment(1) == "student_progress_report"){ echo "active"; }?>">
			<a class="nav-link" href="{{ URL('porfolio_assessment') }}">
				<span class="nav-icon" title="Assessment">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="25">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-6-3h30v30H-6z" />
							<path fill="#FFF"
							d="M12.21.158A.46.46 0 0011.843 0H1.974C.884 0 0 .884 0 1.974v17.105c0 1.09.884 1.974 1.974 1.974H5.46v3a.5.5 0 00.289.447c.18.08.39.049.54-.079l2.552-2.184 2.632 2.184c.144.128.35.16.526.079a.474.474 0 00.29-.447v-3h3.486c1.093 0 1.98-.882 1.987-1.974V5.329a.513.513 0 00-.17-.368L12.21.158zm.132 1.447l3.553 3.21h-3.066a.5.5 0 01-.487-.486V1.605zm-1.026 14.25a2.921 2.921 0 11-.553-3.79 2.947 2.947 0 01.553 3.79zm-2.105 5.29a.5.5 0 00-.645 0L6.46 22.908v-5.513a3.947 3.947 0 004.776 0v5.513L9.21 21.145zM15.789 20h-3.565v-3.737a3.947 3.947 0 10-6.763 0V20H1.974a1 1 0 01-.987-.987V1.973a1 1 0 01.987-.986h9.368v3.342c.007.816.67 1.474 1.487 1.474h3.868V18.96a.987.987 0 01-.986.986l.078.053z" />
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Portfolio Assessment</span>
			</a>
		</li>
		<li class="nav-item <?php if(request()->segment(1) == "vocabulary"){ echo "active"; }?>">
			<a class="nav-link" href="{{ URL('vocabulary') }}">
				<span class="nav-icon" title="Vocabulary">
					<svg xmlns="http://www.w3.org/2000/svg" width="21" height="26">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-5-2h30v30H-5z" />
							<g fill="#FFF">
								<path
								d="M17.853.963H3.852a2.369 2.369 0 00-1.676.655c-.44.412-.695.985-.703 1.589V4.43H.414A.414.414 0 000 4.815v2.292c0 .232.182.423.414.433h1.06v.559H.413A.404.404 0 000 8.503v2.263a.385.385 0 00.414.385h1.06v.616H.413a.404.404 0 00-.414.395v2.282a.395.395 0 00.414.395h1.06v.568H.413a.395.395 0 00-.414.386v2.263a.404.404 0 00.414.404h1.06v.559H.413a.433.433 0 00-.414.433v2.263a.414.414 0 00.414.433h1.06v1.223a2.311 2.311 0 002.378 2.253h14.001a2.292 2.292 0 002.37-2.243V3.159a2.292 2.292 0 00-2.37-2.196zM.82 5.248h2.234v1.493H.819V5.248zm0 3.66h2.234v1.434H.819V8.907zm0 3.668h2.234v1.435H.819v-1.435zm0 3.67h2.234v1.434H.819v-1.435zm0 3.62h2.234v1.483H.819v-1.483zm18.546 3.515a1.483 1.483 0 01-1.512 1.425H3.852A1.493 1.493 0 012.32 23.38v-1.233h1.155a.424.424 0 00.376-.404V19.48a.453.453 0 00-.424-.434H2.292v-.558h1.155a.414.414 0 00.405-.405v-2.263a.404.404 0 00-.424-.385H2.292v-.616h1.155a.414.414 0 00.405-.376v-2.282a.414.414 0 00-.424-.395H2.292v-.616h1.155a.404.404 0 00.424-.385V8.503a.414.414 0 00-.424-.404H2.292V7.54h1.155a.453.453 0 00.405-.433V4.815a.424.424 0 00-.424-.414H2.292V3.207c.015-.367.174-.713.443-.963a1.58 1.58 0 011.117-.463h14.001a1.483 1.483 0 011.512 1.426V23.38z" />
								<path
								d="M10.997 13.481H8.262a.193.193 0 00-.183.126l-.433 1.213a.173.173 0 01-.173.125h-.829a.193.193 0 01-.183-.25l2.446-6.808a.193.193 0 01.183-.126h1.089a.193.193 0 01.182.126l2.446 6.827a.193.193 0 01-.183.25h-.837a.173.173 0 01-.174-.125l-.433-1.213a.193.193 0 00-.183-.125m-1.54-3.794l-.964 2.57a.202.202 0 00.183.26h1.81a.202.202 0 00.184-.26l-.906-2.57a.183.183 0 00-.356 0" />
								<path
								d="M12.191 14.156c.457-.009.902.141 1.262.423a.193.193 0 00.308-.154c0-.106.086-.192.192-.192h.559c.106 0 .192.086.192.192v4.14a.193.193 0 01-.192.194h-.559a.193.193 0 01-.192-.193.193.193 0 00-.308-.145 2.06 2.06 0 01-1.281.424 2.186 2.186 0 01-2.119-2.35 2.157 2.157 0 012.138-2.32m.193.809a1.396 1.396 0 00-1.368 1.512 1.425 1.425 0 001.368 1.54 1.406 1.406 0 001.377-1.53 1.406 1.406 0 00-1.377-1.522" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Vocabulary</span>
			</a>
		</li>

		<li class="nav-item <?php if(request()->segment(1) == "functional_language"){ echo "active"; }?>">
			<a class="nav-link" href="{{ URL('functional_language') }}">
				<span class="nav-icon" title="Functional Language">
					<svg xmlns="http://www.w3.org/2000/svg" width="26" height="23">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-2-4h30v30H-2z" />
							<g fill="#FFF">
								<path
								d="M21.67 3a14.37 14.37 0 00-8.93-3 14.39 14.39 0 00-8.93 3A9.38 9.38 0 000 10.32a9.38 9.38 0 003.82 7.37l-.19 4.93A.31.31 0 004 23a.27.27 0 00.13 0l6-2.53a16.82 16.82 0 002.65.22 14.37 14.37 0 008.93-2.95 9.4 9.4 0 003.81-7.37A9.38 9.38 0 0021.67 3m-.39 14.2a13.75 13.75 0 01-8.54 2.8 15.49 15.49 0 01-2.63-.23.37.37 0 00-.18 0L4.3 22.18l.18-4.6a.3.3 0 00-.12-.26l-.16-.12a8.8 8.8 0 01-3.57-6.88A8.78 8.78 0 014.2 3.44 13.72 13.72 0 0112.74.62a13.7 13.7 0 018.54 2.82 8.76 8.76 0 013.58 6.88 8.78 8.78 0 01-3.58 6.88" />
								<path
								d="M19.57 13.34V7.9a.32.32 0 00-.21-.3l-6.94-2.55a.41.41 0 00-.22 0L5.26 7.61a.3.3 0 00-.2.29c0 .129.08.244.2.29L7.32 9v5.09a.3.3 0 00.2.29 13.76 13.76 0 004.79.87 13.83 13.83 0 004.81-.87.31.31 0 00.21-.29V9L19 8.36v5a1.19 1.19 0 00-.85 1.12 1.17 1.17 0 002.33 0 1.18 1.18 0 00-.86-1.12l-.05-.02zm-7.2 1.29a13.09 13.09 0 01-4.38-.75v-1.61c2.841.96 5.919.96 8.76 0v1.59a13 13 0 01-4.38.75v.02zm4.38-3.02c-2.834 1-5.926 1-8.76 0V9.23l4.26 1.66a.23.23 0 00.11 0 .22.22 0 00.12 0l4.22-1.66.05 2.38zm.2-3.13l-4.57 1.78-4.63-1.77-1.5-.58 6.06-2.23 6.06 2.23-1.42.57zM19.26 15a.52.52 0 01-.53-.52.53.53 0 01.53-.53.53.53 0 110 1.05z" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Functional Language</span>
			</a>
		</li>

		<li class="nav-item <?php if(request()->segment(1) == "profile" && !empty(request()->segment(2))){ echo "active"; }?>">
			<a class="nav-link"  href="{{ URL('profile/ilps') }}">
				<span class="nav-icon" title="Organiser">
					<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25">
						<defs />
						<g fill="none" fill-rule="nonzero">
							<path d="M-3-3h30v30H-3z" />
							<g fill="#FFF">
								<path
								d="M22 3.34h-.66v-.53a2.81 2.81 0 00-5.62 0v.53H9.24v-.53a2.81 2.81 0 10-5.62 0v.53H3a3 3 0 00-3 3v15.11a3 3 0 003 3h19a3 3 0 003-3V6.3a3 3 0 00-3-3v.04zm-5.1-.57a1.63 1.63 0 113.26 0V5h-3.22l-.04-2.23zm-12.1.04a1.63 1.63 0 013.26 0V5H4.8V2.81zM3 4.53h.66v1.1c0 .326.264.59.59.59h4.4a.59.59 0 00.59-.59v-1.1h6.52v1.1c0 .326.264.59.59.59h4.44a.59.59 0 00.59-.59v-1.1H22a1.77 1.77 0 011.81 1.77v2.94H1.18V6.3A1.78 1.78 0 013 4.53zm19 18.69H3a1.78 1.78 0 01-1.78-1.77v-11h22.59v11A1.77 1.77 0 0122 23.22z" />
								<path
								d="M16.34 13.43l-5 4.75-2.49-2.52a.59.59 0 00-.83 0 .6.6 0 000 .84L11 19.43a.58.58 0 00.82 0l5.39-5.15a.594.594 0 10-.82-.86" />
							</g>
						</g>
					</svg>
				</span>
				<span class="nav-link__name">Organiser</span>
			</a>
		</li>
        <li class="nav-item {{ ( request()->segment(1) == 'marking' && !empty(request()->segment(1)) ) ? 'active' : '' }}" onclick="tempfunction()" title="Marking">
				<a class="nav-link" href="{{ url('/marking') }}">
					<span class="nav-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="25">
							<defs />
							<g fill="none" fill-rule="nonzero">
								<path d="M-5-3h30v30H-5z" />
								<g fill="#FFF">
									<path d="M10.93 24.19h-9A1.88 1.88 0 010 22.31V4.08A1.88 1.88 0 011.89 2.2h13.19A1.89 1.89 0 0117 4.08v14.11a.64.64 0 01-.19.44L11.37 24a.63.63 0 01-.44.22v-.03zm-9-20.7a.63.63 0 00-.63.62v18.2c0 .348.282.63.63.63h8.79l5-5V4.08a.63.63 0 00-.63-.62l-13.16.03z" />
									<path d="M4.24 13.67H3a.63.63 0 110-1.26h1.24a.63.63 0 110 1.26M13.35 13.67H6.13a.63.63 0 110-1.26h7.22a.63.63 0 110 1.26M4.24 16.81H3a.63.63 0 110-1.26h1.24a.63.63 0 110 1.26M13.35 16.81H6.13a.63.63 0 110-1.26h7.22a.63.63 0 110 1.26M4.24 10.53H3a.63.63 0 010-1.26h1.24a.63.63 0 010 1.26M13.35 10.53H6.13a.63.63 0 110-1.26h7.22a.63.63 0 11.02 1.26M4.24 7.38H3a.63.63 0 010-1.25h1.24a.63.63 0 110 1.25M13.35 7.38H6.13a.63.63 0 110-1.25h7.22a.63.63 0 110 1.25" />
									<path d="M18.54 17.88a.63.63 0 01-.63-.63V2.51a1.25 1.25 0 00-1.26-1.25H2.83a.63.63 0 010-1.26h13.82a2.51 2.51 0 012.52 2.51v14.74a.63.63 0 01-.63.63" />
								</g>
							</g>
						</svg>
					</span>
					<span class="nav-link__name">Teacher/Marking</span>
				</a>
			</li>
			<li class="nav-item <?php if(request()->segment(1) == "purchase_course" && empty(request()->segment(2))){ echo "active"; }?>">
				<a class="nav-link" href="{{ URL('purchase_course') }}">
					<span class="nav-icon" title="Organiser">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
							<defs />
							<g fill="none" fill-rule="nonzero">
							<path d="M-3-3h30v30H-3z" />
							<g fill="#FFF">
								<path
								d="M22 3.34h-.66v-.53a2.81 2.81 0 00-5.62 0v.53H9.24v-.53a2.81 2.81 0 10-5.62 0v.53H3a3 3 0 00-3 3v15.11a3 3 0 003 3h19a3 3 0 003-3V6.3a3 3 0 00-3-3v.04zm-5.1-.57a1.63 1.63 0 113.26 0V5h-3.22l-.04-2.23zm-12.1.04a1.63 1.63 0 013.26 0V5H4.8V2.81zM3 4.53h.66v1.1c0 .326.264.59.59.59h4.4a.59.59 0 00.59-.59v-1.1h6.52v1.1c0 .326.264.59.59.59h4.44a.59.59 0 00.59-.59v-1.1H22a1.77 1.77 0 011.81 1.77v2.94H1.18V6.3A1.78 1.78 0 013 4.53zm19 18.69H3a1.78 1.78 0 01-1.78-1.77v-11h22.59v11A1.77 1.77 0 0122 23.22z" />
								<path
								d="M16.34 13.43l-5 4.75-2.49-2.52a.59.59 0 00-.83 0 .6.6 0 000 .84L11 19.43a.58.58 0 00.82 0l5.39-5.15a.594.594 0 10-.82-.86" />
							</g>
						</g>
						</svg>
					</span>
					<span class="nav-link__name">Purchase</span>
				</a>
			</li>
			<li class="nav-item <?php if(request()->segment(1) == "profile" && empty(request()->segment(2))){ echo "active"; }?>">
				<a class="nav-link" href="{{ URL('profile') }}">
					<span class="nav-icon" title="Profile">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
							<defs />
							<g fill="none" fill-rule="nonzero">
								<path d="M-4-3h30v30H-4z" />
								<g fill="#FFF">
									<path
									d="M11.57 0a11.57 11.57 0 10-.007 23.14A11.57 11.57 0 0011.57 0M5.31 20.06v-1a6.26 6.26 0 0112.51 0v1a10.55 10.55 0 01-12.51 0m13.52-.85v-.15a7.27 7.27 0 10-14.53 0v.15A10.47 10.47 0 011 11.57a10.56 10.56 0 1121.11 0 10.47 10.47 0 01-3.29 7.64" />
									<path
									d="M11.59 3.41a3.91 3.91 0 102.77 1.14 3.84 3.84 0 00-2.77-1.14m2.06 6A2.91 2.91 0 119.53 5.3a2.91 2.91 0 014.12 4.11" />
								</g>
							</g>
						</svg>
					</span>
					<span class="nav-link__name">Profile</span>
				</a>
			</li>
			<li class="nav-item <?php if(request()->segment(1) == "contact-us"){ echo "active"; }?>">
				<a class="nav-link" href="{{ URL('contact-us') }}">
					<span class="nav-icon" title="Contact Us">
						<img src="{{ url('public/images/contact_us.png') }}" width="30" height="30">
					</span>
					<span class="nav-link__name">Contact Us</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#logout_popup" title="Logout">
					<span class="nav-icon" title="Log Out">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
							<defs />
							<g fill="none" fill-rule="nonzero">
								<path d="M-4-3h30v30H-4z" />
								<g fill="none">
									<path id="Stroke 1" d="M21.791 12.1208H9.75" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path id="Stroke 3" d="M18.8643 9.20483L21.7923 12.1208L18.8643 15.0368" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path id="Stroke 4" d="M16.3597 7.63C16.0297 4.05 14.6897 2.75 9.35974 2.75C2.25874 2.75 2.25874 5.06 2.25874 12C2.25874 18.94 2.25874 21.25 9.35974 21.25C14.6897 21.25 16.0297 19.95 16.3597 16.37" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</g>
							</g>
						</svg>
					</span>
					<span class="nav-link__name">Log Out</span>
				</a>
			</li>
			<hr style="width: 100%;border-top: 1px solid #ffffff;">
			<li class="nav-item">
				<a class="nav-link chat-support" href="javascript:void(0);">
					<span class="nav-icon" title="Chat Support">
						<img src="{{ url('public/images/contactus-04.svg') }}" width="30" height="30">
					</span>
					<span class="nav-link__name">Chat Support</span>
				</a>
			</li>
	</ul>
</nav>
</aside>
<!-- Logout Modal -->
<div class="modal fade" id="logout_popup" tabindex="-1" role="dialog" aria-labelledby="erasemodalLongTitle" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<h5 class="modal-title" id="erasemodalLongTitle">Logout</h5>
			</div>
			<div class="modal-body text-center m-5">
				<p>Are you sure you want to logout?</p>
			</div>
			<div class="modal-footer justify-content-center">
				<a href="{{url('/logout')}}"><button type="button" class="btn btn-primary mr-3 reset-answer">Yes</button></a>
				<button type="button" class="btn btn-cancel" data-dismiss="modal">No</button>
			</div>
		</div>
	</div>
</div>