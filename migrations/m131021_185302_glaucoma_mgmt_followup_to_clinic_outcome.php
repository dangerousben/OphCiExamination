<?php

class m131021_185302_glaucoma_mgmt_followup_to_clinic_outcome extends CDbMigration {

  // Use safeUp/safeDown to do migration with transaction
  public function safeUp() {

    $rows = $this->getDbConnection()->createCommand('select * from et_ophciexamination_glaucoma_management')->queryAll();
    $role = Yii::app()->db->createCommand()->select("*")->from("ophciexamination_clinicoutcome_role")->where('name=:name', array(':name' => 'Other'))->queryRow();
    $role_id = $role['id'];
    // each glaucoma mgmt. entry event ID must be updated with the master/parent ID:
    foreach ($rows as $row) {
      $event_id = $row['event_id'];
      $fup = $row['follow_up'];
      $lmuid = $row['last_modified_user_id'];
      $cuid = $row['created_user_id'];
      $cdate = $row['last_modified_date'];
      $lmdate = $row['created_date'];
      $fup_quantity = $this->getQuantity($fup);
      $period_id = $this->getPeriodId($fup);
      $status_id = $this->getStatusId($fup);
      $this->insert('et_ophciexamination_clinicoutcome', array('event_id' => $event_id,
          'last_modified_user_id' => $lmuid,
          'followup_quantity' => $fup_quantity,
          'followup_period_id' => $period_id,
          'status_id' => $status_id,
          'created_user_id' => $cuid,
          'role_id' => $role_id,
          'last_modified_date' => $lmdate,
          'created_date' => $cdate));
    }
  }

  private function getQuantity($fup) {
    switch ($fup) {
      case 1: return 1; // 1 week
        break;
      case 2: return 2; // 2 weeks
        break;
      case 3: return 3; // 3 weeks
        break;
      case 6: return 6; // 6 weeks
        break;
      case 4: return 1; // 1 month
        break;
      case 8: return 2; // 2 month
        break;
      case 12: return 3; // 3 month
        break;
      case 16: return 4; // 4 month
        break;
      case 24: return 6; // 6 month
        break;
      case 36: return 9; // 9 month
        break;
      case 52: return 1; // 1 year
        break;
      default: return NULL;
    }
  }

  private function getPeriodId($fup) {
    switch ($fup) {
      case 1: return Period::model()->find('name=:name', array(':name' => 'weeks'))->id;
        break;
      case 2: return Period::model()->find('name=:name', array(':name' => 'weeks'))->id;
        break;
      case 3: return Period::model()->find('name=:name', array(':name' => 'weeks'))->id;
        break;
      case 6: return Period::model()->find('name=:name', array(':name' => 'weeks'))->id;
        break;
      case 4: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 8: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 12: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 16: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 24: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 36: return Period::model()->find('name=:name', array(':name' => 'months'))->id;
        break;
      case 52: return Period::model()->find('name=:name', array(':name' => 'years'))->id;
        break;
      default: return NULL;
    }
  }

  private function getStatusId($fup) {
    switch ($fup) {
      case 10001:
        $status = Yii::app()->db->createCommand()->select("*")->from("ophciexamination_clinicoutcome_status")->where('name=:name', array(':name' => 'Discharge'))->queryRow();
        return $status['id'];
        break;
      case 10002: 
        $status = Yii::app()->db->createCommand()->select("*")->from("ophciexamination_clinicoutcome_status")->where('name=:name', array(':name' => 'Discharge'))->queryRow();
        return $status['id'];
        break;
      default: 
        $status = Yii::app()->db->createCommand()->select("*")->from("ophciexamination_clinicoutcome_status")->where('name=:name', array(':name' => 'Follow-up'))->queryRow();
        return $status['id'];
    }
  }

  public function safeDown() {
    
  }

}