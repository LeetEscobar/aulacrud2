<?php
require_once('classes/crud.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Series($db);

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read':
            $rows = $crud->read();
            break;
        case 'update':
            if(isset($_POST['id'])){
                $crud->update($_POST);
            }
            $rows=$crud->read();
            break;
            
        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;

        default:
        $rows = $crud->read();
        break;
        

    }
}else{
    $rows = $crud->read();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series</title>

    <style>
        body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        background-color: rgb(216, 200, 255);
       }
       form{
        background-color: rgb(233, 224, 255);
        max-width: 400px;
        margin: 100px auto;
        padding: 40px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgb(216, 200, 255);

        }
         label{
            display: flex;
            margin-top:10px;
         }
         input[type=text]{
            width:100%;
            padding: 12px 20px;
            margin: 8px 0;
            display:inline-block;
            border: 1px solid #ccc;
            border-radius:4px;
            box-sizing:border-box;
         }
         input[type=submit]{
            background-color: rgb(120, 103, 164);
            color:white;
            padding:12px 20px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            float:right;
         }
         input[type=submit]:hover{
            background-color:rgb(216, 200, 255);
         }
         table{
            border-collapse:collapse;
            width:100%;
            font-family:Arial, sans-serif;
            font-size:14px;
            color:#333;
            background-color: white;
         }
         th, td{
            text-align:left;
            padding:8px;
            border: 1px solid #ddd;
         }
        th{
           background-color:rgb(216, 200, 255);
           font-weight:bold; 
        }
        a{
            display:inline-block;
            padding:4px 8px;
            background-color: rgb(216, 200, 255);
            color:#fff;
            text-decoration:none;
            border-radius:4px;
        }
        a:hover{
            background-color:rgb(216, 200, 255);
        }

        a.delete{
            background-color: rgb(216, 200, 255);
        }
        a.delete:hover{
            background-color:#c82333;
        }

        h1 {
            font-size: 24px;
            color: #323232;
            text-align: center;
            margin-top: 10px;
            
        }
    </style>

    <h1> Séries </h1>

</head>
<body>

<?php  

    if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $crud->readOne($id);

        if(!$result){
            echo "Registro não encontrado.";
            exit();
        }
        $nome = $result['nome'];
        $genero = $result['genero'];
        $temporadas = $result['temporadas'];
        $episodios = $result['episodios'];
        $ano = $result['ano'];
    
?>
    <form action="?action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label for="nome">Nome</label>
        <input type="text" name="nome" value="<?php echo $nome ?>">

        <label for="genero">Genero</label>
        <input type="text" name="genero" value="<?php echo $genero ?>">

        <label for="temporadas">Temporadas</label>
        <input type="text" name="temporadas" value="<?php echo $temporadas ?>">

        <label for="epsodios">Epsodios</label>
        <input type="text" name="episodios" value="<?php echo $episodios ?>">

        <label for="ano">Ano</label>
        <input type="text" name="ano" value="<?php echo $ano ?>">

        <input type="submit" value="Atualizar" name="enviar"  onclick="return confirm('Certeza que deseja atualizar?')">
    </form>

    <?php }else{?>


    <form action="?action=create" method="POST">
        <label for="">Nome</label>
        <input type="text" name="nome">

        <label for="">Genero</label>
        <input type="text" name="genero">

        <label for="">Temporadas</label>
        <input type="text" name="temporadas">

        <label for="">Episodios</label>
        <input type="text" name="episodios">

        <label for="">Ano</label>
        <input type="text" name="ano">

        <input type="submit" value="Cadastrar" name="enviar">
    </form>
    <?php }?>


    <table>
        <tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Genero</td>
            <td>Temporadas</td>
            <td>Episodios</td>
            <td>Ano</td>
            <td>Ações</td>
            
        </tr>
        <?php

  if($rows->rowCount() == 0){
    echo "<tr>";
    echo "<td colspan='7'>Nenhum dado encontrado</td>";
    echo "</tr>";
  } else {
    while($row = $rows->fetch(PDO::FETCH_ASSOC)){
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['nome'] . "</td>";
      echo "<td>" . $row['genero'] . "</td>";
      echo "<td>" . $row['temporadas'] . "</td>";
      echo "<td>" . $row['episodios'] . "</td>";
      echo "<td>" . $row['ano'] . "</td>";
      echo "<td>";
      echo "<a href='?action=update&id=" . $row['id'] . "'>Atualizar</a>";
      echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que quer apagar esse registro?\")' class='delete'>Deletar</a>";
      echo "</td>";
      echo "</tr>";
    }
  }
?>
    </table>
</body>
</html>

