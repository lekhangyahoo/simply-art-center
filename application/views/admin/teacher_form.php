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
        <a class="btn" href="<?php echo site_url($this->config->item('admin_folder') . '/centers/teachers'); ?>"><i
                class=" icon-th-list"></i> <?php echo lang('teachers'); ?></a>
    </div>
</div>

<div class="row">
    <div class="span6">
        <?php echo form_open($this->config->item('admin_folder') . '/centers/teacher_form/' . $id, 'enctype="multipart/form-data"'); ?>
        <fieldset>
            <legend>Information</legend>
            <label for="title">Full Name</label>
            <?php
            $data = array('name' => 'name', 'value' => set_value('name', @$name), 'class' => 'span6', 'required' => 'required');
            echo form_input($data);
            ?>
            <br/>

            <label for="title">Gender</label>
            <select name="gender">
                <option value="1" <?php if ($gender == 1) echo 'selected'; ?>>Female</option>
                <option value="0" <?php if ($gender == 0) echo 'selected'; ?>>Male</option>
            </select>
            <br/>

            <label for="content">Birthday</label>
            <?php
            $data = array('name' => 'birthday', 'value' => set_value('birthday    ', @$birthday), 'class' => 'span6', 'required' => 'required', 'placeholder' => '1990-12-31');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Phone</label>
            <?php
            $data = array('name' => 'phone', 'value' => set_value('phone', @$phone), 'class' => 'span6', 'required' => 'required');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Email</label>
            <?php
            $data = array('name' => 'email', 'value' => set_value('email', @$email), 'class' => 'span6');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Adress</label>
            <?php
                $data = array('name' => 'address', 'value' => set_value('address', @$address), 'class' => 'span6');
                echo form_input($data);
            ?>
            <div class="clearfix"></div>
            <select id="district_id" name="center_id" class="span6">
                <option value="">-- Select District --</option>
                <?php foreach ($districts as $district) { ?>
                    <option value="<?php echo $district->id; ?>" <?php if($district->id == $district_id) echo 'selected';?>><?php echo $district->name; ?></option>
                <?php } ?>
            </select>
            <div class="clearfix"></div>
            <select id="ward_id" name="center_id" class="span6">
                <option value="">-- Select Ward --</option>
                <?php foreach ($wards as $ward) {?>
                    <option class="value-ward" value="<?php echo $ward->id; ?>" <?php if($ward->id == $ward_id) echo 'selected';?>><?php echo $ward->name; ?></option>
                <?php }?>
            </select>
            <br/>

            <label for="content">Note</label>
            <?php
            $data = array('name' => 'note', 'value' => set_value('note', @$note), 'class' => 'span6');
            echo form_input($data);
            ?>
            <br/>

            <label for="description">Description</label>
            <?php
            $data	= array('name'=>'description', 'class'=>'redactor', 'value'=>set_value('description', $description));
            echo form_textarea($data);
            ?>
            <br/>

            <?php
            $config_image = config_item('image');
            $config_type = $config_image['teachers'];
            ?>
            <label for="content">Image</label>
            <input type="file" name="userfile" value="" id="userfile" class="input-file">
            <?php if(isset($image) && $image != ''){?>
                <img height="50px" src="/<?php echo $config_type['path_medium'].'/' . $image;?>">
            <?php }?>
            <br/>

            <label for="content">Active</label>
            <select name="active">
                <option value="1" <?php if ($active == 1) echo 'selected'; ?>>Enabled</option>
                <option value="0" <?php if ($active == 0) echo 'selected'; ?>>Disabled</option>
            </select>
        </fieldset>
        <div class="row">
            <div class="span6">
                <button name="submit" value="save" type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
                <button name="submit" value="save-continue" type="submit" class="btn btn-primary">Save & Continue</button>
            </div>
        </div>
        </form>

    </div>

</div>

