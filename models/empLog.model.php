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
    }
}

?>