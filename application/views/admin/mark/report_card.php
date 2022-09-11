<?php

//school_id ==1 Means Pre-primary School
//school_id ==2 Means Primary and Secondary  School
//examType ==1 Means This exam is assesment
//examType ==2 Means This exam is term

if($school_id==1 && $examType==1)
{

    ?>
<!--    Your HTML IS HERE-->
    <!--    Your HTML IS HERE-->
    <!DOCTYPE html>
    <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Leadership School</title>
        <style type="text/css">
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #464a46;
                padding: 3px;
            }

            #customers tr:nth-child(even){}

            #customers tr:hover {}

            #customers th {
                padding-top: 3px;
                padding-bottom: 3px;
                text-align: left;
                background-color: #464a46;
                color: white;
            }
            body{
                width: 8.3in;
                height: 10.2in;
                margin: auto;
                font-size: 12px;
            }
            .wrapper{
                position: relative;
                /*margin: .5in;*/
                border: 4px solid #464a46;
                border-style: dashed;
                padding: 15px;
                height: 10.5in;
            }

        </style>
    </head>
    <body>
    <div class="wrapper">
        <?php
        //            var_dump($student_exam_result[0]->class);
        //            die();
//                    echo "<pre>";
//                    var_dump(array_unique( $student_exam_result));
//                    die();
        ?>
        <table style="margin-top: .3in; width: 100%">
            <tr style="text-align: left;">
                <th style="width: 100px;"><img src="<?=base_url('uploads/')?>logo.jpg"></th>
                <th style="padding-left: 155px;line-height: 5px;"><h2>Student 's Monthly Progress Report</h2>
<!--                    <p>PECHS Campus</p><p><b>Assessment 2018-19</b></p><p><b>--><?//=$student_exam_result[0]?><!-- Result card</b></p>-->
                </th>
            </tr>
        </table>
        <div style="height: 65px ;float: left; width: 350px; border: 2px solid;">
            <div style="text-align: right;width: 30%; float: left;">
                <b><p>Student Name:<br>
                        Class:<br>
                        Roll Number:</p></b>
            </div>
            <div style="text-align: left;width: 67%; float: right;">
<!--                ." ".$student_exam_result[0]->lastname-->
                <p><?=$student_exam_result[0]->firstname?><br>
                    <?=$student_exam_result[0]->class?><br>
                    <?=$student_exam_result[0]->roll_no?></p>
            </div>
        </div>
        <div style="float: right; width: 250px; border: 2px solid; height: 65px ;margin-bottom: 10px">
            <div style="text-align: right;width: 30%; float: left;">
                    <b><p>Campus:<br>
                            Exams :<br>
                           </p></b>
                </div>
                <div style="text-align: left;width: 67%; float: right;">
                    <p>PECHS Campus<br>
                       Monthly Assessments<br>
                       </p>
                </div>
        </div>


<!--        <center ><h2 style="display: -webkit-inline-box; display: inline-block;">ACADEMIC PERFORMANCE</h2></center>-->

        <table id="customers" style="width:100%">
            <tr>
                <th>Sr#</th>
                <th>Subject</th>
<!--                <th>Highest Grade</th>-->
                <th style="text-align: center">Grade/Rating</th>
                <th style="text-align: center">Class work</th>
                <th style="text-align: center">Home work</th>
                <th style="text-align: center">Behaviour</th>
            </tr>
            <?php
            $sr=1;
