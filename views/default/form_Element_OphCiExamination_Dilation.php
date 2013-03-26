<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<div class="removeElement">
		<button class="classy blue mini">
			<span class="button-span icon-only"><img
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="24" height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<?php 
		$key = 0;
	?>
	<div class="cols2 clearfix">
		<input type="hidden" name="dilation_treatments_valid" value="1" />
		<?php echo $form->hiddenField($element, 'eye_id', array('class' => 'sideField')); ?>
		<div
			class="side left eventDetail<?php if(!$element->hasRight()) { ?> inactive<?php } ?>"
			data-side="right">
			<div class="activeForm">
				<a href="#" class="removeSide">-</a>
				<?php echo $form->dropDownListNoPost('dilation_drug_right',$element->getUnselectedDilationDrugs('right'),'', array('class'=> 'dilation_drug', 'empty'=>'--- Please select ---'))?>
				<button class="clearDilation classy green mini" type="button">
					<span class="button-span button-span-green">Clear</span>
				</button>
				<?php $right_treatments = (isset($_POST['dilation_treatments_valid']) ? $element->convertTreatments(@$_POST['dilation_treatment'], 'right') : $element->right_treatments); ?>
				<div class="timeDiv right"<?php if (!$right_treatments) {?> style="display: none;"<?php }?>>
					<span class="label">Time:</span>
					<?php echo CHtml::textField(get_class($element)."[right_time]",isset($_POST[get_class($element)]['right_time']) ? $_POST[get_class($element)]['right_time'] : substr($element->right_time,0,5))?>
				</div>
				<div class="grid-view dilation_table"<?php if (!$right_treatments) {?> style="display: none;"<?php }?>>
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th style="width: 50px;">Drops</th>
								<th style="width: 40px;"></th>
							</tr>
						</thead>
						<tbody id="dilation_right">
							<?php foreach ($right_treatments as $treatment) {
									$this->renderPartial('form_Element_OphCiExamination_Dilation_Treatment',array(
										'treatment' => $treatment,
										'key' => $key,
										'side' => $treatment->side,
										'drug_name' => $treatment->drug->name,
										'drug_id' => $treatment->drug_id,
									));
								$key++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="inactiveForm">
				<a href="#">Add right side</a>
			</div>
		</div>
		<div
			class="side right eventDetail<?php if(!$element->hasLeft()) { ?> inactive<?php } ?>"
			data-side="left">
			<div class="activeForm">
				<a href="#" class="removeSide">-</a>
				<?php echo $form->dropDownListNoPost('dilation_drug_left',$element->getUnselectedDilationDrugs('left'),'', array('class'=> 'dilation_drug', 'empty'=>'--- Please select ---'))?>
				<button class="clearDilation classy green mini" type="button">
					<span class="button-span button-span-green">Clear</span>
				</button>
				<?php $left_treatments = (isset($_POST['dilation_treatments_valid']) ? $element->convertTreatments(@$_POST['dilation_treatment'], 'left') : $element->left_treatments); ?>
				<div class="timeDiv left"<?php if (!$left_treatments) {?> style="display: none;"<?php }?>>
					<span class="label">Time:</span>
					<?php echo CHtml::textField(get_class($element)."[left_time]",isset($_POST[get_class($element)]['left_time']) ? $_POST[get_class($element)]['left_time'] : substr($element->left_time,0,5))?>
				</div>
				<div class="grid-view dilation_table"<?php if (!$left_treatments) {?> style="display: none;"<?php }?>>
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th>Drops</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="dilation_left">
							<?php foreach ($left_treatments as $treatment) {
									$this->renderPartial('form_Element_OphCiExamination_Dilation_Treatment',array(
										'treatment' => $treatment,
										'key' => $key,
										'side' => $treatment->side,
										'drug_name' => $treatment->drug->name,
										'drug_id' => $treatment->drug_id,
									));
								$key++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="inactiveForm">
				<a href="#">Add left side</a>
			</div>
		</div>
	</div>
</div>

<script id="dilation_treatment_template" type="text/html">
	<?php
	$this->renderPartial('form_Element_OphCiExamination_Dilation_Treatment', array(
			'key' => '{{key}}',
			'side' => '{{side}}',
			'drug_name' => '{{drug_name}}',
			'drug_id' => '{{drug_id}}',
	));
	?>
</script>
