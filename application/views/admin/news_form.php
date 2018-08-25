<?php echo form_open($this->config->item('admin_folder').'/news/form/'.$id, 'enctype="multipart/form-data"'); ?>

<div class="tabbable">
	
	<ul class="nav nav-tabs">
		<li class="active"><a href="#content_tab" data-toggle="tab"><?php echo lang('content');?></a></li>
		<li><a href="#attributes_tab" data-toggle="tab"><?php echo lang('attributes');?></a></li>
		<li><a href="#seo_tab" data-toggle="tab"><?php echo lang('seo');?></a></li>
	</ul>
	
	<div class="tab-content">
		<div class="tab-pane active" id="content_tab">
			<fieldset>
				<label for="title"><?php echo lang('title');?></label>
				<?php
				$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'span12');
				echo form_input($data);
				?>

				<label for="title">Description</label>
				<?php
				$data	= array('name'=>'description', 'value'=>set_value('description', $description), 'class'=>'span12');
				echo form_input($data);
				?>

				<label for="content"><?php echo lang('content');?></label>
				<?php
				$data	= array('name'=>'content', 'class'=>'redactor', 'value'=>set_value('content', $content));
				echo form_textarea($data);
				?>
				<br/>

				<?php
				$config_image = config_item('image');
				$config_type = $config_image['news'];
				?>
				<label for="content">Image</label>
				<input type="file" name="userfile" value="" id="userfile" class="input-file">
				<?php if(isset($image) && $image != ''){?>
					<img height="50px" src="/<?php echo $config_type['path_medium'].'/' . $image;?>">
				<?php }?>

			</fieldset>
		</div>

		<div class="tab-pane" id="attributes_tab">
			<fieldset>
				<label for="menu_title"><?php echo lang('menu_title');?></label>
				<?php
				$data	= array('name'=>'menu_title', 'value'=>set_value('menu_title', $menu_title), 'class'=>'span3');
				echo form_input($data);
				?>
			
				<label for="slug"><?php echo lang('slug');?></label>
				<?php
				$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'span3');
				echo form_input($data);
				?>
			
				<label for="sequence"><?php echo lang('sequence');?></label>
				<?php
				$data	= array('name'=>'sequence', 'value'=>set_value('sequence', $sequence), 'class'=>'span3');
				echo form_input($data);
				?>
			</fieldset>
		</div>
	
		<div class="tab-pane" id="seo_tab">
			<fieldset>
				<label for="code"><?php echo lang('seo_title');?></label>
				<?php
				$data	= array('name'=>'seo_title', 'value'=>set_value('seo_title', $seo_title), 'class'=>'span12');
				echo form_input($data);
				?>

				<label>Meta Key Words</label>
				<?php
				$data	= array('rows'=>'3', 'name'=>'meta_keyword', 'value'=>set_value('meta_keyword', html_entity_decode($meta_keyword)), 'class'=>'span12');
				echo form_textarea($data);
				?>

				<label><?php echo lang('meta');?> description</label>
				<?php
				$data	= array('rows'=>'3', 'name'=>'meta', 'value'=>set_value('meta', html_entity_decode($meta)), 'class'=>'span12');
				echo form_textarea($data);
				?>
				
				<p class="help-block"><?php echo lang('meta_data_description');?></p>
			</fieldset>
		</div>
	</div>
</div>

<div class="form-actions">
	<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
</div>	
</form>