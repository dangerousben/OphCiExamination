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

/**
 * The followings are the available columns in table '':
 * @property string $id
 * @property integer $event_id 
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class Element_OphCiExamination_GlaucomaManagement extends SplitEventTypeElement {
	public $service;
    /** Follow up constant value for a follow up within a week. */

    const OPTION_1_52 = 1;
    /** Follow up constant value for a follow up within two weeks. */
    const OPTION_2_52 = 2;
    /** Follow up constant value for a follow up within three weeks. */
    const OPTION_3_52 = 3;
    /** Follow up constant value for a follow up within six weeks. */
    const OPTION_6_52 = 6;
    /** Follow up constant value for a follow up within a calendar month. */
    const OPTION_1_12 = 4;
    /** Follow up constant value for a follow up within two months. */
    const OPTION_2_12 = 8;
    /** Follow up constant value for a follow up within three months. */
    const OPTION_3_12 = 12;
    /** Follow up constant value for a follow up within four months. */
    const OPTION_4_12 = 16;
    /** Follow up constant value for a follow up within 6 months. */
    const OPTION_6_12 = 24;
    /** Follow up constant value for a follow up within 6 months. */
    const OPTION_9_12 = 36;
    /** Follow up constant value for a follow up within nine months. */
    const OPTION_12_12 = 52;
    /** No follow up; discharged. */
    const OPTION_DISCHARGED = 10001;
    /** No follow up; discharged to optometrist. */
    const OPTION_DISCHARGED_TO_OPTOM = 10002;

    /**
     * Set the visit value, used to determine which visit this is (that is,
     * if this is a follow up or an initial exam).
     * 
     * @return boolean true, always.
     */
