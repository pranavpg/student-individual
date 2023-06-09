<?php

Route::get('/notes',['uses'=>'NotesController@notes']);
Route::post('/note_post',['uses'=>'NotesController@note_post']);
Route::post('/notes/downloadnotes_pdf',['uses'=>'NotesController@downloadnotes_pdf'])->name('notes.downloadnotes_pdf');
Route::get('/vocabulary/downloadvocabulary_pdf',['uses'=>'NotesController@downloadvocabulary_pdf']);

Route::get('/summary',['uses'=>'SummaryController@summary']);
Route::post('/summary_post',['uses'=>'SummaryController@summary_post']);

Route::post('/get_task',['uses'=>'CommonController@gettask']); 
Route::post('/get_topic_task',['uses'=>'CommonController@gettopics']);
Route::get('/functional_language',['uses'=>'CommonController@functional_language']);

Route::get('/vocabulary',['uses'=>'VocabularyController@vocabulary']);
Route::post('/vocab_topic_post',['uses'=>'VocabularyController@vocab_topic_post']);
Route::post('/vocab_post',['uses'=>'VocabularyController@vocab_post']);

Route::post('reset-answer',['uses'=>'DashboardController@resetAnswer']);
// Route::get('checkemail',['uses'=>'GlobalController@checkEmail']);
Route::get('/',['uses'=>'DashboardController@index']);
Route::get('/purchase_course',['uses'=>'DashboardController@purchase_course']);
Route::get('/login',['uses'=>'DashboardController@index_new']);
Route::get('/newpage',['uses'=>'DashboardController@newindex']);
Route::post('/rename-audio',['uses'=>'PractiseNewController@renameAudio']);
Route::post('/get_topic_list',['uses'=>'DashboardController@getTopicList']);
// Route::post('/login_post',['uses'=>'DashboardController@login_post']);
Route::post('/login_post_new',['uses'=>'DashboardController@login_post_new']);
Route::get('/profile-create',['uses'=>'CommonController@profile']);
Route::post('/update-profile',['uses'=>'DashboardController@updateProfile']);
Route::post('/do-update-profile',['uses'=>'DashboardController@doUpdateProfile']);
Route::get('/forgot-password',['uses'=>'DashboardController@forgotpassword']);
Route::post('/forgotpassword_post',['uses'=>'DashboardController@forgotpassword_post']);

Route::get('/porfolio_assessment1',['uses'=>'DashboardController@student_progress']);//student progress report
Route::get('/student_progress_report',['uses'=>'DashboardController@getprogressreport']);
Route::get('/porfolio_assessment',['uses'=>'DashboardController@porfolio_assessment']);

