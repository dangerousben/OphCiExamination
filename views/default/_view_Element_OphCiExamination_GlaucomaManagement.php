<?php
/**
 * OpenEyes
 *
 * (C) University of Cardiff, 2012
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) University of Cardiff, 2012
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<?php
//$followUpData = $element->getFollow_up_list();
//$locations = Site::model()->getList();
$laserOptions = $element->getLaserOptions();
$surgeryOptions = $element->getSurgeryOptions();

$medications = $element->getMedications();
?>


<div class="eventDetail">
  <table class="subtleWhite normalText">
    <tbody>
      <?php
      if ($element->right_surgery || $element->right_surgery || $element->medication_1_right) {
        ?>
        <tr>
          <th><b>RE</b></th>
        </tr>
        <?php
        if ($element->medication_1_right) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('medication_1_right')) ?></th>
            <td>
              <?php
              $medications = $element->getMedications();
              echo $medications[$element->medication_1_right];
              if ($element->medication_2_right) {
                echo ", " . $medications[$element->medication_2_right];
                if ($element->medication_3_right) {
                  echo ", " . $medications[$element->medication_3_right];
                }
              }
              ?></td>
            </th>
          </tr>
          <?php
        }
        if ($element->right_laser) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('right_laser')) ?></th>
            <td><?php echo $laserOptions[$element->right_laser->id]; ?></td>
          </tr>
          <?php
        }
        if ($element->right_surgery) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('right_surgery')) ?></th>
            <td><?php echo $surgeryOptions[$element->right_surgery->id]; ?></td>
          </tr>
          <?php
        }
      }
      if ($element->left_surgery || $element->left_surgery || $element->medication_1_left) {
        ?>
        <tr>
          <th><b>LE</b></th>
        </tr>
        <?php
        if ($element->medication_1_left) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('medication_1_left')) ?></th>
            <td>
              <?php
              $medications = $element->getMedications();
              echo $medications[$element->medication_1_left];
              if ($element->medication_2_left) {
                echo ", " . $medications[$element->medication_2_left];
                if ($element->medication_3_left) {
                  echo ", " . $medications[$element->medication_3_left];
                }
              }
              ?></td>
            </th>
          </tr>
          <?php
        }
        if ($element->left_surgery) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('left_surgery')) ?></th>
            <td><?php echo $surgeryOptions[$element->left_surgery->id]; ?></td>
          </tr>
          <?php
        }
        if ($element->left_laser) {
          ?>
          <tr>
            <th><?php echo CHtml::encode($element->getAttributeLabel('left_laser')) ?></th>
            <td><?php echo $laserOptions[$element->left_laser->id]; ?></td>
          </tr>
          <?php
        }
      }
      if ($element->comments) {
        ?>
        <tr>
          <th>
            <?php echo CHtml::encode($element->getAttributeLabel('comments')) ?>
          </th>
          <td>
            <?php echo nl2br($element->comments) ?>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
