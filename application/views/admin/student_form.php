<style>
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
    <div class="span6">
        <?php echo form_open($this->config->item('admin_folder') . '/centers/course_form/' . $id); ?>
        <fieldset>
            <legend>Information</legend>
            <label for="title">Full Name</label>
            <?php
            $data = array('name' => 'name', 'value' => set_value('name', @$name), 'class' => 'span6', 'required' => 'required');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Birthday</label>
            <?php
            $data = array('name' => 'birthday', 'value' => set_value('birthday    ', @$birthday), 'class' => 'span6', 'required' => 'required');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Parent Name</label>
            <?php
            $data = array('name' => 'parent_name', 'value' => set_value('parent_name', @$parent_name), 'class' => 'span6', 'required' => 'required');
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
            $data = array('name' => 'email', 'value' => set_value('email', @$email), 'class' => 'span6', 'required' => 'required');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Adress</label>
            <?php
                $data = array('name' => 'address', 'value' => set_value('address', @$address), 'class' => 'span6');
                echo form_input($data);
            ?>
            <select id="district_id" name="center_id" class="span3">
                <option value="">-- Select District --</option>
                <?php foreach ($districts as $district) { ?>
                    <option value="<?php echo $district->id; ?>" <?php if($district->id == $district_id) echo 'selected';?>><?php echo $district->name; ?></option>
                <?php } ?>
            </select>
            <?php if(isset($wards) && !empty($districts)){?>
                <select id="ward_id" name="center_id" class="span3">
                    <option value="">-- Select Ward --</option>
                    <?php foreach ($wards as $ward) {?>
                        <option class="value-ward" value="<?php echo $ward->id; ?>" <?php if($ward->id == $ward_id) echo 'selected';?>><?php echo $ward->name; ?></option>
                    <?php }?>
                </select>
            <?php }?>
            <br/>

            <label for="content">Note</label>
            <?php
            $data = array('name' => 'note', 'value' => set_value('note', @$note), 'class' => 'span6');
            echo form_input($data);
            ?>
            <br/>

            <label for="content">Active</label>
            <select name="active">
                <option value="1" <?php if ($active == 1) echo 'selected'; ?>>Enabled</option>
                <option value="0" <?php if ($active == 0) echo 'selected'; ?>>Disabled</option>
            </select>
        </fieldset>
        </form>

    </div>
    <?php if($id > 0){?>
    <div class="span6">
        <fieldset>
            <legend>New Registration</legend>
            <div class="row new-registration">
                <div class="span3">
                    <label for="title">Center</label>
                    <select id="new_regis_center_id" name="center_id" required="required">
                        <option value="">-- Select Center --</option>
                        <?php foreach ($centers as $center) { ?>
                            <option value="<?php echo $center->id; ?>"><?php echo $center->name; ?></option>
                        <?php } ?>
                    </select>
                    <br/>

                    <label for="title">Course Number</label>
                    <select name="course_number_id" required="required">
                        <?php foreach ($course_numbers as $course_number) { ?>
                            <option
                                value="<?php echo $course_number->id; ?>"><?php echo $course_number->title; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="span3">
                    <label for="title">Course</label>
                    <select id="new_regis_course_id" name="course_id" required="required">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $course) { ?>
                            <option value="<?php echo $course->id; ?>"><?php echo $course->title; ?></option>
                        <?php } ?>
                    </select>
                    <br/>

                    <label for="title">Schedule</label>
                    <select id="new_regis_schedule_id" name="schedule_id" required="required">
                    </select>
                </div>
            </div>
            <br/>

        </fieldset>

        <fieldset>
            <legend>Registered</legend>
            <label for="title">Full Name</label>
            <?php
            $data = array('name' => 'title', 'value' => set_value('title', @$title), 'class' => 'span6');
            echo form_input($data);
            ?>
            <br/>
        </fieldset>
    </div>
    <?php }?>

</div>
<div class="row">
    <div class="span5">
        <button name="submit" value="submit" type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
    </div>
</div>
