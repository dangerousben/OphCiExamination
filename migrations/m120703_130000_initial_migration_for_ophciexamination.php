<?php

class m120703_130000_initial_migration_for_ophciexamination extends OEMigration
{
	public function up()
	{
		// Get the event group id for "Clinical Events"
		$group_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_group')
		->where('code=:code', array(':code'=>'Ci'))
		->queryScalar();

		// Create the new Examination event_type
		$this->insert('event_type', array(
				'name' => 'Examination',
				'event_group_id' => $group_id,
				'class_name' => 'OphCiExamination'
		));

		// Get the newly created event type
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();

		// Insert element types (in order of display)
		$element_types = array(
				'Element_OphCiExamination_History' => array('name' => 'History'),
				'Element_OphCiExamination_Refraction' => array('name' => 'Refraction'),
				'Element_OphCiExamination_VisualAcuity' => array('name' => 'Visual Acuity'),
				'Element_OphCiExamination_AdnexalComorbidity' => array('name' => 'Adnexal Comorbidity'),
				'Element_OphCiExamination_CataractAssessment' => array('name' => 'Cataract Assessment'),
				'Element_OphCiExamination_IntraocularPressure' => array('name' => 'Intraocular Pressure'),
				'Element_OphCiExamination_PosteriorSegment' => array('name' => 'Posterior Segment'),
				'Element_OphCiExamination_Diagnosis' => array('name' => 'Diagnosis'),
				'Element_OphCiExamination_Investigation' => array('name' => 'Investigation'),
				'Element_OphCiExamination_Conclusion' => array('name' => 'Conclusion'),
		);
		$display_order = 1;
		foreach ($element_types as $element_type_class => $element_type_data) {
			$this->insert('element_type', array(
					'name' => $element_type_data['name'],
					'class_name' => $element_type_class,
					'event_type_id' => $event_type_id,
					'display_order' => $display_order * 10,
					'default' => 1,
			));

			// Insert element type id into element type array
			$element_type_id = $this->dbConnection->createCommand()
				->select('id')
				->from('element_type')
				->where('class_name=:class_name', array(':class_name'=>$element_type_class))
				->queryScalar();
			$element_types[$element_type_class]['id'] = $element_type_id;

			$display_order++;
		}

		// Create element type tables
		$element_type_tables = array(
				'adnexalcomorbidity',
				'anteriorsegment',
				'cataractassessment',
				'conclusion',
				'diagnosis',
				'history',
				'intraocularpressure',
				'investigation',
				'posteriorsegment',
				'refraction',
				'visualacuity',
		);
		foreach ($element_type_tables as $element_type_table) {
			$this->createTable('et_ophciexamination_'.$element_type_table, array(
					'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
					'event_id' => 'int(10) unsigned NOT NULL',
					'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
					'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
					'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
					'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
					'PRIMARY KEY (`id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_e_id_fk` (`event_id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_c_u_id_fk` (`created_user_id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_l_m_u_id_fk` (`last_modified_user_id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		}

		// Attributes
		$this->createTable('ophciexamination_attribute',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) NOT NULL',
				'label' => 'varchar(255) NOT NULL',
				'element_type_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_attribute_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_attribute_option',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'attribute_id' => 'int(10) unsigned NOT NULL',
				'value' => 'varchar(255) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_attribute_option_attribute_id_fk` FOREIGN KEY (`attribute_id`) REFERENCES `ophciexamination_attribute` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_option_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_option_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// Element sets and rules
		$this->createTable('ophciexamination_element_set',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) DEFAULT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_element_set_item',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'set_id' => 'int(10) unsigned NOT NULL',
				'element_type_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_element_type_id_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_element_set_rule',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'set_id' => 'int(10) unsigned NOT NULL',
				'parent_id' => 'int(10) unsigned',
				'clause' => 'varchar(255)',
				'value' => 'varchar(255)',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_parent_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophciexamination_element_set_rule` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		// Conclusion
		$this->addColumn('et_ophciexamination_conclusion', 'description', 'text');

		// History
		$this->addColumn('et_ophciexamination_history', 'description', 'text');

		// Investigation
		$this->addColumn('et_ophciexamination_investigation', 'description', 'text');

		// Adnexal Comorbidity
		$this->addColumn('et_ophciexamination_adnexalcomorbidity', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_adnexalcomorbidity', 'right_description', 'text');

		// Cataract Assessment
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_pupil', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_nuclear', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_cortical', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_pxe', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_phako', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_pupil', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_nuclear', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_cortical', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_pxe', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_phako', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_description', 'text');

		// Visual Acuity
		$this->addColumn('et_ophciexamination_visualacuity', 'left_initial', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_wearing', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_corrected', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_initial', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_wearing', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_corrected', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_comments', 'text');
		$this->createTable('ophciexamination_visual_acuity_unit',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_visual_acuity_unit_value',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'unit_id' => 'int(10) unsigned NOT NULL',
				'value' => 'varchar(255) NOT NULL',
				'base_value' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_VisualAcuity']['id'],
				'field_type_id' => 2, // Dropdown
				'key' => 'unit_id',
				'name' => 'Units',
				'default_value' => 2, // Snellen Metre
		));
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_VisualAcuity']['id'],
				'field_type_id' => 1, // Checkbox
				'key' => 'notes',
				'name' => 'Show Notes',
				'default_value' => 1,
		));

		// Intraocular Pressure
		$this->createTable('ophciexamination_instrument',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_instrument_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_instrument_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_instrument_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_li_fk', 'et_ophciexamination_intraocularpressure', 'left_instrument_id', 'ophciexamination_instrument', 'id');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_reading', 'varchar(45)');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_instrument_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_ri_fk', 'et_ophciexamination_intraocularpressure', 'right_instrument_id', 'ophciexamination_instrument', 'id');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_reading', 'varchar(45)');
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_IntraocularPressure']['id'],
				'field_type_id' => 2, // Dropdown
				'key' => 'default_instrument_id',
				'name' => 'Default Instrument',
				'default_value' => 1, // Goldmann
		));
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_IntraocularPressure']['id'],
				'field_type_id' => 1, // Boolean
				'key' => 'show_instruments',
				'name' => 'Show instruments',
				'default_value' => 1,
		));
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_IntraocularPressure']['id'],
				'field_type_id' => 1, // Boolean
				'key' => 'link_instruments',
				'name' => 'Link Instruments',
				'default_value' => 1,
		));

		// Anterior Segment
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_diagnosis_id', 'int(10) unsigned');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_diagnosis_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_ldi_fk', 'et_ophciexamination_anteriorsegment', 'left_diagnosis_id', 'disorder', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rdi_fk', 'et_ophciexamination_anteriorsegment', 'right_diagnosis_id', 'disorder', 'id');

		// Posterior Segment
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_cd_ratio', 'varchar(40)');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_cd_ratio', 'varchar(40)');

		// Diagnosis
		$this->addColumn('et_ophciexamination_diagnosis', 'eye_id', 'int(10) unsigned');
		$this->addColumn('et_ophciexamination_diagnosis', 'disorder_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_diagnosis_eye_id_fk', 'et_ophciexamination_diagnosis', 'eye_id', 'eye', 'id');
		$this->addForeignKey('et_ophciexamination_diagnosis_disorder_id_fk', 'et_ophciexamination_diagnosis', 'disorder_id', 'disorder', 'id');

		// Refraction
		$this->addColumn('et_ophciexamination_refraction', 'left_sphere', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_refraction', 'left_cylinder', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_refraction', 'left_axis', 'int(3)');
		$this->addColumn('et_ophciexamination_refraction', 'left_axis_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_refraction', 'left_type', 'varchar(40)');
		$this->addColumn('et_ophciexamination_refraction', 'right_sphere', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_refraction', 'right_cylinder', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_refraction', 'right_axis', 'int(3)');
		$this->addColumn('et_ophciexamination_refraction', 'right_axis_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_refraction', 'right_type', 'varchar(40)');

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		// Remove tables
		$tables = array(
				'et_ophciexamination_adnexalcomorbidity',
				'et_ophciexamination_anteriorsegment',
				'et_ophciexamination_cataractassessment',
				'et_ophciexamination_conclusion',
				'et_ophciexamination_diagnosis',
				'et_ophciexamination_history',
				'et_ophciexamination_intraocularpressure',
				'et_ophciexamination_investigation',
				'et_ophciexamination_posteriorsegment',
				'et_ophciexamination_refraction',
				'et_ophciexamination_visualacuity',
				'ophciexamination_visual_acuity_unit_value',
				'ophciexamination_visual_acuity_unit',
				'ophciexamination_instrument',
				'ophciexamination_attribute_option',
				'ophciexamination_attribute',
				'ophciexamination_element_set_rule',
				'ophciexamination_element_set_item',
				'ophciexamination_element_set',
		);
		foreach ($tables as $table) {
			$this->dropTable($table);
		}

		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();

		// Remove settings
		$element_type_ids = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('event_type_id = :event_type_id', array(':event_type_id'=>$event_type_id))
		->queryColumn();
		$element_type_ids_string = implode(',',$element_type_ids);
		$this->delete('setting_metadata', "element_type_id IN ($element_type_ids_string)");

		// Delete the element types
		$this->delete('element_type','event_type_id = ' . $event_type_id);

		// Delete the event type
		$this->delete('event_type','id = ' . $event_type_id);

	}

}