Route::get('/logout',['uses'=>'DashboardController@doLogout'])->name('logout');
Route::get('/profile',['uses'=>'ProfileController@index']);
Route::post('/profile/reset_password',['uses'=>'ProfileController@reset_password']);
Route::post('/profile/student-update',['uses'=>'ProfileController@update_profile']);
Route::get('/contact-us',['uses'=>'ProfileController@contactUs']);
Route::get('/profile/course',['uses'=>'ProfileController@course']);
Route::get('/profile/ilps',['uses'=>'ProfileController@ilps']);
Route::get('/profile/ilps/downloadilps_pdf',['uses'=>'ProfileController@downloadilps_pdf']);
Route::get('/profile/certificate',['uses'=>'ProfileController@certificatedetails']);
Route::get('/profile/feedbacks/get-student-teacher',['uses'=>'ProfileController@feedbacks']);
Route::post('/profile/add-view-feedbacks_mobile',['uses'=>'ProfileController@add_feedbacks_mobile']);
Route::post('/profile/add_edit_ilp',['uses'=>'ProfileController@add_ilps']);
Route::get('get-progress-task',['uses'=>'TopicController@get_progress_task']);
Route::get('/topic/{topicId}',['uses'=>'TopicController@index'])->middleware('SessionCheck');
Route::get('/topic/{topicId}/{taskId}',['uses'=>'TopicController@index'])->middleware('lastTask');
Route::get('/topic_new/{topicId}',['uses'=>'TopicController@index_new'])->middleware('SessionCheck');
Route::get('/topic_new/{topicId}/{taskId}',['uses'=>'TopicController@index_new'])->middleware('lastTask');
Route::get('/topic-iframe/{topicId}/{taskId}/{practiceId}/{showPrevious?}',['uses'=>'TopicController@getIframeContent']);
Route::get('/topic_aim/{topicId}',['uses'=>'TopicController@topic_aim']);
Route::get('/topic_aim/{topicId}/{taskId}',['uses'=>'TopicController@topic_aim']);
Route::get('/topic_aim_new/{topicId}',['uses'=>'TopicController@topic_aim_new']);
Route::get('/topic_aim_new/{topicId}/{taskId}',['uses'=>'TopicController@topic_aim_new']);
Route::post('/save-blank-table-speaking', ['uses'=>'PractiseNewController@saveBlankTableSpeaking']);
Route::post('/upload-audio', ['uses'=>'PractiseNewController@doUploadAudio']);
Route::post('/delete-audio', ['uses'=>'PractiseNewController@doDeleteAudio']);
Route::post('/save-speaking-writing', ['uses'=>'PractiseNewController@saveSpeakingWriting']);
Route::post('/save-speaking-writing-up-new', ['uses'=>'PracticeArshitController@saveSpeakingWritingUpNew']);
Route::post('/save-true-false-speaking', ['uses'=>'PractiseNewController@saveTrueFalseSpeaking']);
Route::post('/save-true-false-wrirting-simple', ['uses'=>'PractiseNewController@saveTrueFalseWritingSimple']);
Route::post('/save-writing-speaking-multi-video-record', ['uses'=>'PractiseNewController@saveWritingMultiplevideo']);
Route::post('/save-underline-text', ['uses'=>'PractiseNewController@saveUnderlineText']);
Route::post('/save-underline-text-roleplay', ['uses'=>'PractiseNewController@saveUnderlineTextRoleplay']);
Route::post('/save-writing-at-end-speaking', ['uses'=>'PractiseNewController@saveWritingAtEndSpeaking']);
Route::post('/save-writing-at-end-option', ['uses'=>'PractiseNewController@saveWritingAtEndOption']);
Route::post('/save-single-image-writing', ['uses'=>'PractiseNewController@saveSingleImageWriting']);
Route::post('/save-true-false-radio', ['uses'=>'PractiseNewController@saveTrueFalseRadio']);
Route::post('/save-speaking-multiple-listening', ['uses'=>'PractiseNewController@saveSpeakingMultipleListening']);
Route::post('/save-speaking-multiple-up', ['uses'=>'PractiseNewController@saveSpeakingMultipleUp']);
Route::post('/save-match-answer-single-image', ['uses'=>'PractiseNewController@saveMatchAnswerSingleImage']);
Route::post('/save-match-answer-single-image-speaking-up', ['uses'=>'PractiseNewController@saveMatchAnswerSingleImageSpeakingUp']);
Route::post('/save-writing-at-end-up-single-underline-text', ['uses'=>'PractiseNewController@saveWritingAtEndUpSingleUnderlineText']);
Route::post('/save-writing-at-end-up-single-underline-text-selection', ['uses'=>'PractiseNewController@saveWritingAtEndUpSingleUnderlineTextSelection']);
Route::post('/save-can-do-statements', ['uses'=>'PractiseNewController@saveCanDoStatements']);
Route::post('/save-image-box-writing', ['uses'=>'PractiseNewController@saveImageBoxWriting']);
Route::post('/save-create-quiz', ['uses'=>'PractiseNewController@saveCreateQuiz']);
Route::post('/save-conversation-simple-multi-blank', ['uses'=>'PractiseNewController@saveConversationSimpleMultiBlank']);
Route::post('/save-image-reading-no-blanks-no-space', ['uses'=>'PractiseNewController@saveImageReadingNoBlanksNoSpace']);
Route::post('/save-single-speaking-writing', ['uses'=>'PractiseNewController@saveSingleSpeakingWriting']);
Route::post('/save-hide-show-answer-speaking-up', ['uses'=>'PractiseNewController@saveHideShowAnswerSpeakingUp']);
Route::post('/save-writing-at-end-up-speaking-multiple', ['uses'=>'PractiseNewController@saveWritingAtEndUpSpeakingMultiple']);
Route::post('/save-multi-image-option', ['uses'=>'PractiseNewController@saveMultiImageOption']);
Route::post('/save-multi-image-selection', ['uses'=>'PractiseNewController@saveMultiImageSelection']);
Route::post('/save-multi-image-writing-at-start-up-end', ['uses'=>'PractiseNewController@saveMultiImageWritingAtStartUpEnd']);
Route::post('/save-single-speaking-up-conversation-simple-view', ['uses'=>'PractiseNewController@saveSingleSpeakingUpConversationSimpleView']);
Route::post('/save-speaking-multiple-single-image', ['uses'=>'PractiseNewController@saveSpeakingMultipleSingleImage']);
Route::post('/save-single-image-writing-at-end-speaking', ['uses'=>'PractiseNewController@saveSingleImageWritingAtEndSpeaking']);
Route::post('/save-set-in-sequence', ['uses'=>'PractiseNewController@saveSetInSequence']);
Route::post('/save-speaking-multiple-single-writing', ['uses'=>'PractiseNewController@saveSpeakingMultipleSingleWriting']);
Route::post('/save-multi-choice-question-multiple-speaking', ['uses'=>'PractiseNewController@saveMultiChoiceQuestionMultipleSpeaking']);
Route::post('/save-multi-choice-question-multiple-writing-at-end-no-option', ['uses'=>'PractiseNewController@saveMultiChoiceQuestionMultipleWritingAtEndNoOption']);
Route::post('/save-mcq-self-marking', ['uses'=>'PractiseNewController@saveMultiChoiceQuestionSelfMarking']);
Route::post('/save-underline-text-multi-color', ['uses'=>'PractiseNewController@saveUnderlineTextMultiColor']);
Route::post('/save-reading-no-blanks-speaking-down', ['uses'=>'PractiseNewController@saveReadingNoBlanksListeningSpeakingDown']);
Route::post('/save-true-false-correct-incorrect', ['uses'=>'PractiseNewController@saveTrueFalseCorrectIncorrect']);
Route::get('/work-record',['uses'=>'WorkRecordController@index']);
Route::post('/save-practice-feedback',['uses'=>'WorkRecordController@savePracticeFeedback']);
Route::post('/save-student-self-marking-review',['uses'=>'PractiseNewController@saveStudentSelfMarkingReviewForm']);
Route::post('/save-student-self-marking',['uses'=>'GlobalController@saveStudentSelfMarkingForm']);
Route::post('/save-write-atend-up', ['uses'=>'PracticeArshitController@saveWriteAtendUp']);
Route::post('/save-write-atend-up-role-play', ['uses'=>'PracticeArshitController@saveWriteAtendUpRolePlay']);
Route::post('/get-student-practisce-answer', ['uses'=>'GlobalController@getStudentPracticeAnswer']);
Route::post('/save-listening-writing', ['uses'=>'PracticeArshitController@saveListeningWriting']);
Route::post('/save-multiple-tick', ['uses'=>'PracticeArshitController@saveMultipleTick']);
Route::post('/save-setin-order-vertical-listening', ['uses'=>'PracticeArshitController@saveSetinOrderVertListening']);
Route::post('/save-true-false-symbol-listening', ['uses'=>'PracticeArshitController@saveTrueFalseSymbolListening']);
Route::post('/reading-no-blanks-no-space', ['uses'=>'PracticeArshitController@readingNoBlanksNoSpace']);
Route::post('/save-true-false-symbol-reading', ['uses'=>'PracticeArshitController@saveTrueFalseSymbolReading']);
Route::post('/save-two-blank-table-up-writing-end', ['uses'=>'PracticeArshitController@saveBlankTableWritingEnd']);
Route::post('/save-true-false-listening-simple', ['uses'=>'PracticeArshitController@saveTrueFalseListeningSimple']);
Route::post('/save-multi-choice-multipul-question', ['uses'=>'PracticeArshitController@saveMultiChoiceMultipulQuestion']);
Route::post('/save-multi-choice-writing-at-end', ['uses'=>'PracticeArshitController@saveMultiChoiceQuestionWritingAtEnd']);
Route::post('/save-draw-image-writing', ['uses'=>'PracticeArshitController@saveDrawImageWriting']);
Route::post('/save-draw-image-speaking', ['uses'=>'PracticeArshitController@saveDrawImageSpeaking']);
Route::post('/save-draw-image-listening', ['uses'=>'PracticeArshitController@saveDrawImagelistening']);
Route::post('/save-single-tick', ['uses'=>'PracticeArshitController@saveSingleTick']);
Route::post('/save-true-false-a-g', ['uses'=>'PracticeArshitController@saveTrueFalseAG']);
Route::post('/save-draw-image-multiple', ['uses'=>'PracticeArshitController@saveDrawImageMultipleTable']);
Route::post('/save-blank-table', ['uses'=>'CommonController@saveBlankTable']);
Route::post('/save-two-blank-table-option-speaking', ['uses'=>'CommonController@twoTableOptionSpeaking']);
Route::post('/save-blank-table-three-blanck-table', ['uses'=>'CommonController@saveBlankTableThreeBlaenTable']);
Route::post('/save-blank-table-three-table-option', ['uses'=>'CommonController@saveBlankTableThreeTableOption']);
Route::post('/save-blank-table-three-table-option-dependancy', ['uses'=>'CommonController@saveBlankTableThreeTableOptionDependancy']);
Route::post('/save-blank-table-three-roleplay', ['uses'=>'CommonController@saveBlankTableThreeRoleplay']);
Route::post('/save-blank-table-four-blank-table-listening', ['uses'=>'CommonController@saveBlankTableFourBlankTableListening']);
Route::post('/save-blank-table-dependancy', ['uses'=>'CommonController@saveBlankTableDependancy']);
Route::post('/save-blank-table-dependancy-three-blank-table-speaking-up-new', ['uses'=>'CommonController@threeBlankTableSpeakingUpNew']);
Route::post('/save-blank-table-one', ['uses'=>'CommonController@saveBlankTableOne']);
Route::post('/reading-no-blanks', ['uses'=>'CommonController@readingNoBlanks']);
Route::post('/true-false-listening', ['uses'=>'CommonController@trueFalseListening']);
Route::post('/clock_submit', ['uses'=>'CommonController@clockSubmit']);
Route::post('/family_tree_submit', ['uses'=>'CommonController@familyTreeSubmit']);
Route::post('/board_game_post', ['uses'=>'CommonController@boardGamePost']);
Route::post('/save_drag_drop', ['uses'=>'CommonController@saveDragDrop']);
Route::post('/save_drag_drop_speaking', ['uses'=>'CommonController@saveDragDropSpeaking']);
Route::post('/save-multi-choice-question-speaking-up', ['uses'=>'CommonController@saveMultiChoiceQuestionSpeakingUp']); //
Route::post('/save_four_blank_table_speaking_writing_form', ['uses'=>'CommonController@saveFourBlankTableSpeakingWriting']);
Route::post('/save_listening', ['uses'=>'CommonController@saveListeningSpeaking']);
Route::post('/save_single_tick_writing', ['uses'=>'CommonController@savesingleTickWriting']);
Route::post('/save_reading_total_blank_speakingup', ['uses'=>'CommonController@saveReadingTotalBlanksSpeakingUp']);
Route::post('/save-match-answer-writing', ['uses'=>'CommonController@saveMatchAnswerWriting']);
Route::post('/save-reading-no-blanks-listening-speaking-down', ['uses'=>'CommonController@saveReadingNoBlanksListeningSpeakingDown']);
Route::post('/save-reading-blank-listening', ['uses'=>'CommonController@saveReadingNoBlanksListeningSpeakingDown']);
Route::post('/save-multiple-tick-writing', ['uses'=>'CommonController@saveMultipleTickWriting']);
Route::post('/save-underline-text-speaking-down', ['uses'=>'CommonController@saveUnderLineTextSpeakingDown']);
Route::post('/save-upload-ppt', ['uses'=>'CommonController@saveUploadPPT']);
Route::post('/save-writing-lines', ['uses'=>'CommonController@saveWritingLines']);
Route::post('/save-writing-edit', ['uses'=>'CommonController@saveWritingEdit']);
Route::post('/save-writing-word-count', ['uses'=>'CommonController@saveWritingWordCount']);
Route::post('/save-three-blank-table-speaking-writing-form', ['uses'=>'CommonController@saveThreeBlankTableListeningWriting']);
Route::post('/save-underline-text-writing-end', ['uses'=>'CommonController@saveUnderLineTextWritingAtEnd']);
Route::post('/save-three-blank-table-writing-up', ['uses'=>'CommonController@saveThreeTableWritingUpBlade']);
Route::post('/save-two-blank-table-tapescript', ['uses'=>'CommonController@saveTwoBlankTableTapeScript']);
Route::post('/save-image-reading-no-blanks', ['uses'=>'CommonController@saveImageReadingNoBlanks']);
Route::post('/save-three-blank-table-speaking-up', ['uses'=>'CommonController@ThreeBlankTableSpeakingUp']);
Route::post('/save_draw_image_writing_email', ['uses'=>'CommonController@saveDrawImageWritingEmail']);
Route::post('/save-record-video', ['uses'=>'CommonController@saveRecordVideo'])->name('save-record-video');
Route::post('/save-single-tick-reading-diff', ['uses'=>'CommonController@saveSingleTickReadingDiff'])->name('save-single-tick-reading-diff');
Route::post('/save-single-tick-reading', ['uses'=>'CommonController@saveSingleTickReading'])->name('save-single-tick-reading');
Route::post('/save-single-tick-speaking', ['uses'=>'CommonController@saveSingleTickSpeaking'])->name('save-single-tick-speaking');
Route::post('/save-true-false-simple', ['uses'=>'CommonController@saveTrueFalseSimple'])->name('save-true-false-simple');
Route::post('/save-true-false-symbol', ['uses'=>'CommonController@saveTrueFalseSymbol'])->name('save-true-false-symbol');
Route::post('/save-true-false-writing-at-end-select-option', ['uses'=>'CommonController@saveTrueFalseWritingAtEndSelectOption'])->name('save-true-false-writing-at-end-select-option');
Route::post('/save-true-false-writing-at-end-all-symbol', ['uses'=>'CommonController@saveTrueFalseWritingAtEndAllSymbol'])->name('save-true-false-writing-at-end-all-symbol');
Route::post('/save-speaking-up-option', ['uses'=>'CommonController@saveSpeakingUpOption'])->name('save-speaking-up-option');
Route::post('/save-hide-show-answer', ['uses'=>'CommonController@saveHideShowAnswer'])->name('save-hide-show-answer');
Route::post('/save-image-writing-at-end-up', ['uses'=>'CommonController@saveImageWritingAtEndUp'])->name('save-image-writing-at-end-up');
Route::post('/save-image-writing-at-end-up-new', ['uses'=>'CommonController@saveImageWritingAtEndUpNew'])->name('save-image-writing-at-end-up-new');
Route::post('/save-multi-choice-question', ['uses'=>'CommonController@saveMultiChoiceQuestion']);
Route::post('/save-true-false-listening-symbols', ['uses'=>'CommonController@saveTrueFalseListeningSymbol']);
Route::post('/save-writing-at-end-speakings', ['uses'=>'CommonController@saveSpeakingWritingNew']);
Route::post('/save-true-false-listening-role', ['uses'=>'CommonController@trueFalseListenings']);
Route::post('/save-reading-no-blanks-speaking-new', ['uses'=>'CommonController@readingNoBlanksNew']);
Route::post('/save-single-image-writing-at-end-speaking-new', ['uses'=>'CommonController@saveSingleImageWritingAtEndSpeakings']);
Route::post('/save-draw-multiple-image-table-new', ['uses'=>'CommonController@saveDrawMultipleImageTableNew']);
Route::post('/save_reading_blanks_new', ['uses'=>'CommonController@saveReadingBlanks']);
Route::get('work-record-new','StudentWorkRecordController@index');
Route::get('work','StudentWorkRecordController@work');
Route::post('student/task-practise','StudentWorkRecordController@getTaskPractise')->name('student.task_practise');
Route::post('student/work-records','StudentWorkRecordController@ajaxList')->name('student.work_records');
Route::get('/getview',['uses'=>'StudentWorkRecordController@ajaxView']);
Route::get('/getExcercise',['uses'=>'StudentWorkRecordController@getExcercise']);
Route::get('/getpractise',['uses'=>'StudentWorkRecordController@getpractise']);
Route::post('view-feedback','ProfileController@viewFeedback')->name('feedback.view');
//------------------------------------------------------------------------------------------------------------------------------
Route::post('/save_reading_blanks_roleplay', ['uses'=>'CommonController@saveReadingBlanksRoleplay']);
Route::post('/save-speaking-multiple-single-image-roleplay',['uses'=>'PractiseNewController@saveSpeakingMultipleSingleImageRoleplay']);
//--------------------------------------------------------------------------------------------------------------------------------------
Route::post('/teacher_marking', ['uses'=>'MarkingController@teacherMarking']);
Route::get('/getlevel',['uses'=>'MarkingController@getlevel']);
Route::get('/gettopic',['uses'=>'MarkingController@gettopic']);
Route::get('/gettask',['uses'=>'MarkingController@gettask']);
Route::get('/getpractice',['uses'=>'MarkingController@getpractice']);
Route::get('/marking_new/{class_id?}',['uses'=>'MarkingController@index']);
// Route::get('/marking/{class_id?}',['uses'=>'MarkingController@index_new']);
Route::get('/getview-marking',['uses'=>'MarkingController@ajaxView']);
Route::get('/getpractise-marking',['uses'=>'MarkingController@getpractise']);
Route::get('marking_list',['uses'=>'MarkingController@markingList'])->name('marking_list');
Route::get('marking/{class_id?}',['uses'=>'MarkingController@newmarking']);
// Route::get('/marking-new/{class_id?}',['uses'=>'MarkingController@kk_index_new']);
Route::post('get-marking-records',['uses'=>'MarkingController@getMarkingRecords'])->name('marking_records');
Route::post('bulk-marking-records',['uses'=>'MarkingController@bulkMarking'])->name('bulk_marking');
Route::get('/practice-detail/{topicId}/{taskId}/{studentId}/{showPrevious?}', ['uses'=>'MarkingController@getPracticeDetail'])->name('practice_detail');
Route::post('/practice-detail/previous-marking', ['uses'=>'MarkingController@showPreviousMarking'])->name('show_previous_history');
Route::post('/practice-submit-marking', ['uses'=>'MarkingController@savePracticeSubmitMarking']);
Route::post('/rename-audio',['uses'=>'MarkingController@renameAudio']);
Route::post('/purchase',['uses'=>'DashboardController@purchase']);
// Route::post('/purchase_model',['uses'=>'DashboardController@purchase_model']);
Route::get('/register',['uses'=>'DashboardController@register']);
Route::post('/store',['uses'=>'DashboardController@store']);


