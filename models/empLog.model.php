<?php
require_once "connection.php";

class empLogModel{
    public function mdlGetEmpLog($empID){
        $db = new Connection();
		$pdo = $db->connect();
        
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM empwork WHERE empID = $empID");
        $stmt->execute();
        $row = $stmt->fetch();
        
        // morning (8:31 - 8:45 AM) - considered late, otherwise it's a half day morning absent
        // afternoon (1:31 - 1:45 PM) - considered late, , otherwise it's a half day afternoon absent
        // (log-in without logout) or (log-out without log-in) - considered absent either morning or afternoon

        //sample data only
        $timeInMorning = "";
        $timeOutMorning = "";
        $timeInAfternoon = "";
        $timeOutAfternoon = "";

        //morning
        if (isset($timeInMorning) or isset($timeOutMorning)){
            if ($timeInMorning <= '08:31:00'){
                $statusMorning = "on-time";
            } elseif (($timeInMorning >= '08:31:00') and ($timeInMorning <= '08:45:00')){
                $statusMorning = "late";
                $hoursLateMorning = '08:30:00' - $timeInMorning;
            } else {
                $statusMorning = "absent";
            }
        } else {
            $statusMorning = "absent";
        }

        //afternoon
        if (isset($timeInAfternoon) or isset($timeOutAfternoon)){
            if ($timeInAfternoon <= '13:31:00'){
                $statusAfternoon = "on-time";
            } elseif (($timeInAfternoon >= '13:31:00') and ($timeInAfternoon <= '13:45:00')){
                $statusAfternoon = "late";
                $hoursLateAfternoon = '13:30:00' - $timeInAfternoon;
            } else {
                $statusAfternoon = "absent";
            }
        } else {
            $statusAfternoon = "absent";
        }

        //calculate hours worked
        if ($statusMorning != "absent"){
            $totalHoursMorning = $timeOutMorning - $timeInMorning;
        } else {
            $totalHoursMorning = 0;
        }
        if ($statusAfternoon != "absent"){
            $totalHoursAfternoon = $timeOutAfternoon - $timeInAfternoon;
        } else {
            $totalHoursAfternoon = 0;
        }
        $totalHours = $totalHoursMorning + $totalHoursAfternoon;
    }
}
?>
