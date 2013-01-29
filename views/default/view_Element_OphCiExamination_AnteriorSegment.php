<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) {
				$this->renderPartial('view_' . get_class($element) . '_OEEyeDraw',
					array('side' => 'right', 'element' => $element));
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) {
				$this->renderPartial('view_' . get_class($element) . '_OEEyeDraw',
					array('side' => 'left', 'element' => $element));
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
	</div>
	<div class="child_elements">
		<?php $this->renderChildDefaultElements($element, $this->action->id, $form, $data); ?>
	</div>
</div>