//            $total_obtain_marks=0;
//            $total_marks=0;
            foreach ($student_exam_result as $value)
            {
                $ci =& get_instance();
                $ci->load->model('Examresult_model');
                $get_grades=$ci->Examresult_model->getGrades($value->student_id,$value->exam_result_id);
//                $total_obtain_marks=$total_obtain_marks+$value->get_marks;
//                $total_marks=$total_marks+$value->full_marks;

                ?>
                <tr>
                    <td><?=$sr?></td>
                    <td><?=$value->name?></td>
<!--                    <td>A</td>-->
                    <td style="text-align: center">
                        <?php
                        if($value->attendence=="ABS")
                        {
                            $get_marks="ABS";
                        }else
                        {
                            $get_marks=$value->get_marks;
                        }
                        ?>

                        <?=$get_marks?></td>
                    <td style="text-align: center"><?=$get_grades->class_work?></td>
                    <td style="text-align: center"><?=$get_grades->home_work?></td>
                    <td style="text-align: center"><?=$get_grades->behaviour?></td>
                </tr>

                <?php
                $sr++;
            }
            ?>
<!--            <tr style="background-color: #464a46; color: white;">-->
<!--                <td colspan="2" style="border: 1px solid #f2fff2;">Overall Result</td>-->
<!--                <td style="border: 1px solid #f2fff2;">Grade</td>-->
<!--                <td style="border: 1px solid #f2fff2;">Grade</td>-->
<!--                <td colspan="3" style="border: 1px solid #f2fff2;">Grade</td>-->
<!---->
<!---->
<!--            </tr>-->

        </table>

        <p>Please tally the grading with the chart below and find out the subject teacher’s impressions regarding your child’s performance in each subject. The class teacher’s comments are given for your information.
        </p>
        <center ><h3 style="display: -webkit-inline-box; display: inline-block;">TEACHER’S IMPRESSION CHART</h3></center>
        <table id="customers" style="width:100%">
            <tr>
                <th style="text-align: center;">Grade</th>
                <th style="text-align: center;">Class Work</th>
                <th style="text-align: center;">Home Work</th>
                <th style="text-align: center;">Behaviour</th>

            </tr>
            <tr>
                <td style="text-align: center">A</td>
                <td>Doing well. Very attentive. Congratulations. </td>
                <td>Takes a keen interest. Does home work regularly</td>
                <td>Anxious to learn, regular in school.</td>
            </tr>
            <tr>
                <td style="text-align: center">B</td>
                <td>Generally doing well. Can improve easily.
                </td>
                <td>Sometimes fails to do homework. Should be more devoted.
                </td>
                <td>Should be more serious towards learning. Generally acceptable. </td>
            </tr>
            <tr>
                <td style="text-align: center">C</td>
                <td>Should improve quickly. Parents may communicate with teacher.
                </td>
                <td>Less interest in homework. Parents should encourage.
                </td>
                <td>Generally not satisfactory.  Parent’s guidance necessary.</td>
            </tr>
            <tr>
                <td style="text-align: center">D</td>
                <td>Falling behind other students. Parent’s involvement thoroughly recommended.
                </td>
                <td>Very weak area. Parent’s immediate attention necessary.
                </td>
                <td>Unacceptable attitude. Parents should contact the class teacher and Principal.
                </td>
            </tr>
            <tr>
                <td>Class Teacher Comments</td>
                <td colspan="3"><?php
                    if(empty($remarks))
                    {
                        echo "No Remarks";
                    }else
                    {
                        echo $remarks;
                    }
                    ?></td>
            </tr>
        </table>

        <table id="customers" style="margin-top: 2%" >
            <tr>
                <th style="text-align: center;">Achievement Ratings</th>

            </tr>
            <tr>
                <td><span style="margin-left: 50px; margin-right: 50px">A-Excellent</span> <span style="margin-left: 50px; margin-right: 50px">B-Good</span><span style="margin-left: 50px; margin-right: 50px">C-Satisfactory</span><span style="margin-left: 50px; margin-right: 50px">D-Needs Improvement</span></td>

            </tr>

        </table>



        <table style="width: 100%;position: absolute;
    bottom: 0px;">
            <tr>
                <th><p>-------------------<br>Class Teacher</p></th>
                <th><p>-------------------<br>Principle</p></th>
                <th><p>-------------------<br>Parent's Signature</p></th>
            </tr>
        </table>

    </div>
    </body>
    </html>


    <?php
}
elseif($school_id==1 && $examType==2)
{
    ?>
    <!--    Your HTML IS HERE-->
    <?php
//    echo "<pre>";
//    var_dump($student_exam_result);
//    die();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Leadership School</title>
        <style type="text/css">
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #464a46;
                padding: 3px;
            }

            #customers tr:nth-child(even){}

            #customers tr:hover {}

            #customers th {
                padding-top: 3px;
                padding-bottom: 3px;
                text-align: left;
                background-color: #464a46;
                color: white;
            }
            body{
                width: 8.3in;
                height: 9.2in;
                margin: auto;
                font-size: 12px;
            }
            .wrapper{
                position: relative;
                /*margin: .5in;*/
                border: 4px solid #464a46;
                border-style: dashed;
                padding: 15px;
                height: 10.75in;
            }
            @wrapper {
                size: Letter;
                margin: 0;
            }

            @media print {
                .wrapper {
                    margin: 0;
                    /*border: initial;*/
                    border-radius: initial;
                    width: initial;
                    min-height: initial;
                    /*box-shadow: initial;*/
                    /*background: initial;*/
                    page-break-after: always;
                }
            }

        </style>
    </head>
    <body>
    <div class="wrapper">
        <table style="margin-top: .3in; width: 100%">
            <tr style="text-align: left;">
                <th style="width: 100px;"><img src="<?=base_url('uploads/')?>logo.jpg"></th>
                <th style="padding-left: 155px;line-height: 5px;"><h2>Leadership School</h2><p>PECHS Campus</p><p><b><?=$examData->name?>2018-19</b></p><p><b><?=$student_exam_result[0]->class?> Result card</b></p></th>
            </tr>
        </table>
        <div style="height: 65px ;float: left; width: 350px; border: 2px solid;">
            <div style="text-align: right;width: 30%; float: left;">
                <b><p>Student Name:<br>
                        Class:<br>
                        Roll Number:</p></b>
            </div>
            <div style="text-align: left;width: 67%; float: right;">
