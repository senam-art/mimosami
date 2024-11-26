<?php

session_start();
session_destroy();

header('Location: ../view/Homepage.html');



exit();
?>