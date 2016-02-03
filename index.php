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

$start = microtime(true);

$visitors = 16000;
$maxAmount = 500000;
$takenSeats = NULL;

$cinema = new Cinema($maxAmount, $takenSeats);
$cinema->giveSeatNumbers($visitors);

?>
</pre>

<?php echo '<p>Took '.(microtime(true) - $start).' seconds to place '.$visitors.' into a Cinema of '.$maxAmount.'</p>'; ?>

<div id="cinema">
    <?php $cinema->showSeats();  ?>
</div>
<p>&nbsp; </p>
</body>
</html>