<!--                ." ".$student_exam_result[0]->lastname-->
                <p><?=$student_exam_result[0]->firstname?><br>
                    <?=$student_exam_result[0]->class?><br>
                    <?=$student_exam_result[0]->roll_no?></p>
            </div>
        </div>
        <div style="height: 65px ;float: right; width: 250px; border: 2px solid;">
            <div style="text-align: right;width: 60%; float: left;">
                <?php
                $calculated_age = date_diff(date_create($student_exam_result[0]->dob), date_create('now'))->y;

                ?>
                <b><p>Age:<br>
                        <!--                        Working Days:<br>-->
                        <!--                        Days Attended:-->
                    </p></b>
            </div>
            <div style="text-align: left;width: 37%; float: right;">
                <?php
                $calculated_age = date_diff(date_create($student_exam_result[0]->dob), date_create('now'))->y;

                ?>
                <p><?=$calculated_age?> Years<br>
                    <!--                    91<br>-->
                    <!--                    84-->
                </p>
            </div>
        </div>


<!--        <center ><h2 style="display: -webkit-inline-box; display: inline-block;">ACADEMIC PERFORMANCE</h2></center>-->

        <table id="customers" style="margin-top: 10%" >
            <tr>
                <th style="text-align: center;">Achievement Ratings</th>

            </tr>
            <tr>
                <td><span style="margin-left: 50px; margin-right: 50px">A=Excellent</span> <span style="margin-left: 50px; margin-right: 50px">B= Good</span><span style="margin-left: 50px; margin-right: 50px">C= Satisfactory</span><span style="margin-left: 50px; margin-right: 50px">D= Needs Improvement</span></td>

            </tr>

        </table>


        <!--        <table id="customers" style="width:100%; margin-top: 30px; margin-bottom: 30px">-->
        <!---->
        <!--            <tr>-->
        <!--                <td>Jill</td>-->
        <!--                <td>Smith</td>-->
        <!--                <td>50</td>-->
        <!--                <td>Jill</td>-->
        <!--                <td>Smith</td>-->
        <!---->
        <!--            </tr>-->
        <!--            <tr>-->
        <!--                <td>Jill</td>-->
        <!--                <td>Smith</td>-->
        <!--                <td>50</td>-->
        <!--                <td>Jill</td>-->
        <!--                <td>Smith</td>-->
        <!---->
        <!--            </tr>-->
        <!---->
        <!--        </table>-->

        <?php
