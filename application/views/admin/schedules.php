<script type="text/javascript">
    function areyousure() {
        return confirm('<?php echo lang('confirm_delete_center');?>');
    }
</script>
<div class="btn-group pull-right">
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('centers'); ?></a>
    <a class="btn"
       href="<?php echo site_url($this->config->item('admin_folder') . '/centers/schedules'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('schedules'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/students'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('students'); ?></a>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Title
        <th></th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($schedules as $schedule): ?>
        <tr id="row-<?php echo $schedule->id;?>">
            <td class="center-name">
                <div class="text-name text">
                    <?php echo $schedule->name; ?>
                </div>
                <div class="input-name hide input">
                    <input type="text" name="name" value="<?php echo $schedule->name; ?>">
                </div>
            </td>

            <td>
                <div class="btn-group" style="float:right">
                    <a id="edit-center-<?php echo $schedule->id;?>" class="btn"
                       href="#" onclick="editCourse(<?php echo $schedule->id;?>);return false;"><i
                            class="icon-pencil"></i> <?php echo lang('edit'); ?></a>
                    <a class="btn btn-danger"
                       href="#" onclick="deleteSchedule(<?php echo $schedule->id;?>);return false;"><i
                            class="icon-trash icon-white"></i> <?php echo lang('delete'); ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>