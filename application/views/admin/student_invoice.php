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
        <?php echo form_open($this->config->item('admin_folder') . '/centers/student_invoice/' . $id); ?>
        <fieldset>
            <legend>Registered - <a href="/admin/centers/student_form/<?php echo $student->id;?>"><?php echo $student->name;?></a></legend>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Center</th>
                    <th>Course</th>
                    <th>Course Number</th>
                    <th>Schedule</th>
                    <th>Price</th>
                    <th>Invoiced</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($student_registered as $registered){?>
                    <?php
                        $flag_sale_off = false;
                        if($registered->price_sale > 0 && $registered->price_sale < $registered->price){
                            $price = $registered->price_sale;
                            $flag_sale_off = true;
                        }else{
                            $price = $registered->price;
                        }
                    ?>
                    <tr>
                        <td>
                            <?php if($registered->invoice_status == 0){?>
                                <input type="checkbox" name="id[]" value="<?php echo $registered->id;?>">
                            <?php }else{?>
                                <input type="checkbox" disabled>
                            <?php }?>
                        </td>
                        <td><?php echo $registered->center_name;?></td>
                        <td><?php echo $registered->course_title;?></td>
                        <td><?php echo $registered->course_number_title;?></td>
                        <td><?php echo $registered->schedule_title . '('.$registered->start_time.' - '.$registered->end_time.')';?></td>
                        <td>
                            <?php echo format_currency($price);?>
                            <?php if($flag_sale_off){?>
                                <br />
                                <span style="text-decoration: line-through; font-size: 12px"><?php echo format_currency($registered->price);?></span>
                            <?php }?>
                        </td>
                        <td>
                            <?php
                                if($registered->invoice_status){?>
                                    <a href="/admin/centers/print_invoice/<?php echo $registered->invoice_number;?>"> <?php echo $registered->invoice_number;?> </a>
                                <?php }else{
                                    echo 'No';
                                }
                            ?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <br/>
        </fieldset>
        <div class="row">
            <div class="span6">
                <button name="submit" value="create-invoice" type="submit" class="btn btn-primary">Create Invoice</button>
            </div>
        </div>
        </form>

    </div>

</div>