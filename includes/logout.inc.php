<?php
    require_once 'connect.inc.php';
    session_start();
    session_unset();
    session_destroy();
    header("location: ../".$url);