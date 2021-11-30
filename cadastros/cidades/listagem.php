<?php
    $Pagina = $_GET['offset'] * 5;
    $Offset = $Pagina - 5;
    if (isset($_GET['id']))
        $id = $_GET['id'];
 
    try {
        if (isset($id)) {
            $stmt = $conn->prepare('SELECT A.*, B.sigla
                                      FROM cidades A
                                     INNER JOIN estados B ON B.id = A.estado 
                                     WHERE A.id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $conn->prepare('SELECT A.*, B.sigla
                                      FROM cidades A
                                     INNER JOIN estados B ON B.id = A.estado
                                     LIMIT :offset,:pag ');
            $stmt->bindParam(':offset',$Offset, PDO::PARAM_INT);
            $stmt->bindParam(':pag', $Pagina, PDO::PARAM_INT); 
        }
        //$stmt->execute(array('id' => $id));
        $stmt->execute();
   
        //while($row = $stmt->fetch()) {
        //while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            //print_r($row);
        //}
 
        $result = $stmt->fetchAll();
?>
<table border="1" class="table table-striped">
<tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Codigo</td>
            <td>Estado</td>
            <td>Ação</td>
</tr>
<?php
        if ( count($result) ) {
            foreach($result as $row) {
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['nome']?></td>
                    <td><?=$row['codigo']?></td>
                    <td><?=$row['sigla']?></td>
                    <td>
                        <a href="?modulo=cidades&pagina=alterar&id=<?=$row['id']?>">Alterar</a>
                        <a href="?modulo=cidades&pagina=deletar&id=<?=$row['id']?>">Excluír</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "Nenhum resultado retornado.";
        }
?>
</table>
<?php
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
