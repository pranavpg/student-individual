@extends('layouts.app')
@section('content')

@php
$skills = ['Reading', 'Writing', 'Listening', 'Speaking', 'Grammar', 'Vocabulary', 'Learner Training'];

$reading = [
'I want to read to understanding the overall meaning of a text (Gist)',
'I want to read for specific information in a text (Detail)',
'I want to scan a text (Reading quickly through a text to look for keywords)',
'I want to skim a text (Reading quickly through a text to get the writer’s main ideas)',
'I read alone for personal enjoyment or for information',
'I want to predict the general content and ideas contained in a text by using vocabulary clues',
'I want to understand words and identify their grammatical function',
'I want to recognise and name features of grammar',
'I want to understand different types of text and identify the purpose',
'I want to identify how a text is organised (e.g. problem-solution-evaluation, thesis-led, etc)',
"I want to identify the writer's attitude",
'I want to follow the development of an argument',
'I want to follow the sequence of a narrative',
'I want to read and paraphrase a text',
'I want to distinguish factual information from opinions',
'I want to understand and analyse the questions and instructions',
'I want to use the questions to analyse the text',
'I want to identify the organised text (e.g. Problem-solution-.evaluation, narrative, thesis-led, for and against) and move around a text with ease',
'I leave questions I want to do and come back again',
'I want to read fast and accurately',
'I want to skim the text',
'I want to scan the text',
'I want to ignore words I don’t know',
'I want to use prefixes and suffixes , plus grammar knowledge to make a guess at the meaning of unknown words',
'I want to manage my time effectively',
'I want to use techniques for multiple choice questions',
'I want to use techniques for headings questions',
'I want to use techniques for matching questions',
'I want to use techniques for sentence completion questions',
'I want to use techniques for gap-fill questions',
'I want to use techniques for True, False, Not Given questions and Yes, No, Not Given questions',
'I want to use techniques for completing tables and labelling diagrams',
];

$writing = [
'I want to spell common words correctly',
'I want to write clearly. (I leave spaces between words/it is easy for people to recognise my letters/I write on the line)',
'I want to use punctuation correctly',
'I want to write by using the appropriate text type (for example, e-mail/letter/ note/ notice/report/essay)',
'I want to use the appropriate vocabulary to write about a variety of topics and situations',
'I want to write grammatically correct sentences (for my level of study)',
'I want to connect my sentences and ideas with conjunctions and text-referencing words',
'I want to write in logical paragraphs (with a topic sentences)',
'I want to write a summary of a text',
'I want to write a description of a process, using appropriate grammar, vocabulary and linking words',
'I want to write about what happened in the past (for example in a diary or select writing story',
'I want to write a for and against discussion essay',
'I want to write a critical review (of a book, a film, a restaurant, etc)',
'I want to skim and understand the diagram and data/diagram/map effectively',
'I want to plan my answer',
'I want to paraphrase the question',
'I want to summarise the information, highlight main features, support with specific data and make comparisons where relevant',
'I want to organise my writing and use paragraphs',
'I want to write at least 150 words',
'I want to use a wide range of grammar and vocabulary',
'I want to look back at what I have written as I write',
'I want to check for mistakes effectively: spelling, grammar, prepositions, collocation, singular/plural, tenses, countable/uncountable nouns and my common mistakes',
'I want to analyse the question',
'I want to plan my answer',
'I want to paraphrase the question and write a thesis statement in the introduction',
'I want to manage my time efficiently',
'I want to write at least 250 words',
'I want to organise my writing and use paragraphs',
'I want to write complex sentences and a range of functions (e.g. cause and effect)',
'I want to use a wide range of grammar and vocabulary',
'I do not over-generalise',
'I want to use appropriate conjunctions, text-referencing words and carrier nouns',
'I want to give reasons and relevant examples',
'I want to look back at what I have written as I write',
'I want to check for mistakes effectively: spelling, grammar, prepositions, collocation, singular/plural, tenses, countable/uncountable nouns and my common mistakes',
];

$listening = [
'I want to interpret the attitude of a speaker through language used and intonation patterns',
'I want to listen for the overall meaning of a text (Gist)',
'I want to listen for specific information in a text (Detail)',
'I want to understand the main points in a presentation',
'I want to understand and follow the main points of an argument',
'I want to follow and identify the main points of a presentation or lecture and make appropriate notes',
'I want to recognise devices to signal a change in topic or direction of conversation',
'I want to follow a conversation between two native speakers',
'I want to listen to and take out the main points of information from a news item',
'Can follow a group discussion and take out the main points and opinions',
'I want to discriminate between individual sounds to identify and spell words',
'I want to recognise phonetic symbols',
'I want to listen, read and write at the same time',
'I want to check the grammar of questions and predict the answer',
'I know how to deal with all the types of questions (see IELTS Reading Skills)',
'I want to concentrate all the time (I want to ‘listen’ , not just ‘hear’)',
'I want to follow dialogues',
'I want to follow monologues',
'I want to ignore words I don’t know',
'I want to listen for synonyms for words in the question',
'I want to manage my time effectively',
];

$speaking = [
'I want to take turns when speaking by recognising intonation patterns',
'I want to use appropriate language in different situations (Register and formality)',
'I want to contribute effectively to a group discussion',
'I want to extend spoken responses and give additional information',
'I want to give a presentation on a range of different subjects',
'I want to answer questions and give appropriate responses',
'I want to use a range of linking words to mark the relationship between ideas',
'I want to paraphrase and cover for gaps in vocabulary knowledge',
'I want to support an argument with relevant examples and evidence',
'I want to narrate a story or past experience in detail',
'I want to invite discussion by asking others to contribute and checking their understanding',
'I want to sound ‘friendly’ and interested in other speakers by using appropriate intonation',
'I want to pronounce individual words correctly and can use correct word stress',
'I want to pronounce words in connected speech (sentences) correctly by using contractions and sentence stress',
'I want to respond by using different, but appropriate, vocabulary and collocation to the other speakers',
'I want to speak fluently',
'I want to speak accurately and clearly (accurate grammar, appropriate vocabulary, accurate pronunciation of sounds in connected speech and appropriate use of intonation)',
'I want to give relevant and appropriate answers',
'I want to manage my time efficiently (in Part 2)',
'I want to organise my ideas as I speak',
'I want to use a wide range of grammar and vocabulary (including collocation, phrasal verbs and carrier nouns)',
'I want to use complex sentences and a range functions (e.g. reasons and examples)',
'I want to use ‘fillers’',
'I do not over-generalise',
'I want to develop an argument',
];

$grammar = [
'I want to use verb tenses correctly',
'I want to structure sentences accurately with correct word order',
'I want to form a variety of different question types',
'I want to use modal verbs (can/could/should/would etc.) correctly and understand their function',
'I want to recognise and use passive forms of speech',
'I want to use articles correctly and countable/uncountable nouns',
'I want to use pronouns and possessives effectively',
'I want to use relative pronouns correctly',
'I want to use prepositions of time, place and movement correctly',
'I want to use dependent prepositions for verbs and adjectives correctly',
'I want to use verb patterns (colligation) for my present level correctly',
'I want to use comparative and superlative forms effectively',
'I want to use conditional structures',
'I want to use conjunctions to link and organise information and ideas relevant to my present level of study',
'I want to use correct word formation in sentences',
'I want to use cleft sentences and inversion effectively to add emphasis',
'I want to use participial clauses effectively',
];

$learnerTraining = [
'I want to record and learn new vocabulary',
'I want to improve spelling by discovering patterns',
'I want to use a dictionary effectively',
'I want to understand meta-language and use it to explain grammar points',
'I want to reflect on my progress and am aware of my strengths and weaknesses',
'I want to recognise and use symbols in the International Phonetic Alphabet (IPA)',
'I want to recognise my own learner needs and establish a personal agenda using an Individual Learning Plan (ILP)',
'I want to manage and balance personal and study time',
'I want to use top-down reading/listening skills',
'I want to deal with new words in reading text using top-down and bottom-up skills',
'I want to recognise the meaning and use of prefixes and suffixes in order to deduce meaning of new vocabulary',
'I want to develop my English language skills through extra-curricular reading/listening and self-study',
];
@endphp
<style type="text/css">
	.add-ilp-modal .modal-dialog {
		max-width: 800px;
	}
	.add-ilp-modal .modal-body .sub-skills {
		border-left: 2px solid #d55b7d;
	}
	.add-ilp-modal .modal-body h3 {
		padding-bottom: 1rem;
		margin-bottom: 0rem;
	}
	.sub_skill_area, .selected_sub_skill_area {
		margin-bottom: 2rem;
	}
	.sub_skill_area_list span {
		width: 100%;
		display: inline-block;
		padding: 0 0 0 6px;
		border-bottom: 2px solid #dae1ef;
		font-size: 1rem;
		color: #495057;
		cursor: pointer;
		margin: 0.4rem 0rem 0.4rem 0rem;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		background-image: url("{{ asset('public/images/icon-select-dropdown.svg') }}");
		background-position: calc(100% - 5px) center;
		background-repeat: no-repeat;
		background-size: 11px auto;
	}
	.sub_skill_area_option ul {
		padding: 0 0 0 6px;
		margin: 0;
	}
	.sub_skill_area_option ul li {
		list-style-type: none;
	}
	.sub_skill_area_option ul li label {
		cursor: pointer;
	}
	.selected_sub_skill_area_list {
		margin-top: 1rem;
	}
	.rate_count {
		text-align: center;
		border: 1px solid #ddd;
		border-radius: 10px;
		width: 200px;
		margin: auto;
		padding: 5px 0;
	}
	.rate_count span input {
		width: 40px;
		text-align: center;
		border: none;
		border-bottom: 1px solid #e1a5b6;
	}
	.ilp_footer_btn>.btn {
		font-size: 1rem!important;
	}
	.ilp_footer_btn img {
		width: 18px;
		vertical-align: sub;
	}

	.dropdown-left-open {
		left: auto !important;
		right: 0 !important;
	}
