<?php
    if (isset($_POST['alterar'])) {
        $ValorEstoque = $_POST['valor'] * $_POST['estoque'];
        try {
            $stmt = $conn->prepare(
                'UPDATE produto SET nome = :nome, marca = :marca, estoque = :estoque, valor = :valor, valorestoque = :valorestoque WHERE id = :id');
            //$stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute(array('nome' => $_POST['nome'], 'marca' => $_POST['marca'], 'estoque' => $_POST['estoque'], 
                                 'valor' => $_POST['valor'], 'valorestoque' => $ValorEstoque,
                                'id' => $_GET['id']));
            //$stmt->execute();
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
 
    if (isset($_GET['id'])) {
        $stmt = $conn->prepare('SELECT * FROM produto WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    }
    //$stmt->execute(array('id' => $id));
    $stmt->execute();
    $r = $stmt->fetchAll();
 
    //print_r($r);
?>
<form method="post">
    <input type="text" name="nome" value="<?=$r[0]['nome']?>" required>
    <input type="text" name="marca" value="<?=$r[0]['marca']?>" required>
    <input type="number" name="valor" min="1" step="any" value="<?=$r[0]['valor']?>" required>
    <input type="number" name="estoque" value="<?=$r[0]['estoque']?>" required>
    <input type="submit" name="alterar" value="Salvar" class="btn btn-success">
</form>