//        $subject_extras = $this->class_model->getSubjectExtras($student_exam_result[4]->subject_id);
//
//        $subject_extras_data=json_decode($subject_extras,true);
//        $count=1;
//        $extra_data="";
//        $subject_extras_grades = $this->class_model->getSubjectExtragrades($student_exam_result[4]->subject_id,$student_id);
//        $encoded_data= json_decode($subject_extras_grades->extra_grades);
//        $counter=0;
        foreach ($student_exam_result as $value)
        {
            $subject_extras = $this->class_model->getSubjectExtras($value->subject_id);
            $subject_extras_data=json_decode($subject_extras,true);

            $subject_extras_grades = $this->class_model->getSubjectExtragrades($value->subject_id,$student_id);
            $encoded_data= json_decode($subject_extras_grades->extra_grades);
            $numberOfrows= ceil(count($subject_extras_data)/3);
            ?>
            <table id="customers" style="width:100% ;margin-top: 1%;">
                <tr>
                    <th colspan="6" style="text-align: center;"><?=$value->name?></th>

                </tr>

                <?php

                if($numberOfrows!=0)
                {
                    $outer_index=0;
                    $upto=3;
                    for ($i=0;$i<$numberOfrows;$i++)
                    {

                        ?>
                        <tr>
                            <?php
                            for ($j=$outer_index;$j<$upto;$j++)
                            {
                                ?>
                                <td><?=ucfirst($subject_extras_data[$j])?> </td>
                                <td style="text-align: center"><?=ucfirst($encoded_data[$j])?></td>
                                <?php
                            }
                            $outer_index=$j;
                            $upto+=3;
                            ?>
                        </tr>
                        <?php
                    }
                }else
                {
                    ?>
                    <tr>
                        <td style="text-align: center;font-size: 18px;">No Extra</td>
                    </tr>
                <?php
                }

                ?>


            </table>

            <?php
        }
        ?>

        <table id="customers" >
            <tr>
                <th style="text-align: center;">Class Teacher's Remarks:</th>

            </tr>
            <tr>

                <td>
                    <?php
                    if(empty($remarks))
                    {
                        echo "No Remarks";
                    }else
                    {
                        echo $remarks;
                    }
                    ?>
                </td>

            </tr>

        </table>

        <table style="width: 100%;position: absolute;
    bottom: 0px;">
            <tr>
                <th><p>-------------------<br>Class Teacher</p></th>
                <th><p>-------------------<br>Campus Stamp</p></th>
                <th><p>-------------------<br>Head of Institution</p></th>
            </tr>
        </table>

    </div>
    </body>
    </html>

    <?php
}
elseif($school_id==2 && $examType==1)
{
    ?>
    <!--    Your HTML IS HERE-->
    <!DOCTYPE html>
    <html>
    <head>
        <title>Leadership School</title>
        <style type="text/css">
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #464a46;
                padding: 3px;
            }

            #customers tr:nth-child(even){}

            #customers tr:hover {}

            #customers th {
                padding-top: 3px;
                padding-bottom: 3px;
                text-align: left;
                background-color: #464a46;
                color: white;
            }
            body{
                width: 8.3in;
                height: 10.2in;
                margin: auto;
                font-size: 12px;
            }
            .wrapper{
                position: relative;
                /*margin: .5in;*/
                border: 4px solid #464a46;
                border-style: dashed;
                padding: 15px;
                height: 10.5in;
            }

        </style>
    </head>
    <body>
    <div class="wrapper">
            <?php
