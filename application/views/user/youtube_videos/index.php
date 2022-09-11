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

            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary" id="holist">
                    <div class="box-body">
                        <div class="row">
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
        load(1);
        $(document).on("click", ".pagination li a", function (event) {
            event.preventDefault();
            var page = $(this).data("ci-pagination-page");
            load(page);
        });
        $(".search_text").keyup(function () {
            load(1);
        });
        $(".file_type").change(function () {
            load(1);
        });

        $('#postdate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });

        $("#confirm-delete").modal({
            backdrop: false,
            show: false

        });
        $('#confirm-delete').on('show.bs.modal', function (e) {

            var record_id = $(e.relatedTarget).data('record_id');
            $('#record_id').val(0).val(record_id);
            $('.del_modal_title').html("Delete Confirmation");
            $('.del_modal_body').html('<p>Are you sure to delete !</p>');
        });
        $('#detail').on('show.bs.modal', function (e) {
            var data = $(e.relatedTarget).data();
            var media_content_path = "<a href='" + data.source + "' target='_blank'>" + data.source + "</a>";
            $('#modal_media_name').text("").text(data.media_name);
            $('#modal_media_path').html("").html(media_content_path);
            $('#modal_media_type').text("").text(data.media_type);
            $('#modal_media_size').text("").text(convertSize(data.media_size));
            updateMediaDetailPopup(data.media_type, data.source, data.image);

        });

        function updateMediaDetailPopup(media_type, url, thumb_path) {
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


        $("#video_form").submit(function (e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = $(this).attr("action");
            var $this = $('.video_submit');

            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: $('#video_form').serialize(),
                beforeSend: function () {
                    $this.button('loading');
                    $("[class$='_error']").html("");
                },
                success: function (data) {
                    if (data.status == 1) {
                        load(1);
                    } else {
                        if (typeof data.error !== 'undefined') {
                            $('.file_error').html(data.error.video_url)
                        } else {
                            errorMsg(data.msg);
                        }
                    }

                },
                error: function (xhr) { // if error occured
                    $this.button('reset');
                },
                complete: function () {
                    $this.button('reset');
                },
            });


        });

    });
    function load(page) {
        var keyword = $('.search_text').val();
        var file_type = $('.file_type').val();
        var is_gallery = 0;
         
        $.ajax({
            url: "<?php echo base_url(); ?>user/media/getYoutubeVideos/" + page,
            method: "GET",
            data: {'keyword': keyword, 'file_type': file_type, 'is_gallery': is_gallery},
            dataType: "json",
            beforeSend: function () {
                $('#media_div').empty();
            },

            success: function (data)
            {
                $('#media_div').empty();
                if (data.result_status === 1) {
                    $.each(data.result, function (index, value) {
                        $("#media_div").append(data.result[index]);
                    });
                    $('#pagination_link').html(data.pagination_link);
                } else {
                }
            },
            complete: function () {


            }
        });
    }

    //========================

    $(function () {
        // Drop
        $('.upload-area').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
            console.log(fd);
            return false;
            var file = e.originalEvent.dataTransfer.files;
            var fd = new FormData();
            var ins = document.getElementById('file').files.length;
            for (var x = 0; x < ins; x++) {
                fd.append("files[]", document.getElementById('file').files[x]);
            }

            uploadData(fd);
        });

        // Open file selector on div click
        $("#files").click(function () {
            $("#file").click();
        });

        // file selected
        $("#file").change(function () {
            var fd = new FormData();
            var fileInput = document.getElementById('file');
            var filePath = fileInput.value;

            var allowedExtensions = /(\.mp4|\.mov|\.flv|\.wmv|\.avi|\.mpg|\.mpeg|\.rm|\.ram|\.swf|\.ogg|\.webm|\.mkv|\.wav|\.mp3|\.aac)$/i;
            if (allowedExtensions.exec(filePath)) {
                errorMsg('File Type not allowed');
                fileInput.value = '';
                return false;
            }
            var ins = fileInput.files.length;

            for (var x = 0; x < ins; x++) {
                fd.append("files[]", document.getElementById('file').files[x]);
            }
            uploadData(fd);
        });
    });

    // Sending AJAX request and upload file


    // Bytes conversion
    function convertSize(bytes, decimalPoint) {
        if (bytes == 0)
            return '0 Bytes';
        var k = 1024,
            dm = decimalPoint || 2,
            sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
            i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

</script>

<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fullshadow">
            <!--<div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Media Detail r</h4>
            </div> -->
            <button type="button" class="ukclose" data-dismiss="modal">&times;</button>
            <div class="smcomment-header">
                <div class="row">
                    <div class="col-md-8 col-sm-8 popup_image">


                    </div>
                    <div class="col-md-4 col-sm-4 smcomment-title">
                        <dl class="mediaDL">
                            <dt><?php echo $this->lang->line('media_name'); ?></dt>
                            <dd id="modal_media_name"></dd>
                            <dt><?php echo $this->lang->line('media_type'); ?></dt>
                            <dd id="modal_media_type"></dd>
                            <dt><?php echo $this->lang->line('media_path'); ?></dt>
                            <dd id="modal_media_path"></dd>
                            <dt><?php echo $this->lang->line('media_size'); ?></dt>
                            <dd id="modal_media_size"></dd>

                        </dl>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php //echo $this->lang->line('cancel');   ?></button>
            </div> -->
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" id="record_id" name="record_id" value="0">
            <div class="modal-header">
                <h4 class="modal-title del_modal_title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body del_modal_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                <a class="btn btn_delete btn-danger" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Please Wait.."><?php echo $this->lang->line('delete'); ?></a>
            </div>
        </div>
    </div>
</div>
