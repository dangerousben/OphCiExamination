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
 * This is the model class for table "ophciexamination_element_set".
 *
 * @property string $id
 * @property string $name
 * @property OphCiExamination_ElementSetItem[] $items

 */
class OphCiExamination_ElementSet extends BaseActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return OphCiExamination_ElementSet the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'ophciexamination_element_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
				array('name', 'required'),
				array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
				'items' => array(self::HAS_MANY, 'OphCiExamination_ElementSetItem', 'set_id',
						'with' => 'element_type',
						'order' => 'element_type.display_order',
				),
		);
	}

	/**
	 * Get an array of ElementTypes corresponding with the items in this set
	 * @return ElementType[]
	 */
	public function getDefaultElementTypes() {
		$default_element_types = ElementType::model()->findAll(array(
				'condition' => "ophciexamination_element_set_item.set_id = :set_id",
				'join' => 'JOIN ophciexamination_element_set_item ON ophciexamination_element_set_item.element_type_id = t.id',
				'order' => 'display_order',
				'params' => array(':set_id' => $this->id),
		));
		return $default_element_types;
	}

	/**
	 * Get an array of ElementTypes corresponding with the items NOT in this set
	 * @return ElementType[]
	 */
	public function getOptionalElementTypes() {
		$optional_element_types = ElementType::model()->findAll(array(
				'condition' => "event_type.class_name = 'OphCiExamination' AND
					ophciexamination_element_set_item.id IS NULL",
				'join' => 'JOIN event_type ON event_type.id = t.event_type_id
					LEFT JOIN ophciexamination_element_set_item ON (ophciexamination_element_set_item.element_type_id = t.id
					AND ophciexamination_element_set_item.set_id = :set_id)',
				'order' => 'display_order',
				'params' => array(':set_id' => $this->id),
		));
		return $optional_element_types;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

}