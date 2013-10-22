<?php

class m130508_143412_reorder_elements extends CDbMigration {

  public function safeUp() {

    $this->execute('update element_type set display_order=15 where class_name=\'Element_OphCiExamination_Risks\'');
    $this->execute('update element_type set display_order=35 where class_name=\'Element_OphCiExamination_PupillaryAbnormalities\'');
    $this->execute('update element_type set display_order=57 where class_name=\'Element_OphCiExamination_Gonioscopy\'');
    $this->execute('update element_type set display_order=67 where class_name=\'Element_OphCiExamination_OpticDisk\'');
    $this->execute('update element_type set display_order=55 where class_name=\'Element_OphCiExamination_CentralCornealThickness\'');
    $this->execute('update element_type set display_order=93 where class_name=\'Element_OphCiExamination_GlaucomaManagement\'');

    $set_id = OphCiExamination_ElementSet::model()->find('name=\'Glaucoma New\'')->id;
    $this->insert('ophciexamination_element_set_item', array('set_id' => $set_id,
        'element_type_id' => ElementType::model()->find('name=\'History\'')->id));
  }

  public function safeDown() {
    echo "m130508_143412_reorder_elements does not support migration down.\n";
    return false;
  }

}