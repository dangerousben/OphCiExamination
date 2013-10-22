<?php

class m130425_124711_glaucoma_management_split_element extends CDbMigration {

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp() {
        $both_eyes_id = Eye::model()->find("name = 'Both'")->id;
        $this->addColumn('et_ophciexamination_glaucoma_management', 'eye_id', "int(10) unsigned NOT NULL DEFAULT $both_eyes_id");
        $this->addForeignKey('et_ophciexamination_glaucoma_management_eye_id_fk', 'et_ophciexamination_glaucoma_management', 'eye_id', 'eye', 'id');
    }

    public function down() {
        $this->dropForeignKey('et_ophciexamination_glaucoma_management_eye_id_fk', 'et_ophciexamination_glaucoma_management');
        $this->dropColumn('et_ophciexamination_glaucoma_management', 'eye_id');
    }

}