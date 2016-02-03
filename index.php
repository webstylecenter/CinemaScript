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


$takenSeats = NULL;

$visitors = 16;
$cinema = new Cinema(30, $takenSeats);
$cinema->giveSeatNumbers($visitors);

print_r($cinema->chosenSeats);

?>
</pre>

<div id="cinema">
    <?php $cinema->showSeats();  ?>
</div>
<p>&nbsp; </p>
</body>
</html>
