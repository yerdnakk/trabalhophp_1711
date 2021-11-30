<?php

include "bibliotecas/parametros.php";
include "bibliotecas/conexao.php";
 
$name = $username = $email = $password = $confirm_password = "";
$name_err = $username_err = $email_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty(trim($_POST["name"]))){
        $name_err = "Por favor digite seu nome.";
    } elseif(!preg_match('/^[a-zA-Z\s]+$/', trim($_POST["name"]))){
        $name_err = "O nome só pode conter letras.";
    } else{
        $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor digite um nome de usuário.";
    } elseif(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["username"]))){
        $username_err = "O nome só pode conter letras e números.";
    } else{
        $sql = "SELECT id FROM usuarios WHERE login = ?";
        $s = $conn->prepare($sql);
        $s->execute(array($_POST['username']));
        $existe = $s->fetchColumn();          
        if($existe > 0){
            $username_err = "Este nome de usuário já existe.";
        } else{
            $username = trim($_POST["username"]); 
        }       
    }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Por favor digite o seu email.";
    } elseif(!preg_match('/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', trim($_POST["email"]))){
        $email_err = "Email inválido.";
    } else{
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $s = $conn->prepare($sql);
        $s->execute(array($_POST['email']));
        $existe = $s->fetchColumn();           
        if($existe > 0){
            $email_err = "Este e-mail já existe.";
        } else{
            $email = trim($_POST["email"]); 
        }       
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor digite uma senha.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A senha deve conter pelo menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme sua senha.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "As senhas não são iguais.";
        }
    }
    
    if(empty($username_err) && empty($email_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO usuarios (login, email, nome, password) VALUES (:login, :email, :nome, :password)";
        $s = $conn->prepare($sql);
        $s->bindParam(':login',$username,PDO::PARAM_STR);
        $s->bindParam(':email',$email,PDO::PARAM_STR);
        $s->bindParam(':nome',$name,PDO::PARAM_STR);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $s->bindParam(':password',$pass_hash,PDO::PARAM_STR);
        $s->execute();            
        header("location: login.php");
    }
 
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="wrapper center">
        <h1>Registro</h1>
        <form action="registrar.php" method="post">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Nome de usuário</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>        
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirmar senha</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="reg btn btn-primary" value="Confirmar">
                <input type="reset" class="btn btn-secondary ml-2" value="Limpar">
            </div>
            <p class="signup_link"><strong>Já possui uma conta? <a href="login.php">Logue aqui</strong></a></p>
        </form>
    </div>    
</body>
</html>