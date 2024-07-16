<?php
session_start();

session_destroy();

header("Location: ../inde.php");
exit();

?>
