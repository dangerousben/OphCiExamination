<?php /**
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
 * This is the model class for table "et_ophciexamination_intraocularpressure".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property OphCiExamination_Instrument $left_instrument
 * @property OphCiExamination_Instrument $right_instrument
 * @property OphCiExamination_IntraocularPressure_Reading $left_reading
 * @property OphCiExamination_IntraocularPressure_Reading $right_reading
 */

class Element_OphCiExamination_IntraocularPressure extends BaseEventTypeElement
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
		return 'et_ophciexamination_intraocularpressure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, left_instrument_id, left_reading_id, right_instrument_id, right_reading_id, eye_id', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, left_instrument_id, left_reading_id, right_instrument_id, right_reading_id, eye_id', 'safe', 'on' => 'search'),
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
				'left_instrument' => array(self::BELONGS_TO, 'OphCiExamination_Instrument', 'left_instrument_id'),
				'right_instrument' => array(self::BELONGS_TO, 'OphCiExamination_Instrument', 'right_instrument_id'),
				'left_reading' => array(self::BELONGS_TO, 'OphCiExamination_IntraocularPressure_Reading', 'left_reading_id'),
				'right_reading' => array(self::BELONGS_TO, 'OphCiExamination_IntraocularPressure_Reading', 'right_reading_id'),
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
				'left_instrument_id' => 'Instrument',
				'left_reading_id' => 'Reading',
				'right_instrument_id' => 'Instrument',
				'right_reading_id' => 'Reading',
		);
	}

	public function getInstrumentValues()
	{
		return CHtml::listData(OphCiExamination_Instrument::model()->findAll(array('order' => 'display_order')), 'id', 'name') ;
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

		$criteria->compare('left_instrument_id', $this->left_instrument_id);
		$criteria->compare('left_reading_id', $this->left_reading_id);
		$criteria->compare('right_instrument_id', $this->right_instrument_id);
		$criteria->compare('right_reading_id', $this->right_reading_id);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions()
	{
		// Default instrument
		if ($default_instrument_id = $this->getSetting('default_instrument_id')) {
			$this->left_instrument_id = $default_instrument_id;
			$this->right_instrument_id = $default_instrument_id;
		}

		// Show instruments
		if (!$this->getSetting('show_instruments')) {
			$this->left_instrument_id = null;
			$this->right_instrument_id = null;
		}
	}

	protected function beforeSave()
	{
		return parent::beforeSave();
	}

	public function getLetter_reading($side)
	{
		$segment = $side.'_reading';
		$reading = $this->$segment->name;
		return $reading == 'NR' ? 'Not recorded' : $reading.' mmHg';
	}

	public function getLetter_string()
	{
		return "Intra-ocular pressure:\nright: ".$this->getLetter_reading('right')."\nleft: ".$this->getLetter_reading('left')."\n";
	}
}
