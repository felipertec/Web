<?php include 'template/header.php' ?>
    <div class="center"><h1>Formulario de Produtos</h1></div>

<?php
    require_once ("../db/pdoconfig.php");

    $msg = false;
    try{
        $pdo->beginTransaction();
        // Insere a imagem no banco de dados
        
        if(isset($_FILES['archive']) && empty($_FILES['archive'])){
            $extension = strtolower(substr($_FILES['archive']['name'], -4));
            $new_name = md5(time()) . $extension;
            $directory = "../upload/";
        
            move_uploaded_file($_FILES['archive']['tmp_name'], $directory.$new_name);

            $sql_code = "INSERT INTO Image(Name) VALUES(?)";

            $statement = $pdo->prepare($sql_code);
            if($statement->execute([$new_name])){
                $msg = "Arquivo enviado com sucesso";
                echo $imageId = $pdo->lastInsertId();
            }else{
                throw new Exception('erro ao salvar a imagem!!');
            }
        }else{
            $imageId = 1;
        }

        // Fim do cadastro de imagem.
    
        //Cadastro de Produto!
        if(isset($_POST['action'])){
            $nameProduct = $_POST['nProduct'];
            $description = $_POST['dProduct'];
            $quantityProduct = (int)$_POST['qProduct'];     
            $priceProduct = (float) str_replace(",",".",$_POST['pProduct']);
            $categoryProduct = $_POST['cProduct'];
            $imageProduct = $imageId;


           

            if($_POST['nProduct'] == '' || $_POST['dProduct'] == '' || $_POST['qProduct'] == '' || $_POST['pProduct'] == ''){
                throw new Exception("Completar todos os campos vazios");
            }elseif((is_numeric($_POST['qProduct']) != is_int($quantityProduct)) || (($quantityProduct == (float)$_POST['qProduct'] *=1)) == false){
                throw new Exception("Tem que ser caracteres numericos inteiros no campo Quantidade");
            }elseif($priceProduct >= 0 && is_string($priceProduct) && !is_float($_POST['pProduct'])){
                throw new Exception("Os caracteres tem que ser numericos no campo Preço");
            }else{
                $sql = "INSERT INTO Product(Name,Description,Qtd,Price,idCategory,idImage) VALUES(:nProduct,:dProduct,:qProduct,:pProduct,:cProduct,:archive)";
                $q = $pdo->prepare($sql);
                $q->execute(array(
                    ':nProduct' => $nameProduct,
                    ':dProduct' => $description,
                    ':qProduct' => $quantityProduct,
                    ':pProduct' => $priceProduct,
                    ':cProduct' => $categoryProduct,
                    ':archive' => $imageId
                ));

                if($q){
                    echo "<p style='color:green; text-align: center;'>Cadastrado com sucesso!</p>";
                }
            }
        }
        
        $pdo->commit();
        
    }catch(Exception $e){
        echo "<h3 style='color:red;'>".$e->getMessage()."</h3>";
        $pdo->rollBack();
        
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
            <label>Arquivo:</label> 
            <div class="center">
                <input class="Input_Product" type="file" name="archive" onchange="readURL(this);">    
            </div>
            <input type="submit" style="width: 10%; padding: 12px 20px; margin: 8px 500px;" class="btnSubmitSend" value="Salvar" name="action">
        </form>
    </div>

<?php 
    $consult = $pdo->query("SELECT Name FROM Category"); 

    while($linha = $consult->fetch(PDO::FETCH_ASSOC)){
        echo "Nome: {$linha['Name']}";
    }
?>

<?php include 'template/footer.php' ?>
