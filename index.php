
<?php
session_start();
if($_POST)
{
    if(isset($_POST["logout"]))
    {
        session_destroy();
        header("location:Login/");
    }
}

if(isset($_SESSION["user"]))
{
    echo ("Hello ".$_SESSION["user"]);
    ?>
<form method="post">
    <button name="logout" type="submit">logout</button>
</form>
<?php
}else {
    echo "hello motherfuccker";
}
?>