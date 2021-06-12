
<link rel="stylesheet" href="https://daycare.doralhealthconnect.com/assets/css/calendar/lib/main.css">
<link rel="stylesheet" href="https://daycare.doralhealthconnect.com/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://daycare.doralhealthconnect.com/assets/css/daterangepicker.min.css">
<div id='calendar'></div>
<!--modal -->
<div class="modal fade fade2 dialogue" tabindex="-1" role="dialog"  id="activity_model">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Activity Center</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row gutter">
                            <div class="col-12 col-sm-12">
                                <label for="_title" class="label">Title</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom" id="admissionId">
                                        <i class="las la-heading"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" id="_title" name="_title"
                                        aria-describedby="_titleHelp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="row gutter">
                            <div class="col-12 col-sm-6">
                                <label for="_patient" class="label">Instructor Name</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom" id="admissionId">
                                        <i class="las la-user-tie"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" id="_instructor_name"
                                        name="_instructor_name" aria-describedby="_instructor_name">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <label for="_datetime" class="label"> Date</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom" id="admissionId">
                                        <i class="las la-calendar-alt"></i>
                                    </span>
                                    <input  type="text" class="form-control form-control-lg" id="_datetime"
                                        name="_datetime" aria-describedby="_datetimeHelp">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <label for="_datetime" class="label"> Start End Time </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom" id="admissionId">
                                        <i class="las la-calendar-alt"></i>
                                    </span>
                                    <input  type="text" class="form-control form-control-lg _time" id="_time"
                                        name="_time" aria-describedby="__timemeHelp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <label for="_notes" class="label">Notes</label>
                                <textarea class="form-control form-control-lg" name="_notes" id="_notes"
                                    rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="_id" value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-event">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@php
$event_array = [];
$result = ($result) ? $result : '';
foreach($result  as $row){
    $event_array[] = array('id'=>$row['id'],'title'=>$row['title'],'start'=>$row['startDate'].'T'.$row['startTime'],'end'=>$row['startDate'].'T'.$row['endTime'],'notes'=>$row['notes'],'instructor_name'=>$row['instructor_name'],'startdate'=>$row['startdate'],'enddate'=>$row['startDate'],'startTimeORG'=>$row['startTime'],'endTimeORG'=>$row['endTime']);
}
$event_array =  json_encode($event_array);
@endphp
<script src="https://daycare.doralhealthconnect.com/assets/js/jquery.min.js"></script>

<script src="https://daycare.doralhealthconnect.com/assets/js/calendar/lib/main.js"></script>
<script src="https://daycare.doralhealthconnect.com/assets/js/moment.min.js"></script>
<script src="https://daycare.doralhealthconnect.com/assets/js/bootstrap.min.js"></script>
<script src="https://daycare.doralhealthconnect.com/assets/js/daterangepicker.min.js"></script>
 <script>
    var now = new Date();
     var myArray = <?php echo $event_array;?>;
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'EST',
                initialView: 'timeGridFourDay',
                height: '100%',
                themeSystem: 'bootstrap4',
                aspectRatio: 2,
                windowResizeDelay: 100,
                stickyHeaderDates: true,
                headerToolbar: {
                    left: 'title',
                    center: '',
                    right: 'dayGridMonth timeGridDay today prev,next'
                },
                initialDate: now,
                expandRows: true,
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,
                selectHelper: true,
                businessHours: false,
                eventColor: '#008591',
                select: function (arg, start, end, allDay) {
                $("#_id").val('');
                $("#_title").val('');
                $("#_instructor_name").val('');
                $("#_notes").val('');
                var current_date = new Date();
                $("#_datetime").val(moment().format("M/DD/YYYY"));
                    var selectDate = arg.startStr.split('T')[0];
                     $("#_datetime").val(selectDate)
                    $('#_time').val('');
                    $('.dialogue').modal('show');
                    var now = new Date(arg.start);
                   var utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);
                   var utcDate_start = new Date(new Date(arg.startStr).toUTCString());
                   var utcDate_end = new Date(new Date(arg.endStr).toUTCString());
                   var start_time = utcDate_start.toTimeString();
                   start_time = start_time.split(' ')[0];

                   var end_time = utcDate_end.toTimeString();
                   end_time = end_time.split(' ')[0];
                   var current_sel_date = moment(utc).format("HH:mm:ss")+'-'+end_time;

                  $('#_time').val(current_sel_date);
                  
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    list: 'List'
                },
                views: {
                    dayGridMonth: { // name of view
                        titleFormat: { year: 'numeric', month: 'short', day: 'numeric' }
                        // other view-specific options here
                    },
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: { days: 6 },
                        buttonText: '4 day'
                    }
                },

                eventRender: function (event, element) {
                },
                eventDidMount: function (info) {
                },
                dateClick: function(info) {
                },
                   eventClick: function (event, jsEvent, view) {
                     
                     var result = $.grep(myArray, function(e){ return e.id == event.event._def.publicId; });

                     $("#_id").val(event.event._def.publicId);
                     $("#_title").val(result[0].title);
                     $("#_instructor_name").val(result[0].instructor_name);
                     $("#_notes").val(result[0].notes);
                      var main_date = result[0].start+"-"+result[0].end;

                    var d = new Date(result[0].start);
                    var years = d.getFullYear();
                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    
                        var orignal_startdate = month+"/"+day+"/"+years;
                        
                        //$("#_datetime").data('daterangepicker').setStartDate(orignal_startdate);
                        var odate = orignal_startdate;
                        var otime = result[0].startTimeORG+'-'+result[0].endTimeORG;
                        
                        $("#_datetime").val(odate)
                        $("#_time").val(otime)
                        $('.modal').modal();
                },
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: <?php echo $event_array;?>,
                
            });

            calendar.render();
        });
        $(function () {
            $('input[name="_datetime"]').daterangepicker({
                //timePicker: true,
                singleDatePicker: true,
                 //endDate: moment().startOf('hour').add(32, 'hour'),
                 defaultDate: moment().format("M/DD/YYYY"),
                locale: {
                   // format: 'M/DD/YYYY hh:mm A'
                   format: 'M/DD/YYYY'
                }
            });

            $('input[name="_time"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                timePickerSeconds: true,

                //singleDatePicker: true,
                locale: {
                   // format: 'M/DD/YYYY hh:mm A'
                   format : 'HH:mm:ss'
                }
            }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide()});
        });
        
        $("#save-event").on("click",function(){
            var base_url='{{ url('/') }}';
            var id = $('#_id').val();
            var title = $('#_title').val();
            var instructor_name = $('#_instructor_name').val();
            var notes = $('#_notes').val();
            var time = $('#_time').val();
            var orignal_startdate = $("#_datetime").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
               url:'{{ route('calendar.store') }}',
               method:"POST",
               data:{'id':id,'user_id':1,'title':title,'instructor_name':instructor_name,'notes':notes,'startDate':orignal_startdate,'time':time},
               success:function(data)
               {
                alert(data.message);
                window.location = base_url+"/hc-zoom";
               }
            });
        });

        // 

        
    </script>
 <style>
        .fc-non-business{pointer-events: none!important;}
</style>
