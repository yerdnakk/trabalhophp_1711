<?php

session_start();
 
if(isset($_SESSION["logado"]) && $_SESSION["logado"] === true){
    header("location: index.php");
    exit;
}

include "bibliotecas/parametros.php";
include "bibliotecas/conexao.php";

 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor digite seu nome de usuário.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor digite sua senha.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, login, password FROM usuarios WHERE login = :login";
        $s = $conn->prepare($sql);
        $s->bindParam(':login',$username,PDO::PARAM_STR);
        $s->execute();            
        if(($s->rowCount() == 1) and ($s)){                   
            $row_user = $s->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row_user["password"])){
                session_start();
                            
                $_SESSION["logado"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;                            
                            
                header("location: index.php");
            } else{
                $login_err = "Nome de usuário ou senha inválidos.";
            }           
        } else{
            $login_err = "Nome de usuário ou senha inválidos.";
        } 
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="wrapper center">
        <h1>Login</h1>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label>Nome de usuário</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p class="signup_link"><strong>Ainda não possui uma conta? <a href="registrar.php">Registre-se aqui</strong></a></p>
        </form>
    </div>
</body>
</html>