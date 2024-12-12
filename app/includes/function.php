<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=magie_academie;charset=utf8', 'root', '');

function sanitarize($input){
    return htmlspecialchars(trim(strtolower($input)));
}
?>