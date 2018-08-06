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
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/course_form'); ?>"><i class="icon-plus-sign"></i> Add New Courses</a>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr width="100%">
        <th width="55%">Title
        <th width="15%">Active</th>
        <th width="30%"></th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($courses as $course): ?>
        <tr id="row-<?php echo $course->id;?>">
            <td class="center-name">
                <div class="text-name text">
                    <?php echo $course->title; ?>
                </div>
            </td>
            <td>
                <?php if ($course->active == 1) {
                    echo 'Enabled';
                } else {
                    echo 'Disabled';
                }
                ?>
            </td>
            <td>
                <div class="btn-group" style="float:right">
                    <a id="edit-center-<?php echo $course->id;?>" class="btn"
                       href="/admin/centers/course_form/<?php echo $course->id;?>"><i
                            class="icon-pencil"></i> <?php echo lang('edit'); ?></a>
                    <a class="btn btn-danger"
                       href="#" onclick="deleteCourse(<?php echo $course->id;?>);return false;"><i
                            class="icon-trash icon-white"></i> <?php echo lang('delete'); ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>