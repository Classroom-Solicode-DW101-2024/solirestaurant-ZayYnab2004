<?php 

require "config.php";
if(isset($_POST["submit"])){
    $tel = $_POST["tel"];
    $rusult=tel_existe($tel);
    if(empty($rusult)){
        header("Location:register.php");
    }else{
        $_SESSION["client"]=$rusult;
        header("Location:index.php");
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




input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s;
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
    </style>
</head>
<body>
    <form method="POST">
        <label for="tel">entre tel:</label>
        <input type="tel" id="tel" name="tel" required>
        <button name="submit">log in</button>
    </form>
</body>
</html>