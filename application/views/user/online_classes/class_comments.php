
<ul id="commentsUl">
    <?php
    foreach ($comments as $comment)
    {
        if($comment->send_by!=$currentId)
        {
            ?>
            <li class="sent">

                    <?php
                    if($comment->type==0)
                    {
                         echo "<p>". $comment->comment_text."</p>";
                    }else
                    {
                        ?>
                        <p class="audio_p">
                        <audio  src="<?=base_url('uploads/voice_comments/').$comment->comment_text?>" controls></audio>
                        </p>
                        <?php
                    }
                    ?>

                <span class="time_date"><?=date('d-M-Y h:i A ',$comment->time)?>  </span>
            </li>
            <?php
        }else {


            ?>
            <li class="replies">

                    <?php
                    $class="";
                    if($comment->type==0)
                    {
                        echo "<p>". $comment->comment_text."</p>";
                    }else
                    {
                        $class="delete-icon"
                        ?>
                      <p class="audio_p" >
                        <audio  src="<?=base_url('uploads/voice_comments/').$comment->comment_text?>" controls></audio>
                </p>
                        <?php
                    }
                    ?>
                <div class="list-icons <?=$class?>">
                    <div class="dropdown">
                        <a href="#" class="list-icons-item" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-option-vertical"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: -135px; transform: translate3d(22px, 1px, 0px);">
                            <button type="submit" value=" " name="p_type" class=" dropdown-item btn btn-info  " onclick="deleteComment('<?=$comment->comment_id?>')">Delete</button>
                        </div>
                    </div>
                </div>

                <span class="time_date_send"> <?=date('d-M-Y h:i A ',$comment->time)?></span>
            </li>


            <?php
        }
    }
    ?>
</ul>