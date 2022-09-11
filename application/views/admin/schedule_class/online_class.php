<style type="text/css">
    .files {
        /* outline: 2px dashed #424242;
         outline-offset: -10px;*/
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
        padding: 0px 0px 0px 0;
        text-align: center !important;
        margin: 0;
        font-size: 1.2em;
        width: 100% !important;
    }
    .files label{display: block;}
    .files input:focus{     /*outline: 2px dashed #92b0b3;  outline-offset: -10px;*/
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
    }
    .files{ position:relative;background-color: rgb(245, 245, 245);
        border: 1px solid rgba(0, 0, 0, 0.06);}
    .files:after {
        pointer-events: none;
        position: absolute;
        top: 14px;
        left: 20px;
        color:#767676;
        font-size: 36px;
        font-family: 'FontAwesome';
        /*width: 50px;
        right: 0;
        height: 50px;*/
        content: "\f0ee";
        /* background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);*/
        display: block;
        margin: 0 auto;
        background-size: 100%;
        background-repeat: no-repeat;
    }
    .color input{ background-color:#f1f1f1;}
    .files:before {
        position: absolute;
        bottom: 27px;
        left: 0;
        pointer-events: none;
        width: 100%;
        right: 0;
        /* height: 90px; */
        content: "Choose a file or drag it here.";
        display: block;
        margin: 0 auto;
        color: #767676;

        text-align: center;
        transition: .3s;
    }
    .files:hover:before{color: #faa21c;}
    .files input[type=file] {
        opacity:0;
        cursor: pointer;
        height: 70px;
    }
    .modal-lg{width: 1100px;}
    @media (max-width:767px){
        .modal-lg{width:100%;}
    }
    .messages {
        height: auto;
        min-height: calc(100% - 115px);
        max-height: calc(100% - 115px);
        overflow-y: scroll;
        overflow-x: hidden;
        width: 100%;
        padding-bottom: 20px;
    }
    #frame {
        width: 100%;
        height: 88vh;
        background: #e6e6e6;
        position: relative;
        display: flex;
    }
    #frame .message-input {
        position: absolute;
        bottom: 0;
        width: 98%;
        z-index: 1;
        margin: 0 auto 10px;
        left: 0;
        right: 0;
    }
    #frame .message-input .wrap {
        position: relative;
        border-radius: 30px;
        box-shadow: 0 0 2rem 0 rgba(136,152,170,.15);
    }
    #frame .message-input .wrap input {
        /* float: left; */
        border: none;
        width: 100%;
        /* width: calc(100% - 54px); */
        padding: 12px 45px;
        color: #32465a;
        border-radius: 30px;
    }
    #frame .message-input .wrap button {
        /* float: right; */
        border: none;
        width: 34px;
        height: 34px;
        line-height: 34px;
        /* padding: 12px 0; */
        cursor: pointer;
        background: #3db16b;
        color: #fff;
        position: absolute;
        right: 4px;
        border-radius: 100%;
        top: 4px;
        transition: all .3s;
    }
    .recording_btn
    {
        left: 2px !important;
        right: unset !important;
        width: 35px!important;
        height: 35px!important;
        padding: 4px!important;
        line-height: 0px!important;
    }
    #frame .chatcontent .messages ul li.replies .audio_p:before
    {
        border-left: 0px solid #24b9ec !important;
    }
    #frame .chatcontent .messages ul li.sent .audio_p:before
    {
        border-right: 0px solid #24b9ec !important;
    }
    #frame .chatcontent .messages ul li.replies p:before
    {
        border-left: 0px solid #24b9ec !important;
    }
    #frame .chatcontent .messages ul li.sent p:before
    {
        border-right: 0px solid #24b9ec !important;
    }
    #frame .chatcontent .messages ul li .audio_p
    {
        box-shadow: none !important;
    }
    #frame .chatcontent .messages ul li.replies .audio_p
    {
        background: none !important;

    }
    #frame .chatcontent .messages ul li.sent .audio_p
    {
        background: none !important;
    }
     .d-none
    {
        display: none !important;
    }
    @media screen and (max-width: 735px){
        #frame .chatcontent {
            width: calc(100% - 0px) !important;
            /* min-width: 300px !important; */
        }
        .replies .audio_p audio{
            margin-left: -55% !important;
        }
        .sent .audio_p audio{
            margin-left: -20% !important;
        }
    }
    .comment-chatbadge {
        position: absolute;
        right: 5px;
        top: 10px;
        width: 15px;
        height: 15px;
        color: #fff;
        text-align: center;
        background: #779f08;
        border-radius: 100%;
        font-size: 10px;
    }
    .blinking{
        animation:blinkingText 0.8s infinite;
    }
    @keyframes blinkingText{
        0%{		color: red;	}
        49%{	color: transparent;	}
        50%{	color: transparent;	}
        99%{	color:transparent;	}
        100%{	color: #000;	}
    }
</style>
<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100%;
    }
    @media (max-width: 767px)
    {
        .button-gloss
        {
            margin-left: 0%!important;
        }
    }
    .delete-icon
    {
        margin-top: 30px !important;
    }
    .list-icons {
        /*display: -ms-inline-flexbox;*/
        display: block;
        /*-ms-flex-align: center;*/
        align-items: center;
        margin-left: 100%;
        margin-top: 10px;
    }
    a.list-icons-item:not([class*=text-]) {
        color: inherit;
    }
    a.list-icons-item {
        transition: all ease-in-out .15s;
    }

    .list-icons-item {
        display: inline-block;
        line-height: 1;
    }
    .dropdown-menu[x-placement^=bottom], .dropdown-menu[x-placement^=left], .dropdown-menu[x-placement^=right], .dropdown-menu[x-placement^=top] {
        right: auto;
        bottom: auto;
    }
    .dropdown-menu-right {
        /*right: 0;*/
        /*left: auto;*/
    }
    .dropdown-menu {
        /*position: absolute;*/
        /*top: 100%;*/
        /*left: 0;*/
        z-index: 1000;
        display: none;
        float: left;
        min-width: 11.25rem;
        padding: .5rem 0;
        margin: .125rem 0 0;
        font-size: 12px;
        color: #333;
        text-align: left;
        list-style: none;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: .1875rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,.1);
    }
    .dropdown-item {
        /*display: -ms-flexbox;*/
        display: flex;
        /*-ms-flex-align: center;*/
        align-items: center;
        position: relative;
        outline: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        margin-bottom: 0;
        transition: background-color ease-in-out .15s,color ease-in-out .15s;
    }

    .dropdown-item {
        /*display: block;*/
        width: 100%;
        padding: .5rem 1rem;
        clear: both;
        font-weight: 400;
        color: #333;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }
    #commentBtn:active:focus
    {
        color: #fff;
        background-color: #4755AB;
        border-color: #4755AB;
    }
    #commentBtn
    {
        width:100%;
    }
</style>

<script type="text/javascript">
    var baseurl = "<?=base_url()?>";
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-empire"></i> <?php echo $this->lang->line('front_cms'); ?>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if(!empty($onlineClass))
            {
                ?>

            <input type="hidden" id="url_input" value="<?=(isset($onlineClass)?$onlineClass['url']:"")?>">
            <input type="hidden" id="schedule_id" value="<?=(isset($onlineClass)?$onlineClass['schedule_id']:"")?>">
            <input type="hidden" id="thumb_path_input" value="">
            <input type="hidden" id="media_type_input" value="video">
            <input type="hidden" id="commentType" value="1">
            <input type="hidden" id="commentCount" value="0">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary" id="holist">
                    <div class="box-body">
                        <div class="row col-md-12 popup_image">
                            <div class="col-md-12 col-sm-12">
                                <div class="mediarow">
                                    <div class="row" id="media_div"></div></div>
                                <div align="right" id="pagination_link"></div>
                            </div>

                        </div>

                    </div><!-- /.box-body -->
                    <button class="btn btn-info col-md-12" data-target="#commentBox" id="commentBtn" data-toggle="modal" style="padding: 6px 25px;">  Comments <span class="comment-chatbadge  " style="display: none;" id="commentCounter">0</span> </button>

                </div><!--/.col (left) -->
            </div>

            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->

        <?php
            }else
            {
                ?>
                <div class="alert alert-info">No Online Class Schedule Found</div>
                <?php
            }
            ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="norecord modal fade" id="commentBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="center" >Comment Box</h4>
            </div>
            <div class="modal-body">
                <div class="row  " >
                    <div id="frame" style="height: 73vh">
                        <div class="chatcontent">
                            <div class="messages" id="commentsList" style="max-height: calc(100% - 75px);">

                            </div>
                        </div>
                        <div class="message-input ">
                            <div class="wrap relative">
                                <div id="controls">
                                    <button id="recordButton" class="recording_btn "><i class="fa fa-microphone" aria-hidden="true"></i></button>
                                    <button id="pauseButton"   style="display: none" disabled>Pause</button>
                                    <!--                                              <button class="recording_btn" id="stopButton" disabled style="top: 25px;"><i class="fa fa-send-o" aria-hidden="true"></i></button>-->
                                </div>
                                <input type="text"   placeholder="Write your comment..." onkeypress="btnProp()" class="chat_input">
                                <!-- <i class="fa fa-paperclip attachment" aria-hidden="true"></i> -->
                                <button class="submit input_submit" id="stopButton"  onclick="postComment()"  disabled ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                            <div style="display: none" id="formats">Format: start recording to see sample rate</div>
                            <p style="display: none"><strong>Recordings:</strong></p>
                            <ol style="display: none" id="recordingsList"></ol>
                            <!--                                    <div id="controls">-->
                            <!--                                        <button id="recordButton">Record</button>-->
                            <!--                                        <button id="pauseButton" disabled>Pause</button>-->
                            <!--                                        <button id="stopButton" disabled>Stop</button>-->
                            <!--                                    </div>-->
                        </div>
                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
     setInterval(function(){
         checkNewComment();
         }, 5000);

     function checkNewComment() {
         var schedule_id = $("#schedule_id").val();
         var commentCount = $("#commentCount").val();

         if(schedule_id!=undefined)
         {
             $.ajax({
                 type: "POST",
                 url: baseurl + 'admin/teacher/checkNewComment',
                 data: {'schedule_id': schedule_id, 'commentCount': commentCount},

                 dataType: "JSON",
                 beforeSend: function () {

                 },
                 success: function (data) {
                     if(data.status)
                     {
                         $("#commentCounter").css('display','block');
                         $("#commentCounter").html(data.count);
//                    getAllComments();
                     }else
                     {
                         $("#commentCounter").css('display','none');
                     }
                 },
                 error: function (jqXHR, textStatus, errorThrown) {

                 },
                 complete: function (data) {

                 }
             });

         }

     }
    function btnProp() {
        $("#recordButton").removeClass("blink");
        $('#commentType').val(1);
        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            $('#stopButton').prop('disabled', true);
        }else {
            $('#stopButton').prop('disabled', false);
        }
    }
    function postComment() {
        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }
        newChatMessage();
