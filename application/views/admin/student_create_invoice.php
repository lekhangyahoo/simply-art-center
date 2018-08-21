<style xmlns="http://www.w3.org/1999/html">
    .new-registration select {
        width: 100%
    }
</style>
<div class="row">
    <div class="btn-group pull-right">
        <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers'); ?>"><i
                class=" icon-th-list"></i> <?php echo lang('centers'); ?></a>
        <a class="btn"
           href="<?php echo site_url($this->config->item('admin_folder') . '/centers/schedules'); ?>"><i
                class=" icon-th-list"></i> <?php echo lang('schedules'); ?></a>
        <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/students'); ?>"><i
                class=" icon-th-list"></i> <?php echo lang('students'); ?></a>
        <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/courses'); ?>"><i
                class=" icon-th-list"></i> <?php echo lang('courses'); ?></a>
    </div>
</div>

<div class="row">
    <div class="span12">
        <?php echo form_open($this->config->item('admin_folder') . '/centers/student_create_invoice/' . $id, 'id = from-create-invoice'); ?>
        <input type="hidden" name="student_id" value="<?php echo $id;?>">
        <fieldset>
            <legend>Confirm to create invoice - <a href="/admin/centers/student_form/<?php echo $student->id;?>"><?php echo $student->name;?></a></legend>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Khoản Thu</th>
                    <th>Mức Phí</th>
                    <th>Thanh Toán</th>
                </tr>
                </thead>
                <tbody>
                <?php $count_index = 1; $total_price = 0;foreach($student_registered as $registered){?>
                    <input type="hidden" name="id[]" value="<?php echo $registered->id;?>">
                    <?php
                        $flag_sale_off = false;
                        if($registered->price_sale > 0 && $registered->price_sale < $registered->price){
                            $price = $registered->price_sale;
                            $flag_sale_off = true;
                        }else{
                            $price = $registered->price;
                        }
                        $total_price = $total_price + $price;
                    ?>
                    <tr>
                        <td>
                            <?php echo $count_index++;?>
                        </td>
                        <td>
                            <?php echo $registered->course_title;?>
                        </td>
                        <td>
                            <?php echo format_currency($price);?>
                        </td>
                        <td>
                            <?php echo format_currency($price);?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="2">Tổng tiền</th>
                    <th><?php echo format_currency($total_price);?></th>
                    <th><?php echo format_currency($total_price);?></th>
                </tr>
                </tfoot>
            </table>
            <br/>
        </fieldset>
        </form>
        <div class="row">
            <div class="span6">
                <a href="/<?php echo $this->config->item('admin_folder') . '/centers/student_invoice/' . $id;?>" class="btn btn-primary">Back</a>
                <button onclick="studentCreateInvoice(0)" value="create-invoice" class="btn btn-primary">Confirm</button>
                <button onclick="studentCreateInvoice(1)" value="create-invoice" class="btn btn-primary">Confirm & Print</button>
            </div>
        </div>
    </div>

</div>