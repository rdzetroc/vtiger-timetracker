<?php

class TimeTracker_Remove_Action extends Vtiger_Action_Controller{
	
    public function checkPermission() {
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        
        $data = array(
                    'accountId' => $_SESSION["authenticated_user_id"],
                    'id'        => $request->get('trackId')
                );

        $isRemoved = TimeTracker_Record_Model::remove($data);

        $response = new Vtiger_Response();

        if($isRemoved)
            $response->setResult(array('data' => 'Data Remove Success'));
        else
            $response->setResult(array('data' => 'Data Remove Failed'));

        return $response;
    }
}