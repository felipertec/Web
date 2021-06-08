<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div><h3><b><s>ICON</s></b></h3></div>
    <div>
        <h1 class="center">
            Bem Vindo a Categoria!
        </h1>
    </div>

    <div class="center">
        <form method="POST" name="formulario">
            <label>Nome da Categoria</label><br>  
            <input type="text" name="cNCategory"><br>
            <label>Descrição</label>  <br>
            <input type="text" name="cDescription"><br>
            <button type="submit" class="botao" onclick="validar()">Cadastrar</button>
        </form>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>