//        e.preventDefault(); // To prevent the default
    }
    function newChatMessage() {
        message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }

        var schedule_id = $("#schedule_id").val();


        if (schedule_id > 0  ) {

            $.ajax({
                type: "POST",
                url: baseurl + 'admin/teacher/sendComment',
                data: {'schedule_id': schedule_id, 'message': message},

                dataType: "JSON",
                beforeSend: function () {

                },
                success: function (data) {
                    $('#stopButton').prop('disabled', true);
                    getAllComments();
                    $(".message-input input").val("");
//                    $('.messages').animate({
//                        scrollTop: $('.messages')[0].scrollHeight}, "slow");

                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
                complete: function (data) {

                }
            });
        }

    }
    function getAllComments() {

        var schedule_id = $("#schedule_id").val();
        if(schedule_id!=undefined){
            $.ajax({
                type: "POST",
                url: baseurl + 'admin/teacher/getAllComments',
                data: {'schedule_id': schedule_id},

                dataType: "JSON",
                beforeSend: function () {

                },
                success: function (data) {
                    $("#commentsList").html("").html(data.commentsList);
                    $(".message-input input").val("");
                    $('#commentType').val(1);
                    $('#commentCount').val(data.count);
//                $('.messages').animate({
//                    scrollTop: $('.messages')[0].scrollHeight}, "slow");

                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
                complete: function (data) {

                }
            });

        }
    }

    function deleteComment(commentId=null) {
         if(commentId!=null)
         {
             $.ajax({
                 type: "POST",
                 url: baseurl + 'admin/teacher/deleteComment',
                 data: {'commentId': commentId},

                 dataType: "JSON",
                 beforeSend: function () {

                 },
                 success: function (data) {
                     if(data.status)
                     {
                         getAllComments();
                     }
                  },
                 error: function (jqXHR, textStatus, errorThrown) {

                 },
                 complete: function (data) {

                 }
             });

         }

    }

    $(document).ready(function () {

        updateMediaDetailPopup( );

        $('#commentBox').on('show.bs.modal', function (e) {
            getAllComments();

        });


//        $(document).on('click', '.input_submit', function (e) {
//
//
//            message = $(".message-input input").val();
//            if ($.trim(message) == '') {
//                return false;
//            }
//            newChatMessage();
//            e.preventDefault(); // To prevent the default
//        });


        function updateMediaDetailPopup() {
            getAllComments();
            var url=$("#url_input").val();
            var thumb_path=$("#thumb_path_input").val();
            var  media_type=$("#media_type_input").val();
            var content_popup = "";
            if (media_type == "video") {
                var youtubeID = YouTubeGetID(url);
                content_popup = '<object data="https://www.youtube.com/embed/' + youtubeID + '?controls=1&modestbranding=1&rel=0&fs=1" width="100%" height="580" allowfullscreen></object>';
            } else {
                content_popup = '<img src="' + thumb_path + '" class="img-responsive">';
            }
            $('.popup_image').html("").html(content_popup);
            $(".ytp-button").addClass("d-none");
           
            // var element = document.getElementsByClassName("ytp-copylink-button ytp-show-copylink-title ytp-copylink-button-visible");
            // element.classList.add("d-none");
            

        }


        function YouTubeGetID(url) {
            var ID = '';
            url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
            if (url[2] !== undefined) {
                ID = url[2].split(/[^0-9a-z_\-]/i);
                ID = ID[0];
            } else {
                ID = url;
            }
            return ID;
        }
    });
</script>

