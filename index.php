<?php
//require 'functions/dbconfig.php';
require 'functions/testcase_cinema.php';



?><!DOCTYPE>
<head>
    <title>Bios</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
         echo '<meta http-equiv="refresh" content="0">';
    ?>
</head>
<body>

<?php

$cinema = new Cinema(200);
$cinema->giveSeatNumbers(50);
//print_r($cinema->availableSeatsGroups);
//print_r($cinema->chosenSeats);
//print_r($cinema->groups);
//print_r($cinema->count);



?>


<div id="cinema">
    <?php echo $cinema->display(); ?>
</div>
<p>&nbsp; </p>
</body>
</html>
