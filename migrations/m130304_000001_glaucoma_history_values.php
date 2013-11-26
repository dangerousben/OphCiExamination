<?php

class m130304_000001_glaucoma_history_values extends OEMigration {

    public function up() {
        $this->delete('ophciexamination_attribute_option');
        $migrations_path = dirname(__FILE__);
        $this->initialiseData($migrations_path);
    }

    public function down() {
        
    }

}