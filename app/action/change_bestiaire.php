<?php
    include('../includes/function.php');
    

    if(isset($_GET['id'])){
        $id =htmlspecialchars($_GET['id']);

        $bestiaireRequest = $bdd->query(
            'SELECT bestiaire.*, type.type AS type 
             FROM bestiaire
             LEFT JOIN type ON bestiaire.id_type = type.id'
        )->fetchAll(PDO::FETCH_ASSOC);

        if($_SESSION['userid']!=$data['user_id']){
            header("location:/projet_academie/index.php");
        }
    }else{
        header('location:/projet_academie/index.php');
    }


    





