<?php

class TimeTracker_Update_Action extends Vtiger_Action_Controller{
	
    public function checkPermission() {
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        
        $id = $request->get('id');

        $data = array(
                    'accountId'     => $_SESSION["authenticated_user_id"],
                    'workingOn'     => $request->get('workingOn'),
                    'task'          => $request->get('task'),
                    'timeElapsed'   => $request->get('timeElapsed'),
                    'ended'         => date('Y-m-d H:i:s')
                );

        TimeTracker_Record_Model::update($id,$data);

        $data = TimeTracker_Record_Model::findById($id);

        $response = new Vtiger_Response();
        $response->setResult(array('data' => $data));
        return $response;
    }
}