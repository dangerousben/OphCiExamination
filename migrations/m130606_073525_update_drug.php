<?php

class m130606_073525_update_drug extends CDbMigration {

  public function safeUp() {
     $this->update(OphCiExamination_GlaucomaSnomedDrug::model()->tableName(),
             array('shortname'=>'Azarga'),'shortname=\'PGA Azarga\'');
  }

  public function safeDown() {
//     $this->update(OphCiExamination_GlaucomaSnomedDrug::model()->tableName(),
//             array('shortname'=>'PGA Azarga'),'shortname=\'Azarga\'');
  }

}