<?php
        include 'template/header.php'
?>
    <div  class="center">
        <h1>
           Cadastro de Categoria!
        </h1>
    </div>

    <div class="center">
        <form class="fCategory" method="post" name="formulario">
            <label>Nome da Categoria</label><br>  
            <input type="text" name="cNCategory"><br>
            <label>Descrição</label>  <br>
            <input type="text" name="cDescription"><br>
           <button type="submit" name="acao" class="btnSubmitCategory" onclick="validar()">Cadastrar</button>
        </form>
    </div>
    
<?php
require_once ("../db/pdoconfig.php");

    if(isset($_POST['acao'])){
        $nameCategory = $_POST['cNCategory'];
        $description = $_POST['cDescription'];

    
        if($_POST['cNCategory'] == "" || $_POST['cDescription'] == ""){
            echo "<h3 style='color:red; text-align:center;'>Preencher todos os campos vazios!</h3>";
        }else{

            $sql = "INSERT INTO Category(Name,Description) VALUES (:cNCategory,:cDescription)";
            $q = $pdo->prepare($sql);
            $q->execute(array(
                ':cNCategory' => $nameCategory,
                'cDescription' => $description
            ));

            if($q){
                echo "<p style='color:green; text-align: center;'>Cadastrado com sucesso!</p>";
            }
        }
    }
?>

<?php include 'template/footer.php'?>