<?php

class m131021_175341_update_management_with_glaucoma_management extends CDbMigration
{
  // Use safeUp/safeDown to do migration with transaction
  public function safeUp() {
    
    $et_mgmt = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_Management'));
    $et_gl_mgmt = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_GlaucomaManagement'));
    $this->update('element_type', array('parent_element_type_id' => $et_mgmt->id), 'id=' .$et_gl_mgmt->id);
    
    $rows = $this->getDbConnection()->createCommand('select * from et_ophciexamination_glaucoma_management')->queryAll();

    // each glaucoma mgmt. entry event ID must be updated with the master/parent ID:
    foreach ($rows as $row) {
      $event_id = $row['event_id'];
      $lmuid = $row['last_modified_user_id'];
      $cuid = $row['created_user_id'];
      $cdate = $row['last_modified_date'];
      $lmdate = $row['created_date'];
      
      $this->insert('et_ophciexamination_management',
              array('event_id' => $event_id,
                  'last_modified_user_id' =>$lmuid,
                  'created_user_id' =>$cuid,
                  'last_modified_date' =>$lmdate,
                  'created_date' =>$cdate));
    }
  }

  public function safeDown() {
    
  }
}