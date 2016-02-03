<?php require 'functions/testcase_cinema.php';
?><!DOCTYPE>
<head>
    <title>Bios</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
        // echo '<meta http-equiv="refresh" content="0">';
    ?>
</head>
<body>
<pre>
<?php

$takenSeats = [
    2 => true,
    10 => true,
    11 => true,
    12 => true,
    13 => true,
    16 => true
];
$cinema = new Cinema(18, $takenSeats);
$cinema->giveSeatNumbers(10);

if (count($cinema->chosenSeats > 10)) {
    echo '<h1 style="color:red;">To much! ('.count($cinema->chosenSeats).')</h1>';
} else {
    echo '<h3>Well Done! '.count($cinema->chosenSeats).'</h3>';
}


?>
</pre>

<div id="cinema">
    <?php $cinema->showSeats(); ?>
</div>
<p>&nbsp; </p>
</body>
</html>
