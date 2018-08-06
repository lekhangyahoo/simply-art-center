<script type="text/javascript">
    function areyousure() {
        return confirm('<?php echo lang('confirm_delete_center');?>');
    }
</script>
<div class="btn-group pull-right">
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/courses'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('courses'); ?></a>
    <a class="btn"
       href="<?php echo site_url($this->config->item('admin_folder') . '/centers/schedules'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('schedules'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/students'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('students'); ?></a>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Active</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <tr id="row-0">
        <td class="center-name">
            <div class="input-name">
                <input type="text" name="name" value="">
            </div>
        </td>
        <td class="gc_cell_left center-address">
            <div class="input-address">
                <input type="text" name="address" value="">
            </div>
        </td>
        <td class="gc_cell_left center-phone">
            <div class="input-phone">
                <input type="number" name="phone" value="">
            </div>
        </td>
        <td>
            <div class="input-active">
                <select name="active">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
        </td>
        <td>
            <div class="btn-group" style="float:right">
                <a class="btn"
                   href="#" onclick="saveCenter(0);return false;"><i
                        class="icon-plus-sign"></i> <?php echo lang('save'); ?></a>
            </div>
        </td>
    </tr>

    <?php foreach ($centers as $center): ?>
        <tr id="row-<?php echo $center->id;?>">
            <?php /*<td style="width:16px;"><?php echo  $customer->id; ?></td>*/ ?>
            <td class="center-name">
                <div class="text-name text">
                    <?php echo $center->name; ?>
                </div>
                <div class="input-name hide input">
                    <input type="text" name="name" value="<?php echo $center->name; ?>">
                </div>
            </td>
            <td class="gc_cell_left center-address">
                <div class="text-address text">
                    <?php echo $center->address; ?>
                </div>
                <div class="input-address hide input">
                    <input type="text" name="address" value="<?php echo $center->address; ?>">
                </div>
            </td>
            <td class="gc_cell_left center-phone">
                <div class="text-phone text">
                    <?php echo $center->phone; ?>
                </div>
                <div class="input-phone hide input">
                    <input type="text" name="phone" value="<?php echo $center->phone; ?>">
                </div>
            </td>
            <td>
                <div class="text-active text">
                    <?php if ($center->active == 1) {
                        echo 'Yes';
                    } else {
                        echo 'No';
                    }
                    ?>
                </div>
                <div class="input-active hide input">
                    <select name="active">
                        <option value="0" <?php if ($center->active == 0) echo 'selected';?>>Disabled</option>
                        <option value="1" <?php if ($center->active == 1) echo 'selected';?>>Enabled</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="btn-group" style="float:right">
                    <a id="edit-center-<?php echo $center->id;?>" class="btn"
                       href="#" onclick="editCenter(<?php echo $center->id;?>);return false;"><i
                            class="icon-pencil"></i> <?php echo lang('edit'); ?></a>

                    <a id="save-center-<?php echo $center->id;?>" class="btn hide"
                       href="#" onclick="saveCenter(<?php echo $center->id;?>);return false;"><i
                            class="icon-hdd"></i> <?php echo lang('save'); ?></a>

                    <a class="btn btn-danger"
                       href="#" onclick="deleteCenter(<?php echo $center->id;?>);return false;"><i
                            class="icon-trash icon-white"></i> <?php echo lang('delete'); ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>