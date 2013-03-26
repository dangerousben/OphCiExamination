<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data">
				<?php if($element->hasRight()) {
					echo $element->right_description;
				} else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="data">
				<?php if($element->hasLeft()) {
					echo $element->left_description;
				} else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
	</div>
</div>
