<?php session_start();?>

<h1>UPLOAD DE IMAGENS - COMPACTAÇÃO DE IMAGENS USANDO BIBLIOTECA GD NO PHP</h1>
<br>
<small>Obs : talvez seja necessário configurar o PHP.ini para permitir envio de imagens grande e memória, também se necessário ativar a biblioteca GD.</small>
<hr>

<style>
    table, tr, td {
        border: 1px solid;        
        border-color: gray;
    }
</style>

<form action="processa.php" method="post" enctype="multipart/form-data">
  <label for="arquivo">Selecione uma Imagem</label><br><br>
  <input type="file" name="arquivo"><br><br>  
  <input type="submit" value="Enviar">
</form> 

<hr>
    <h1>IMAGENS PARA COMPARAÇÃO</h1>
    <small>Acesse o diretório de armazenamento e confira o tamanho das imagens para comparação</small>

<table>
    <tr>
        <td>ORIGINAL</td>
        <td>COMPACTADA</td>
    </tr>
    <tr>
        <td>             
            <?php if (!empty($_SESSION['img_o'])): ;?>            
                <img src="<?php echo $_SESSION['img_o'] ;?>" height="400" widht="400">
                <?php $_SESSION['img_o'] = "" ;?>
            <?php endif ;?>
        </td>
        <td>
            <?php if (!empty($_SESSION['img_c'])): ;?>            
                <img src="<?php echo $_SESSION['img_c'] ;?>" height="400" widht="400">
                <?php $_SESSION['img_c'] = "" ;?>
            <?php endif ;?>
        </td>
    <tr>
</table>

<hr>