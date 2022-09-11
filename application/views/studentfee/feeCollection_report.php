<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();

//print_r();die;
?>
<style type="text/css">
    /*REQUIRED*/
    .carousel-row {
        margin-bottom: 10px;
    }
    .slide-row {
        padding: 0;
        background-color: #ffffff;
        min-height: 150px;
        border: 1px solid #e7e7e7;
        overflow: hidden;
        height: auto;
        position: relative;
    }
    .slide-carousel {
        width: 20%;
        float: left;
        display: inline-block;
    }
    .slide-carousel .carousel-indicators {
        margin-bottom: 0;
        bottom: 0;
        background: rgba(0, 0, 0, .5);
    }
    .slide-carousel .carousel-indicators li {
        border-radius: 0;
        width: 20px;
        height: 6px;
    }
    .slide-carousel .carousel-indicators .active {
        margin: 1px;
    }
    .slide-content {
        position: absolute;
        top: 0;
        left: 20%;
        display: block;
        float: left;
        width: 80%;
        max-height: 76%;
        padding: 1.5% 2% 2% 2%;
        overflow-y: auto;
    }
    .slide-content h4 {
        margin-bottom: 3px;
        margin-top: 0;
    }
    .slide-footer {
        position: absolute;
        bottom: 0;
        left: 20%;
        width: 78%;
        height: 20%;
        margin: 1%;
    }
    /* Scrollbars */
    .slide-content::-webkit-scrollbar {
        width: 5px;
    }
    .slide-content::-webkit-scrollbar-thumb:vertical {
        margin: 5px;
        background-color: #999;
        -webkit-border-radius: 5px;
    }
    .slide-content::-webkit-scrollbar-button:start:decrement,
    .slide-content::-webkit-scrollbar-button:end:increment {
        height: 5px;
        display: block;
    }
</style>

