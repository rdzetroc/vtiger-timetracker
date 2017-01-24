<?php

class TimeTracker_Save_Action extends Vtiger_Action_Controller{
	
    public function checkPermission() {
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        
        $data = array(
                    'accountId'     => $_SESSION["authenticated_user_id"],
                    'workingOn'     => $request->get('workingOn'),
                    'task'          => $request->get('task'),
                    'timeElapsed'   => $request->get('timeElapsed'),
                    'started'       => date('Y-m-d H:i:s')
                );

        $id = TimeTracker_Record_Model::create($data);

        $data = TimeTracker_Record_Model::findById($id);

        $response = new Vtiger_Response();
        $response->setResult(array('data' => $data));
        return $response;
    }
}