//    protected function beforeSave() {
//        parent::beforeSave();
//        // the visit is initially 0; each new visit increments this value -
//        // we need to seaerch back through the patient events to find this
//        // value out:
////        $this->visit = $this->getLastVisit() + 1;
//        return true;
//    }

    /**
     * Returns the static model of the specified AR class.
     * @return ElementOperation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'et_ophciexamination_glaucoma_management';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        return array(
            array('eye_id, left_laser_id, right_laser_id, left_surgery_id, right_surgery_id, medication_1_left, medication_2_left, medication_3_left, medication_1_right, medication_2_right, medication_3_right, event_id, follow_up, location, comments, visit', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('eye_id, left_laser_id, right_laser_id, left_surgery_id, right_surgery_id, medication_1_left, medication_2_left, medication_3_left, medication_1_right, medication_2_right, medication_3_right, follow_up, search, id, event_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'element_type' => array(self::HAS_ONE, 'ElementType', 'id', 'on' => "element_type.class_name='" . get_class($this) . "'"),
            'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
            'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
            'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
            'med_1_left' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_1_left'),
            'med_1_right' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_1_right'),
            'med_2_left' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_2_left'),
            'med_2_right' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_2_right'),
            'med_3_left' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_3_left'),
            'med_3_right' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSnomedDrug', 'medication_3_right'),
            'left_laser' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaLaser', 'left_laser_id'),
            'right_laser' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaLaser', 'right_laser_id'),
            'left_surgery' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSurgery', 'left_surgery_id'),
            'right_surgery' => array(self::BELONGS_TO, 'OphCiExamination_GlaucomaSurgery', 'right_surgery_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
            'follow_up' => 'Follow Up',
            'comments' => 'Comments',
            'location' => 'Review Location',
            'left_laser_id' => 'Laser',
            'right_laser_id' => 'Laser',
            'left_surgery_id' => 'Surgery',
            'right_surgery_id' => 'Surgery',
            'medication_1_left' => 'Medication',
            'medication_1_right' => 'Medication',
        );
    }

    /**
     * Get the time periods for a folow up.
     * 
     * @return an array of strings dictating, in increasing order, the different
     * follow up dates for the follow up list.
     */
    public static function getFollow_up_list() {

        return array(
            self::OPTION_DISCHARGED => 'Discharged',
            self::OPTION_DISCHARGED_TO_OPTOM => 'Discharged to Optom',
            self::OPTION_1_52 => '1/52',
            self::OPTION_2_52 => '2/52',
            self::OPTION_3_52 => '3/52',
            self::OPTION_1_12 => '1/12',
            self::OPTION_6_52 => '6/52',
            self::OPTION_2_12 => '2/12',
            self::OPTION_3_12 => '3/12',
            self::OPTION_4_12 => '4/12',
            self::OPTION_6_12 => '6/12',
            self::OPTION_9_12 => '9/12',
            self::OPTION_12_12 => '12/12',
        );
    }

    /**
     * Gets the site list for populating the location for the next follow up.
     * 
     * @return an array of site locations.
     */
    public function getLocations() {
        return Site::model()->getList();
    }

    /**
     * Gets all laser options.
     * 
     * @return an array of laser options.
     */
    public function getLaserOptions() {
        return CHtml::listData(OphCiExamination_GlaucomaLaser::model()->findAllByAttributes(array()), 'id', 'name');
    }

    /**
     * Gets all surgery options.
     * 
     * @return an array of surgery options.
     */
    public function getSurgeryOptions() {
        return CHtml::listData(OphCiExamination_GlaucomaSurgery::model()->findAllByAttributes(array()), 'id', 'name');
    }

    /**
     * Determines if this is a follow up exam or an initial (first-time) visit.
     * 
     * @return boolan true if the patient has had an examination previously;
     * false otherwise.
     */
    public function isFollowUp() {
        return $this->getLastVisit() > 0;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('event_id', $this->event_id, true);
        $criteria->compare('comments', $this->comments, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public function afterSave() {
    parent::afterSave();
    $firm = $this->event->episode->firm;
    $pid = $this->event->episode->patient->id;
    if ($this->location && $this->follow_up) {
      $followUps = $this->getFollow_up_list();
      Yii::app()->event->dispatch('virtual_clinic_update', array(
          'patient_id' => $pid,
          'follow_up' => $followUps[$this->follow_up],
//          'visit_date' => $this->event->datetime,
          'firm_id' => $firm_id = Yii::app()->session['selected_firm_id'],
          'patient_id' => $pid,
          'site_id' => $this->location,
          'reviewed' => 0,
          'clinic' => 'Glaucoma',
          // Wrong! Do it with current (user) subspeciality? Or
          // the selected subs. from the clinic page?,
          'subspeciality_id' => Subspecialty::model()->find('name=\'Glaucoma\'')->id)
      );
    }
  }

    /**
     * Gets the value of the last visit - this tells us how many
     * examinations they've had.
     * 
     * @return int 0 if this is the first patient's examination visit;
     * otherwise, the number of visits the patient has had.
     */
    function getLastVisit() {
        $lastVisitCount = 0;
        // can only perform this if we've got access to the patient ID:
        if (!empty($_GET['patient_id'])) {
            /* At some point (on creating an examination), the follow up
             * event, since it's new, has no episode associated with it,
             * and therefore it's difficult for us to trawl back through other
             * follow ups to get the last visit count. Here we do some DB
             * hackery to enable us to get the last follow up event visit value
             * for this patient: */
            $patientId = $_GET['patient_id'];
            $criteria = new CDbCriteria;
            $criteria->order = 'visit desc';
            $criteria->limit = 1;
            $criteria->alias = 'fup';
            $criteria->join = 'left join event e on fup.event_id=e.id';
            $criteria->join .= ' left join episode ep on ep.id=e.episode_id';
            $criteria->join .= ' left join patient p on ep.patient_id = p.id';
            $criteria->condition = 'p.id=:pid';
            $criteria->params = array(':pid' => $patientId);
            $lastVisit = Element_OphCiExamination_GlaucomaManagement::model()->find($criteria);
            if ($lastVisit) {
                $lastVisitCount = $lastVisit->visit;
            }
        }
        return $lastVisitCount;
    }

    /**
     * Gets the list of glaucoma medications.
     * 
     * Note that this is a refactor of a previous incarnation, in a move
     * to move all values to the database.
     * 
     * @return array of medications, indexed alphabetically as an associative
     * array of int(index) => string(medication) values.
     */
    function getMedications() {// 1st entry for disorder is for fk compatibility with diagnosis
        $criteria = new CdbCriteria;
        $criteria->order = 'sort_order ASC';
        $criteria->condition = 'sort_order > 0';
        $meds = OphCiExamination_GlaucomaSnomedDrug::model()->findAll($criteria);
        $data = array();
        foreach ($meds as $medication) {
            $data = $data + array($medication->id => $medication->shortname);
        }
        return $data;
    }

    /**
     * Gets the list of glaucoma medications mapped to medication groups.
     * 
     * Ideally this will all be re-factored in to the database at some point.
     * 
     * @return array of medications and groups, indexed alphabetically as
     * an associative array of string(medication) => string(medicationGroup)
     * values.
     */
    function getMedicationGroups() {

        $meds = OphCiExamination_GlaucomaSnomedDrug::model()->findAll();
        $data = array();
        foreach ($meds as $med) {
            $criteria = new CDbCriteria;
            $criteria->select = 'group_name';
            $criteria->condition = 'id=' . $med->group_id;
            $group = OphCiExamination_GlaucomaDrugGroup::model()->find($criteria);
            $data = array_merge($data, array($med->shortname => $group->group_name));
        }
        return $data;
    }

    /**
     * Gets the list of glaucoma medication groups mapped to an array of groups
     * that the group is not compatible with.
     * 
     * Ideally this will all be re-factored in to the database at some point.
     * 
     * @return array of medication groups, as an associative
     * array of string(medicationGroup) => array(groups) values.
     */
    function getConflictingGroups() {

        // TODO - at the moment, groups are combined - that is, medication
        // and diagnsosis groups. This is fine, since they're explicitly
        // referenced per group; might be an idea to differentiate though.
        $data = array();
        $criteria = new CDbCriteria;
        $criteria->select = 'group_name, conflicting_groups';
        $groups = OphCiExamination_GlaucomaDrugGroup::model()->findAll();
        foreach ($groups as $group) {
            $groupData = $group->conflicting_groups;
            $groupArray = explode(",", $groupData);
            $data = array_merge($data, array($group->group_name => $groupArray));
        }
        return $data;
    }

}
