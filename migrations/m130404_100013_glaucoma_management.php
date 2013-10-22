<?php

class m130404_100013_glaucoma_management extends OEMigration {

    public function safeUp() {
        
        $groups = 'ophciexamination_glaucoma_drug_group';
        $this->createTable($groups, array_merge(array(
                    'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'group_name' => 'varchar(20)',
                    'conflicting_groups' => 'varchar(255)',
                        ), $this->getDefaults($groups, false)), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

        $snomed_meds = 'ophciexamination_glaucoma_snomed_drug';
        $this->createTable($snomed_meds, array_merge(array(
                    'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'drug_id' => 'int(10) unsigned NOT NULL',
                    'shortname' => 'varchar(20)',
                    'group_id' => 'int(10) unsigned NOT NULL',
                    'sort_order' => 'int(10) unsigned default 0',
                    'KEY `' . $snomed_meds
                    . '_drug_id_fk' . '` (`drug_id`)',
                    'KEY `' . $snomed_meds
                    . '_group_id_fk' . '` (`group_id`)',
                        ), $this->getDefaults($snomed_meds, false)), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

        $laser = 'ophciexamination_glaucoma_laser';
        $this->createTable($laser, array_merge(array(
                    'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'name' => 'varchar(128)',
                        ), $this->getDefaults($laser, false)), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

        $surgery = 'ophciexamination_glaucoma_surgery';
        $this->createTable($surgery, array_merge(array(
                    'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
                    'name' => 'varchar(128)',
                        ), $this->getDefaults($surgery, false)), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

        $this->createTable('et_ophciexamination_glaucoma_management', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'event_id' => 'int(10) unsigned NOT NULL',
            'hos_num_id' => 'int(10) unsigned NOT NULL',
            'event_id' => 'int(10) unsigned NOT NULL',
            'follow_up' => 'int(10) unsigned NOT NULL',
            'visit' => 'int(10) unsigned DEFAULT 0',
            'location' => 'varchar(255)',
            'comments' => 'text default NULL',
            'medication_1_left' => 'int(10) unsigned default NULL',
            'medication_2_left' => 'int(10) unsigned default NULL',
            'medication_3_left' => 'int(10) unsigned default NULL',
            'medication_1_right' => 'int(10) unsigned default NULL',
            'medication_2_right' => 'int(10) unsigned default NULL',
            'medication_3_right' => 'int(10) unsigned default NULL',
            'left_surgery_id' => 'int(10) unsigned default NULL',
            'right_surgery_id' => 'int(10) unsigned default NULL',
            'left_laser_id' => 'int(10) unsigned default NULL',
            'right_laser_id' => 'int(10) unsigned default NULL',
            'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
            'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
            'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
            'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
            'PRIMARY KEY (`id`)',
            'KEY `et_ophciexamination_glaucoma_management_event_id_fk` (`event_id`)',
            'KEY `et_ophciexamination_glaucoma_management_last_modified_user_id_fk` (`last_modified_user_id`)',
            'KEY `et_ophciexamination_glaucoma_management_created_user_id_fk` (`created_user_id`)',
            'KEY `et_ophciexamination_glaucoma_management_ll_id_fk` (`left_laser_id`)',
            'KEY `et_ophciexamination_glaucoma_management_rl_id_fk` (`right_laser_id`)',
            'KEY `et_ophciexamination_glaucoma_management_rs_id_fk` (`right_surgery_id`)',
            'KEY `et_ophciexamination_glaucoma_management_ls_id_fk` (`left_surgery_id`)',
            'KEY `et_ophciexamination_glaucoma_management_m1l_id_fk` (`medication_1_left`)',
            'KEY `et_ophciexamination_glaucoma_management_m2l_id_fk` (`medication_2_left`)',
            'KEY `et_ophciexamination_glaucoma_management_m3l_id_fk` (`medication_3_left`)',
            'KEY `et_ophciexamination_glaucoma_management_m1r_id_fk` (`medication_1_right`)',
            'KEY `et_ophciexamination_glaucoma_management_m2r_id_fk` (`medication_2_right`)',
            'KEY `et_ophciexamination_glaucoma_management_m3r_id_fk` (`medication_3_right`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_ll_id_fk` FOREIGN KEY (`left_laser_id`) REFERENCES `ophciexamination_glaucoma_laser` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_rl_id_fk` FOREIGN KEY (`right_laser_id`) REFERENCES `ophciexamination_glaucoma_laser` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_ls_id_fk` FOREIGN KEY (`left_surgery_id`) REFERENCES `ophciexamination_glaucoma_surgery` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_rs_id_fk` FOREIGN KEY (`right_surgery_id`) REFERENCES `ophciexamination_glaucoma_surgery` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m1l_id_fk` FOREIGN KEY (`medication_1_left`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m2l_id_fk` FOREIGN KEY (`medication_2_left`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m3l_id_fk` FOREIGN KEY (`medication_3_left`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m1r_id_fk` FOREIGN KEY (`medication_1_right`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m2r_id_fk` FOREIGN KEY (`medication_2_right`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
            'CONSTRAINT `et_ophciexamination_glaucoma_management_m3r_id_fk` FOREIGN KEY (`medication_3_right`) REFERENCES `ophciexamination_glaucoma_snomed_drug` (`id`)',
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
        );
        $event_type = $this->dbConnection->createCommand()
                ->select('id')
                ->from('event_type')
                ->where('class_name=:class_name', array(':class_name' => 'OphCiExamination'))
                ->queryRow();
        $this->insert('element_type', array(
            'name' => 'Glaucoma Management',
            'class_name' => 'Element_OphCiExamination_GlaucomaManagement',
            'event_type_id' => $event_type['id'],
            'display_order' => 1,
            'default' => 1,
        ));
        
        $this->initialiseData(dirname(__FILE__));
    }

    public function safeDown() {
        $event_type = $this->dbConnection->createCommand()
                ->select('id')
                ->from('event_type')
                ->where('class_name=:class_name', array(':class_name' => 'OphCiExamination'))
                ->queryRow();
        $element_type = $this->dbConnection->createCommand()
                        ->select('id')
                        ->from('element_type')
                        ->where('class_name=:class_name and event_type_id=:event_type_id', array(
                            ':class_name' => 'Element_OphCiExamination_GlaucomaManagement',
                            ':event_type_id' => $event_type['id']
                        ))->queryRow();
        $this->delete('element_type', 'id=' . $element_type['id']);

        $this->dropTable('et_ophciexamination_glaucoma_management');
        $this->dropTable('ophciexamination_glaucoma_laser');
        $this->dropTable('ophciexamination_glaucoma_snomed_drug');
        $this->dropTable('ophciexamination_glaucoma_drug_group');
        $this->dropTable('ophciexamination_glaucoma_surgery');
    }

    /**
     * Returns all the default table array elements that all tables share.
     * This is a convenience method for all table creation.
     * 
     * @param $suffix the table name suffix - this is the name of the table
     * without the formal table name 'et_[spec][group][code]_'.
     * 
     * @param useEvent by default, the event type is created as a foreign
     * key to the event table; set this to false to not create this key.
     * 
     * @return an array of defaults to merge in to the table array data required.
     */
    function getDefaults($tableName, $useEvent = true) {
        $defaults = array('last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
            'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01
			00:00:00\'',
            'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
            'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
            'PRIMARY KEY (`id`)',
            'KEY `' . $tableName . '_event_id_fk' . '` (`event_id`)',
            'KEY `' . $tableName . '_created_user_id_fk' . '`
			(`created_user_id`)',
            'KEY `' . $tableName . '_last_modified_user_id_fk' . '`
			(`last_modified_user_id`)',
            'CONSTRAINT `' . $tableName . '_event_id_fk' . '` FOREIGN KEY
			(`event_id`) REFERENCES `event` (`id`)',
            'CONSTRAINT `' . $tableName . '_created_user_id_fk' . '`
			FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
            'CONSTRAINT
			`' . $tableName . '_last_modified_user_id_fk' . '` FOREIGN KEY
			(`last_modified_user_id`) REFERENCES `user` (`id`)',);
        if ($useEvent == false) {
            $defaults = array('last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
                'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01
        00:00:00\'',
                'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
                'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
                'PRIMARY KEY (`id`)',
                'KEY `' . $tableName . '_last_modified_user_id_fk' . '`
        (`last_modified_user_id`)',
                'CONSTRAINT `' . $tableName . '_created_user_id_fk' . '`
        FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
                'CONSTRAINT
        `' . $tableName . '_last_modified_user_id_fk' . '` FOREIGN KEY
        (`last_modified_user_id`) REFERENCES `user` (`id`)');
        }
        return $defaults;
    }
}