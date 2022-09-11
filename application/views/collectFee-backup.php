<tbody>
<?php
$total_amount = 0;
$total_deposite_amount = 0;
$total_fine_amount = 0;
$total_discount_amount = 0;
$total_balance_amount = 0;
$alot_fee_discount = 0;

//                                echo "<pre>";
//                                var_dump($student_fee);
//                                die();
foreach ($student_due_fee as $key => $fee) {

    foreach ($fee->fees as $fee_key => $fee_value) {
        $fee_paid = 0;
        $fee_discount = 0;
        $fee_fine = 0;

        if (!empty($fee_value->amount_detail)) {
            $fee_deposits = json_decode(($fee_value->amount_detail));

            foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                $fee_paid = $fee_paid + $fee_deposits_value->amount;
                $fee_discount = $fee_discount + $fee_deposits_value->amount_discount;
                $fee_fine = $fee_fine + $fee_deposits_value->amount_fine;
            }
        }
        $total_amount = $total_amount + $fee_value->amount;
        $total_discount_amount = $total_discount_amount + $fee_discount;
        $total_deposite_amount = $total_deposite_amount + $fee_paid;
        $total_fine_amount = $total_fine_amount + $fee_fine;
        $feetype_balance = $fee_value->amount - ($fee_paid + $fee_discount);
        $total_balance_amount = $total_balance_amount + $feetype_balance;
        ?>
        <?php
        if ($feetype_balance > 0 && strtotime($fee_value->due_date) < strtotime(date('Y-m-d'))) {
            ?>
            <tr class="danger font12">
            <?php
        } else {
            ?>
            <tr class="dark-gray">
            <?php
        }
        ?>
        <td><input class="checkbox" type="checkbox" name="fee_checkbox" data-fee_master_id="<?php echo $fee_value->id ?>" data-fee_session_group_id="<?php echo $fee_value->fee_session_group_id ?>" data-fee_groups_feetype_id="<?php echo $fee_value->fee_groups_feetype_id ?>"></td>
        <td align="left"><?php
            echo $fee_value->name;
            ?></td>
        <!--                                        <td align="left">--><?php //echo $fee_value->code; ?><!--</td>-->
        <td align="left" class="text text-left">

            <?php
            if ($fee_value->due_date == "0000-00-00") {

            } else {

                echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_value->due_date));
            }
            ?>
        </td>
        <td align="left" class="text text-left width85">
            <?php
            if ($feetype_balance == 0) {
                ?><span class="label label-success"><?php echo $this->lang->line('paid'); ?></span><?php
            } else if (!empty($fee_value->amount_detail)) {
                ?><span class="label label-warning"><?php echo $this->lang->line('partial'); ?></span><?php
            } else {
                ?><span class="label label-danger"><?php echo $this->lang->line('unpaid'); ?></span><?php
            }
            ?>

        </td>
        <td class="text text-right"><?php echo $fee_value->amount; ?></td>

        <td class="text text-left"></td>
        <td class="text text-left"></td>
        <td class="text text-left"></td>
        <td class="text text-right"><?php
            echo (number_format($fee_discount, 2, '.', ''));
            ?></td>
        <td class="text text-right"><?php
            echo (number_format($fee_fine, 2, '.', ''));
            ?></td>
        <td class="text text-right"><?php
            echo (number_format($fee_paid, 2, '.', ''));
            ?></td>
        <td class="text text-right"><?php
            $display_none = "ss-none";
            if ($feetype_balance > 0) {
                $display_none = "";

                echo (number_format($feetype_balance, 2, '.', ''));
            }
            ?>
        </td>
        <td>
            <div class="btn-group pull-right" style="width: 40px;">
                <button type="button" data-student_session_id="<?php echo $fee->student_session_id; ?>" data-student_fees_master_id="<?php echo $fee->id; ?>" data-fee_groups_feetype_id="<?php echo $fee_value->fee_groups_feetype_id; ?>"
                        data-group="<?php echo $fee_value->name; ?>"
                        data-type="<?php echo $fee_value->code; ?>"
                        class="btn btn-xs btn-default myCollectFeeBtn <?php echo $display_none; ?>"
                        title="<?php echo $this->lang->line('add_fees'); ?>" data-toggle="modal" data-target="#myFeesModal"
                ><i class="fa fa-plus"></i></button>


                <button  class="btn btn-xs btn-default printInv" data-fee_master_id="<?php echo $fee_value->id ?>" data-fee_session_group_id="<?php echo $fee_value->fee_session_group_id ?>" data-fee_groups_feetype_id="<?php echo $fee_value->fee_groups_feetype_id ?>"
                         title="<?php echo $this->lang->line('print'); ?>"
                ><i class="fa fa-print"></i> </button>
            </div>
        </td>


        </tr>

        <?php
        if (!empty($fee_value->amount_detail)) {

            $fee_deposits = json_decode(($fee_value->amount_detail));

            foreach ($fee_deposits as $fee_deposits_key => $fee_deposits_value) {
                ?>
                <tr class="white-td">
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td class="text-right"><img src="<?php echo base_url(); ?>backend/images/table-arrow.png" alt="" /></td>
                    <td class="text text-left">


                        <a href="#" data-toggle="popover" class="detail_popover" > <?php echo $fee_value->student_fees_deposite_id . "/" . $fee_deposits_value->inv_no; ?></a>
                        <div class="fee_detail_popover" style="display: none">
                            <?php
                            if ($fee_deposits_value->description == "") {
                                ?>
                                <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                                <?php
                            } else {
                                ?>
                                <p class="text text-info"><?php echo $fee_deposits_value->description; ?></p>
                                <?php
                            }
                            ?>
                        </div>


                    </td>
                    <td class="text text-left"><?php echo $fee_deposits_value->payment_mode; ?></td>
                    <td class="text text-left">

                        <?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($fee_deposits_value->date)); ?>
                    </td>
                    <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_discount, 2, '.', '')); ?></td>
                    <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount_fine, 2, '.', '')); ?></td>
                    <td class="text text-right"><?php echo (number_format($fee_deposits_value->amount, 2, '.', '')); ?></td>
                    <td class="text text-right">
                        <div class="btn-group pull-right" style="width: 41px;">

                            <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_delete')) { ?>
                                <button class="btn btn-default btn-xs" data-invoiceno="<?php echo $fee_value->student_fees_deposite_id . "/" . $fee_deposits_value->inv_no; ?>" data-main_invoice="<?php echo $fee_value->student_fees_deposite_id ?>" data-sub_invoice="<?php echo $fee_deposits_value->inv_no ?>" data-toggle="modal" data-target="#confirm-delete" title="<?php echo $this->lang->line('revert'); ?>">
                                    <i class="fa fa-undo"> </i>
                                </button>
                            <?php } ?>
                            <button  class="btn btn-xs btn-default printDoc" data-main_invoice="<?php echo $fee_value->student_fees_deposite_id ?>" data-sub_invoice="<?php echo $fee_deposits_value->inv_no ?>"  title="<?php echo $this->lang->line('print'); ?>"><i class="fa fa-print"></i> </button>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        <?php
    }
}
?>
<?php
if (!empty($student_discount_fee)) {

    foreach ($student_discount_fee as $discount_key => $discount_value) {
        ?>
        <tr class="dark-light">
            <td></td>
            <td align="left"> <?php echo $this->lang->line('discount'); ?> </td>
            <td align="left">
                <?php echo $discount_value['code']; ?>
            </td>
            <td align="left"></td>
            <td align="left" class="text text-left">
                <?php
                if ($discount_value['status'] == "applied") {
                    ?>
                    <a href="#" data-toggle="popover" class="detail_popover" >

                        <?php echo $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']) . " : " . $discount_value['payment_id']; ?>

                    </a>
                    <div class="fee_detail_popover" style="display: none">
                        <?php
                        if ($discount_value['student_fees_discount_description'] == "") {
                            ?>
                            <p class="text text-danger"><?php echo $this->lang->line('no_description'); ?></p>
                            <?php
                        } else {
                            ?>
                            <p class="text text-danger"><?php echo $discount_value['student_fees_discount_description'] ?></p>
                            <?php
                        }
                        ?>

                    </div>
                    <?php
                } else {
                    echo '<p class="text text-danger">' . $this->lang->line('discount_of') . " " . $currency_symbol . $discount_value['amount'] . " " . $this->lang->line($discount_value['status']);
                }
                ?>

            </td>
            <td></td>
            <td class="text text-left"></td>
            <td class="text text-left"></td>
            <td class="text text-left"></td>
            <td  class="text text-right">
                <?php
                $alot_fee_discount = $alot_fee_discount;
                ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div class="btn-group pull-right">
                    <?php
                    if ($discount_value['status'] == "applied") {
                        ?>

                        <?php if ($this->rbac->hasPrivilege('collect_fees', 'can_delete')) { ?>
                            <button class="btn btn-default btn-xs" data-discounttitle="<?php echo $discount_value['code']; ?>" data-discountid="<?php echo $discount_value['id']; ?>" data-toggle="modal" data-target="#confirm-discountdelete" title="<?php echo $this->lang->line('revert'); ?>">
                                <i class="fa fa-undo"> </i>
                            </button>
                            <?php
                        }
                    }
                    ?>

                    <button type="button" data-modal_title="<?php echo $this->lang->line('discount') . " : " . $discount_value['code']; ?>" data-student_fees_discount_id="<?php echo $discount_value['id']; ?>"
                            class="btn btn-xs btn-default applydiscount"
                            title="<?php echo $this->lang->line('apply_discount'); ?>"
                    ><i class="fa fa-check"></i>
                    </button>

                </div>
            </td>
        </tr>
        <?php
    }
}
?>


<tr class="box box-solid total-bg">
    <td align="left" ></td>
    <td align="left" ></td>
    <td align="left" ></td>
    <td align="left" ></td>
    <td align="left" class="text text-left" ><?php echo $this->lang->line('grand_total'); ?></td>
    <td class="text text-right"><?php
        echo ($currency_symbol . number_format($total_amount, 2, '.', ''));
        ?></td>
    <td class="text text-left"></td>
    <td class="text text-left"></td>
    <td class="text text-left"></td>

    <td class="text text-right"><?php
        echo ($currency_symbol . number_format($total_discount_amount + $alot_fee_discount, 2, '.', ''));
        ?></td>
    <td class="text text-right"><?php
        echo ($currency_symbol . number_format($total_fine_amount, 2, '.', ''));
        ?></td>
    <td class="text text-right"><?php
        echo ($currency_symbol . number_format($total_deposite_amount, 2, '.', ''));
        ?></td>
    <td class="text text-right"><?php
        echo ($currency_symbol . number_format($total_balance_amount - $alot_fee_discount, 2, '.', ''));
        ?></td>  <td class="text text-right"></td>
</tr>
</tbody>
