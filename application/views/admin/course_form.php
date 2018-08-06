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

<?php echo form_open($this->config->item('admin_folder') . '/centers/course_form/' . $id); ?>
    <div class="tabbable">

        <div>
            <fieldset>
                <label for="title"><?php echo @lang('title'); ?></label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span12', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content"><?php echo @lang('description'); ?></label>
                <?php
                $data = array('name' => 'description', 'class' => 'redactor', 'value' => set_value('description', @$description));
                echo form_textarea($data);
                ?>
                <br/>

                <label for="content"><?php echo @lang('content'); ?></label>
                <?php
                $data = array('name' => 'content', 'class' => 'redactor', 'value' => set_value('content', @$content));
                echo form_textarea($data);
                ?>
                <br/>

                <label for="content">Active</label>
                <select name="active">
                    <option value="1" <?php if ($active == 1) echo 'selected';?>>Enabled</option>
                    <option value="0" <?php if ($active == 0) echo 'selected';?>>Disabled</option>
                </select>
            </fieldset>
        </div>
    </div>

    <div class="form-actions">
        <button name="submit" value="submit" type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
    </div>
</form>