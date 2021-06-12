<?php

Route::get('hc-zoom', 'Hcbszoom\Zoom\ZoomController@zoom');
Route::get('/zoomListing_ajax', 'Hcbszoom\Zoom\ZoomController@zoomaAjaxList')->name('zoomListing.ajax');
Route::post('/zoom-generate_signature','Hcbszoom\Zoom\ZoomController@zoomGenerateSignature');
Route::get('calendar', 'Hcbszoom\Zoom\ZoomController@calendar');
Route::post('/calendar-store', 'Hcbszoom\Zoom\ZoomController@store')->name('calendar.store');
Route::post('/start-meeting', 'Hcbszoom\Zoom\MeetingController@startMeeting')->name('start_meeting');

