<?php
require_once "../controllers/empLog.controller.php";
require_once "../models/empLog.model.php";

class empLog{
    public $empID;

    public function getEmpLog(){
        $empID = $this -> empID;
        $answer = (new empLogController) -> ctrGetEmpLog($empID);
    }
}

// $emp_Log = new empLog();
// $emp_Log -> empID = $_POST["empID"];

?>