<div class="content-wrapper" style="min-height: 946px;">

    <section class="content-header">

    </section>
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('reports/_finance');?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header ">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>

                    <form role="form" action="<?php echo site_url('studentfee/feeCollection_report') ?>" method="post" class="">
                        <div class="box-body row">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="col-sm-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('search') . " " . $this->lang->line('type'); ?><small class="req"> *</small></label>
                                    <select class="form-control" name="search_type" onchange="showdate(this.value)">

                                        <?php foreach ($searchlist as $key => $search) {
                                            ?>
                                            <option value="<?php echo $key ?>" <?php
                                            if ((isset($search_type)) && ($search_type == $key)) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $search ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('search_type'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('collect')." ".$this->lang->line('by'); ?></label>
                                    <select class="form-control"  name="collect_by" >
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php

                                        foreach ($collect_by as $key => $value) {
                                            ?>
                                            <option value="<?php echo $key ?>" <?php
                                            if((isset($received_by)) && ($received_by == $key)) {
                                                echo "selected";
                                            } ?> ><?php echo $value ?></option>
                                        <?php  } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('collect_by'); ?></span>
                                </div>
                            </div>
                            <div id='date_result'>

                            </div>
                            <div class="col-sm-4 col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('group')." ".$this->lang->line('by'); ?> </label>
                                    <select class="form-control" name="group" >
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Cheque">Soneri</option>
                                        <option value="DD">HBL</option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('group'); ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><i class="fa fa-money"></i> <?php  ?> <?php echo $this->lang->line('fees')." ".$this->lang->line('collection')." ".$this->lang->line('report'); ?></h3>
                        </div>
                        <div class="box-body table-responsive" id="transfee">
                            <div class="download_label"><?php  ?> <?php echo $this->lang->line('fees')." ".$this->lang->line('collection')." ".$this->lang->line('report')."<br>"; $this->customlib->get_postmessage(); ?></div>
                            <a class="btn btn-default btn-xs pull-right" id="print" onclick="printDiv()" ><i class="fa fa-print"></i></a> <a class="btn btn-default btn-xs pull-right" id="btnExport" onclick="fnExcelReport();"> <i class="fa fa-file-excel-o"></i> </a>
                            <table class="table table-striped  table-hover " id="headerTable">
                                <thead class="header">
                                <tr>
                                    <th>SNO</th>
                                    <th><?php echo $this->lang->line('date'); ?></th>
                                    <th><?php echo $this->lang->line('name'); ?></th>
                                    <th><?php echo $this->lang->line('roll_no'); ?></th>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <th>Billing Period</th>
                                    <th><?php echo $this->lang->line('collect_by'); ?></th>
                                    <th><?php echo $this->lang->line('payment'); ?><?php echo $this->lang->line('mode'); ?></th>

                                    <th class="text text-right"><?php echo $this->lang->line('amount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right">Tuition Fee</th>
                                    <?php
                                    if(!empty($feeTypes))
                                    {
                                        foreach ($feeTypes as $feeType)
                                        {
                                            if($feeType->fee_type=="other" || $feeType->fee_type=="anuual" || $feeType->fee_type=="lab")
                                            {
                                                echo ' <th class="text text-right">'.substr($feeType->type,'0','3').' Fee</th>';
                                            }

                                        }
                                    }
                                    ?>
<!--                                    <th class="text text-right">--><?php //echo $this->lang->line('discount'); ?><!-- <span>--><?php //echo "(" . $currency_symbol . ")"; ?><!--</span></th>-->
                                    <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right">Deposit <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right">Extra <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                    <th class="text text-right"><?php echo $this->lang->line('total'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php



                                if (empty($results)) {

                                } else {

                                    $count = 1;
                                    $grdamountLabel=array();
                                    $grddiscountLabel=array();
                                    $grdfineLabel=array();
                                    $grdTotalLabel=array();
                                    $grdTotalextra_amount=array();
                                    $grdTotalto_bePaid=array();
                                    $grdTotaltuituionFee=array();
                                    $grdTotalOtherFees=array();

                                    foreach ($feeTypes as $countTotal )
                                    {
                                        if($countTotal->fee_type=="other" || $countTotal->fee_type=="anuual" || $countTotal->fee_type=="lab")
                                        {
                                            $grdTotalOtherFees[$countTotal->id]=0;
                                        }

                                    }
                                    
                                    foreach ($results as $key => $value) {






                                        ?>
                                        <tr>
                                            <td><?=$value->std_deposit_id?></td>
                                            <td><?=$value->date?></td>
                                            <td><?=$value->name?></td>
                                            <td><?=$value->roll_no?></td>



                                            <td><?=$value->class?></td>
                                            <td><?=$value->fee_month?></td>
 <!--                                            <td>--><?php
//                                                foreach (explode(',',$value->feeType) as $item )
//                                                {
//                                                    echo $item.'<br>';
//                                                }
//                                                ?><!--</td>-->

                                            <td><?=$value->received_byname['name']?></td>
                                            <td>
                                                <?php
                                                if($value->mode=="DD")
                                                {
                                                    echo "HBL";

                                                }elseif($value->mode=="Cheque")
                                                {
                                                    echo "SONERI";
                                                }else
                                                {
                                                    echo "Cash";
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right"><?=$value->to_bePaid?></td>
                                            <td class="text-right"><?=$value->tutionFee?></td>
                                            <?php

                                                foreach ($feeTypes as $item )
                                                {
                                                    if($item->fee_type=="other" || $item->fee_type=="anuual" || $item->fee_type=="lab")
                                                    {
                                                        if(array_key_exists($item->id,$value->otherFees))
                                                        {
                                                            $grdTotalOtherFees[$item->id]=$grdTotalOtherFees[$item->id]+$value->otherFees[$item->id];
                                                            echo '<td class="text-right">'.$value->otherFees[$item->id].'</td>';
                                                        }else{


                                                            echo '<td class="text-right">0</td>';
                                                        }

                                                    }

                                                }
                                                ?>
<!--                                            <td class="text-right">0</td>-->
                                            <td class="text-right"><?=$value->fine?></td>
                                            <td class="text-right"><?=$value->paid_amount?></td>
                                            <td class="text-right"><?=$value->extra_amount?></td>
                                            <td class="text-right"><?=$value->paid_amount+$value->extra_amount+$value->fine?></td>


                                         </tr>
                                        <?php
                                        $count++;
                                        ?>

                                        <?php
                                        $grdamountLabel[]=$value->paid_amount;
                                        $grddiscountLabel[]=0;
                                        $grdfineLabel[]=$value->fine;
                                        $grdTotalLabel[]=$value->paid_amount+$value->extra_amount+$value->fine;
                                        $grdTotalextra_amount[]=$value->extra_amount;
                                        $grdTotalto_bePaid[]=$value->to_bePaid;
                                        $grdTotaltuituionFee[]=$value->tutionFee;

                                    }
                                    ?>

                                    <?php
                                    $unknownPaymentTotal=0;
                                    if(!empty($unknownPayments))
                                    {
                                        foreach ($unknownPayments as $unknownPayment)
                                        {
                                            if($unknownPayment->amount>0)
                                            {
                                                $unknownPaymentTotal+=$unknownPayment->amount;
                                            }
                                        }
                                    }
                                    if($unknownPaymentTotal>0)
                                    {
                                        ?>
                                        <tr>
                                            <td>Unknown Payments</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td style="font-weight:bold"> </td>
                                            <td class="text text-right" style="font-weight:bold"> </td>
                                            <td class="text text-right" style="font-weight:bold"> </td>
                                            <?php
                                            foreach ($grdTotalOtherFees as $grdTotalOtherFee)
                                            {
                                                echo '<td class="text text-right" style="font-weight:bold" > </td>';
                                            }
                                            ?>
                                            <td class="text text-right" style="font-weight:bold" > </td>
                                            <td class="text text-right " style="font-weight:bold" > </td>
                                            <td class="text text-right " style="font-weight:bold" > </td>

                                            <td class="text text-right " style="font-weight:bold" ><?php echo number_format($unknownPaymentTotal ,2,'.',',') ; ?></td>
                                        </tr>

                                        <?php
                                    }
                                    ?>



                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td style="font-weight:bold"><?php echo $this->lang->line('grand')." ".$this->lang->line('total'); ?></td>
                                        <td class="text text-right" style="font-weight:bold"><?php echo  array_sum($grdTotalto_bePaid); ?></td>
                                        <td class="text text-right" style="font-weight:bold"><?php echo  array_sum($grdTotaltuituionFee); ?></td>
                                        <?php
                                        foreach ($grdTotalOtherFees as $grdTotalOtherFee)
                                        {
                                            echo '<td class="text text-right" style="font-weight:bold" >'.$grdTotalOtherFee.'</td>';
                                        }
                                        ?>
                                         <td class="text text-right" style="font-weight:bold" ><?php echo array_sum($grdfineLabel); ?></td>
                                        <td class="text text-right " style="font-weight:bold" ><?php echo array_sum($grdamountLabel); ?></td>
                                        <td class="text text-right " style="font-weight:bold" ><?php echo array_sum($grdTotalextra_amount); ?></td>

                                        <td class="text text-right " style="font-weight:bold" ><?php echo number_format($unknownPaymentTotal+array_sum($grdTotalLabel),2,'.',',') ; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<iframe id="txtArea1" style="display:none"></iframe>

<script>
    <?php
    if($search_type=='period'){
    ?>

    $(document).ready(function () {
        showdate('period');
    });

    <?php
    }
    ?>


    document.getElementById("print").style.display = "block";
    document.getElementById("btnExport").style.display = "block";

    function printDiv() {
        document.getElementById("print").style.display = "none";
        document.getElementById("btnExport").style.display = "none";
        var divElements = document.getElementById('transfee').innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";
        window.print();
        document.body.innerHTML = oldPage;

        location.reload(true);
    }

    function fnExcelReport()
    {
        var tab_text="<table border='2px'><tr >";
        var textRange; var j=0;
        tab = document.getElementById('headerTable'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++)
        {
            tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
            //tab_text=tab_text+"</tr>";
        }

        tab_text=tab_text+"</table>";
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
        }
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }






</script>