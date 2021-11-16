<?php
    if (isset($_POST['gravar'])) {
        try {

            $nome = $_POST['nome'];
            $estado = $_POST['estado'];
            $codigo = $_POST['codigo'];


            $stmt = $conn->prepare(
                'INSERT INTO cidades (nome, estado, codigo) values (:nome, :estado, :codigo)');

            $stmt->bindParam(':nome', $nome);          
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
?>

<form method="post">
    <div class="form-group">
        <label for="nome">Nome da cidade</label>
        <input type="text" class="form-control" name="nome" id="nome" placeholder="nome">
        <label for="estado">Estado</label>
        <input type="number" class="form-control" name="estado" id="estado" placeholder="estado">
        <label for="codigo">Código da cidade</label>
        <input type="number" class="form-control" name="codigo" id="codigo" placeholder="codigo">
    </div>
    <input type="submit" name="gravar" value="Gravar">
</form>