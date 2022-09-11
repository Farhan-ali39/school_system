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
        padding: 12px 20px;
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
        right: unset !important;
        width: 20px!important;
        height: 20px!important;
        padding: 0px!important;
        line-height: 0px!important;
    }
</style>
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

            <input type="hidden" id="url_input" value="<?=(isset($onlineClass)?$onlineClass['vid_url']:"")?>">
            <input type="hidden" id="thumb_path_input" value="">
            <input type="hidden" id="media_type_input" value="video">
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
                </div><!--/.col (left) -->
            </div>
            <div class="row">
                <div class="col-md-12">
                </div><!--/.col (right) -->
            </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        updateMediaDetailPopup( );

        function updateMediaDetailPopup() {
            var url=$("#url_input").val();
            var thumb_path=$("#thumb_path_input").val();
            var  media_type=$("#media_type_input").val();
            var content_popup = "";
            if (media_type == "video") {
                var youtubeID = YouTubeGetID(url);
                content_popup = '<object data="https://www.youtube.com/embed/' + youtubeID + '" width="100%" height="400"></object>';
            } else {
                content_popup = '<img src="' + thumb_path + '" class="img-responsive">';
            }
            $('.popup_image').html("").html(content_popup);


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

