<?php
require_once "connection.php";

class empLogModel{
    static public function mdlGetEmpLog($empID){
        $db = new Connection();
		$pdo = $db->connect();
        
        $stmt = (new Connection)->connect()->prepare("SELECT * FROM empwork WHERE empID = $empID");
        $stmt->execute();
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $time = strtotime($row['date'] . ' ' . $row['time']);

            if(date("Y-m-d H", $time) == $row['date'].' 08'){
                $timeInMorning = $time;
            } elseif(date("Y-m-d H", $time) == $row['date'].' 12'){
                $timeOutMorning = $time;
            } elseif(date("Y-m-d H", $time) == $row['date'].' 13'){
                $timeInAfternoon = $time;
            } elseif(date("Y-m-d H", $time) == $row['date'].' 17'){
                $timeOutAfternoon = $time;
            }

            //declarations
            $refDate = $row['date'];
            $morningLate = strtotime($refDate." 08:31:00");
            $morningAbsent = strtotime($refDate." 08:46:00");
            $afternoonLate = strtotime($refDate." 13:31:00");
            $afternoonAbsent = strtotime($refDate." 13:46:00");
        }

        //morning
        if (isset($timeInMorning) and isset($timeOutMorning)){
            if ($timeInMorning <=  $morningLate){
                $statusMorning = "on-time";
                $minsLateMorning = 0;
            } elseif (($timeInMorning >= $morningLate) and ($timeInMorning <= $morningAbsent)){
                $statusMorning = "late";
                $minsLateMorning = round(abs($morningLate - $timeInMorning)/60);
            } else {
                $statusMorning = "absent";
            }
        } else {
            $statusMorning = "absent";
        }

        //afternoon
        if (isset($timeInAfternoon) and isset($timeOutAfternoon)){
            if ($timeInAfternoon <= $afternoonLate){
                $statusAfternoon= "on-time";
                $minsLateAfternoon = 0;
            } elseif (($timeInAfternoon >= $afternoonLate) and ($timeInAfternoon <= $afternoonAbsent)){
                $statusAfternoon = "late";
                $minsLateAfternoon = round(abs($afternoonLate - $timeInAfternoon)/60);
            } else {
                $statusAfternoon = "absent";
            }
        } else {
            $statusAfternoon = "absent";
        }

        //calculate hours worked
        if ($statusMorning != "absent"){
            $totalHoursMorning = round(abs($timeInMorning - $timeOutMorning)/3600);
        } else {
            $minsLateMorning = 0;
            $totalHoursMorning = 0;
        }
        if ($statusAfternoon != "absent"){
            $totalHoursAfternoon = round(abs($timeInAfternoon - $timeOutAfternoon)/3600);
        } else {
            $minsLateAfternoon = 0;
            $totalHoursAfternoon = 0;
        }

        $logDate = $refDate;
        if(isset($timeInMorning)){$timeInMorning = date("h:i:s a", $timeInMorning);}else{$timeInMorning="N/A";}
        if(isset($timeOutMorning)){$timeOutMorning = date("h:i:s a", $timeOutMorning);}else{$timeOutMorning="N/A";}
        if(isset($timeInAfternoon)){$timeInAfternoon = date("h:i:s a", $timeInAfternoon);}else{$timeInAfternoon="N/A";}
        if(isset($timeOutAfternoon)){$timeOutAfternoon = date("h:i:s a", $timeOutAfternoon);}else{$timeOutAfternoon="N/A";}

        $totalHours = $totalHoursMorning + $totalHoursAfternoon . " hour/s";
        $totalMinsLate = $minsLateMorning + $minsLateAfternoon . " minute/s";

        $empLog = array($totalHours, $totalMinsLate, $logDate, $timeInMorning, $timeOutMorning, $statusMorning, $timeInAfternoon, $timeOutAfternoon, $statusAfternoon);
        echo json_encode($empLog);
    }
}
?>