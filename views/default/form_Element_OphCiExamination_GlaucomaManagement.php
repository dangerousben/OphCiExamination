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
// list of medications for the first list:
$medications = $element->getMedications();
// map of to medications to group name:
$medications2group = $element->getMedicationGroups();
// map group name with array of groups NOT added with the specified group
// (should another selection occur):
$groupRemoval = $element->getConflictingGroups();
?>

<script type="text/javascript">
  // step 1 - what's the current medication and it's group?
  var medications = new Array();
  // medications for the second list:
  var medications2 = new Array();
<?php
$i = 1;
foreach ($medications2group as $med => $medGroup) {
//    foreach ($medGroup as $med => $group) {
  echo "medications['" . $med
  . "'] = '" . $medGroup . "';\n";
  echo "medications['" . $med
  . "'].value = " . $i++ . ";\n";
//    }
}
?>
  // step 2 - what's the current group and what groups does it conflict with?
  // step 1 - what's the current medication and it's group?
  var groupRemoval = new Array();
<?php
foreach ($groupRemoval as $medGroup => $conflictingGroups) {
  $i = 0;
  echo "groupRemoval['" . $medGroup . "'] = new Array();\n";
  foreach ($conflictingGroups as $group) {
    echo "groupRemoval['" . $medGroup . "'][" . $i . "] = '" . $group . "';\n";
    $i++;
  }
}
?>
</script>

  <div class="cols2 clearfix">
    <?php echo $form->hiddenField($element, 'eye_id', array('class' => 'sideField')); ?>
    <div
      class="side left eventDetail<?php if (!$element->hasRight()) { ?> inactive<?php } ?>"
      data-side="right">
      <div class="activeForm">
        <a href="#" class="removeSide">-</a>
        <div class="data">
          <?php
          echo $form->dropDownList($element, 'medication_1_right', $medications, array('empty' =>
              '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_1_right\', \'Element_OphCiExamination_GlaucomaManagement_medication_2_right\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_right\', groupRemoval, medications, medications2);', 'nowrapper' => true));
          ?>
          <?php
          if (!$element->medication_2_left) {
            echo $form->dropDownList($element, 'medication_2_right', array(), array('empty' =>
                '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_2_right\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_right\', null, groupRemoval, medications, medications2);', 'nowrapper' => true));
          } else {
            echo $form->dropDownList($element, 'medication_2_right', $medications, array('empty' =>
                '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_2_right\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_right\', null, groupRemoval, medications, medications2);', 'nowrapper' => true));
          }
          ?>
          <?php
          if (!$element->medication_3_right) {
            echo $form->dropDownList($element, 'medication_3_right', array(), array('empty' =>
                '- Select Drug -', 'nowrapper' => true));
          } else {
            echo $form->dropDownList($element, 'medication_3_right', $medications, array('empty' =>
                '- Select Drug -', 'nowrapper' => true));
          }
          ?>
        </div>

        <div class="data">
          <?php
          $laserOptions = CHtml::listData(OphCiExamination_GlaucomaLaser::model()->findAllByAttributes(array()), 'id', 'name');
          echo $form->dropDownList($element, 'right_laser_id', $laserOptions, array('empty' =>
              '- Please select -'));
          ?>
        </div>
        <div class="data">
          <?php
          $surgeryOptions = CHtml::listData(OphCiExamination_GlaucomaSurgery::model()->findAllByAttributes(array()), 'id', 'name');
          echo $form->dropDownList($element, 'right_surgery_id', $surgeryOptions, array('empty' => '- Please select -'));
          ?>
        </div>
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
        <div class="data">
          <?php
          echo $form->dropDownList($element, 'medication_1_left', $medications, array('empty' =>
              '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_1_left\', \'Element_OphCiExamination_GlaucomaManagement_medication_2_left\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_left\', groupRemoval, medications, medications2);', 'nowrapper' => true));
          ?>
          <?php
          if (!$element->medication_2_left) {
            echo $form->dropDownList($element, 'medication_2_left', array(), array('empty' =>
                '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_2_left\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_left\', null, groupRemoval, medications, medications2);', 'nowrapper' => true));
          } else {
            echo $form->dropDownList($element, 'medication_2_left', $medications, array('empty' =>
                '- Select Drug -', 'onChange' => 'populateList(\'Element_OphCiExamination_GlaucomaManagement_medication_2_left\', \'Element_OphCiExamination_GlaucomaManagement_medication_3_left\', null, groupRemoval, medications, medications2);', 'nowrapper' => true));
          }
          ?>
          <?php
          if (!$element->medication_3_left) {
            echo $form->dropDownList($element, 'medication_3_left', array(), array('empty' =>
                '- Select Drug -', 'nowrapper' => true));
          } else {
            echo $form->dropDownList($element, 'medication_3_left', $medications, array('empty' =>
                '- Select Drug -', 'nowrapper' => true));
          }
          ?>
        </div>
        <div class="data">
          <?php
          $laserOptions = CHtml::listData(OphCiExamination_GlaucomaLaser::model()->findAllByAttributes(array()), 'id', 'name');
          echo $form->dropDownList($element, 'left_laser_id', $laserOptions, array('empty' =>
              '- Please select -'));
          ?>
        </div>
        <div class="data">
          <?php
          $surgeryOptions = CHtml::listData(OphCiExamination_GlaucomaSurgery::model()->findAllByAttributes(array()), 'id', 'name');
          echo $form->dropDownList($element, 'left_surgery_id', $surgeryOptions, array('empty' => '- Please select -'));
          ?>
        </div>
      </div>

      <div class="inactiveForm">
        <a href="#">Add left side</a>
      </div>
    </div>
  </div>

  <div id="div_<?php echo get_class($element) ?>_comments"
       class="eventDetail">
    <div class="data">
      <?php echo $form->textArea($element, 'comments', array('rows' => "3", 'cols' => "70", 'class' => 'autosize', 'nowrapper' => true)) ?>
    </div>
  </div>

<script type="text/javascript">
  // make the 2nd and 3rd selects hidden until they're used:
<?php
if (!$element->medication_2_right) {
  ?>
        document.getElementById("Element_OphCiExamination_GlaucomaManagement_medication_2_right").style.display = "none";
  <?php
}
?>
<?php
if (!$element->medication_3_right) {
  ?>
        document.getElementById("Element_OphCiExamination_GlaucomaManagement_medication_3_right").style.display = "none";
  <?php
}
?>
<?php
if (!$element->medication_2_left) {
  ?>
        document.getElementById("Element_OphCiExamination_GlaucomaManagement_medication_2_left").style.display = "none";
  <?php
}
?>
<?php
if (!$element->medication_3_left) {
  ?>
        document.getElementById("Element_OphCiExamination_GlaucomaManagement_medication_3_left").style.display = "none";
<?php }
?>
</script>