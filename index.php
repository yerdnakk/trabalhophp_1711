<?php 
    session_start();

    include "bibliotecas/parametros.php";
    include "bibliotecas/conexao.php";

    if (!isset($_SESSION['logado'])){
        header('Location: login.php');
    }else{

    if (!isset($_GET['offset'])){
        $_GET['offset'] = 1;
    }
    
        include LAYOUTS.'header.php';
    
        include LAYOUTS.'menu.php';
    
        if (!isset($_GET['pagina']))
            include LAYOUTS.'home.php';
        else
            include CADASTROS.$_GET['modulo'].'/'.$_GET['pagina'].'.php';

        if((isset($_GET['pagina'])) and ($_GET['pagina'] == 'listagem')){
            if (count($result)){
                if ($_GET['offset'] > 1){
                    ?>
                    <a class="btn btn-secondary" href="?offset=<?php echo $_GET['offset'] - 1 . '&modulo=' . $_GET['modulo'] . '&pagina=' . $_GET['pagina'] ; ?>">Anterior</a>
                    <a class="btn btn-secondary" href="?offset=<?php echo $_GET['offset'] + 1 . '&modulo=' . $_GET['modulo'] . '&pagina=' . $_GET['pagina'] ; ?>">Próximo</a>
                    <?php
                }else{
                    ?>
                    <a class="btn btn-secondary" href="?offset=<?php echo $_GET['offset'] + 1 . '&modulo=' . $_GET['modulo'] . '&pagina=' . $_GET['pagina'] ; ?>">Próximo</a>
                <?php
                }
            }else if($_GET['offset'] > 1){
                ?>
                    <a class="btn btn-secondary" href="?offset=<?php echo $_GET['offset'] - 1 . '&modulo=' . $_GET['modulo'] . '&pagina=' . $_GET['pagina'] ; ?>">Anterior</a>
                <?php
            }
        }

        include LAYOUTS.'footer.php';   
}