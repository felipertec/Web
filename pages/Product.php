<?php include 'template/header.php' ?>
    <div class="center"><h1>Formulario de Produtos</h1></div>

<?php
    require_once ("../db/pdoconfig.php");

    $msg = false;
    
    // Insere a imagem no banco de dados
    if(isset($_FILES['archive'])){
        $extension = strtolower(substr($_FILES['archive']['name'], -4));
        $new_name = md5(time()) . $extension;
        $directory = "../upload/";
    
        move_uploaded_file($_FILES['archive']['tmp_name'], $directory.$new_name);

        $sql_code = "INSERT INTO Image(idImage, Name) VALUES(null,'$new_name')";
        if($pdo->query($sql_code)){
            $msg = "Arquivo enviado com sucesso";

        }else{
            $msg = "Falha No Arquivo";
        }
    }
    // Fim do cadastro de imagem.
    
    //Cadastro de Produto!
    if(isset($_POST['action'])){
        $nameProduct = $_POST['nProduct'];
        $description = $_POST['dProduct'];
        $quantityProduct = $_POST['qProduct'];
        $priceProduct = $_POST['pProduct'];
        $categoryProduct = $_POST['cProduct'];


        if($_POST['nProduct'] == '' || $_POST['dProduct'] == '' || $_POST['qProduct'] == '' || $_POST['pProduct'] == ''){
            echo "<h3 style='color:red;'>Preencher todos os campos vazios.</h3>";
        }else{
            $sql = "INSERT INTO Product(Name,Description,Qtd,Price,idCategory) VALUES(:nProduct,:dProduct,:qProduct,:pProduct,:cProduct)";
            $q = $pdo->prepare($sql);
            $q->execute(array(
                ':nProduct' => $nameProduct,
                ':dProduct' => $description,
                ':qProduct' => $quantityProduct,
                ':pProduct' => $priceProduct,
                ':cProduct' => $categoryProduct

            ));

            if($q){
                echo "<p style='color:green; text-align: center;'>Cadastrado com sucesso!</p>";
            }
        }
    }
 

    
    // fim de cadastro de produtos
?>
<?php if($msg != false)echo $msg; ?>
    <div>
        <form class="fProduct" method="POST" enctype="multipart/form-data">
            <label>Nome do Produto:</label><br>
            <input type="text" name="nProduct" placeholder="Nome do Produto"><br>
            <label>Descrição:</label><br>
            <input type="text" name="dProduct" placeholder="Descrição"><br>
            <label>Quatidade:</label><br>
            <input type="text" name="qProduct" placeholder="Quantidade"><br>
            <label>Preço:</label><br>
            <input type="text" name="pProduct" placeholder="Digite o Preço"><br>
            <label>Categoria:</label><br>
            <select name="cProduct">
                <option value=""></option>
                <?php 
                    $consult = $pdo->query("SELECT idCategory, Name FROM Category"); 

                    while($linha = $consult->fetch(PDO::FETCH_ASSOC)){
                        
                        echo '<option value="'.$linha['idCategory'].'">'.$linha['Name'].'</option>';
                    }
                ?>
            </select><br>
            Arquivo: <input type="file" name="archive">
            <input type="submit" value="Salvar" name="action">
        </form>
    </div>

<?php 
    $consult = $pdo->query("SELECT Name FROM Category"); 

    while($linha = $consult->fetch(PDO::FETCH_ASSOC)){
        echo "Nome: {$linha['Name']}";
    }
?>

<?php include 'template/footer.php' ?>