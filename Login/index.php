<?php
session_start();

if(!isset($_POST["token"]) || $_POST["token"]!=$_SESSION["token"])
{
    echo " token violation";
}

if($_POST && $_POST["token"]==$_SESSION["token"])
{

     $user = $_POST["username"];
     $pass = md5(hash("haval160,4",sha1($_POST["password"])));
     require "../config.php";
     $qury =$db->prepare("select count(*) from user where username=? and password=?");
     $qury->bind_param("ss",$user,$pass);
     $qury->execute();
     $result = $qury->get_result();
     $count = $result->fetch_row();
if($count[0]==1)
{
    $_SESSION["user"]=$user;
}else{
    $_SESSION["attempts"] = isset($_SESSION["attempts"])?1:$_SESSION["attempts"]+=1;
    if($_SESSION["attempts"]==3){
        $_SESSION["unblock_time"];
        $date=new DateTime(time());
        $date->add(new DateInterval('PT' . 5 . 'M'));
        $_SESSION["unblock_time"] =date;
    }
    echo "mot de passe ou nom d'utilisateur est incorrect";
}
}
require "../csrfgenerator/gentoken.php";
if(isset($_SESSION["user"]))
{
    header("location:../");
}else{
    ?>

    <html>
    <body>
    <form method="post">
        <label>username</label>
        <input name="username"/>
        <br>
        <label>username</label>
        <input name="password"/>
        <br>
        <input name="token" type="hidden" value="<?php $_SESSION["token"]?>"/>
        <button type="submit">se connecter</button>
        <a href="../Register">creer un compte</a>
    </form>
    </body>
    </html>
    <?php
}