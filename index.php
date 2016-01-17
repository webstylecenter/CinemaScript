<?php

//require 'functions/dbconfig.php';
require 'functions/testcase_cinema.php';



?><!DOCTYPE>
<head>
    <title>Bios</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
        // echo '<meta http-equiv="refresh" content="0">';
    ?>
</head>
<body>

<?php

$cinema = new Cinema(7000);
echo '<pre>';
;
$cinema->giveSeatNumbers(1001);
//print_r($cinema->availableSeatsGroups);
print_r($cinema->count);

echo '</pre>';

?>


<div id="cinema">
    <?php echo $cinema->display(); ?>
</div>
<p>&nbsp; </p>
</body>
</html>
