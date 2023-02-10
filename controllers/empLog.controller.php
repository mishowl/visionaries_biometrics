<?php

class empLogController{
    static public function ctrGetEmpLog($empID){
        $answer = (new empLogModel) -> mdlGetEmpLog($empID);
    }
}

?>