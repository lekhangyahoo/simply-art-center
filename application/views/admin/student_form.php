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

<?php echo form_open($this->config->item('admin_folder') . '/centers/course_form/' . $id); ?>
    <div class="row">
        <div class="span8">
            <fieldset>
                <legend>Information</legend>
                <label for="title">Full Name</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Birthday</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Parent Name</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Phone</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Email</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Adress</label>
                <input type="text" name="title" value="" class="span4" placeholder="Addess">
                <input type="text" name="title" value="" class="span2" placeholder="District">
                <input type="text" name="title" value="" class="span2" placeholder="Ward">
                <br/>

                <label for="content">Note</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span8');
                echo form_input($data);
                ?>
                <br/>

                <label for="content">Active</label>
                <select name="active">
                    <option value="1" <?php if ($active == 1) echo 'selected'; ?>>Enabled</option>
                    <option value="0" <?php if ($active == 0) echo 'selected'; ?>>Disabled</option>
                </select>
            </fieldset>

        </div>
        <div class="span4">
            <fieldset>
                <legend>New Registration</legend>
                <label for="title">Full Name</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span4', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>
            </fieldset>

            <fieldset>
                <legend>Registered</legend>
                <label for="title">Full Name</label>
                <?php
                $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span4', 'required' => 'required');
                echo form_input($data);
                ?>
                <br/>
            </fieldset>
        </div>

    </div>
    <div class="row">
        <div class="span4">
            <button name="submit" value="submit" type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
        </div>
    </div>
</form>