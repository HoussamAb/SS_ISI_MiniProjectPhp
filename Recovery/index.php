<?php
session_start();

if(isset($_SESSION["recover_email_sent"]))
{
    include "submitcode.php";
}elseif(isset($_SESSION["recover_email"]))
{
    include "accountrecover.php";
}elseif (isset($_SESSION["user"]))
{
    include "passwordchange.php";
}else{
?>
    <form>
entrez votre email : <input name="email"/>
        <br>
entrez votre login : <input name="login"/>
    </form>
<?php } ?>
