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

/**
 * This is the model class for table "et_ophciexamination_lasermanagement".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $laser_status_id
 * @property string $laser_deferralreason_id
 * @property string $laser_deferralreason_other
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_LaserManagement extends SplitEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophciexamination_lasermanagement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, eye_id, laser_status_id, laser_deferralreason_id, laser_deferralreason_other, left_lasertype_id, ' .
					'left_lasertype_other, left_comments, right_lasertype_id, right_lasertype_other, right_comments', 'safe'),
				array('laser_status_id', 'required'),
				array('laser_status_id', 'laserDependencyValidation'),
				array('laser_deferralreason_id', 'laserDeferralReasonDependencyValidation'),
				array('left_lasertype_id', 'requiredIfTreatmentNeeded', 'side' => 'left'),
				array('left_lasertype_other', 'requiredIfLaserTypeOther', 'side' => 'left', 'lasertype' => 'left_lasertype'),
				array('right_lasertype_id', 'requiredIfTreatmentNeeded', 'side' => 'right'),
				array('right_lasertype_other', 'requiredIfLaserTypeOther', 'side' => 'right', 'lasertype' => 'right_lasertype'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, laser_status_id, laser_deferralreason_id, laser_deferralreason_other', 'safe', 'on' => 'search'),
		);
	}

	public function sidedFields()
	{
		return array('lasertype_id', 'lasertype_other', 'comments');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'laser_status' => array(self::BELONGS_TO, 'OphCiExamination_Management_Status', 'laser_status_id'),
				'laser_deferralreason' => array(self::BELONGS_TO, 'OphCiExamination_Management_DeferralReason', 'laser_deferralreason_id'),
				'left_lasertype' => array(self::BELONGS_TO, 'OphCiExamination_LaserManagement_LaserType', 'left_lasertype_id'),
				'right_lasertype' => array(self::BELONGS_TO, 'OphCiExamination_LaserManagement_LaserType', 'right_lasertype_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'laser_status_id' => "Laser",
				'laser_deferralreason_id' => 'Laser deferral reason',
				'laser_deferralreason_other' => 'Laser deferral reason',
				'left_lasertype_id' => 'Laser type',
				'left_lasertype_other' => 'Please provide other laser type name',
				'left_comments' => 'Comments',
				'right_lasertype_id' => 'Laser type',
				'right_lasertype_other' => 'Please provide other laser type name',
				'right_comments' => 'Comments',
				
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		$criteria->compare('laser_status_id', $this->laser_status_id);
		$criteria->compare('laser_deferralreason_id', $this->laser_deferral_reason_id);
		$criteria->compare('laser_deferralreason_other', $this->laser_deferralreason_other);
		$criteria->compare('left_lasertype_id', $this->left_lasertype_id);
		$criteria->compare('left_lasertype_other', $this->left_lasertype_other);
		$criteria->compare('left_comments', $this->left_comments);
		$criteria->compare('right_lasertype_id', $this->right_lasertype_id);
		$criteria->compare('right_lasertype_other', $this->right_lasertype_other);
		$criteria->compare('right_comments', $this->right_comments);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/*
	 * deferral reason is only required for laser status that are flagged deferred
	 */
	public function laserDependencyValidation($attribute)
	{
		if ($this->laser_status && $this->laser_status->deferred) {
			$v = CValidator::createValidator('required', $this, array('laser_deferralreason_id'));
			$v->validate($this);
		}
	}

	/*
	 * only need a text "other" reason for reasons that are flagged "other"
	 */
	public function laserDeferralReasonDependencyValidation($attribute)
	{
		if ($this->laser_deferralreason && $this->laser_deferralreason->other) {
			$v = CValidator::createValidator('required', $this, array('laser_deferralreason_other'), array('message' => '{attribute} required when deferral reason is ' . $this->laser_deferralreason));
			$v->validate($this);
		}
	}

	public function requiredIfTreatmentNeeded($attribute, $params)
	{
		$side = $params['side'];
		if ($this->laser_status && ($this->laser_status->book || $this->laser_status->event) ) {
			$this->requiredIfSide($attribute, $params);
		}
	}
	
	public function requiredIfLaserTypeOther($attribute, $params)
	{
		$lasertype_attr = $params['lasertype'];
		$lt = $this->$lasertype_attr;
		if ($lt && $lt->other) {
			$v = CValidator::createValidator('required', $this, array($attribute), array('message' => ucfirst($params['side']) . ' {attribute} required for laser type ' . $lt->name));
			$v->validate($this);
		}
	}
	
	/*
	 * returns the reason the injection has been deferred (switches between text value of fk, or the entered 'other' reason)
	*
	* @returns string
	*/
	public function getLaserDeferralReason()
	{
		if ($this->laser_deferralreason) {
			if ($this->laser_deferralreason->other) {
				return $this->laser_deferralreason_other;
			} else {
				return $this->laser_deferralreason->name;
			}
		} else {
			// shouldn't get to this point really
			return "N/A";
		}
	}
	
	/**
	 * returns the laser type for the given side
	 * 
	 * @param string $side
	 * @return string
	 */
	public function getLaserTypeStringForSide($side)
	{
		if ($lt = $this->{$side . '_lasertype'}) {
			if ($lt->other) {
				return $this->{$side . '_lasertype_other'};
			} else {
				return $lt->name;
			}
		}
		return 'N/A';
	}
	
	/**
	 * Returns the laser management plan section  for use in correspondence
	 *
	 * @return string
	 */
	public function getLetter_lmp()
	{
		$text = array();

		if ($this->laser_status) {
			$text[] = $this->laser_status;
			if ($this->laser_status->deferred) {
				$text[] = $this->getLaserDeferralReason();
			}
		}

		return implode(', ',$text)."\n";
	}
}