</style>


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
            <div class="custom-control custom-radio">
               <input type="radio" class="custom-control-input" id="student_led" name="led" value="b">
               <label class="custom-control-label" for="student_led">Student Led</label>
            </div>
         </div>
         <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 partA">
            <div class="dropdown-div mt-3">
               <div class="class-dropdown mb-2">
                  <span class="sidefilter-heading d-block sidefilter-heading">Select Date</span>
                  <div class="form-group form-group-iconright">
                     <span class="form-group-icon">
                     <i class="fa-solid fa-calendar-days"></i>
                     </span>
                     <input type="text" class="form-control border-bottom" placeholder="Date" id="ilp_date" autocomplete="off">
                  </div>
               </div>
            </div>
         </div>
         <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-0 partB">
            <div class="filter-action-buttons">
               <div class="ilp-student-options">
                  @if(!empty($student_ilps))
                  <div class="add-ilp-button mx-0 first">
                     <a href="ilps/downloadilps_pdf" class="btn btn-classic"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                  </div>
                  @endif
                  <div class="add-ilp-button mx-0 second">
                     <a href="javascript:void(0);" data-toggle="modal" class="btn btn-classic" onclick="openAddIlp()">
                     <i class="fa fa-plus" aria-hidden="true"></i> Add ILP
                     </a>
                  </div>
               </div>
               @if(!empty($teacher_ilps))
               <div class="add-ilp-button_2 mx-2 first" style="display:none" id="abc">
                  <a href="ilps/downloadilps_pdf" class="btn btn-classic"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
               </div>
               @endif
            </div>
         </div>
         @if(empty($instration['getdocument'] OR $instration['getvideo']))
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
            <button type="button"  class="btn btn-cancel" data-dismiss="modal" id="close_video">Close</button>
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
            @include('profile.menu')
            <!-- /. Management Slider-->
            <div class="p-3">
               <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-4">
                  <div class="row">
                     <div class="col-12 col-sm-7 col-md-6 col-lg-8 col-xl-8 d-none d-sm-block d-xl-none notes-selection">
                        <select class="col-md-6 custom-select2-dropdown-nosearch" id="led_search">
                           <option value="s_led">Student Led</option>
                        </select>
                     </div>
                     <div class="col-12 col-sm-6 col-md-6 col-lg-8 col-xl-8 d-none d-xl-block">
                        <ul class="nav nav-pills nav-pills_switch clickled" id="pills-tab" role="tablist">
                           <li class="nav-item mr-2">
                              <a class="nav-link stu active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" id-data="stu">Student Led</a>
                           </li>
                        </ul>
                     </div>
                     <div class="col-6 d-sm-none">
                        <h6 id="getFirstClassName"></h6>
                     </div>
                     <div class="col-6 col-sm-5 col-md-6 col-lg-4 col-xl-4">
                        <div class="row">
                           <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10 common-search">
                              <div class="search-form ilp-search">
                                 <div class="form-group mb-0">
                                    <input type="search search_box" class="form-control form-control-lg search_work_record newsearch s0" placeholder="Search" id="student_led1" aria-label="Search">
                                    <span class="icon-search">
                                    <img src="https://teacher.englishapp.uk/public/teacher/images/icon-search-pink.svg" alt="Search" class="img-fluid">
                                    </span>
                                 </div>
                              </div>
                              <div class="search-form ilp-search" style="display:none" id="teacher_led1">
                                 <div class="form-group mb-0">
                                    <input type="search search_box" class="form-control form-control-lg search_work_record newsearch s1" placeholder="Search" id="search_val" aria-label="Search">
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
            </div>
            <div class="main__content ieuk-ilpm pt-3">
               <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" >
                     <div class="table-responsive p-1 p-md-0">
                        <table class="table work-record__table ieuktable-sline table1" id="student-led">
                           <thead class="thead-dark">
                              <tr>
                                 <th scope="col" width="12%">Date</th>
                                 <th scope="col" width="20%">What did you do?</th>
                                 <th scope="col" width="24%">How did this help you?</th>
                                 <th scope="col" width="24%">Comments</th>
                                 <th scope="col" width="20%">Action</th>
                              </tr>
                           </thead>
                           <?php //dd($student_ilps)?>
                           <tbody>
                            <?php 
                                foreach($student_ilps as $student_ilp)
                                { ?>
                              <tr>
                                 <td scope="row"><span title="Date"></span><?php echo date("d-m-Y",strtotime($student_ilp['record_date']));?></td>
                                 <td class="ieuk-ilp-hsf"><span title="What did you do?"></span><?php echo $student_ilp['what_did_you_do'];?></td>
                                 <td class="ieuk-ilp-hsf"><span title="How did this help you?"></span><?php echo $student_ilp['how_did_this_help'];?></td>
                                 <td class="ieuk-ilp-hsf"><span title="Comments"></span><?php echo $student_ilp['comments'];?></td>
                                 <td class="ieuk-ilp-acn">
                                    <a href="" data-toggle="modal" data-course-id="{{$student_ilp['course_id']}}" data-leval-id="{{$student_ilp['level_id']}}"id="popupEdit" class="popupEdit"  data-id="{{$student_ilp['id']}}" data-skillArea = "{{$student_ilp['skill_area']}}"  data-ques1 = "{{$student_ilp['what_did_you_do']}}" data-ques2 = "{{$student_ilp['how_did_this_help']}}" data-comments = "{{$student_ilp['comments']}}" data-score = "{{$student_ilp['score']}}"data-del="ed" >
                                    <img src="{{ asset('public/images/icon-table-edit.png') }}" alt="Edit" class="img-fluid" width="21px">
                                    </a>
                                    <a href="" class="deleteIlp" data-id="{{$student_ilp['id']}}" data-course-delete-id="{{$student_ilp['course_id']}}" data-leval-delete-id="{{$student_ilp['level_id']}}"   data-skillArea = "{{$student_ilp['skill_area']}}"  data-ques1 = "{{$student_ilp['what_did_you_do']}}" data-ques2 = "{{$student_ilp['how_did_this_help']}}" data-comments = "{{$student_ilp['comments']}}" data-score = "{{$student_ilp['score']}}" data-del="del" >
                                    <img src="{{ asset('public/images/icon-trash.png') }}" alt="Delete" class="img-fluid" width="21px">
                                    </a>
                                    <a href="javascript:void(0)" class="ieuk-ilp-hsb on"><img src="{{ asset('public/images/down-arrow.png') }}" alt="hide-show" class="img-fluid" width="20px"></a>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                     <div class=" w-100 norecorddata">
                        <div class="main__content" id="image_class1" style="display: none;">
                           <div class="row text-center">
                              <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                                 <img src="{{ asset('public/images/no_record_found.gif') }}" width="100%">
                                 <p style="font-weight: 600;font-size: 20px;margin-left: 25px;">No Records Found</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- tab 1-->
               </div>
            </div>
         </section>
      </div>
   </div>
</main>
<!-- teacher model view -->
<div class="modal fade" id="edit-ilp-modal" tabindex="-1" role="dialog" aria-labelledby="edit-ilp-modalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header deleteIlp">
            <h3 style="text-align: center;margin-bottom: 18px;">Are you sure want to delete?</h3>
         </div>
         <div class="modal-header flex-wrap addEditIlp">
            <div class="modal-header-top d-flex flex-wrap justify-content-between align-items-center w-100">
               <h4 class="modal-title" id="view-ilp-modalLabel">
                  <i class="fa-solid fa-brain"></i>Individual Learning Plan (teacher)
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <!-- /. Modal Header top-->
            <!-- /. Alert-->
         </div>
         <div class="modal-body addEditIlp">
            <div class="modal-selectors w-100">
               <p class="mb-2" style="border-color:#f5f5f5;color:#d55b7d;font-size:.875rem;">Every student has an Individual Learning Plan. In this plan you decide what you need to focus on and how you can do this. This plan should be reviewed every 6 weeks and be discussed during tutorials.</p>
               <div class="row mr-n1 ml-n1">
                  <div class="col-12 col-sm-6 col-md-3 p-1 select-date">
                     <div class="form-group form-group-iconright">
                        <h6>Select Date</h6>
                        <span class="form-group-icon">
                        <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <input type="text" class="form-control form-control-sm current_date_new"  name="current_date_new" id="current_date_new" disabled="">
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-3 p-1 form-group">
                     <h6>Select class</h6>
                     <input type="text" class="form-control form-control-sm" value="" disabled="" name="class_name" id="class_name">
                  </div>
                  <div class="col-12 col-sm-6 col-md-3 p-1 form-group">
                     <h6>Select student</h6>
                     <input type="text" class="form-control form-control-sm" value="{{$stdtname}}" disabled="" id="student_name">
                  </div>
                  <div class="col-12 col-sm-6 col-md-3 p-1 form-group">
                     <h6>Learning Style</h6>
                     <input type="text" class="form-control form-control-sm hasDatepicker" value="" disabled="" id="learning_style">
                  </div>
               </div>
            </div>
            <h6>Useful ways to study</h6>
            <div class="form-group form-group_underline">
               <!-- <input type="text" class="form-control form-control-sm form-control_underline" value="" name="useful_ways_add" id="useful_ways_add" disabled=""> -->
               <textarea class="form-control form-control-sm form-control_underline" value="" name="useful_ways_add" id="useful_ways_add" disabled=""></textarea>
            </div>
            <h6>Strengths</h6>
            <div class="form-group form-group_underline">
               <textarea class="form-control form-control-sm form-control_underline" value="" name="strengths_add" id="strengths_add" disabled=""></textarea>
               <!-- <input type="text" class="form-control form-control-sm form-control_underline" value="" name="strengths_add" id="strengths_add" disabled=""> -->
            </div>
            <h6>Weaknesses</h6>
            <div class="form-group form-group_underline">
               <textarea class="form-control form-control-sm form-control_underline" value="" name="weakness_add" id="weakness_add" disabled=""></textarea>
               <!-- <input type="text" class="form-control form-control-sm form-control_underline" value="" name="weakness_add" id="weakness_add" disabled=""> -->
            </div>
            <h6>End of course target</h6>
            <div class="form-group form-group_underline mb-0">
               <textarea  class="form-control form-control-sm form-control_underline" value="" name="end_target_add" id="end_target_add" disabled=""></textarea>
               <!-- <input type="text" class="form-control form-control-sm form-control_underline" value="" name="end_target_add" id="end_target_add" disabled=""> -->
            </div>
            <div style="text-align: center;">
               <span class="lerning_error" style="display: none;color:red;">Complate the pen profile for selected student.</span>
            </div>
         </div>
         <div class="modal-footer justify-content-center">
            <div class="success_alert text-center alert alert-success" style="display:none;">
               <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  <i class="fa-regular fa-circle-check"></i>
               </div>
            </div>
            <div class="error_alert text-center alert alert-danger" style="display:none;">
               <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  <i class="fa fa-circle-exclamation"></i>
               </div>
            </div>
            <button type="button" class="btn btn-danger" id="update_teacher_ilp_btn"><i class="fa-regular fa-floppy-disk"></i> Update</button>
            <button type="button" class="btn  btn-cancel" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
</div>

<!-- add and update modal -->
<form id = "add_ilp_form" class = "add_ilp_form" name = "add_ilp_form" method = "post">
   <input type="hidden" name="ilp_id" class="ilp_id_form" id="ilp_id_form">
   <input type="hidden" name="deleteilpFlag" class="deleteilpFlag" id="deleteilpFlag">
   <div class="modal fade add-ilp-modal" id="add-edit-ilp-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header alsoremove">
               <h5 class="modal-title" id="exampleModalLongTitle">
                  <i class="fa-solid fa-brain"></i>
                  Individual Learning Plan
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div id="edit">
               <div class="modal-body">
                  <p class="mb-2">
                     The Imperial English Model promotes learner independence & respects learner voice. You should
                     record all self-study activities you have done & comment on how they help you here.
                  </p>
                  <div class="row">
	                  <div class="form-group-checkbox col-lg-6">
	                     <select class="form-control form-control-sm peer_course_id" id="course_id" name="course_id">
	                        <option value="" required>Select Course</option>
	                     </select>
	                  </div>
	                  <div class="form-group-checkbox col-lg-6">
	                     <select class="form-control form-control-sm peer_course_id" id="level_id" name="level_id">
	                     	<option value="" required>Please Select level</option>
	                     	@foreach($onlyCourse as $key=> $data)
		                        <option value="{{$data['level']['_id']}}">{{$data['level']['leveltitle']}}</option>
		                    @endforeach
	                     </select>
	                  </div>
	                 </div>
                  <h3><b>Skill Area</b></h3>
                  <div class="form-group-checkbox">
                     @foreach($skills as $key => $value)
                     <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input skill-chechbox ilpcheckbox {{strtolower(str_replace(' ','',$value))}}" id="ilpCheckbox[{{$key}}]" data-skill="{{strtolower(str_replace(' ','',$value))}}" value="{{$value}}" name="ilpCheckbox[{{$key}}]" >
                        <label class="form-check-label" for="ilpCheckbox[{{$key}}]">{{$value}}</label>
                     </div>
                     @endforeach
                  </div>
                  <div class="sub_skill_area collapse" id="sub_skill_area">
                     <h3><b>Sub Skill Area</b></h3>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_reading">
                        <span id="sub_skill_reading" class="sub_skill_options" data-option="reading">Reading</span>
                        <div class="sub_skill_area_option collapse sub_skill_reading" data-skill="reading">
                           <ul>
                              @foreach($reading as $key => $value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_reading[]" name="skill_reading[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-reading" type="checkbox" id="skill_reading[{{$key}}]" name="skill_reading[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_reading[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_writing">
                        <span id="sub_skill_writing" class="sub_skill_options" data-option="writing">Writing</span>
                        <div class="sub_skill_area_option collapse sub_skill_writing" data-skill="writing" >
                           <ul>
                              @foreach($writing as $key => $value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_writing[{{$key}}]" name="skill_writing[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-writing" type="checkbox" id="skill_writing[{{$key}}]" name="skill_writing[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_writing[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_listening">
                        <span id="sub_skill_listening" class="sub_skill_options" data-option="listening">Listening</span>
                        <div class="sub_skill_area_option collapse sub_skill_listening" data-skill="listening">
                           <ul>
                              @foreach($listening as $key=>$value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_listening[{{$key}}]" name="skill_listening[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-listening" type="checkbox" id="skill_listening[{{$key}}]" name="skill_listening[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_listening[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_speaking">
                        <span id="sub_skill_speaking"  class="sub_skill_options" data-option="speaking">Speaking</span>
                        <div class="sub_skill_area_option collapse sub_skill_speaking" data-skill="speaking">
                           <ul>
                              @foreach($speaking as $key => $value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_speaking[{{$key}}]" name="skill_speaking[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-speaking" type="checkbox" id="skill_speaking[{{$key}}]" name="skill_speaking[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_speaking[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_grammar">
                        <span id="sub_skill_grammar" class="sub_skill_options" data-option="grammar">Grammar</span>
                        <div class="sub_skill_area_option collapse sub_skill_grammar" data-skill="grammar">
                           <ul>
                              @foreach($grammar as $key => $value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_grammar[{{$key}}]" name="skill_grammar[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-grammar" type="checkbox" id="skill_grammar[{{$key}}]" name="skill_grammar[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_grammar[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_vocabulary">
                        <span id="sub_skill_vocabulary" class="sub_skill_options" data-option="vocabulary">Vocabulary</span>
                        <div class="sub_skill_area_option collapse sub_skill_vocabulary" data-skill="vocabulary">
                           <ul>
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_vocabulary[0]" name="skill_vocabulary[0]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-vocabulary" type="checkbox" id="skill_vocabulary[0]" name="skill_vocabulary[0]" value="true" data="1">
                                    <label class="form-check-label" for="skill_vocabulary_1">There are no sub-skills available for this section. Please select this option and continue to complete the ILP.</label>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="sub_skill_area_list collapse" id="sub_skill_area_list_learnertraining">
                        <span id="sub_skill_learnertraining" class="sub_skill_options" data-option="learnertraining" >Learner Training</span>
                        <div class="sub_skill_area_option collapse sub_skill_learnertraining" data-skill="learnertraining">
                           <ul>
                              @foreach($learnerTraining as $key => $value)
                              <li>
                                 <div class="form-check">
                                    <input type="hidden" id="skill_learnertraining[{{$key}}]" name="skill_learnertraining[{{$key}}]" value="false">
                                    <input class="form-check-input sub-skill-chechbox sub-skill-check-learnertraining" type="checkbox" id="skill_learnertraining[{{$key}}]" name="skill_learnertraining[{{$key}}]" value="true" data="{{$key+1}}">
                                    <label class="form-check-label" for="skill_learnertraining[{{$key}}]">{{$value}}</label>
                                 </div>
                              </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="selected_sub_skill_area collapse">
                     <h3><b>Selected Sub Skill Area</b></h3>
                     <div class="collapse" id="selected_sub_skill_area_list_reading">
                        <h4>Reading</h4>
                        <div class="sub-skills">
                           <p class="skill_reading_1 collapse">I want to read to understanding the overall meaning of a text (Gist)</p>
                           <p class="skill_reading_2 collapse">I want to read for specific information in a text (Detail)</p>
                           <p class="skill_reading_3 collapse">I want to scan a text (Reading quickly through a text to look for keywords)</p>
                           <p class="skill_reading_4 collapse">I want to skim a text (Reading quickly through a text to get the writer’s main ideas)</p>
                           <p class="skill_reading_5 collapse">I read alone for personal enjoyment or for information</p>
                           <p class="skill_reading_6 collapse">I want to predict the general content and ideas contained in a text by using vocabulary clues</p>
                           <p class="skill_reading_7 collapse">I want to understand words and identify their grammatical function</p>
                           <p class="skill_reading_8 collapse">I want to recognise and name features of grammar</p>
                           <p class="skill_reading_9 collapse">I want to understand different types of text and identify the purpose</p>
                           <p class="skill_reading_10 collapse">I want to identify how a text is organised (e.g. problem-solution-evaluation, thesis-led, etc)</p>
                           <p class="skill_reading_11 collapse">I want to identify the writer's attitude</p>
                           <p class="skill_reading_12 collapse">I want to follow the development of an argument</p>
                           <p class="skill_reading_13 collapse">I want to follow the sequence of a narrative</p>
                           <p class="skill_reading_14 collapse">I want to read and paraphrase a text</p>
                           <p class="skill_reading_15 collapse">I want to distinguish factual information from opinions</p>
                           <p class="skill_reading_16 collapse">I want to understand and analyse the questions and instructions</p>
                           <p class="skill_reading_17 collapse">I want to use the questions to analyse the text</p>
                           <p class="skill_reading_18 collapse">I want to identify the organised text (e.g. Problem-solution-.evaluation, narrative, thesis-led, for and against) and move around a text with ease</p>
                           <p class="skill_reading_19 collapse">I leave questions I want to do and come back again</p>
                           <p class="skill_reading_20 collapse">I want to read fast and accurately</p>
                           <p class="skill_reading_21 collapse">I want to skim the text</p>
                           <p class="skill_reading_22 collapse">I want to scan the text</p>
                           <p class="skill_reading_23 collapse">I want to ignore words I don’t know</p>
                           <p class="skill_reading_24 collapse">I want to use prefixes and suffixes , plus grammar knowledge to make a guess at the meaning of unknown words</p>
                           <p class="skill_reading_25 collapse">I want to manage my time effectively</p>
                           <p class="skill_reading_26 collapse">I want to use techniques for multiple choice questions</p>
                           <p class="skill_reading_27 collapse">I want to use techniques for headings questions</p>
                           <p class="skill_reading_28 collapse">I want to use techniques for matching questions</p>
                           <p class="skill_reading_29 collapse">I want to use techniques for sentence completion questions</p>
                           <p class="skill_reading_30 collapse">I want to use techniques for gap-fill questions</p>
                           <p class="skill_reading_31 collapse">I want to use techniques for True, False, Not Given questions and Yes, No, Not Given questions</p>
                           <p class="skill_reading_32 collapse">I want to use techniques for completing tables and labelling diagrams</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_writing">
                        <h4>Writing</h4>
                        <div class="sub-skills">
                           <p class="skill_writing_1 collapse">I want to spell common words correctly</p>
                           <p class="skill_writing_2 collapse">I want to write clearly. (I leave spaces between words/it is easy for people to recognise my letters/I write on the line)</p>
                           <p class="skill_writing_3 collapse">I want to use punctuation correctly.</p>
                           <p class="skill_writing_4 collapse">I want to write by using the appropriate text type (for example, e-mail/letter/ note/ notice/report/essay)</p>
                           <p class="skill_writing_5 collapse">I want to use the appropriate vocabulary to write about a variety of topics and situations</p>
                           <p class="skill_writing_6 collapse">I want to write grammatically correct sentences (for my level of study).</p>
                           <p class="skill_writing_7 collapse">I want to connect my sentences and ideas with conjunctions and text-referencing words</p>
                           <p class="skill_writing_8 collapse">I want to write in logical paragraphs (with a topic sentences)</p>
                           <p class="skill_writing_9 collapse">I want to write a summary of a text</p>
                           <p class="skill_writing_10 collapse">I want to write a description of a process, using appropriate grammar, vocabulary and linking words</p>
                           <p class="skill_writing_11 collapse">I want to write about what happened in the past (for example in a diary or select writing story</p>
                           <p class="skill_writing_12 collapse">I want to write a for and against discussion essay</p>
                           <p class="skill_writing_13 collapse">I want to write a critical review (of a book, a film, a restaurant, etc)</p>
                           <p class="skill_writing_14 collapse">I want to skim and understand the diagram and data/diagram/map effectively</p>
                           <p class="skill_writing_15 collapse">I want to plan my answer</p>
                           <p class="skill_writing_16 collapse">I want to paraphrase the question</p>
                           <p class="skill_writing_17 collapse">I want to summarise the information, highlight main features, support with specific data and make comparisons where relevant</p>
                           <p class="skill_writing_18 collapse">I want to organise my writing and use paragraphs</p>
                           <p class="skill_writing_19 collapse">I want to write at least 150 words</p>
                           <p class="skill_writing_20 collapse">I want to use a wide range of grammar and vocabulary</p>
                           <p class="skill_writing_21 collapse">I want to look back at what I have written as I write</p>
                           <p class="skill_writing_22 collapse">I want to check for mistakes effectively: spelling, grammar, prepositions, collocation, singular/plural, tenses, countable/uncountable nouns and my common mistakes</p>
                           <p class="skill_writing_23 collapse">I want to analyse the question</p>
                           <p class="skill_writing_24 collapse">I want to plan my answer</p>
                           <p class="skill_writing_25 collapse">I want to paraphrase the question and write a thesis statement in the introduction</p>
                           <p class="skill_writing_26 collapse">I want to manage my time efficiently</p>
                           <p class="skill_writing_27 collapse">I want to write at least 250 words</p>
                           <p class="skill_writing_28 collapse">I want to organise my writing and use paragraphs</p>
                           <p class="skill_writing_29 collapse">I want to write complex sentences and a range of functions (e.g. cause and effect)</p>
                           <p class="skill_writing_30 collapse">I want to use a wide range of grammar and vocabulary</p>
                           <p class="skill_writing_31 collapse">do not over-generalise</p>
                           <p class="skill_writing_32 collapse">I want to use appropriate conjunctions, text-referencing words and carrier nouns</p>
                           <p class="skill_writing_33 collapse">I want to give reasons and relevant examples</p>
                           <p class="skill_writing_34 collapse">I want to look back at what I have written as I write</p>
                           <p class="skill_writing_35 collapse">I want to check for mistakes effectively: spelling, grammar, prepositions, collocation, singular/plural, tenses, countable/uncountable nouns and my common mistakes</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_listening">
                        <h4>Listening</h4>
                        <div class="sub-skills">
                           <p class="skill_listening_1 collapse">I want to interpret the attitude of a speaker through language used and intonation patterns</p>
                           <p class="skill_listening_2 collapse">I want to listen for the overall meaning of a text (Gist)</p>
                           <p class="skill_listening_3 collapse">I want to listen for specific information in a text (Detail)</p>
                           <p class="skill_listening_4 collapse">I want to understand the main points in a presentation</p>
                           <p class="skill_listening_5 collapse">I want to understand and follow the main points of an argument</p>
                           <p class="skill_listening_6 collapse">I want to follow and identify the main points of a presentation or lecture and make appropriate notes</p>
                           <p class="skill_listening_7 collapse">I want to recognise devices to signal a change in topic or direction of conversation</p>
                           <p class="skill_listening_8 collapse">I want to follow a conversation between two native speakers</p>
                           <p class="skill_listening_9 collapse">I want to listen to and take out the main points of information from a news item</p>
                           <p class="skill_listening_10 collapse">Can follow a group discussion and take out the main points and opinions</p>
                           <p class="skill_listening_11 collapse">I want to discriminate between individual sounds to identify and spell words</p>
                           <p class="skill_listening_12 collapse">I want to recognise phonetic symbols</p>
                           <p class="skill_listening_13 collapse">I want to listen, read and write at the same time</p>
                           <p class="skill_listening_14 collapse">I want to check the grammar of questions and predict the answer</p>
                           <p class="skill_listening_15 collapse">know how to deal with all the types of questions (see IELTS Reading Skills)</p>
                           <p class="skill_listening_16 collapse">I want to concentrate all the time (I I want to ‘listen’ , not just ‘hear’)</p>
                           <p class="skill_listening_17 collapse">I want to follow dialogues</p>
                           <p class="skill_listening_18 collapse">I want to follow monologues</p>
                           <p class="skill_listening_19 collapse">I want to ignore words I don’t know</p>
                           <p class="skill_listening_20 collapse">I want to listen for synonyms for words in the question</p>
                           <p class="skill_listening_21 collapse">I want to manage my time effectively</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_speaking">
                        <h4>Speaking</h4>
                        <div class="sub-skills">
                           <p class="skill_speaking_1 collapse">I want to take turns when speaking by recognising intonation patterns</p>
                           <p class="skill_speaking_2 collapse">I want to use appropriate language in different situations (Register and formality)</p>
                           <p class="skill_speaking_3 collapse">I want to contribute effectively to a group discussion</p>
                           <p class="skill_speaking_4 collapse">I want to extend spoken responses and give additional information</p>
                           <p class="skill_speaking_5 collapse">I want to give a presentation on a range of different subjects</p>
                           <p class="skill_speaking_6 collapse">I want to answer questions and give appropriate responses</p>
                           <p class="skill_speaking_7 collapse">I want to use a range of linking words to mark the relationship between ideas</p>
                           <p class="skill_speaking_8 collapse">I want to paraphrase and cover for gaps in vocabulary knowledge</p>
                           <p class="skill_speaking_9 collapse">I want to support an argument with relevant examples and evidence</p>
                           <p class="skill_speaking_10 collapse">I want to narrate a story or past experience in detail</p>
                           <p class="skill_speaking_11 collapse">I want to invite discussion by asking others to contribute and checking their understanding</p>
                           <p class="skill_speaking_12 collapse">I want to sound ‘friendly’ and interested in other speakers by using appropriate intonation</p>
                           <p class="skill_speaking_13 collapse">I want to pronounce individual words correctly and can use correct word stress</p>
                           <p class="skill_speaking_14 collapse">I want to pronounce words in connected speech (sentences) correctly by using contractions and sentence stress</p>
                           <p class="skill_speaking_15 collapse">I want to respond by using different, but appropriate, vocabulary and collocation to the other speakers</p>
                           <p class="skill_speaking_16 collapse">I want to speak fluently</p>
                           <p class="skill_speaking_17 collapse">I want to speak accurately and clearly (accurate grammar, appropriate vocabulary, accurate pronunciation of sounds in connected speech and appropriate use of intonation)</p>
                           <p class="skill_speaking_18 collapse">I want to give relevant and appropriate answers</p>
                           <p class="skill_speaking_19 collapse">I want to manage my time efficiently (in Part 2)</p>
                           <p class="skill_speaking_20 collapse">I want to organise my ideas as I speak</p>
                           <p class="skill_speaking_21 collapse">I want to use a wide range of grammar and vocabulary (including collocation, phrasal verbs and carrier nouns)</p>
                           <p class="skill_speaking_22 collapse">I want to use complex sentences and a range functions (e.g. reasons and examples)</p>
                           <p class="skill_speaking_23 collapse">I want to use ‘fillers’</p>
                           <p class="skill_speaking_24 collapse">do not over-generalise</p>
                           <p class="skill_speaking_25 collapse">I want to develop an argument</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_grammar">
                        <h4>Grammar</h4>
                        <div class="sub-skills">
                           <p class="skill_grammar_1 collapse">I want to use verb tenses correctly</p>
                           <p class="skill_grammar_2 collapse">I want to structure sentences accurately with correct word order</p>
                           <p class="skill_grammar_3 collapse">I want to form a variety of different question types</p>
                           <p class="skill_grammar_4 collapse">I want to use modal verbs (can/could/should/would etc.) correctly and understand their function</p>
                           <p class="skill_grammar_5 collapse">I want to recognise and use passive forms of speech</p>
                           <p class="skill_grammar_6 collapse">I want to use articles correctly and countable/uncountable nouns</p>
                           <p class="skill_grammar_7 collapse">I want to use pronouns and possessives effectively</p>
                           <p class="skill_grammar_8 collapse">I want to use relative pronouns correctly</p>
                           <p class="skill_grammar_9 collapse">I want to use prepositions of time, place and movement correctly</p>
                           <p class="skill_grammar_10 collapse">I want to use dependent prepositions for verbs and adjectives correctly</p>
                           <p class="skill_grammar_11 collapse">I want to use verb patterns (colligation) for my present level correctly</p>
                           <p class="skill_grammar_12 collapse">I want to use comparative and superlative forms effectively</p>
                           <p class="skill_grammar_13 collapse">I want to use conditional structures</p>
                           <p class="skill_grammar_14 collapse">I want to use conjunctions to link and organise information and ideas relevant to my present level of study</p>
                           <p class="skill_grammar_15 collapse">I want to use correct word formation in sentences</p>
                           <p class="skill_grammar_16 collapse">I want to use cleft sentences and inversion effectively to add emphasis.</p>
                           <p class="skill_grammar_17 collapse">I want to use participial clauses effectively</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_vocabulary">
                        <h4>Vocabulary</h4>
                        <div class="sub-skills">
                           <p class="skill_vocabulary_1 collapse">There are no sub-skills available for this section. Please select this option and continue to complete the ILP.</p>
                        </div>
                     </div>
                     <div class="collapse" id="selected_sub_skill_area_list_learnertraining">
                        <h4>Learner Training</h4>
                        <div class="sub-skills">
                           <p class="skill_learnertraining_1 collapse">I want to record and learn new vocabulary</p>
                           <p class="skill_learnertraining_2 collapse">I want to improve spelling by discovering patterns</p>
                           <p class="skill_learnertraining_3 collapse">I want to use a dictionary effectively</p>
                           <p class="skill_learnertraining_4 collapse">I want to understand meta-language and use it to explain grammar points</p>
                           <p class="skill_learnertraining_5 collapse">I want to reflect on my progress and am aware of my strengths and weaknesses</p>
                           <p class="skill_learnertraining_6 collapse">I want to recognise and use symbols in the International Phonetic Alphabet (IPA)</p>
                           <p class="skill_learnertraining_7 collapse">I want to recognise my own learner needs and establish a personal agenda using an Individual Learning Plan (ILP)</p>
                           <p class="skill_learnertraining_8 collapse">I want to manage and balance personal and study time</p>
                           <p class="skill_learnertraining_9 collapse">I want to use top-down reading/listening skills</p>
                           <p class="skill_learnertraining_10 collapse">I want to deal with new words in reading text using top-down and bottom-up skills</p>
                           <p class="skill_learnertraining_11 collapse">I want to recognise the meaning and use of prefixes and suffixes in order to deduce meaning of new vocabulary</p>
                           <p class="skill_learnertraining_12 collapse">I want to develop my English language skills through extra-curricular reading/listening and self-study</p>
                        </div>
                     </div>
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="skill_error"></span>
                  </div>
                  <h3><b>What did you do? (Materials used - book/article/DVD/Website Details)</b></h3>
                  <div class="form-group">
                     <!-- <input type="text" class="form-control" name = "What_did_you_do" id = "What_did_you_do" placeholder="write here..."> -->
                     <textarea class="form-control" name = "What_did_you_do" id = "What_did_you_do" onkeyup="textAreaAdjust(this)" placeholder="write here..."></textarea>
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="what_did_you_help"></span>
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="course_e"></span>
                  </div>
                  <h3><b>How did this help you?</b></h3>
                  <div class="form-group">
                     <!-- <input type="text" class="form-control" name = "How_did_this_help_you" id = "How_did_this_help_you" placeholder="write here..."> -->
                     <textarea class="form-control" name = "How_did_this_help_you" id = "How_did_this_help_you" onkeyup="textAreaAdjust(this)" placeholder="write here..."></textarea>
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="how_did_this_help"></span>
                  </div>
                  <h3><b>Comments</b></h3>
                  <div class="form-group">
                     <textarea class="form-control" name = "comments" id = "comments" onkeyup="textAreaAdjust(this)"  placeholder="write here..."></textarea>
                     <!-- <input type="text" class="form-control" name = "comments" id = "comments" placeholder="write here..."> -->
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="comments_error"></span>
                  </div>
                  <div class="rate_count">
                     <p><b>Rate Your ILP</b></p>
                     <span><input type="text" name = "ilp_rate" id = "ilp_rate" max="10" maxlength="2" onkeypress="return isNumber(event)"> / 10</span>
                  </div>
                  <div class="form-group-checkbox" style="text-align: center;">
                     <span id="ilp_rate_error"></span>
                  </div>
               </div>
            </div>
            <div id="delete">
               <div class="modal-header justify-content-center">
                  <h5 class="modal-title" id="erasemodalLongTitle">Delete Record</h5>
               </div>
               <input type="hidden" name="del_rec1" id="del_rec1" value="">
               <div class="modal-body text-center m-5">
                  <p style="color: #30475e;font-size: 1rem;margin: 0;">Are you sure you want to delete ?</p>
               </div>
            </div>
            <div class="modal-footer justify-content-center ilp_footer_btn">
               <div class="success_alert text-center alert alert-success" style="display:none;">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                     <i class="fa-regular fa-circle-check"></i>
                  </div>
               </div>
               <div class="error_alert text-center alert alert-danger" style="display:none;">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                     <i class="fa fa-circle-exclamation"></i>
                  </div>
               </div>
               <button type="button" class="btn  btn-primary" id="add_ilp_btn"> 
               <i class="fa-regular fa-floppy-disk"></i>
               <span class="savetext">Save</span>
               </button>
               <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</form>

<!--Delete Modal-->
<div class="modal fade" id="delete-ilp-modal" tabindex="-1" role="dialog" aria-labelledby="erasemodalLongTitle">
   <div class="modal-dialog erase-modal modal-dialog-centered" role="document">
      <div class="modal-content">
         <form class="delete_ilp_form"  method="post">
            <input type="hidden" name="id" class="ilp_id">
            <input type="hidden" name="is_delete" value="1">
            <div class="modal-header justify-content-center">
               <h5 class="modal-title" id="erasemodalLongTitle">Delete Record</h5>
            </div>
            <div class="modal-body">
               <p>Are you sure you want to delete ?</p>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="submit" class="btn btn-primary reset-answer" data-dismiss="modal">Yes</button>
               <button type="button" class="btn btn-cancel" data-dismiss="modal" id="no">Cancel</button>
            </div>
         </form>
      </div>
   </div>
</div>


<script>
function resetcourse(){
	let options = '<option value="" style="">Please Select course</option>';
	$('#course_id').html(options);
}
$(document).ready(function() {
	var coursedata = <?php echo json_encode($newArray)?>;
	let options = '<option value="" style="">Please Select course</option>';
	coursedata.forEach(function(course,index){
		options += '<option value="'+course.course_id+'" style="">'+course.course_name+'</option>';
	});
	resetcourse();
	$('#course_id').html(options);
  	$('#course_id').on('change',function(){
  		var value = $(this).val();
    	let options = '<option value="" style="">Please Select level</option>';
    	coursedata.forEach(function(leval,index){
    		 if(value == leval.levals.courseid){
    			options += '<option value="'+leval.levals.levalid+'" style="">'+leval.levals.levalname+'</option>'; 	
    		 }
    	});
    	$('#level_id').html(options);
    });
});
</script>

<!-- script code -->

<script type="text/javascript">
	$('#ilp_date').datepicker({
		dateFormat: 'dd-mm-yy'
	});
	$('#ilp_date').change(function(){
	    table1.search($(this).val() ).draw();
	});
	$('#ilp_date').change(function(){
	    table2.search($(this).val() ).draw();
	});
</script>

<script>
var editFlag = false;
function openAddIlp(){
	resetdata();
	editFlag = false;
	$('.ilp_id_form').val("");
	$('#ilp_rate').val("");
	$('#course_id').val("");
	$('#level_id').val("");
	$('#add-edit-ilp-modal').modal("show")
   $('#course_id').css({"pointer-events":"auto"})
   $('#level_id').css({"pointer-events":"auto"})

}

function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function resetdata(){
	$('.sub-skills .collapse').each(function(){
		$(this).fadeOut();	
	})
	$('#deleteilpFlag').val("")
	$('#edit').css("display","block")
	$('.alsoremove').css("display","block")
	$('#delete').css("display","none")
	$("#add_ilp_btn .fa-floppy-disk").show();
	$('.savetext').text("Save")
	$('#What_did_you_do').val("")
	$('#How_did_this_help_you').val("")
	$('#comments').val("")
	$('.add_ilp_form').find('.form-check-input').prop("checked",false)
	$('.sub_skill_area').fadeOut()
	$('.sub_skill_area_list').fadeOut()
	$('.selected_sub_skill_area').fadeOut()
	$('#selected_sub_skill_area_list_reading').fadeOut()
	$('#selected_sub_skill_area_list_writing').fadeOut()
	$('#selected_sub_skill_area_list_listening').fadeOut()
	$('#selected_sub_skill_area_list_speaking').fadeOut()
	$('#selected_sub_skill_area_list_grammar').fadeOut()
	$('#selected_sub_skill_area_list_vocabulary').fadeOut()
	$('#selected_sub_skill_area_list_learnertraining').fadeOut()
}

$(document).ready(function(){
	$('.openmodel').click(function(){
	var lerining = $(this).attr("data-lerining")
	var next = $(this).attr("data-next")
	var current_date = $(this).attr("data-current_date")
	var usefull = $(this).attr("data-usefull")
	var strengths = $(this).attr("data-strengths")
	var weakness = $(this).attr("data-weakness")
	var end_target = $(this).attr("data-end_target")
	var learning_style = $(this).attr("data-end_target")
	var classname = $(this).attr("data-classname")
	//alert(classname);
	$('#useful_ways_add').val(usefull)
	$('#strengths_add').val(strengths)
	$('#weakness_add').val(weakness)
	$('#end_target_add').val(end_target)
	$('#current_date_new').val(current_date)
	$('#learning_style').val(lerining)
	$('#class_name').val(classname)
	// alert(lerining)
	$('.deleteIlp').css("display","none")
	$('#update_teacher_ilp_btn').css("display","none")
	$('#edit-ilp-modal').modal("show")
	});

	jQuery('#ilp_rate').keyup(function () { 
	if($(this).val()>10){
		$(this).val("")
	}
	});


	$(".sub_skill_options").click(function(){
	var option = $(this).attr('data-option')
	$(".sub_skill_"+option).slideToggle();
	});

	jQuery("#add_ilp_btn").click(function(){
	var inc = 0;
	var finalArray = {}
	$('.ilpcheckbox').each(function(){
		if($(this).is(":checked")){
			var keyname = $(this).val();
			var string = $(this).attr("data-skill").toLowerCase();
			inc++;
			var totalData = 0;
			$('.sub_skill_'+string+' .sub-skill-check-'+string ).each(function(){
				if($(this).is(":checked")) {
					totalData++;
				}
				finalArray[keyname] = totalData;
			});
		}
	});
	
	var submitFlag = true;
	var checksum = $("#del_rec1").val();
	if(checksum !== 'del'){
		if($("#course_id").val() == ""){
			$('#skill_error').fadeIn();
			$('#skill_error').css("color","red");
			$('#skill_error').css("text-align","center");
			$('#skill_error').text("Please select course");
			submitFlag = false;
			return false
		}else{
			$('#skill_error').fadeOut();
		}

		if($("#level_id").val() == ""){
			$('#skill_error').fadeIn();
			$('#skill_error').css("color","red");
			$('#skill_error').css("text-align","center");
			$('#skill_error').text("Please select level");
			submitFlag = false;
			return false
		}else{
			$('#skill_error').fadeOut();
		}

		if(inc == 0){
			$('#skill_error').fadeIn();
			$('#skill_error').css("color","red");
			$('#skill_error').css("text-align","center");
			$('#skill_error').text("Please select Skill Area");
			submitFlag = false;
			return false
		}else{
			$('#skill_error').fadeOut();
		}

		$.each(finalArray, function (k,i) {
			if(i === 0){
				$('#skill_error').fadeIn();
				$('#skill_error').css("color","red");
				$('#skill_error').css("text-align","center");
				$('#skill_error').text("Please select Sub Skill Area Of "+k);
				submitFlag = false;
				return false
			}
		});

		if($('#What_did_you_do').val() == ""){
			$('#what_did_you_help').fadeIn();
			$('#what_did_you_help').css("color","red");
			$('#what_did_you_help').css("text-align","center");
			$('#what_did_you_help').text("Please enter what did you do.");
			submitFlag = false;
			return false
		}else{
			$('#what_did_you_help').fadeOut();
		}

		if($('#How_did_this_help_you').val() == ""){
			$('#how_did_this_help').fadeIn();
			$('#how_did_this_help').css("color","red");
			$('#how_did_this_help').css("text-align","center");
			$('#how_did_this_help').text("Please enter how did this help you.");
			submitFlag = false;
			return false
		}else{
			$('#how_did_this_help').fadeOut();
		}

		if($('#comments').val() == ""){
			$('#comments_error').fadeIn();
			$('#comments_error').css("color","red");
			$('#comments_error').css("text-align","center");
			$('#comments_error').text("Please enter comments.");
			submitFlag = false;
			return false
		}else{
			$('#comments_error').fadeOut();
		}
		if($('#ilp_rate').val() == ""){
			$('#ilp_rate_error').fadeIn();
			$('#ilp_rate_error').css("color","red");
			$('#ilp_rate_error').css("text-align","center");
			$('#ilp_rate_error').text("Please enter your ilp rate.");
			submitFlag = false;
			return false
		}else{
			$('#ilp_rate_error').fadeOut();
		}
		if($('#ilp_rate').val()>10){
			$('#ilp_rate_error').fadeIn();
			$('#ilp_rate_error').css("color","red");
			$('#ilp_rate_error').css("text-align","center");
			$('#ilp_rate_error').text("Please enter below 10 rate.");
			submitFlag = false;
			return false
		}
	}

	if(submitFlag){
		$('.savetext').text("Submitting....")
		$('#add_ilp_btn').attr("disabled",true);
		$.ajax({
			url: "{{URL('profile/add_edit_ilp')}}",
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			type: 'POST',
			data: $("#add_ilp_form").serialize(), 
			success: function (data) {
				// console.log(data)
				if(data.success){
					location.reload();
					$('.alert-danger').hide();
					$('.alert-success').show().html(data.message).fadeOut(6000);
				}else{
					$('.alert-success').hide();
					$('.alert-danger').show().html(data.message).fadeOut(6000);
				}
			}
		});
	}
	});	
});


$('.deleteIlp').click(function(){
	var del_val = $(".deleteIlp").attr('data-del');
	$("#del_rec1").val(del_val);
	$('#edit').css("display","none")
	$('.alsoremove').css("display","none")
	$('#delete').css("display","block")
	$("#add_ilp_btn .fa-floppy-disk").hide();
	$('.savetext').text("Yes")
	$('#add-edit-ilp-modal').modal("show");
	$('#deleteilpFlag').val($(this).attr('data-id'))
	$('#What_did_you_do').val($(this).attr("data-ques1"));
	$('#How_did_this_help_you').val($(this).attr("data-ques2"));
	$('#comments').val($(this).attr("data-comments"));
	$('#ilp_rate').val($(this).attr("data-score"));
	$('.ilp_id_form').val($(this).attr("data-id"));
	$('#course_id').val($(this).attr('data-course-delete-id'))
	$('#level_id').val($(this).attr('data-leval-delete-id'))


	var data = JSON.parse($(this).attr("data-skillarea"));

	$.each(data, function(index, value) {
		var key = index.toLowerCase();
		var key = key.replace(" ","");
		$('#sub_skill_area_list_'+key).fadeIn();
		$('.'+key).prop("checked",true);
		$('#selected_sub_skill_area_list_'+key).fadeIn();
		$.each(value['values'], function(index1, value1) {
			if(value1 === "true" || value1 === true){
				$('#sub_skill_area_list_'+key).find('.sub-skill-check-'+key+':eq('+index1+')').click();
			}
		});
	});
	$('.sub_skill_area').fadeIn();
	$('.selected_sub_skill_area').fadeIn();
	$('#add-edit-ilp-modal').modal("show");
	return false;
});

// edit model
$('.popupEdit').click(function(){
	resetdata();
	editFlag = true;
	$('#What_did_you_do').val($(this).attr("data-ques1"));
	$('#How_did_this_help_you').val($(this).attr("data-ques2"));
	$('#comments').val($(this).attr("data-comments"));
	$('#ilp_rate').val($(this).attr("data-score"));
	$('.ilp_id_form').val($(this).attr("data-id"));
	$('.ilp_id_form').val($(this).attr("data-id"));
	var data = JSON.parse($(this).attr("data-skillarea"));
	$('#course_id').val($(this).attr("data-course-id"))
	$('#level_id').val($(this).attr("data-leval-id"))
	$('#course_id').css({"pointer-events":"none"})
	$('#level_id').css({"pointer-events":"none"})

	$.each(data, function(index, value) {
		var key = index.toLowerCase();
		var key = key.replace(" ","");
		$('#sub_skill_area_list_'+key).fadeIn();
		$('.'+key).prop("checked",true);
		$('#selected_sub_skill_area_list_'+key).fadeIn();
		$.each(value['values'], function(index1, value1) {
			if(value1 === "true" || value1 === true){
				$('#sub_skill_area_list_'+key).find('.sub-skill-check-'+key+':eq('+index1+')').click();
			}
		});
	});
	$('.sub_skill_area').fadeIn();
	$('.selected_sub_skill_area').fadeIn();
	$('#add-edit-ilp-modal').modal("show");

	$('.savetext').text(' Update');
});
</script>
<script type="text/javascript">

	$(function(){
		$('input[type=checkbox].skill-chechbox').change(function(){
			if($('input[type=checkbox].skill-chechbox:checked').length>0){
				$(".sub_skill_area").slideDown();
			}
			else {
				$('.sub_skill_area').slideUp();
				$('.selected_sub_skill_area').slideUp();
			}
		});


		$('.ilpcheckbox').on('change', function(){
			var skill  = $(this).attr('data-skill')
			$("#sub_skill_area_list_"+skill).slideToggle();
			if(!$(this).is(':checked')) {
				$('#selected_sub_skill_area_list_' + skill).slideUp();
			} else {
				if($('#sub_skill_area_list_' + skill).find('input[type="checkbox"]').is(':checked')) {
					$('.selected_sub_skill_area').slideDown();
					$('#selected_sub_skill_area_list_' + skill).slideDown();
				}
			}
		})
	});

	$(function(){
		$('input[type=checkbox].sub-skill-chechbox').change(function(){
			if($('input[type=checkbox].sub-skill-chechbox:checked').length>0){
				$(".selected_sub_skill_area").show();
			}
			else {
				$('.selected_sub_skill_area').hide();
			}
		});
	});
	$(function(){
		$('input[type=checkbox].sub-skill-check-reading').change(function(){
			if($('input[type=checkbox].sub-skill-check-reading:checked').length>0){
				if($(this).is(":checked")){
					$(".sub-skills .skill_reading_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_reading_"+$(this).attr("data")).hide();
				}
				$("#selected_sub_skill_area_list_reading").show();
			}
			else {
				$('#selected_sub_skill_area_list_reading').hide();
			}
		});
	});

	$(document).ready(function(){
		$("#skill_reading_1").click(function(){$(".skill_reading_1").slideToggle();});
		$("#skill_reading_2").click(function(){$(".skill_reading_2").slideToggle();});
		$("#skill_reading_3").click(function(){$(".skill_reading_3").slideToggle();});
		$("#skill_reading_4").click(function(){$(".skill_reading_4").slideToggle();});
		$("#skill_reading_5").click(function(){$(".skill_reading_5").slideToggle();});
		$("#skill_reading_6").click(function(){$(".skill_reading_6").slideToggle();});
		$("#skill_reading_7").click(function(){$(".skill_reading_7").slideToggle();});
		$("#skill_reading_8").click(function(){$(".skill_reading_8").slideToggle();});
		$("#skill_reading_9").click(function(){$(".skill_reading_9").slideToggle();});
		$("#skill_reading_10").click(function(){$(".skill_reading_10").slideToggle();});
		$("#skill_reading_11").click(function(){$(".skill_reading_11").slideToggle();});
		$("#skill_reading_12").click(function(){$(".skill_reading_12").slideToggle();});
		$("#skill_reading_13").click(function(){$(".skill_reading_13").slideToggle();});
		$("#skill_reading_14").click(function(){$(".skill_reading_14").slideToggle();});
		$("#skill_reading_15").click(function(){$(".skill_reading_15").slideToggle();});
		$("#skill_reading_16").click(function(){$(".skill_reading_16").slideToggle();});
		$("#skill_reading_17").click(function(){$(".skill_reading_17").slideToggle();});
		$("#skill_reading_18").click(function(){$(".skill_reading_18").slideToggle();});
		$("#skill_reading_19").click(function(){$(".skill_reading_19").slideToggle();});
		$("#skill_reading_20").click(function(){$(".skill_reading_20").slideToggle();});
		$("#skill_reading_21").click(function(){$(".skill_reading_21").slideToggle();});
		$("#skill_reading_22").click(function(){$(".skill_reading_22").slideToggle();});
		$("#skill_reading_23").click(function(){$(".skill_reading_23").slideToggle();});
		$("#skill_reading_24").click(function(){$(".skill_reading_24").slideToggle();});
		$("#skill_reading_25").click(function(){$(".skill_reading_25").slideToggle();});
		$("#skill_reading_26").click(function(){$(".skill_reading_26").slideToggle();});
		$("#skill_reading_27").click(function(){$(".skill_reading_27").slideToggle();});
		$("#skill_reading_28").click(function(){$(".skill_reading_28").slideToggle();});
		$("#skill_reading_29").click(function(){$(".skill_reading_29").slideToggle();});
		$("#skill_reading_30").click(function(){$(".skill_reading_30").slideToggle();});
		$("#skill_reading_31").click(function(){$(".skill_reading_31").slideToggle();});
		$("#skill_reading_32").click(function(){$(".skill_reading_32").slideToggle();});
	});
	$(function(){
		
		$('input[type=checkbox].sub-skill-check-writing').change(function(){
			if($('input[type=checkbox].sub-skill-check-writing:checked').length>0){
				if($(this).is(":checked")){
					$(".sub-skills .skill_writing_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_writing_"+$(this).attr("data")).hide();
				}
				$("#selected_sub_skill_area_list_writing").show();
			}
			else {
				$('#selected_sub_skill_area_list_writing').hide();
			}
		});
	});

	$(document).ready(function(){
		$("#skill_writing_1").click(function(){$(".skill_writing_1").slideToggle();});
		$("#skill_writing_2").click(function(){$(".skill_writing_2").slideToggle();});
		$("#skill_writing_3").click(function(){$(".skill_writing_3").slideToggle();});
		$("#skill_writing_4").click(function(){$(".skill_writing_4").slideToggle();});
		$("#skill_writing_5").click(function(){$(".skill_writing_5").slideToggle();});
		$("#skill_writing_6").click(function(){$(".skill_writing_6").slideToggle();});
		$("#skill_writing_7").click(function(){$(".skill_writing_7").slideToggle();});
		$("#skill_writing_8").click(function(){$(".skill_writing_8").slideToggle();});
		$("#skill_writing_9").click(function(){$(".skill_writing_9").slideToggle();});
		$("#skill_writing_10").click(function(){$(".skill_writing_10").slideToggle();});
		$("#skill_writing_11").click(function(){$(".skill_writing_11").slideToggle();});
		$("#skill_writing_12").click(function(){$(".skill_writing_12").slideToggle();});
		$("#skill_writing_13").click(function(){$(".skill_writing_13").slideToggle();});
		$("#skill_writing_14").click(function(){$(".skill_writing_14").slideToggle();});
		$("#skill_writing_15").click(function(){$(".skill_writing_15").slideToggle();});
		$("#skill_writing_16").click(function(){$(".skill_writing_16").slideToggle();});
		$("#skill_writing_17").click(function(){$(".skill_writing_17").slideToggle();});
		$("#skill_writing_18").click(function(){$(".skill_writing_18").slideToggle();});
		$("#skill_writing_19").click(function(){$(".skill_writing_19").slideToggle();});
		$("#skill_writing_20").click(function(){$(".skill_writing_20").slideToggle();});
		$("#skill_writing_21").click(function(){$(".skill_writing_21").slideToggle();});
		$("#skill_writing_22").click(function(){$(".skill_writing_22").slideToggle();});
		$("#skill_writing_23").click(function(){$(".skill_writing_23").slideToggle();});
		$("#skill_writing_24").click(function(){$(".skill_writing_24").slideToggle();});
		$("#skill_writing_25").click(function(){$(".skill_writing_25").slideToggle();});
		$("#skill_writing_26").click(function(){$(".skill_writing_26").slideToggle();});
		$("#skill_writing_27").click(function(){$(".skill_writing_27").slideToggle();});
		$("#skill_writing_28").click(function(){$(".skill_writing_28").slideToggle();});
		$("#skill_writing_29").click(function(){$(".skill_writing_29").slideToggle();});
		$("#skill_writing_30").click(function(){$(".skill_writing_30").slideToggle();});
		$("#skill_writing_31").click(function(){$(".skill_writing_31").slideToggle();});
		$("#skill_writing_32").click(function(){$(".skill_writing_32").slideToggle();});
		$("#skill_writing_33").click(function(){$(".skill_writing_33").slideToggle();});
		$("#skill_writing_34").click(function(){$(".skill_writing_34").slideToggle();});
		$("#skill_writing_35").click(function(){$(".skill_writing_35").slideToggle();});
	});

	$(function(){
		$('input[type=checkbox].sub-skill-check-listening').change(function(){
			if($('input[type=checkbox].sub-skill-check-listening:checked').length>0){

				if($(this).is(":checked")){
					$(".sub-skills .skill_listening_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_listening_"+$(this).attr("data")).hide();
				}

				$("#selected_sub_skill_area_list_listening").show();
			}
			else {
				$('#selected_sub_skill_area_list_listening').hide();
			}
		});
	});

	$(document).ready(function(){
		$("#skill_listening_1").click(function(){$(".skill_listening_1").slideToggle();});
		$("#skill_listening_2").click(function(){$(".skill_listening_2").slideToggle();});
		$("#skill_listening_3").click(function(){$(".skill_listening_3").slideToggle();});
		$("#skill_listening_4").click(function(){$(".skill_listening_4").slideToggle();});
		$("#skill_listening_5").click(function(){$(".skill_listening_5").slideToggle();});
		$("#skill_listening_6").click(function(){$(".skill_listening_6").slideToggle();});
		$("#skill_listening_7").click(function(){$(".skill_listening_7").slideToggle();});
		$("#skill_listening_8").click(function(){$(".skill_listening_8").slideToggle();});
		$("#skill_listening_9").click(function(){$(".skill_listening_9").slideToggle();});
		$("#skill_listening_10").click(function(){$(".skill_listening_10").slideToggle();});
		$("#skill_listening_11").click(function(){$(".skill_listening_11").slideToggle();});
		$("#skill_listening_12").click(function(){$(".skill_listening_12").slideToggle();});
		$("#skill_listening_13").click(function(){$(".skill_listening_13").slideToggle();});
		$("#skill_listening_14").click(function(){$(".skill_listening_14").slideToggle();});
		$("#skill_listening_15").click(function(){$(".skill_listening_15").slideToggle();});
		$("#skill_listening_16").click(function(){$(".skill_listening_16").slideToggle();});
		$("#skill_listening_17").click(function(){$(".skill_listening_17").slideToggle();});
		$("#skill_listening_18").click(function(){$(".skill_listening_18").slideToggle();});
		$("#skill_listening_19").click(function(){$(".skill_listening_19").slideToggle();});
		$("#skill_listening_20").click(function(){$(".skill_listening_20").slideToggle();});
		$("#skill_listening_21").click(function(){$(".skill_listening_21").slideToggle();});
	});

	// <--&&- 3//

	// -&&--> 4//

	$(function(){
		$('input[type=checkbox].sub-skill-check-speaking').change(function(){
			if($('input[type=checkbox].sub-skill-check-speaking:checked').length>0){


				if($(this).is(":checked")){
					$(".sub-skills .skill_speaking_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_speaking_"+$(this).attr("data")).hide();
				}

				$("#selected_sub_skill_area_list_speaking").show();
			}
			else {
				$('#selected_sub_skill_area_list_speaking').hide();
			}
		});
	});
	$(document).ready(function(){
		$("#skill_speaking_1").click(function(){$(".skill_speaking_1").slideToggle();});
		$("#skill_speaking_2").click(function(){$(".skill_speaking_2").slideToggle();});
		$("#skill_speaking_3").click(function(){$(".skill_speaking_3").slideToggle();});
		$("#skill_speaking_4").click(function(){$(".skill_speaking_4").slideToggle();});
		$("#skill_speaking_5").click(function(){$(".skill_speaking_5").slideToggle();});
		$("#skill_speaking_6").click(function(){$(".skill_speaking_6").slideToggle();});
		$("#skill_speaking_7").click(function(){$(".skill_speaking_7").slideToggle();});
		$("#skill_speaking_8").click(function(){$(".skill_speaking_8").slideToggle();});
		$("#skill_speaking_9").click(function(){$(".skill_speaking_9").slideToggle();});
		$("#skill_speaking_10").click(function(){$(".skill_speaking_10").slideToggle();});
		$("#skill_speaking_11").click(function(){$(".skill_speaking_11").slideToggle();});
		$("#skill_speaking_12").click(function(){$(".skill_speaking_12").slideToggle();});
		$("#skill_speaking_13").click(function(){$(".skill_speaking_13").slideToggle();});
		$("#skill_speaking_14").click(function(){$(".skill_speaking_14").slideToggle();});
		$("#skill_speaking_15").click(function(){$(".skill_speaking_15").slideToggle();});
		$("#skill_speaking_16").click(function(){$(".skill_speaking_16").slideToggle();});
		$("#skill_speaking_17").click(function(){$(".skill_speaking_17").slideToggle();});
		$("#skill_speaking_18").click(function(){$(".skill_speaking_18").slideToggle();});
		$("#skill_speaking_19").click(function(){$(".skill_speaking_19").slideToggle();});
		$("#skill_speaking_20").click(function(){$(".skill_speaking_20").slideToggle();});
		$("#skill_speaking_21").click(function(){$(".skill_speaking_21").slideToggle();});
		$("#skill_speaking_22").click(function(){$(".skill_speaking_22").slideToggle();});
		$("#skill_speaking_23").click(function(){$(".skill_speaking_23").slideToggle();});
		$("#skill_speaking_24").click(function(){$(".skill_speaking_24").slideToggle();});
		$("#skill_speaking_25").click(function(){$(".skill_speaking_25").slideToggle();});
	});
	$(function(){
		$('input[type=checkbox].sub-skill-check-grammar').change(function(){
			if($('input[type=checkbox].sub-skill-check-grammar:checked').length>0){
				if($(this).is(":checked")){
					$(".sub-skills .skill_grammar_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_grammar_"+$(this).attr("data")).hide();
				}
				$("#selected_sub_skill_area_list_grammar").show();
			}
			else {
				$('#selected_sub_skill_area_list_grammar').hide();
			}
		});
	});

	$(document).ready(function(){
		$("#skill_grammar_1").click(function(){$(".skill_grammar_1").slideToggle();});
		$("#skill_grammar_2").click(function(){$(".skill_grammar_2").slideToggle();});
		$("#skill_grammar_3").click(function(){$(".skill_grammar_3").slideToggle();});
		$("#skill_grammar_4").click(function(){$(".skill_grammar_4").slideToggle();});
		$("#skill_grammar_5").click(function(){$(".skill_grammar_5").slideToggle();});
		$("#skill_grammar_6").click(function(){$(".skill_grammar_6").slideToggle();});
		$("#skill_grammar_7").click(function(){$(".skill_grammar_7").slideToggle();});
		$("#skill_grammar_8").click(function(){$(".skill_grammar_8").slideToggle();});
		$("#skill_grammar_9").click(function(){$(".skill_grammar_9").slideToggle();});
		$("#skill_grammar_10").click(function(){$(".skill_grammar_10").slideToggle();});
		$("#skill_grammar_11").click(function(){$(".skill_grammar_11").slideToggle();});
		$("#skill_grammar_12").click(function(){$(".skill_grammar_12").slideToggle();});
		$("#skill_grammar_13").click(function(){$(".skill_grammar_13").slideToggle();});
		$("#skill_grammar_14").click(function(){$(".skill_grammar_14").slideToggle();});
		$("#skill_grammar_15").click(function(){$(".skill_grammar_15").slideToggle();});
		$("#skill_grammar_16").click(function(){$(".skill_grammar_16").slideToggle();});
		$("#skill_grammar_17").click(function(){$(".skill_grammar_17").slideToggle();});
		//var screenSize = screen.width;
		if (screen.width < 768) {
			$('.ieuk-ilp-hsf').toggle();
		}
		//============== for hide show details in mobileview 28-8-2021=============//
		$(".ieuk-ilp-hsb").click(function(){
			$(this).toggleClass("on");		
			$(this).parent().parent('tr').addClass("needactive");
			$('tr.needactive .ieuk-ilp-hsf').toggle(300);
			$('tr.needactive .ieuk-ilp-hsb').parent().parent('tr').removeClass("needactive");
		});
		//============== for hide show details in mobileview 28-8-2021=============//
	});
	$(function(){
		$('input[type=checkbox].sub-skill-check-vocabulary').change(function(){
			if($('input[type=checkbox].sub-skill-check-vocabulary:checked').length>0){
				
				if($(this).is(":checked")){
					$(".sub-skills .skill_vocabulary_"+$(this).attr("data")).show();
				} else {
					$(".sub-skills .skill_vocabulary_"+$(this).attr("data")).hide();
				}
				$("#selected_sub_skill_area_list_vocabulary").show();
			}
			else {
				$('#selected_sub_skill_area_list_vocabulary').hide();
			}
		});
	});

	$(document).ready(function(){
		$('#student_led').prop('checked',true);
		$("#skill_vocabulary_1").click(function(){
			
			$(".skill_vocabulary_1").slideToggle();
		});
	});

	$(function(){

		$('input[type=checkbox].sub-skill-check-learnertraining').change(function(){

			if($('input[type=checkbox].sub-skill-check-learnertraining:checked').length>0){

				if($(this).is(":checked")){
					$(".sub-skills .skill_learnertraining_"+$(this).attr("data")).show();
				}else{
					$(".sub-skills .skill_learnertraining_"+$(this).attr("data")).hide();
				}
				$("#selected_sub_skill_area_list_learnertraining").show();

			}
			else {

				$('#selected_sub_skill_area_list_learnertraining').hide();
				$(".sub-skills .skill_learnertraining_"+$(this).attr("data")).hide();
			}
		});
	});
	$(document).ready(function(){
		$("#skill_learnertraining_1").click(function(){$(".skill_learnertraining_1").slideToggle();});
		$("#skill_learnertraining_2").click(function(){$(".skill_learnertraining_2").slideToggle();});
		$("#skill_learnertraining_3").click(function(){$(".skill_learnertraining_3").slideToggle();});
		$("#skill_learnertraining_4").click(function(){$(".skill_learnertraining_4").slideToggle();});
		$("#skill_learnertraining_5").click(function(){$(".skill_learnertraining_5").slideToggle();});
		$("#skill_learnertraining_6").click(function(){$(".skill_learnertraining_6").slideToggle();});
		$("#skill_learnertraining_7").click(function(){$(".skill_learnertraining_7").slideToggle();});
		$("#skill_learnertraining_8").click(function(){$(".skill_learnertraining_8").slideToggle();});
		$("#skill_learnertraining_9").click(function(){$(".skill_learnertraining_9").slideToggle();});
		$("#skill_learnertraining_10").click(function(){$(".skill_learnertraining_10").slideToggle();});
		$("#skill_learnertraining_11").click(function(){$(".skill_learnertraining_11").slideToggle();});
		$("#skill_learnertraining_12").click(function(){$(".skill_learnertraining_12").slideToggle();});
	});

	$(document).on('change',"#student_led",function(){
		$("#pills-home").addClass('active show');
		$("#pills-profile").removeClass('active show');
		$("#pills-profile-tab").removeClass('active show');
		$("#pills-home-tab").addClass('active show');
		$("#led_search [value='"+'s_led'+"']" ).prop('selected', true);
        $("#select2-led_search-container").text('Student Led');
        $('.ilp-student-options').show();
		$('.deleteIlp').show();
        $("#teacher_led1").hide();
		$("#student_led1").hide();
		$("#student_led1").show();
	});
	$(document).on('change',"#led_search",function(){
		var value = $(this).val();
		if(value == "s_led"){
			$("#pills-home").addClass('active show');
			$("#pills-profile").removeClass('active show');
			$('#student_led').prop('checked',true);
			$('.ilp-student-options').show();
			$("#teacher_led1").hide();
			$("#student_led1").hide();
			$("#student_led1").show();
			$('.deleteIlp').show();
			$('.nav-link.teach').removeClass('active');
			$('.nav-link.stu').addClass('active');
		}
		if(value == "t_led"){
			$("#pills-home").removeClass('active show');
			$("#pills-profile").addClass('active show');
			$('#teacher_led').prop('checked',true);
			$('.ilp-student-options').hide();
			$("#student_led1").hide();
			$("#teacher_led1").hide();
			$("#teacher_led1").show();
			$('.nav-link.stu').removeClass('active');
			$('.nav-link.teach').addClass('active');
		}
	});
	$(document).on('click','.nav-link.stu',function(){
         $("#teacher_led1").hide();
		 $("#student_led1").hide();
		 $("#student_led1").show();
		 $("#teacher_led").prop('checked',false);
		 $("#student_led").prop('checked',true);
		 $('.deleteIlp').show();
		 $("#led_search option[value='"+'s_led'+"']" ).prop('selected', true);
		 $("#select2-led_search-container").text('Student Led');
	});
    $(document).on('click','.nav-link.teach',function(){
         $("#student_led1").hide();
	     $("#teacher_led1").hide();
		 $("#teacher_led1").show();
		 $("#student_led").prop('checked',false);
	     $("#teacher_led").prop('checked',true);
	     $("#led_search option[value='"+'t_led'+"']" ).prop('selected', true);
	     $("#select2-led_search-container").text('Teacher Led');
	});
	//---------------------------------------------------------
    $(document).ready(function() {
        table1 = $('.table1').DataTable({
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
            if (aiDisplay.length > 0) {
                $("#image_class1").hide();
                $(".datatable-footer").show();
            }
            else{
                $("#image_class1").show();
                $(".datatable-footer").hide();
            }
        }
        });
        table2 = $('.table2').DataTable({
         "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
            console.log(aiDisplay.length);
            if (aiDisplay.length > 0) {
                 $("#image_class").hide();
                 $(".datatable-footer").show();
            }
            else{
                 $("#image_class").show();
                 $(".datatable-footer").hide();
            }
        }
        });
    });
    $('.s0').keyup(function(){
             table1.search($(this).val() ).draw();
    });
    $('.s1').keyup(function(){
             table2.search( $(this).val() ).draw();
    });
	
</script>
@endsection

