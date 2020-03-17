<?php
session_start();

if($_POST)
{
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $email = $_POST["email"];
    $confpass = $_POST["confpass"];
    require "../config.php";
    if($pass == $confpass){
        if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/",$pass))
        {
            $pass = md5(hash("haval160,4",sha1($pass)));

            $qury =$db->prepare("insert into user(username,password,email) values(?,?,?);");
            $qury->bind_param("sss",$user,$pass,$email);
            $qury->execute();
        }else{
            echo "The password string will start this way
                password must contain at least 1 lowercase alphabetical character
                <br> at least 1 uppercase alphabetical character
                <br> at least 1 numeric character
                <br> must be eight characters or longer";
        }

    }else{
        echo "Erreur : password doesn't match !";
    }

}

if(isset($_SESSION["user"]))
{
    header("location:../");
}else{
    ?>
        <html>
        <body>
        <form action="index.php" method="post">
            <label>username</label>
            <input name="username"/>
            <br>
            <label>email</label>
            <input name="email"/>
            <br>
            <label>password</label>
            <input name="password"/>
            <br>
            <label>confirme password</label>
            <input name="confpass"/>
            <br>
            <button type="submit">Crée</button>
            <a href="../Login">se connecter</a>
        </form>
        </body>
        </html>
<?php
}
?>