//            var_dump($student_exam_result[0]->class);
//            die();
//            echo "<pre>";
//            var_dump($student_exam_result);
//            die();
            ?>
        <table style="margin-top: .3in; width: 100%">
            <tr style="text-align: left;">
                <th style="width: 100px;"><img src="<?=base_url('uploads/')?>logo.jpg"></th>
<!--                <th style="padding-left: 155px;line-height: 5px;"><h2>Leadership School</h2><p>PECHS Campus</p><p><b>--><?//=$examData->name?><!-- 2018-19</b></p><p><b>--><?//=$student_exam_result[0]->class?><!-- Result card</b></p></th>-->
                <th style="padding-left: 155px;line-height: 5px;"><h2>Student 's Monthly Progress Report</h2>

            </tr>
        </table>
        <div style="height: 65px;float: left; width: 350px; border: 2px solid;">
            <div style="text-align: right;width: 30%; float: left;">
                <b><p>Student Name:<br>
                        Class:<br>
                        Roll Number:</p></b>
            </div>
            <div style="text-align: left;width: 67%; float: right;">
<!--                ." ".$student_exam_result[0]->lastname/-->
                <p><?=$student_exam_result[0]->firstname?><br>
                    <?=$student_exam_result[0]->class?><br>
                    <?=$student_exam_result[0]->roll_no?></p>
            </div>
        </div>
