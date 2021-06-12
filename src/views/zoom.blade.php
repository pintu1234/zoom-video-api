<!DOCTYPE html>
<html>
<head>
	<title>HC-ZOOM</title>
    <style>
html,body{
width: 100%;
height: 100%;
}
body {
background: #222;
}
#wc-loading {
width: 100%;
height: 100%;
background: #222;
position: relative;
text-align: center;
}
.loading-main{
position: absolute;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%,-50%);
-moz-transform: translate(-50%,-50%);
-ms-transform: translate(-50%,-50%);
-o-transform: translate(-50%,-50%);
transform: translate(-50%,-50%);
}
.loading-img {
width: 64px;
-webkit-animation: wc-spin infinite 1.5s linear;
-o-animation: wc-spin infinite 1.5s linear;
animation: wc-spin infinite 1.5s linear;
}
@-webkit-keyframes wc-spin {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@-moz-keyframes wc-spin {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@-ms-keyframes wc-spin {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@-o-keyframes wc-spin {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
@keyframes wc-spin {
0% {
-webkit-transform: rotate(0deg);
-moz-transform: rotate(0deg);
-ms-transform: rotate(0deg);
-o-transform: rotate(0deg);
transform: rotate(0deg);
}
100% {
-webkit-transform: rotate(360deg);
-moz-transform: rotate(360deg);
-ms-transform: rotate(360deg);
-o-transform: rotate(360deg);
transform: rotate(360deg);
}
}
.join-meeting {
font-size: 24px;
color: #fff;
margin: 12px auto 14px;
padding-bottom: 25px;
}
.scroll-text {
font-size: 14px;
bottom: 0;
width: 100%;
text-align: center;
white-space: nowrap;
position: absolute;
color: #8A8A9E;
}
.footer{
    padding: 0px 0 0 !important;
}
.join-dialog {
    position: absolute !important;
    left: 0 !important;
    bottom: 0 !important;
    height: 430px !important;
    background: rgba(38,40,42,.95);
    z-index: 11;
    bottom: 0px;
    width: 1299px !important;
}
.modal{
    opacity: 1 !important;
}
</style>
  <link rel="stylesheet" href="https://daycare.doralhealthconnect.com/assets/css/bootstrap.min.css">
  <link href="https://daycare.doralhealthconnect.com/assets/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <a href='{{ url('/calendar') }}'><h4>Add Meeting</h4></a>
	<table id="daycare"  class="display responsive wrap" style="width:100%">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Title</th>
                <th>Instructor Name</th>
                <th>Start Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
	<div class="app-video">
		<div id="zmmtg-root" style="width: 100% !important;"></div>
	</div>
<script src="https://daycare.doralhealthconnect.com/assets/js/jquery.min.js"></script>

<script src="https://daycare.doralhealthconnect.com/assets/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
var i = 1;
var cuurent_date = "<?php echo ('Y-m-d');?>";
    var disabled_buuton = '';
  var tableMy = $('#daycare').DataTable({
            processing: false,
            serverSide: false,
            ajax: {
                url : "{{  route('zoomListing.ajax') }}",
                type : 'GET',
            },
            "initComplete": function (oSettings) {
                $('.app-video').hide();
                $('.scheduled-call').on('click', function () {
                    $('.app-video').addClass('scale-up-center');
                    setTimeout(() => {
                        $('.app-video').show();
                        $('.app-video').removeClass('scale-down-center');
                    }, 1000);
                })

                $(this).on('click', 'i.la-copy', function(e){
                    var dataId = $(this).data("id");

                    var rowData = tableMy.row($(this).closest('tr')).data();
                    var columns = tableMy.settings().pop().aoColumns;
                    var column = columns[tableMy.column($(this).closest('td')).index()];
                    var rowIndex = tableMy.row($(this).closest('tr')).index();
                    $('#activity_model').modal();
                    for(var col in columns){
                        $('#_title').val(rowData[columns[1].data]);
                        $('#_instructor_name').val(rowData[columns[2].data]);
                        var _datetime2 = rowData[columns[3].data].replace("-", "/").replace("-", "/");
                        $('#_datetime').val(_datetime2);
                        var starttime2 = rowData[columns[4].data].replace("am", ":00").replace("pm", ":00");
                        var endtime2 = rowData[columns[5].data].replace("pm", ":00").replace("am", ":00");
                        $('#_time').val(starttime2+'-'+endtime2);
                        $('#_notes').val(dataId);
                    }
                });
              },
            columns: [
                {
                    data:'id',
                    name:'id',
                    "bSortable": true,
                    render: function(data, type, full, meta) {
                        return i++;
                    }
                },
                {
                    data:'title',
                    name:'title',
                    "bSortable": true
                },
                {data:'instructor_name',name:'instructor_name',"bSortable": true},
                {data:'startDate',name:'startDate',"bSortable": true},
                {data:'startTime',name:'startTime',"bSortable": true},
                {data:'endTime',name:'endTime',"bSortable": true},
                {data:'notes',name:'notes',"bSortable": true},
                
                {
                    data:'id',
                    name:'id',
                    "bSortable": true,
                    render: function (data, type, row, meta) {
                        var action = '';
                        if (row.virtual_room){
                            var data = {
                                'meeting_id': row.virtual_room.meeting_id,
                                'name': 'gaurav',
                                'email': 'gauravpatel@hcbspro.com',
                                'password': row.virtual_room.meeting_detail.password
                            }

                            if(cuurent_date == row.startDate){
                                 disabled_buuton = 'disabled';
                            }
                            action = '<div class="d-flex">'+
                                '<button type="button" onclick="startVideoCall('+row.id+')" class="single-upload-btn mr-2" '+disabled_buuton+'>'+
                                '<img src="{{ asset("assets/img/icons/start-vedio.svg")}}" class="icon mr-2">Start Activity'+
                                '</button>'+'</i>'
                                '</div>';
                        }

                        return action;
                    }
                }
            ],
            "order": ['0','asc']
        });
        $(".search_icon").on("input", function (e) {
            e.preventDefault();
        $('#daycare').DataTable().search($(this).val()).draw();
        });
</script>
  <script src="https://source.zoom.us/1.9.5/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.9.5/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-1.9.5.min.js"></script>
    <script>
    ZoomMtg.setZoomJSLib("https://jssdk.zoomus.cn/1.9.5/lib", "/av"); // china cdn option
ZoomMtg.preLoadWasm();
ZoomMtg.prepareJssdk();

const zoomMeeting = document.getElementById("zmmtg-root")

function startZoomMeeting(meetConfig) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:base_url+'/zoom-generate_signature',
        method:'POST',
        data:meetConfig,
        dataType:'json',
        success:function (response) {
            console.log(response)
            beginJoin(response.signature,meetConfig)
        },
        error:function (error) {
            console.log(error)
        }
    })
}

function beginJoin(signature,meetingConfig) {
    console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));
    ZoomMtg.init({
        leaveUrl: meetingConfig.leaveUrl,
        webEndpoint: meetingConfig.webEndpoint,
        isSupportAV: true,
        success: function () {
            // $.i18n.reload(meetingConfig.lang);
            ZoomMtg.join({
                meetingNumber: meetingConfig.meetingNumber,
                userName: meetingConfig.userName,
                signature: signature,
                apiKey: meetingConfig.apiKey,
                userEmail: meetingConfig.userEmail,
                passWord: meetingConfig.passWord,
                success: function (res) {
                    // $('.meeting-app').removeAttr('style');
                    $('.join-dialog').removeAttr('style');
                    $('.active-video-container__wrap').removeAttr('style');
                    console.log("join meeting success");
                    console.log("get attendeelist");
                    ZoomMtg.getAttendeeslist({});
                    ZoomMtg.showPureSharingContent({
                        show: true
                    });
                    ZoomMtg.getCurrentUser({
                        success: function (res) {
                            console.log("success getCurrentUser", res.result.currentUser);
                        },
                    });
                },
                error: function (res) {
                    console.log(res);
                },
            });
        },
        error: function (res) {
            console.log(res);
        },
    });

    ZoomMtg.inMeetingServiceListener('onUserJoin', function (data) {
        console.log('inMeetingServiceListener onUserJoin', data);
    });

    ZoomMtg.inMeetingServiceListener('onUserLeave', function (data) {
        //alert(123)
        console.log('inMeetingServiceListener onUserLeave', data);
    });

    ZoomMtg.inMeetingServiceListener('onUserIsInWaitingRoom', function (data) {
        console.log('inMeetingServiceListener onUserIsInWaitingRoom', data);
    });

    ZoomMtg.inMeetingServiceListener('onMeetingStatus', function (data) {
        console.log('inMeetingServiceListener onMeetingStatus', data);
    });
}

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        var base_url='{{ url('/') }}';
        const simd = async () => WebAssembly.validate(new Uint8Array([0, 97, 115, 109, 1, 0, 0, 0, 1, 4, 1, 96, 0, 0, 3, 2, 1, 0, 10, 9, 1, 7, 0, 65, 0, 253, 15, 26, 11]))
        simd().then((res) => {
            console.log("simd check", res);
        });

        function startVideoCall(activity_id) {
            $('.app-video').addClass('scale-up-center');
            $("#loader-wrapper").show();
            $.ajax({
                url:base_url+'/start-meeting',
                method:'POST',
                data:{
                    activity_id:activity_id,
                    role:1
                },
                dataType:'json',
                success:function (response) {
                  const sources = response.data;
                    const meeting = sources;
                    if (meeting){
                        const meetConfig = {
                            apiKey: meeting.apiKey,
                            meetingNumber:parseInt(meeting.meetingNumber),
                            leaveUrl:base_url+'hc-zoom',
                            userName: meeting.userName,
                            userEmail: meeting.userEmail, // required for webinar
                            passWord: meeting.passWord, // if required
                            lang: meeting.lang,
                            china: meeting.china,
                            role: parseInt(meeting.role, 10) // 1 for host; 0 for attendee or webinar
                        };
                        //
                        startZoomMeeting(meetConfig);
                        console.log(meetConfig);
                        
                        setTimeout(() => {
                            $('.app-video').show();
                            $('.app-header-block').hide()
                            $('.app-video').removeClass('scale-down-center');
                        }, 1000);
                    }

                },
                error:function (error) {
                    const sources = JSON.parse(error.responseText);
                    alert(sources.message)
                }
            })

            //

        }
        </script>
</body>
</html>