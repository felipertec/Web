<?php include 'template/header.php'?>


<?php
    require_once ("../db/pdoconfig.php");

    $msg = false;
    try {
        //cadastro de Usuario!
        if(isset($_POST['action'])){
            $nameUser = $_POST['nameUser'];
            $last_nameUser = $_POST['last_nameUser'];
            $emailUser = $_POST['emailUser'];
            $birthUser = $_POST['birthUser'];
            $addressUser = $_POST['addressUser'];
            $numberUser = $_POST['numberUser'];
            $districtUser = $_POST['districtUser'];
            $cityUser = $_POST['cityUser'];
            $stateUser = $_POST['stateUser'];
            $zip_codeUser = $_POST['zip_codeUser'];

            $consult = $pdo->query("Select COUNT(*) from User Where Email = '$emailUser'");
            $row = $consult->fetch();
            if($row[0]> 0){
                throw new Exception("Email ja Cadastrado!!!");
            }else{
                $sql = "INSERT INTO User(Name, Last_Name, Email, Birth, Address, Number, DistrictUser, City, State, Zip_code) VALUES(:nameUser,:last_nameUser,:emailUser,:birthUser,:addressUser,:numberUser,:districtUser,:cityUser,:stateUser,:zip_codeUser)";
                $q = $pdo->prepare($sql);
                $q->execute(array(
                    ':nameUser' => $nameUser,
                    ':last_nameUser' => $last_nameUser,
                    ':emailUser' => $emailUser,
                    ':birthUser' => $birthUser,
                    ':addressUser' => $addressUser,
                    ':numberUser' => $numberUser,
                    ':districtUser' => $districtUser,
                    ':cityUser' => $cityUser,
                    ':stateUser' => $stateUser,
                    ':zip_codeUser' => $zip_codeUser
                ));
                echo "<p style='color:green; text-align: center;'>Cadastrado com sucesso!</p>";
            }
        }
    } catch (Exception $e) {
        echo "<h3 style='color:red;'>".$e->getMessage()."</h3>";
    }

?>

<div class="container">
    <form  class="fUser" method="post">
        <label>Nome:</label><br>
        <input type="text" name="nameUser" required placeholder="Digite o Nome"><br>
        <label>Sobrenome:</label><br>
        <input type="text" name="last_nameUser"  placeholder="Digite o Sobrenome"><br>
        <label>Email:</label><br>
        <input type="email" name="emailUser" onblur="validarEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Digite o Email"><span id="error-email"></span><br>
        <label>Data de Nascimento:</label><br>
        <input type="date" name="birthUser" placeholder="Data de Nascimento"><br>
        <label>CEP:</label><br>
        <input name="zip_codeUser" type="text" id="cep"  maxlength="9" required
           onblur="pesquisacep(this.value);" /><br />  
        <label>Endereço:</label><br>
        <input type="text" name="addressUser" id="rua" required placeholder="Endereço"><br>
        <label>Numero:</label><br>
        <input type="number" name="numberUser" required placeholder="Digite o numero"><br>
        <label>Bairro:</label><br>
        <input type="text" name="districtUser" id="bairro" required placeholder="Nome do Usuario"><br>
        <label>Cidade:</label><br>
        <input type="text" name="cityUser" id="cidade" required placeholder="Nome do Usuario"><br>
        <label>UF:</label><br>
        <input type="text" name="stateUser" id="uf" size="1" required><br>
        <button type="submit" style="width: 20%; padding: 12px 20px; margin: 8px 450px;" class="btnSubmitSend" name="action">Cadastrar Usuario</button>
    </form>
    <?php if($msg != false)echo $msg; ?>
</div>

<?php include 'template/footer.php'?>