<!--        <div style="height: 65px; float: right; width: 250px; border: 2px solid;">-->
<!--            <div style="text-align: right;width: 60%; float: left;">-->
<!--                <b><p>Age:<br>-->
<!--                        Working Days:<br>-->
<!--                        Days Attended:-->
<!--                    </p></b>-->
<!--            </div>-->
<!--            <div style="text-align: left;width: 37%; float: right;">-->
<!--                --><?php
//                $calculated_age = date_diff(date_create($student_exam_result[0]->dob), date_create('now'))->y;
//
//                ?>
<!--                <p>--><?//=$calculated_age?><!-- Years<br>-->
<!--                    91<br>-->
<!--                    84-->
<!--                </p>-->
<!--            </div>-->
<!--        </div>-->
        <div style="float: right; width: 250px; border: 2px solid; height: 65px ;margin-bottom: 10px">
            <div style="text-align: right;width: 30%; float: left;">
                <b><p>Campus:<br>
                        Exams :<br>
                    </p></b>
            </div>
            <div style="text-align: left;width: 67%; float: right;">
                <p>PECHS Campus<br>
                    Monthly Assessments<br>
                </p>
            </div>
        </div>

        <div class="col-md-12">
            <center ><h2 style=" margin-left: 30%;display: -webkit-inline-box; display: inline-block;">ACADEMIC PERFORMANCE</h2></center>

        </div>


        <table id="customers" style="width:100%">
            <tr>
                <th>Sr#</th>
                <th>Subject</th>
                <th>Total Marks</th>
                <th>Obtained Marks</th>
                <th>Class work</th>
                <th>Home work</th>
                <th>Behaviour</th>
            </tr>
            <?php
            $sr=1;
            $total_obtain_marks=0;
            $total_marks=0;
            $ci =& get_instance();
            $ci->load->model('Examresult_model');
            foreach ($student_exam_result as $value)
            {

                $get_grades=$ci->Examresult_model->getGrades($value->student_id,$value->exam_result_id);
                $total_obtain_marks=$total_obtain_marks+$value->get_marks;
                $total_marks=$total_marks+$value->full_marks;

                ?>
                <tr>
                    <td><?=$sr?></td>
                    <td><?=$value->name?></td>
                    <td style="text-align: center"><?=$value->full_marks?></td>
                    <td style="text-align: center">
                        <?php
                        if($value->attendence=="ABS")
                        {
                            $get_marks="ABS";
                        }else
                        {
                            $get_marks=$value->get_marks;
                        }
                        ?>

                        <?=$get_marks?>
                    </td>
                    <td style="text-align: center"><?=$get_grades->class_work?></td>
                    <td style="text-align: center"><?=$get_grades->home_work?></td>
                    <td style="text-align: center"><?=$get_grades->behaviour?></td>
                </tr>

                <?php
                $sr++;
            }
            ?>
            <tr style="background-color: #464a46; color: white;">
                <td colspan="2" style="border: 1px solid #f2fff2;">Overall Result</td>
                <td style="border: 1px solid #f2fff2;"><?=$total_marks?></td>
                <td style="border: 1px solid #f2fff2;"><?=$total_obtain_marks?></td>
                <td colspan="3" style="border: 1px solid #f2fff2;"><?= round($total_obtain_marks/$total_marks*100,2)?>%</td>


            </tr>

        </table>

        <p>Please tally the grading with the chart below and find out the subject teacher’s impressions regarding your child’s performance in each subject. The class teacher’s comments are given for your information.
        </p>
        <center ><h3 style="display: -webkit-inline-box; display: inline-block;">TEACHER’S IMPRESSION CHART</h3></center>
        <table id="customers" style="width:100%">
            <tr>
                <th style="text-align: center;">Grade</th>
                <th style="text-align: center;">Class Work</th>
                <th style="text-align: center;">Home Work</th>
                <th style="text-align: center;">Behaviour</th>

            </tr>
            <tr>
                <td style="text-align: center">A</td>
                <td>Doing well. Very attentive. Congratulations. </td>
                <td>Takes a keen interest. Does home work regularly</td>
                <td>Anxious to learn, regular in school.</td>
            </tr>
            <tr>
                <td style="text-align: center">B</td>
                <td>Generally doing well. Can improve easily.
                </td>
                <td>Sometimes fails to do homework. Should be more devoted.
                </td>
                <td>Should be more serious towards learning. Generally acceptable. </td>
            </tr>
            <tr>
                <td style="text-align: center">C</td>
                <td>Should improve quickly. Parents may communicate with teacher.
                </td>
                <td>Less interest in homework. Parents should encourage.
                </td>
                <td>Generally not satisfactory.  Parent’s guidance necessary.</td>
            </tr>
            <tr>
                <td style="text-align: center">D</td>
                <td>Falling behind other students. Parent’s involvement thoroughly recommended.
                </td>
                <td>Very weak area. Parent’s immediate attention necessary.
                </td>
                <td>Unacceptable attitude. Parents should contact the class teacher and Principal.
                </td>
            </tr>
            <tr>
                <td>Class Teacher Comments</td>
                <td colspan="3"><?php
                    if(empty($remarks))
                    {
                        echo "No Remarks";
                    }else
                    {
                        echo $remarks;
                    }
                    ?></td>
            </tr>
        </table>

        <table style="width: 100%;position: absolute;
    bottom: 0px;">
            <tr>
                <th><p>-------------------<br>Class Teacher</p></th>
                <th><p>-------------------<br>Principle</p></th>
                <th><p>-------------------<br>Parent's Signature</p></th>
            </tr>
        </table>

    </div>
    </body>
    </html>

    <?php
}
elseif($school_id==2 && $examType==2)
{
    ?>
    <!--    Your HTML IS HERE-->
    <?php
//            var_dump($student_exam_result[0]->class);
//            die();
//            echo "<pre>";
//            var_dump($student_exam_result);
//            die();
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Leadership School</title>
        <style type="text/css">
            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #464a46;
                padding: 3px;
            }

            #customers tr:nth-child(even){}

            #customers tr:hover {}

            #customers th {
                padding-top: 3px;
                padding-bottom: 3px;
                text-align: left;
                background-color: #464a46;
                color: white;
            }
            body{
                width: 8.3in;
                height: 9.2in;
                margin: auto;
                font-size: 12px;
            }
            .wrapper{
                position: relative;
                /*margin: .5in;*/
                border: 4px solid #464a46;
                border-style: dashed;
                padding: 15px;
                height: 10.5in;
            }

        </style>
    </head>
    <body>
    <div class="wrapper">
        <table style="margin-top: .3in; width: 100%">
            <tr style="text-align: left;">
                <th style="width: 100px;"><img src="<?=base_url('uploads/')?>logo.jpg"></th>
                <th style="padding-left: 155px;line-height: 5px;"><h2>Leadership School</h2><p>PECHS Campus</p><p><b><?=$examData->name?> 2018-19</b></p><p><b><?=$student_exam_result[0]->class?> Result card</b></p></th>
            </tr>
        </table>
        <div style="height: 65px; float: left; width: 350px; border: 2px solid;">
            <div style="text-align: right;width: 30%; float: left;">
                <b><p>Student Name:<br>
                        Class:<br>
                        Roll Number:</p></b>
            </div>
            <div style="text-align: left;width: 67%; float: right;">
