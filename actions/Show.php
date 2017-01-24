<?php

class TimeTracker_Show_Action extends Vtiger_Action_Controller{
	
    public function checkPermission() {
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        
        $role = TimeTracker_Record_Model::getUserRole($_SESSION["authenticated_user_id"]);

        if($role == 'H2')
        {
            $data = TimeTracker_Record_Model::showAll();

            $data['isAdmin'] = true;
        }
        else

            $data = TimeTracker_Record_Model::showAllByAccountId($_SESSION["authenticated_user_id"]);    
        
        $response = new Vtiger_Response();

        $response->setResult(array('data' => $data));

        return $response;
    }
}