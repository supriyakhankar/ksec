<?php namespace ksec\Services;

use Request,Config,DB,Validator;
use ksec\Libraries\Lib;
use ksec\Unit as Unit;
use ksec\User as User;
use Sentinel,Lang,Hash;
use ksec\Services\DrawingService as DrawingService; 

class AdminService {

    public function __construct(Unit $unit,
        DrawingService $drawingService,
        User $user)
    {
        $this->user = $user;
    	$this->unit = $unit;
        $this->drawingService = $drawingService;
	}   

	public function getUnitList()
 	{
 		$units = Lib::addSelect($this->unit->getUnitList());
 		return $units;
 	}

    public function getTimeZoneByUnitId($unitId)
    {
        return $this->unit->getTimeZoneByUnitId($unitId);
    }
    
    public function getUnitName($input){
        $response = [
            'success' => 0,
            'data' => Lang::get ( 'messages.PROCESS_FAIL' ) 
        ];
        try {
            $response['success'] = 1;
             $response['data'] =  $this->unit->getUnitById($input['unitId']);
       } catch (Exception $e) {
           $response['data'] = "AdminService::getUnitName ".$e->getMessage();
       }   
        return $response;
    }

    public function deleteAttachment($attachmentId)
    {
        return $this->drawingService->deleteAttachment($attachmentId);
    }

    public function changePassword($input)
    {
        $response = [
            'success' => 0,
            'data' => Lang::get ( 'messages.PROCESS_FAIL' ) 
        ];
        try {
            $user = Sentinel::getUser();
            $id = $user->id;

            $record = $this->user->findById($id);
            
            if (Hash::check($input['oldPassword'], $record->password)) {
                if ($input['oldPassword'] != $input['newPassword']) {
       
                    $update['password'] = $input['newPassword'];
                    
                    $res = Sentinel::update($user, $update);
                    
                    if ($res) {
                        $response['success'] = 1;
                        unset($response['data']);
                    }
                    else
                    {
                        $response['success'] = 0;
                    }
                } else {
                    $response['success'] = 0;
                    $response['data'] = Lang::get('messages.password_not_equal');
                }
            } else {
                $response['success'] = 0;
                $response['data'] = Lang::get('messages.old_pwd_mismatch');
            }
        } catch (Exception $e) {
           $response['data'] = "AdminService::changePassword ".$e->getMessage();
        }
        return $response;
    }

    public function updateProfile($input)
    {
        $response = [
            'success' => 0,
            'data' => Lang::get ( 'messages.PROCESS_FAIL' ),
            'class' => 'alert alert-danger',
        ];
        try {
            $user = Sentinel::getUser();

            $res = Sentinel::update($user, $input);
            if($res){
                $response['success'] = 1;
                $response['data'] = Lang::get('messages.update_profile_succ');
                $response['class'] = 'alert alert-success';
            }
        } catch (Exception $e) {
            $response['data'] = "AdminService::updateProfile ".$e->getMessage();
        }
        return $response;
    }
}