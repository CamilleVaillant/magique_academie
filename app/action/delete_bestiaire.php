<?php
    include('../includes/function.php');
    var_dump($_GET);
exit();

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);

        $requestRead = $bdd->prepare(  '    SELECT *
                                            FROM bestiaire
                                            WHERE id = :id'
            );

        $requestRead->execute(array(
                'id'   =>  $id
        ));

        $data = $requestRead->fetch();

        if($_SESSION['userid']==$data['user_id']){
            unlink('../../uploads/bestiaire/' . $data['bestiaire']);

            $request = $bdd->prepare('  DELETE FROM bestiaire
            WHERE id=:id');

            $request->execute(['id' =>$id]);

            header('location:/projet_academie/index.php?success=9');
            exit();
        }else{
            header('location:/projet_academie/index.php');
        }
    }else{
        header('loaction:/projet_academie/index.php');
    }
?>