<!--                ." ".$student_exam_result[0]->lastname-->
                <p><?=$student_exam_result[0]->firstname?><br>
                    <?=$student_exam_result[0]->class?><br>
                    <?=$student_exam_result[0]->roll_no?></p>
            </div>
        </div>
        <div style="height: 65px;float: right; width: 250px; border: 2px solid;">
            <div style="text-align: right;width: 60%; float: left;">
                <?php
                $calculated_age = date_diff(date_create($student_exam_result[0]->dob), date_create('now'))->y;

                ?>
                <b><p>Age:<br>
<!--                        Working Days:<br>-->
<!--                        Days Attended:-->
                    </p></b>
            </div>
            <div style="text-align: left;width: 37%; float: right;">
                <?php
                $calculated_age = date_diff(date_create($student_exam_result[0]->dob), date_create('now'))->y;

                ?>
                <p><?=$calculated_age?> Years<br>
<!--                    91<br>-->
<!--                    84-->
                </p>
            </div>
        </div>

        <div class="col-md-12">
            <center ><h2 style="display: -webkit-inline-box; display: inline-block;">ACADEMIC PERFORMANCE</h2></center>

        </div>

        <table id="customers" style="width:100%">
            <tr>
                <th>Sr#</th>
                <th>Subject</th>
                <th>Term(50%)</th>
                <th>Exam(50%)</th>
                <th>Total%</th>
                <th>Grade</th>
            </tr>
            <?php
            $sr=1;
            $index=0;
            $total_obtain_marks=0;
            $total_marks=0;
            $ci =& get_instance();
            $ci->load->model('Examresult_model');
            $get_mid_term_extra_grades=$ci->Examresult_model->getMidTermExtrsGrades($student_id);
//            var_dump($get_mid_term_extra_grades);
            foreach ($student_exam_result as $value)
            {
                $total_marks=0;
                $total_marks=$first_marks[$index]+$second_marks[$index]+$value->get_marks;
                ?>
                <tr>
                    <td><?=$sr?></td>
                    <td><?=$value->name?></td>
                    <td style="text-align: center"><?=$first_marks[$index]+$second_marks[$index]?></td>
                     <?php
                            if($value->attendence=="ABS")
                            {
                                $get_marks="ABS";
                            }else
                            {
                                $get_marks=$value->get_marks;
                            }
                          ?>
                         <td style="text-align: center"><?=$get_marks?></td>
                    <td style="text-align: center"><?=$first_marks[$index]+$second_marks[$index]+$value->get_marks?></td>
                    <td style="text-align: center">
                        <?php
                        if($total_marks>=90 && $total_marks<=100)
                        {
                            echo "A+";

                        }elseif($total_marks>=80 && $total_marks<=89)
                        {
                            echo "A";
                        }elseif($total_marks>=70 && $total_marks<=79)
                        {
                            echo "B";
                        }elseif($total_marks>=60 && $total_marks<=69)
                        {
                            echo "C";
                        }elseif($total_marks>=0 && $total_marks<=59)
                        {
                            echo "D";
                        }
                        ?>

                    </td>
                </tr>
            <?php
                $sr++;
                $index++;
            }
            ?>


        </table>


