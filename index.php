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

$cinema = new Cinema(30);
$cinema->giveSeatNumbers(12);

?>
</pre>

<div id="cinema">
    <?php $cinema->showSeats(); ?>
</div>
<p>&nbsp; </p>
</body>
</html>
