<?php  if (count($errors) > 0) : ?>
	<div class="error" style="color:red;">
		<?php foreach ($errors as $error) : ?>
			<strong><?php echo $error ?></strong><br>
		<?php endforeach ?>
	</div>
<?php  endif ?>