<!--        <table id="customers" style="width:100%; margin-top: 30px; margin-bottom: 30px">-->
<!---->
<!--            <tr>-->
<!--                <td>Jill</td>-->
<!--                <td>Smith</td>-->
<!--                <td>50</td>-->
<!--                <td>Jill</td>-->
<!--                <td>Smith</td>-->
<!---->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Jill</td>-->
<!--                <td>Smith</td>-->
<!--                <td>50</td>-->
<!--                <td>Jill</td>-->
<!--                <td>Smith</td>-->
<!---->
<!--            </tr>-->
<!---->
<!--        </table>-->

        <table id="customers" style="width:100%">
            <tr>
                <th colspan="6" style="text-align: center;">General Progress</th>

            </tr>
            <tr>
                <td>PUNCTUALITY</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->PUNCTUALITY?></td>
                <td>ART</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->Art?></td>
                <td>ATTENDANCE</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->ATTENDANCE?></td>
            </tr>
            <tr>
                <td>CLASSWORK</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->CLASS_WORK?></td>
                <td>HOMEWORK</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->Home_work?></td>
                 <td>P.E AND GAMES</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->GAME?></td>
            </tr>
            <tr>
                 <td>CONDUCT</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->CONDUCT?></td>
                <td>WORK PRESENTATION</td>
                <td style="text-align: center"><?=$get_mid_term_extra_grades->PRESENTATION?></td>
            </tr>
            <tr>
                <td colspan="6"><span style="margin-left: 50px; margin-right: 50px">A= Excellent</span> <span style="margin-left: 50px; margin-right: 50px">B= Good</span><span style="margin-left: 50px; margin-right: 50px">C= Satisfactory</span><span style="margin-left: 50px; margin-right: 50px">D= Needs Improvement</span></td>
            </tr>
        </table>


        <table id="customers" style="width:250px; border: 1px solid; float: left; margin-top: 30px;">
            <tr>
                <th colspan="5" >Grades</th>

            </tr>
            <tr>
                <td style="border: none;">A+</td>
                <td style="border: none;">=</td>
                <td style="border: none;">90.00</td>
                <td style="border: none;">-</td>
                <td style="border: none;">100</td>
            </tr>
            <tr>
                <td style="border: none;">A</td>
                <td style="border: none;">=</td>
                <td style="border: none;">80.00</td>
                <td style="border: none;">-</td>
                <td style="border: none;">89.00</td>
            </tr>
            <tr>
                <td style="border: none;">B</td>
                <td style="border: none;">=</td>
                <td style="border: none;">70.00</td>
                <td style="border: none;">-</td>
                <td style="border: none;">79.00</td>
            </tr>
            <tr>
                <td style="border: none;">C</td>
                <td style="border: none;">=</td>
                <td style="border: none;">60.00</td>
                <td style="border: none;">-</td>
                <td style="border: none;">69.00</td>
            </tr>
            <tr>
                <td style="border: none;">D</td>
                <td style="border: none;">=</td>
                <td style="border: none;">0.00</td>
                <td style="border: none;">-</td>
                <td style="border: none;">59.00</td>
            </tr>

        </table>



        <table id="customers" style="width:400px; float: right; margin-top: 30px;">
            <tr>
                <th style="text-align: center;">Class Teacher's Remarks:</th>

            </tr>
            <tr>
                <td>
                    <?php
                    if(empty($remarks))
                    {
                        echo "No Remarks";
                    }else
                    {
                        echo $remarks;
                    }
                    ?>
                </td>

            </tr>

        </table>

        <table style="width: 100%;position: absolute;
    bottom: 0px;">
            <tr>
                <th><p>-------------------<br>Class Teacher</p></th>
                <th><p>-------------------<br>Campus Stamp</p></th>
                <th><p>-------------------<br>Head of Institution</p></th>
            </tr>
        </table>

    </div>
    </body>
    </html>
    <?php
}
?>



