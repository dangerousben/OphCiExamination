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
?>


<div class="data">

  <?php
  if ($element->medication_1_left || $element->medication_1_right) {
    ?>
    <?php
    if ($element->medication_1_right) {
      ?>
      <?php
      $medications = $element->getMedications();
      echo "RE: " . $medications[$element->medication_1_right];
      if ($element->medication_2_right) {
        echo ", " . $medications[$element->medication_2_right];
        if ($element->medication_3_right) {
          echo ", " . $medications[$element->medication_3_right];
        }
      }
      ?>

      <?php
    }if ($element->medication_1_left) {
      ?>
      <?php
      $medications = $element->getMedications();
      if ($element->medication_1_left) {
        echo "; ";
      }
      echo "LE: " . $medications[$element->medication_1_left];
      if ($element->medication_2_left) {
        echo ", " . $medications[$element->medication_2_left];
        if ($element->medication_3_left) {
          echo ", " . $medications[$element->medication_3_left];
        }
      }
      ?>

      <?php
    }
    ?>
    <br/><br/>
    <?php
  }
  ?>
  <?php
  if ($element->left_laser || $element->right_laser) {
    echo "Laser ";
  }
  if ($element->right_laser) {
    echo "RE: " . $laserOptions[$element->right_laser->id]
    ?>
    <?php
  }
  if ($element->left_laser) {
    if ($element->right_laser) {
      echo ", ";
    }
    echo "LE: " . $laserOptions[$element->left_laser->id]
    ?>
    <?php
  }
  if ($element->left_laser || $element->right_laser) {
    echo "<br/><br/>";
  }
  if ($element->left_surgery || $element->right_surgery) {
    echo "Surgery ";
  }
  if ($element->right_surgery) {
    echo "RE: " . $surgeryOptions[$element->right_surgery->id]
    ?>
    <?php
  }
  if ($element->left_surgery) {
    if ($element->right_surgery) {
      echo ", ";
    }
    echo "LE: " . $surgeryOptions[$element->left_surgery->id]
    ?>
    <?php
  }
  if ($element->left_surgery || $element->right_surgery) {
    echo "<br/><br/>";
  }
  if ($element->comments) {
    echo nl2br($element->comments) . "<br/><br/>";
  }
  ?>
</div>
