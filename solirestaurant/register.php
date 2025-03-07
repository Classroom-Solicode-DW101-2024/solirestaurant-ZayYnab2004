<?php
require 'config.php';
$erreurs=[];
if(isset($_POST["btnSubmit"] )){
    $nom=trim($_POST["nom"]);
    $prenom=trim($_POST["prenom"]);
    $tel=trim($_POST["tel"]);
    $tel_is_exist=tel_existe($tel);
    var_dump( $tel_is_exist);
    if(!empty($nom) && !empty($prenom) && !empty($tel) && empty($tel_is_exist)){
     $sql_insert_client="insert into CLIENT  values(:id,:nom,:prenom,:tel)";
     $stmt_insert_client=$pdo->prepare($sql_insert_client);
    $idvalue=getLastIdClient()+1;

     $stmt_insert_client->bindParam(':id',$idvalue);
     $stmt_insert_client->bindParam(':nom',$nom);
     $stmt_insert_client->bindParam(':prenom',$prenom);
     $stmt_insert_client->bindParam(':tel',$tel);

     $stmt_insert_client->execute();
    echo 'Client bien ajouté !!';

    }else {
        if(empty($nom)){
            $erreurs['nom']="remplir le nom";
        }
        if(empty($prenom)){
            $erreurs['prenom']="remplir le prenom";
        }
        if(empty($tel)){
            $erreurs['tel']="remplir le tel";
        }
        if(!empty($tel_is_exist)){
            $erreurs['tel']="tel is duplique";
        }
    }
    
}
 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    flex-direction: column;
}


form {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
    display: flex;
    flex-direction: column;
}


label {
    font-weight: bold;
    margin-top: 10px;
}

input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
}

input:focus {
    border-color:rgb(6, 6, 6);
}

button {
    margin-top: 15px;
    padding: 10px;
    background-color:rgb(6, 6, 6);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color:rgb(6, 6, 6);
}


.erreur {
    color: red;
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
}


a {
    display: block;
    margin-top: 15px;
    text-align: center;
    color:brown;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <form  method="POST" >
        <label for="nom">Entrez votre nom:</label>
        <input type="text" name="nom" id="nom">
        <label for="prenom">Entrez votre prénom</label>
        <input type="text" name="prenom" id="prenom">
        <label for="numTel">Entrez votre numéro de téléphone</label>
        <input type="tel" name="tel" id="numTel" >
        <button name="btnSubmit">Je m'inscris!</button>
    </form>
    <a href="login.php">log in</a>
    <?php
    if(count($erreurs)>0){
        foreach($erreurs as $key=>$erreur){
            echo "<span class='erreur'>".$erreur."</span><br>";
        }
    }
    ?>
</body>
</html>