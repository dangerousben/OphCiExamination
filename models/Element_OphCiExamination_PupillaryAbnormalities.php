<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "et_ophciexamination_pupillaryabnormalities".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property OphCiExamination_PupillaryAbnormalities_Abnormality $left_abnormality
 * @property OphCiExamination_PupillaryAbnormalities_Abnormality $right_abnormality
 */

class Element_OphCiExamination_PupillaryAbnormalities extends SplitEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_PupillaryAbnormalities the static model class
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
		return 'et_ophciexamination_pupillaryabnormalities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('eye_id', 'required'),
				array('left_abnormality_id', 'requiredIfSide', 'side' => 'left'),
				array('right_abnormality_id', 'requiredIfSide', 'side' => 'right'),
				array('event_id', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, left_abnormality_id, right_abnormality_id, eye_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'left_abnormality' => array(self::BELONGS_TO, 'OphCiExamination_PupillaryAbnormalities_Abnormality', 'left_abnormality_id'),
				'right_abnormality' => array(self::BELONGS_TO, 'OphCiExamination_PupillaryAbnormalities_Abnormality', 'right_abnormality_id'),
		);
	}

	public function sidedFields()
	{
		return array('abnormality_id');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'left_abnormality_id' => 'Abnormality',
				'right_abnormality_id' => 'Abnormality',
		);
	}

	public function getAbnormalityOptions()
	{
		return CHtml::listData(OphCiExamination_PupillaryAbnormalities_Abnormality::model()->findAll(array('order' => 'display_order')), 'id', 'name') ;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

}
