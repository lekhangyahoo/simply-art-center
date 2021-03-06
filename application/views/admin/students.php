<div class="btn-group pull-right">
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('centers'); ?></a>
    <a class="btn"
       href="<?php echo site_url($this->config->item('admin_folder') . '/centers/schedules'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('schedules'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/courses'); ?>"><i
            class=" icon-th-list"></i> <?php echo lang('courses'); ?></a>
    <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/student_form'); ?>"><i class="icon-plus-sign"></i> Add New Student</a>
</div>

<div class="row">
    <form action="/admin/centers/students" method="post" accept-charset="utf-8">
        <div class="span2">
            <input type="text" name="key_word" value="<?php if(isset($key_word)) echo $key_word;?>" class="span2" required="required" placeholder="Key Word Name" minlength=2 autocomplete="off">
        </div>
        <div class="span2">
            <input type="text" name="key_word_birthday" value="<?php if(isset($key_word_birthday)) echo $key_word_birthday;?>" class="span2" placeholder="Key Word Birthday" autocomplete="off">
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
        <th width="10%">Gender</th>
        <th width="15%">Phone</th>
        <th width="15%">Parent Name</th>
        <th width="10%">Active</th>
        <th width="20%"></th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($students as $student): ?>
        <tr id="row-<?php echo $student->id;?>">
            <td class="center-name">
                <?php echo $student->name; ?>
            </td>
            <td>
                <?php echo $student->birthday; ?>
            </td>
            <td>
                <?php if ($student->gender == 1) {
                    echo 'Nữ';
                } else {
                    echo 'Nam';
                }
                ?>
            </td>
            <td>
                <?php echo $student->phone; ?>
            </td>
            <td>
                <?php echo $student->parent_name; ?>
            </td>

            <td>
                <?php if ($student->active == 1) {
                    echo 'Enabled';
                } else {
                    echo 'Disabled';
                }
                ?>
            </td>
            <td>
                <div class="btn-group" style="float:right">
                    <a id="edit-center-<?php echo $student->id;?>" class="btn"
                       href="/admin/centers/student_detail/<?php echo $student->id;?>"> Detail </a>
                    <a id="edit-center-<?php echo $student->id;?>" class="btn"
                       href="/admin/centers/student_invoice/<?php echo $student->id;?>">Invoice</a>
                    <a id="edit-center-<?php echo $student->id;?>" class="btn"
                       href="/admin/centers/student_form/<?php echo $student->id;?>"><?php echo lang('edit'); ?></a>
                    <a class="btn btn-danger"
                       href="#" onclick="deleteStudent(<?php echo $student->id;?>);return false;"><?php echo lang('delete'); ?></a>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>