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
 * The followings are the available columns in table 'et_ophciexamination_comorbidities':
 * @property integer $id
 * @property integer $event_id
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property OphCiExamination_Comorbidities_Item[] $items
 */
class Element_OphCiExamination_Comorbidities extends BaseEventTypeElement
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_Comorbidities the static model class
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
		return 'et_ophciexamination_comorbidities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, comments', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id', 'safe', 'on' => 'search'),
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
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'items' => array(self::MANY_MANY, 'OphCiExamination_Comorbidities_Item', 'ophciexamination_comorbidities_assignment(element_id, item_id)', 'order' => 'display_order, name'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
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

	public function getItemOptions()
	{
		$items = OphCiExamination_Comorbidities_Item::model()->findAll(array('order'=>'name'));
		return CHtml::encodeArray(CHtml::listData($items, 'id', 'name'));
	}

	public function getItemIds()
	{
		return CHtml::listData($this->items, 'id', 'id');
	}

	public function getSummary()
	{
		$return = array();
		foreach ($this->items as $item) {
			$return[] = $item->name;
		}
		if ($return) {
			return implode(', ',$return);
		} else {
			return 'None';
		}
	}

	protected function beforeDelete()
	{
		OphCiExamination_Comorbidities_Assignment::model()->deleteAllByAttributes(array('element_id' => $this->id));
		return parent::beforeDelete();
	}

	protected function afterSave()
	{
		// Check to see if items have been posted
		if (isset($_POST['comorbidities_items_valid']) && $_POST['comorbidities_items_valid']) {

			// Get a list of ids so we can keep track of what's been removed
			$existing_item_ids = array();
			foreach ($this->items as $item) {
				$existing_item_ids[$item->id] = $item->id;
			}

			// Process (any) posted items
			$new_items = (isset($_POST['comorbidities_items'])) ? $_POST['comorbidities_items'] : array();
			foreach ($new_items as $item_id) {

				if ($item_id && isset($existing_item_ids[$item_id])) {

					// Item is being updated
					$item_assignment = OphCiExamination_Comorbidities_Assignment::model()->findByAttributes(array('element_id' => $this->id, 'item_id' => $item_id));
					unset($existing_item_ids[$item_id]);

				} else {

					// Item is new
					$item_assignment = new OphCiExamination_Comorbidities_Assignment();
					$item_assignment->element_id = $this->id;
					$item_assignment->item_id = $item_id;

				}

				$item_assignment->save();

			}

			// Delete remaining (removed) ids
			OphCiExamination_Comorbidities_Assignment::model()->deleteAllByAttributes(array('element_id' => $this->id, 'item_id' =>array_values($existing_item_ids)));

		}

		parent::afterSave();
	}

}
