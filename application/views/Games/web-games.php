<!-- Content Wrapper. Contains page content -->

<style>
    .d-none
    {
        display: none;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            <i class="fa fa-facebook"></i> Facebook</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row col-md-12">
            <div class="col-md-3">

                <ul class="treeview-menu1">
                    <li class="info-box  "><a  onclick="displayFrame('fastMathGame','https://www.ilibrarian.net/games/fastmath/index.html')" >Fast Math</a></li>
                    <li class="info-box  "><a onclick="displayFrame('mathPuzzle','https://www.ilibrarian.net/games/math-plus-puzzle/index.html')">Math Plus Puzzle Game</a></li>
                    <li class="info-box  "><a onclick="displayFrame('wordPuzzle','https://www.ilibrarian.net/games/word-puzzle/index.html')">Word Puzzle</a></li>
                </ul>


            </div>
            <div class="col-md-9">
                <div id="fastMathGame" class="d-none"  >
                    <iframe id="frame_fastMathGame" src="" height="580"  style="width: 100%"></iframe>
                </div>
                <div id="mathPuzzle" class="d-none"  >
                    <iframe id="frame_mathPuzzle" src="" height="580"  style="width: 100%"></iframe>
                </div>
                <div id="wordPuzzle" class="d-none"  >
                    <iframe id="frame_wordPuzzle" src="" height="580"  style="width: 100%"></iframe>
                </div>

            </div>
        </div>
     </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<script>
    function displayFrame(divId,url) {
//        alert(url);
        $('.d-none').css('display','none');
        $('.d-none iframe').attr('src', " ");
        $('#'+divId).css('display','block');
        $('#frame_'+divId ).attr('src', url);

    }
</script>