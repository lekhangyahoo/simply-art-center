<div class="btn-group pull-right">
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('centers'); ?></a>
    <a class="btn"
       href="<?php echo site_url($this->config->item('admin_folder') . '/centers/schedules'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('schedules'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/courses'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('courses'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/teacher_form'); ?>"><i class="icon-plus-sign"></i> Add New Teacher</a>
</div>

<div class="row">
    <form action="/admin/centers/teachers" method="post" accept-charset="utf-8">
        <div class="span2">
            <input type="text" name="key_word" value="<?php if(isset($key_word)) echo $key_word;?>" class="span2" required="required" placeholder="Key Word Name" minlength=2 autocomplete="off">
        </div>
        <div class="span1">
            <button name="search" value="search" type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr width="100%">
        <th width="15%">Name</th>
        <th width="15%">Birthday</th>
        <th width="10%">Email</th>
        <th width="15%">Phone</th>
        <th width="10%">Active</th>
        <th width="20%"></th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($teachers as $teacher): ?>
        <tr id="row-<?php echo $teacher->id;?>">
            <td class="center-name">
                <?php echo $teacher->name; ?>
            </td>
            <td>
                <?php echo $teacher->birthday; ?>
            </td>
            <td>
                <?php echo $teacher->email; ?>
            </td>
            <td>
                <?php echo $teacher->phone; ?>
            </td>

            <td>
                <?php if ($teacher->active == 1) {
                    echo 'Enabled';
                } else {
                    echo 'Disabled';
                }
                ?>
            </td>
            <td>
                <div class="btn-group" style="float:right">
                    <a id="edit-center-<?php echo $teacher->id;?>" class="btn"
                       href="/admin/centers/teacher_form/<?php echo $teacher->id;?>"><?php echo lang('edit'); ?></a>
                    <a class="btn btn-danger"
                       href="#" onclick="deleteTeacher(<?php echo $teacher->id;?>);return false;"><?php echo lang('delete'); ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>