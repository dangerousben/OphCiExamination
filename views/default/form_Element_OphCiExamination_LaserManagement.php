<?php /* DEPRECATED */ ?>
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
<?php
	$statuses = OphCiExamination_Management_Status::model()->findAll();
	$status_options = array('empty'=>'- Please select -', 'options' => array());
	foreach ($statuses as $opt) {
		$status_options['options'][(string) $opt->id] = array('data-deferred' => $opt->deferred, 'data-book' => $opt->book, 'data-event' => $opt->event);
	}

	$deferrals = OphCiExamination_Management_DeferralReason::model()->findAll();
	$deferral_options = array('empty'=>'- Please select -', 'options' => array());
	foreach ($deferrals as $opt) {
		$deferral_options['options'][(string) $opt->id] = array('data-other' => $opt->other);
	}

	$lasertypes = OphCiExamination_LaserManagement_LaserType::model()->findAll();
	$lasertype_options = array();

	foreach ($lasertypes as $lt) {
		$lasertype_options[(string)$lt->id] = array('data-other' => $lt->other);
	}

?>

<div class="cols2 clearfix" id="div_<?php echo get_class($element)?>_treatment_fields">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div
		class="side left eventDetail<?php if (!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php $this->renderPartial('form_' . get_class($element) . '_fields',
				array('side' => 'right', 'element' => $element, 'form' => $form,
					'statuses' => $statuses, 'status_options' => $status_options,
					'deferrals' => $deferrals, 'deferral_options' => $deferral_options,
					'lasertypes' => $lasertypes, 'lasertype_options' => $lasertype_options)); ?>
		</div>
		<div class="inactiveForm">
			<a href="#">Add right side</a>
		</div>
	</div>
	<div
		class="side right eventDetail<?php if (!$element->hasLeft()) { ?> inactive<?php } ?>"
		data-side="left">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php $this->renderPartial('form_' . get_class($element) . '_fields',
				array('side' => 'left', 'element' => $element, 'form' => $form,
					'statuses' => $statuses, 'status_options' => $status_options,
					'deferrals' => $deferrals, 'deferral_options' => $deferral_options,
					'lasertypes' => $lasertypes, 'lasertype_options' => $lasertype_options)); ?>
		</div>
		<div class="inactiveForm">
			<a href="#">Add left side</a>
		</div>
	</div>
</div>
