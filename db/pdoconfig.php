<?php
    $host = "localhost";
    $dbname = "web";
    $username = "root";
    $password = "";

    try{
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        //echo "Conectado com sucesso";
    } catch(PDOExceptio $pe){
       // die("não foi possivel se conecctar ao banco de dados $dbname : ". $pe->getMessage());
    }