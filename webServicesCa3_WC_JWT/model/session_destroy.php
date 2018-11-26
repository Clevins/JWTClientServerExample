<?php
session_start();
session_unset();
session_destroy();

include_once '../view/show_login.php';

