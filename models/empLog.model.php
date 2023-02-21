<?php
require_once "connection.php";

class empLogModel{
    static public function mdlGetEmpLog($empID){
        $db = new Connection();
		$pdo = $db->connect();
        
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM empwork WHERE empID = $empID");
        $stmt->execute();
        $row = $stmt->fetch();
        
        // morning (8:31 - 8:45 AM) - considered late, otherwise it's a half day morning absent
        // afternoon (1:31 - 1:45 PM) - considered late, , otherwise it's a half day afternoon absent
        // (log-in without logout) or (log-out without log-in) - considered absent either morning or afternoon

        //sample data only
        $timeInMorning = strtotime("08:31:00");
        $timeOutMorning = strtotime("12:31:00");
        $timeInAfternoon = strtotime("13:31:00");
        $timeOutAfternoon = strtotime("15:31:00");

        //declarations
        $morningLate = strtotime("08:30:00");
        $morningAbsent = strtotime("08:45:00");
        $afternoonLate = strtotime("13:30:00");
        $afternoonAbsent = strtotime("13:45:00");

        //morning
        if (isset($timeInMorning) and isset($timeOutMorning)){
            if ($timeInMorning <=  $morningLate){
                $statusMorning = "on-time";
            } elseif (($timeInMorning >= $morningLate) and ($timeInMorning <= $morningAbsent)){
                $statusMorning = "late";
                $minsLateMorning = floor(abs($morningLate - $timeInMorning)/60);
            } else {
                $statusMorning = "absent";
            }
        } else {
            $statusMorning = "absent";
        }

        //afternoon
        if (isset($timeInAfternoon) and isset($timeOutAfternoon)){
            if ($timeInAfternoon <= $afternoonLate){
                $statusAfternoon = "on-time";
            } elseif (($timeInAfternoon >= $afternoonLate) and ($timeInAfternoon <= $afternoonAbsent)){
                $statusAfternoon = "late";
                $minsLateAfternoon = floor(abs($afternoonLate - $timeInAfternoon)/60);
            } else {
                $statusAfternoon = "absent";
            }
        } else {
            $statusAfternoon = "absent";
        }

        //calculate hours worked
        if ($statusMorning != "absent"){
            $totalHoursMorning = floor(abs($timeInMorning - $timeOutMorning)/3600);
        } else {
            $totalHoursMorning = 0;
        }
        if ($statusAfternoon != "absent"){
            $totalHoursAfternoon = floor(abs($timeInAfternoon - $timeOutAfternoon)/3600);
        } else {
            $totalHoursAfternoon = 0;
        }
        $totalHours = $totalHoursMorning + $totalHoursAfternoon . " hours";
        $totalMinsLate = $minsLateMorning + $minsLateAfternoon . " minutes";

        $empLog = array($totalHours, $totalMinsLate);
        echo json_encode($empLog);
    }
}
?>