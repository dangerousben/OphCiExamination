<?php

class m130507_200641_glaucoma_element_sets extends CDbMigration {

  private $common = array('Visual Acuity', 'Anterior Segment', 'Intraocular Pressure',
      'OpticDisk', 'Glaucoma Management');
  private $newEpisode = array('Risks', 'Central Corneal Thickness', 'Pupillary Abnormalities',
      'Gonioscopy', 'Dilation', 'Posterior Segment', 'Diagnoses');

  public function safeUp() {
    foreach (array('Glaucoma Default', 'Glaucoma New', 'Glaucoma Under investigation',
 'Glaucoma Listed/booked', 'Glaucoma Post-op', 'Glaucoma Follow-up', 'Glaucoma Discharged') as $name) {
      $this->insert('ophciexamination_element_set', array('name' => $name));
    }
    // add default elements:
    $set_id = $this->getSet('Glaucoma Default')->id;
    foreach ($this->common as $element) {
      $this->insert('ophciexamination_element_set_item', array('set_id' => $set_id,
          'element_type_id' => $this->getElement($element)->id));
    }
    $this->insert('ophciexamination_element_set_rule', array(
        'set_id' => $set_id, 'parent_id' => 1,
        'clause' => 'status_id', 'value' => Subspecialty::model()->find('name=\'Glaucoma\'')->id));
    // glaucoma new:

    $new_set_id = $this->getSet('Glaucoma New')->id;
    foreach ($this->newEpisode as $element) {
      $this->insert('ophciexamination_element_set_item', array('set_id' => $new_set_id,
          'element_type_id' => $this->getElement($element)->id));
    }
    foreach ($this->common as $element) {
      $this->insert('ophciexamination_element_set_item', array('set_id' => $new_set_id,
          'element_type_id' => $this->getElement($element)->id));
    }
    // this set's PARENT, i.e. previous set id
    $parent_id = OphCiExamination_ElementSetRule::model()->find('set_id=' . $set_id)->id;
    $this->insert('ophciexamination_element_set_rule', array(
        'set_id' => $new_set_id, 'parent_id' => $parent_id,
        'value' => EpisodeStatus::model()->find('name=\'New\'')->id));
    // glaucoma under investigation:

//    foreach (array('Glaucoma Under investigation',
// 'Glaucoma Listed/booked', 'Glaucoma Post-op', 'Glaucoma Follow-up', 'Glaucoma Discharged') as
//    $status) {
//      $new_set_id = $this->getSet($status)->id;
//      foreach ($this->common as $element) {
//        $this->insert('ophciexamination_element_set_item', array('set_id' => $new_set_id,
//            'element_type_id' => $this->getElement($element)->id));
//      }
//      $parent_id = OphCiExamination_ElementSetRule::model()->find('set_id=' . $set_id)->id;
//      $this->insert('ophciexamination_element_set_rule', array(
//          'set_id' => $new_set_id, 'parent_id' => $parent_id,
//          'value' => EpisodeStatus::model()->find('name=\'' . substr($status, strlen('Glaucoma ')) . '\'')->id));
//    }
  }

  public function safeDown() {

    $set_id = $this->getSet('Glaucoma New')->id;

    foreach ($this->common as $element) {
      $this->delete('ophciexamination_element_set_item', 'set_id=' . $set_id
              . ' and element_type_id=' . $this->getElement($element)->id);
    }
    $this->delete('ophciexamination_element_set_rule', 'set_id=' . $set_id);
    $set_id = $this->getSet('Glaucoma Default')->id;

    foreach ($this->common as $element) {
      $this->delete('ophciexamination_element_set_item', 'set_id=' . $set_id
              . ' and element_type_id=' . $this->getElement($element)->id);
    }
    $this->delete('ophciexamination_element_set_rule', 'set_id=' . $set_id);
//    foreach (array('Glaucoma Discharged', 'Glaucoma Follow-up', 'Glaucoma Post-op', 
//        'Glaucoma Listed/booked', 'Glaucoma Under investigation','Glaucoma New', 'Glaucoma Default') as $name) {
//      $this->delete('ophciexamination_element_set', 'name=\'' . $name . '\'');
//    }
  }

  private function getSet($name) {
    return OphCiExamination_ElementSet::model()->find('name=\'' . $name . '\'');
  }

  private function getElement($name) {
    return ElementType::model()->find('name=\'' . $name . '\'');
  }

}