<?php 

class TimeTracker_Record_Model extends Vtiger_Base_Model{

	public function create($data) {
       	$db = PearDatabase::getInstance();
        $db->pquery('INSERT INTO rlemon_timetracker 
        	(account_id, working_on,task_id,elapsed,started) VALUES(?,?,?,?,?)', 
        	array(
                $data['accountId'], 
                $data['workingOn'],
                $data['task'],
                $data['timeElapsed'],
                $data['started']
        	)
        );
        return $db->getLastInsertID();
	}

    public function findById($id) {
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM rlemon_timetracker WHERE id=?',array($id));
        $rowCount = $db->num_rows($result);
        
        $data = array();

        if($rowCount > 0) {
            $data = array(
                        'id'            => $db->query_result($result,0,'id'),
                        'account_id'    => $db->query_result($result,0,'account_id'),
                        'task'          => TimeTracker_Record_Model::getProjectTaskById($db->query_result($result,0,'task_id')),
                        'working_on'    => $db->query_result($result,0,'working_on'),
                        'elapsed'       => $db->query_result($result,0,'elapsed'),
                        'started'       => $db->query_result($result,0,'started'),
                        'ended'         => $db->query_result($result,0,'ended')
                    );
        }

        return $data;
    }

    public function showAllByAccountId($accountId) {
        
        $data['trackList'] = TimeTracker_Record_Model::getAllTimeTrackDataByAccountId($accountId);

        $data['taskList'] = TimeTracker_Record_Model::getAllProjectTaskByAccountId($accountId);

        return $data;
    }

    public function getAllTimeTrackDataByAccountId($accountId)
    {
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM rlemon_timetracker WHERE account_id=? ORDER BY id DESC',array($accountId));
        $rowCount = $db->num_rows($result);
        
        $data = array();

        if($rowCount > 0) {
            for($x = 0; $x<$rowCount;$x++){
            $data[] = array(
                        'id'            => $db->query_result($result,$x,'id'),
                        'account_id'    => $db->query_result($result,$x,'account_id'),
                        'task'          => TimeTracker_Record_Model::getProjectTaskById($db->query_result($result,$x,'task_id')),
                        'working_on'    => $db->query_result($result,$x,'working_on'),
                        'elapsed'       => $db->query_result($result,$x,'elapsed'),
                        'started'       => $db->query_result($result,$x,'started'),
                        'ended'         => $db->query_result($result,$x,'ended')
                    );
            }
        }

        return $data;
    }

    public function getAllProjectTaskByAccountId($accountId)
    {
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM vtiger_crmentity INNER JOIN vtiger_project ON vtiger_crmentity.crmid = vtiger_project.projectid WHERE smownerid=?',array($accountId));
        $rowCount = $db->num_rows($result);

        $data = array();

        if($rowCount > 0) {
            for($x = 0; $x<$rowCount;$x++){
            $data[] = array(
                        'task_id'       => $db->query_result($result,$x,'crmid'),
                        'label'         => $db->query_result($result,$x,'label')
                    );
            }
        }

        return $data;
    }

    public function getProjectTaskById($id)
    {
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM vtiger_crmentity WHERE crmid=?',array($id));

        $rowCount = $db->num_rows($result);

        if($rowCount > 0) {
            return $db->query_result($result,0,'label');
        }

        return null;
    }

    public function getAllTaskByAccountId($accountId){

        $db = PearDatabase::getInstance();
        

        return $data;
    }

    public function update($id,$data) {
        $db = PearDatabase::getInstance();
        $db->pquery('UPDATE rlemon_timetracker SET account_id=?,task_id=?,working_on=?,elapsed=?,ended=? WHERE id=?', 
            array(
                $data['accountId'],  
                $data['task'],
                $data['workingOn'],
                $data['timeElapsed'],
                $data['ended'],
                $id
            )
        );

        return true;
    }

    public function remove($data) {

        $db = PearDatabase::getInstance();
        
        $result = $db->pquery('DELETE FROM rlemon_timetracker WHERE id=? AND account_id=?', 
            array(
                $data['id'],
                $data['accountId']
            )
        );

        if($result)
            return true;

        return false;
    }

    public function getUserRole($id){

        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM  vtiger_user2role WHERE userid=?',array($id));
        $rowCount = $db->num_rows($result);
        
        $data = array();

        if($rowCount > 0) {
  
                return $db->query_result($result,0,'roleid');
        }
    }

    public function showAll(){

        $data['trackList'] = TimeTracker_Record_Model::getAllTimeTrack();

        $data['taskList'] = TimeTracker_Record_Model::getAllProjectTask();

        return $data;
    }

    public function getAllTimeTrack(){
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM rlemon_timetracker ORDER BY id DESC');
        $rowCount = $db->num_rows($result);
        
        $data = array();

        if($rowCount > 0) {
            for($x = 0; $x<$rowCount;$x++){

            $user = TimeTracker_Record_Model::getAccountById($db->query_result($result,$x,'account_id'));

            $data[] = array(
                        'id'            => $db->query_result($result,$x,'id'),
                        'account_id'    => $db->query_result($result,$x,'account_id'),
                        'user_name'      => $user['user_name'],
                        'task'          => TimeTracker_Record_Model::getProjectTaskById($db->query_result($result,$x,'task_id')),
                        'working_on'    => $db->query_result($result,$x,'working_on'),
                        'elapsed'       => $db->query_result($result,$x,'elapsed'),
                        'started'       => $db->query_result($result,$x,'started'),
                        'ended'         => $db->query_result($result,$x,'ended')
                    );
            }
        }

        return $data;
    }

    public function getAccountById($id){
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM vtiger_users WHERE id=?',array($id));
        $rowCount = $db->num_rows($result);
        
        $data = array();

        if($rowCount > 0) {
            $data = array(
                        'id'            => $db->query_result($result,$x,'id'),
                        'user_name'     => $db->query_result($result,$x,'user_name'),
                        'first_name'    => $db->query_result($result,$x,'first_name'),
                        'last_name'     => $db->query_result($result,$x,'last_name')
                    );
        }

        return $data;
    }

    public function getAllProjectTask(){
        $db = PearDatabase::getInstance();
        $result = $db->pquery('SELECT * FROM vtiger_crmentity INNER JOIN vtiger_project ON vtiger_crmentity.crmid = vtiger_project.projectid');
        $rowCount = $db->num_rows($result);

        $data = array();

        if($rowCount > 0) {
            for($x = 0; $x<$rowCount;$x++){
            $data[] = array(
                        'task_id'       => $db->query_result($result,$x,'crmid'),
                        'label'         => $db->query_result($result,$x,'label')
                    );
            }
        }

        return $data;
    }
}