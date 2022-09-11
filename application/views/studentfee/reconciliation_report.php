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




                    <div class="">
                        <div class="box-header ptbnull"></div>
                        <div class="box-header ptbnull">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>

                            <h3 class="box-title titlefix"><i class="fa fa-money"></i>  Reconciliation Report</h3>
                            <a style="float: right" href="<?php echo site_url('Studentfee/previous_balance') ?>" class="btn btn-primary  ">Previous Session Balance</a>

                        </div>
                        <div class="box-body table-responsive" id="transfee">
                            <div class="download_label"><?php  ?> <?php echo $this->lang->line('fees')." ".$this->lang->line('collection')." ".$this->lang->line('report')."<br>"; $this->customlib->get_postmessage(); ?></div>
                            <a class="btn btn-default btn-xs pull-right" id="print" onclick="printDiv()" ><i class="fa fa-print"></i></a> <a class="btn btn-default btn-xs pull-right" id="btnExport" onclick="fnExcelReport();"> <i class="fa fa-file-excel-o"></i> </a>
                            <table class="table table-striped  table-hover " id="headerTable">
                                 <tbody>
                                 <?php
                                 $hbl_p_balance=0;
                                 $soneri_p_balance=0;
                                 $cash_p_balance=0;
                                 $hbl_fee_collection=0;
                                 $soneri_fee_collection=0;
                                 $cash_fee_collection=0;
                                 $cash_deposit_hbl=0;
                                 $cash_deposit_soneri=0;
                                 $expenses_cash=0;
                                 $expenses_hbl=0;
                                 $expenses_soneri=0;
                                 $income_cash=0;
                                 $income_hbl=0;
                                 $income_soneri=0;
                                 $withdraw_hbl=0;
                                 $withdraw_soneri=0;
                                 $withdraw_cash=0;
                                 $investment_cash=0;
                                 $investment_hbl=0;
                                 $investment_soneri=0;
                                 $bank_transfer_hbl=0;
                                 $bank_transfer_soneri=0;
                                 $bank_fee_amount_hbl=0;
                                 $bank_fee_amount_soneri=0;
                                 $cash_addon_hbl=0;
                                 $cash_addon_soneri=0;

                                 foreach ($previous_balance as $value)if(!empty($value))
                                 {
                                     if($value->type=="HBL")
                                     {

                                         $hbl_p_balance+=$value->amount;
                                     }elseif ($value->type=="Soneri")
                                     {
                                         $soneri_p_balance+=$value->amount;

                                     }elseif ($value->type=="Cash")
                                     {
                                         $cash_p_balance+=$value->amount;

                                     }
                                 }
                                 foreach ($bank_fee_amounts as $bank_fee_amount)if(!empty($bank_fee_amount))
                                 {
                                     if($bank_fee_amount->bank_name=="HBL")
                                     {

                                         $bank_fee_amount_hbl+=$bank_fee_amount->amount;
                                     }elseif ($bank_fee_amount->bank_name=="Soneri")
                                     {
                                         $bank_fee_amount_soneri+=$bank_fee_amount->amount;

                                     }
                                 }
                                 foreach ($cash_addons as $cash_addon)if(!empty($cash_addon))
                                 {
                                     if($cash_addon->bank_name=="HBL")
                                     {

                                         $cash_addon_hbl+=$cash_addon->amount;
                                     }elseif ($cash_addon->bank_name=="Soneri")
                                     {
                                         $cash_addon_soneri+=$cash_addon->amount;

                                     }
                                 }

                                 foreach ($fee_collection as $value_2)if(!empty($value_2))
                                 {

                                     if($value_2->mode=="DD")
                                     {

                                         $hbl_fee_collection=$hbl_fee_collection+$value_2->paid_amount+$value_2->fine+$value_2->extra_amount;
                                     }elseif ($value_2->mode=="Cheque")
                                     {
                                          $soneri_fee_collection=$soneri_fee_collection+$value_2->paid_amount+$value_2->fine+$value_2->extra_amount;

                                     }else
                                     {
                                          $cash_fee_collection=$cash_fee_collection+$value_2->paid_amount+$value_2->fine+$value_2->extra_amount;

                                     }
                                 }
                                  foreach ($cash_deposit as $value_3)
                                 {

                                     if($value_3->bank_name=="HBL")
                                     {
                                         $cash_deposit_hbl+=$value_3->amount;
                                     }elseif($value_3->bank_name=="Soneri")
                                     {
                                         $cash_deposit_soneri+=$value_3->amount;
                                     }
                                 }

                                 foreach ($expenses as $expens)
                                 {
                                       if($expens->payment_mode=="DD")
                                     {
                                         $expenses_hbl+=$expens->amount;
                                     }elseif($expens->payment_mode=="Cheque")
                                     {
                                         $expenses_soneri+=$expens->amount;
                                     }else
                                     {
                                         $expenses_cash+=$expens->amount;
                                     }
                                 }
                                   foreach ($incomes as $income)
                                 {
                                     if($income->payment_mode=="DD")
                                     {
                                         $income_hbl+=$income->amount;
                                     }elseif($income->payment_mode=="Cheque")
                                     {
                                         $income_soneri+=$income->amount;
                                     }else
                                     {
                                         $income_cash+=$income->amount;
                                     }
                                 }
                                 foreach ($withdraw_investment as $value_withdraw)
                                 {
                                     if($value_withdraw->type=="Withdraw")
                                     {
                                         if($value_withdraw->mode=="HBL")
                                         {
                                             $withdraw_hbl+=$value_withdraw->amount;
                                         }elseif($value_withdraw->mode=="Soneri")
                                         {
                                             $withdraw_soneri+=$value_withdraw->amount;
                                         }elseif($value_withdraw->mode=="Cash")
                                         {
                                             $withdraw_cash+=$value_withdraw->amount;
                                         }
                                     }elseif($value_withdraw->type=="Investment")
                                     {
                                         if($value_withdraw->mode=="HBL")
                                         {
                                             $investment_hbl+=$value_withdraw->amount;
                                         }elseif($value_withdraw->mode=="Soneri")
                                         {
                                             $investment_soneri+=$value_withdraw->amount;
                                         }elseif($value_withdraw->mode=="Cash")
                                         {
                                             $investment_cash+=$value_withdraw->amount;
                                         }
                                     }
                                 }
                                 foreach ($bank_transfer as $value_4)
                                 {


                                     if($value_4->bank_from=="HBL")
                                     {
                                         $bank_transfer_soneri+=$value_4->amount;
                                     }elseif($value_4->bank_from=="Soneri")
                                     {

                                         $bank_transfer_hbl+=$value_4->amount;
                                     }
                                 }


                                 $current_balance_hbl=$hbl_p_balance+$hbl_fee_collection+$cash_deposit_hbl+$investment_hbl+$income_hbl-$expenses_hbl-$withdraw_hbl-$bank_transfer_hbl;
                                 $current_balance_soneri=$soneri_p_balance+$soneri_fee_collection+$cash_deposit_soneri+$investment_soneri+$income_soneri-$expenses_soneri-$withdraw_soneri-$bank_transfer_soneri;
                                 $current_balance_cash=$cash_p_balance+$cash_fee_collection+$investment_cash+$income_cash-$expenses_cash-$withdraw_cash-$cash_deposit_hbl-$cash_deposit_soneri-$cash_addon_hbl-$cash_addon_soneri;

                                 ?>

                                 <tr>
                                     <th colspan="3">
                                         Previous session balance
                                     </th>
                                 </tr>
                                 <tr>
                                     <th class="text-center">HBL</th>
                                     <td><?=$hbl_p_balance?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$soneri_p_balance?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Cash</th>
                                     <td><?=$cash_p_balance?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th  class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$hbl_p_balance+$soneri_p_balance+$cash_p_balance?>
                                     </th>
                                     <th >

                                     </th>
                                 </tr>
                                 <tr>
                                     <th colspan="3">
                                         Current bank/Cash Balance
                                     </th>
                                 </tr>
                                 <tr>
                                     <th class="text-center">HBL</th>
                                     <td><?=$current_balance_hbl?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$current_balance_soneri?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Cash</th>
                                     <td><?=$current_balance_cash?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$current_balance_cash+$current_balance_soneri+$current_balance_hbl?>
                                     </th>
                                     <th >

                                     </th>
                                 </tr>

                                 <tr>
                                     <th colspan="3">
                                         Bank   addon
                                     </th>
                                 </tr>
                                 <tr>
                                      <th class="text-center">HBL</th>
                                     <td><?=$cash_deposit_hbl?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$cash_deposit_soneri?></td>
                                     <td> </td>
                                 </tr>
                                  <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$cash_deposit_soneri+$cash_deposit_hbl?>
                                     </th>
                                     <th >

                                     </th>
                                  </tr>
                                 <tr>
                                     <th colspan="3">
                                         Cash   addon
                                     </th>
                                 </tr>
                                 <tr>
                                      <th class="text-center">HBL</th>
                                     <td><?=$cash_addon_hbl?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$cash_addon_soneri?></td>
                                     <td> </td>
                                 </tr>
                                  <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$cash_addon_hbl+$cash_addon_soneri?>
                                     </th>
                                     <th >

                                     </th>
                                  </tr>
                                 <tr>
                                     <th colspan="3">
                                         Unknown Payments
                                     </th>
                                 </tr>
                                 <tr>
                                      <th class="text-center">HBL</th>
                                     <td><?=$bank_fee_amount_hbl?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$bank_fee_amount_soneri?></td>
                                     <td> </td>
                                 </tr>
                                  <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$bank_fee_amount_hbl+$bank_fee_amount_soneri?>
                                     </th>
                                     <th >

                                     </th>
                                 </tr>

                                 <tr>
                                     <th  >
                                         Fee collection and other income
                                     </th>
                                     <th  >
                                         Fee Collection
                                     </th>
                                     <th  >
                                         Income
                                     </th>

                                 </tr>
                                 <tr>
                                     <th class="text-center">HBL</th>

                                     <td><?=$hbl_fee_collection?></td>
                                     <td><?=$income_hbl?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>

                                     <td><?=$soneri_fee_collection?></td>
                                     <td><?=$income_soneri?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">Cash</th>

                                     <td><?=$cash_fee_collection?></td>
                                     <td><?=$income_cash?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">
                                         Total
                                     </th>


                                     <th >
                                         <?=$bank_fee_amount_hbl+$bank_fee_amount_soneri+$cash_fee_collection+$soneri_fee_collection+$hbl_fee_collection?>
                                     </th>
                                     <th >
                                         <?=$income_cash+$income_hbl+$income_soneri?>
                                     </th>
                                 </tr>

                                 <tr>
                                     <th colspan="3">
                                         Expenses
                                     </th>
                                 </tr>
                                  <tr>
                                     <th class="text-center">HBL</th>
                                     <td><?=$expenses_hbl?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$expenses_soneri?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th  class="text-center">Cash</th>
                                     <td><?=$expenses_cash?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$expenses_cash+$expenses_hbl+$expenses_soneri?>
                                     </th>
                                     <th >

                                     </th>
                                 </tr>

                                 <tr>
                                     <th  >
                                         Withdraw/Investment
                                     </th>
                                     <th  >
                                           Withdraw
                                     </th>
                                     <th  >
                                         Investment
                                     </th>
                                 </tr>
                                  <tr>
                                     <th class="text-center">HBL</th>
                                     <td><?=$withdraw_hbl?></td>
                                     <td><?=$investment_hbl?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$withdraw_soneri?></td>
                                     <td><?=$investment_soneri?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">Cash</th>
                                     <td><?=$withdraw_cash?></td>
                                     <td><?=$investment_cash?></td>

                                 </tr>
                                 <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$withdraw_hbl+$withdraw_soneri+$withdraw_cash?>
                                     </th>
                                     <th >
                                         <?=$investment_hbl+$investment_soneri+$investment_cash?>
                                     </th>
                                 </tr>

                                 <tr>
                                     <th colspan="3">
                                         Amount transfer (bank to bank)
                                     </th>
                                 </tr>
                                 <tr>
                                     <th class="text-center">HBL</th>
                                     <td>
                                          <?=$bank_transfer_hbl?>
                                      </td>
                                     <td></td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">Soneri</th>
                                     <td><?=$bank_transfer_soneri?></td>
                                     <td> </td>
                                 </tr>
                                 <tr>
                                     <th class="text-center">
                                         Total
                                     </th>
                                     <th >
                                         <?=$bank_transfer_soneri+$bank_transfer_hbl?>
                                     </th>
                                     <th >

                                     </th>
                                 </tr>

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