<?php
include('../includes/function.php');
session_unset();
session_destroy();
header('location:/projet_academie/index.php');