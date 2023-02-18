<?php require_once "models/empLog.model.php"; error_reporting(0); ?>

<html>
    <head>
        <title>Biometrics</title>
        <script src="views/js/jquery-3.6.3.min.js"></script>
        <script src="views/js/script.js"></script>
    </head>
<body>

<form id="empLog-form">
  <input type="number" id="empID" name="empID" placeholder="Enter Employee ID">
  <button type="submit">Calculate</button>
  <br><br>
  <p>Total number of hours worked for the day: <input type="text" id="hoursWorked" name="hoursWorked" value="<?php echo $totalHours;?>" readonly> </p>
  <p>Number of minutes late in the morning: <input type="text" id="minsLateMorning" name="minsLateMorning" value="<?php echo $hoursLateMorning;?>" readonly> </p>
  <p>Number of minutes late in the afternoon: <input type="text" id="minsLateAfternoon" name="minsLateAfternoon" value="<?php echo $hoursLateAfternoon;?>" readonly> </p>
</form>

</body>
</html>