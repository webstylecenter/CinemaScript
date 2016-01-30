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
<pre>
<?php

$cinema = new Cinema(200);
print_r($cinema->giveSeatNumbers(50));

?>
</pre>

<div id="cinema">
    <?php echo $cinema->display(); ?>
</div>
<p>&nbsp; </p>
</body>
</html>
