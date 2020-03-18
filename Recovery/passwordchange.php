<?php
if(!isset($_SESSION))
{
    session_start();
}
if ($_POST && $_POST["token"]==$_SESSION["token"]){
    $new = $_POST["newpassword"];
    $confnew = $_POST["confirmenewpassword"];
    if(($_POST["lastpassword"] == $new)){
        echo "new password should be different from old one !";
    }else if($new == $confnew)
    {
        $last = md5(hash("haval160,4",sha1($_POST["lastpassword"])));
        require "../config.php";
        $qury =$db->prepare("select count(*) from user where username=? and password=?");
        $qury->bind_param("ss",$_SESSION["user"],$last);
        $qury->execute();
        $result = $qury->get_result();
        $count = $result->fetch_row();
        if($count[0]==1)
        {
            if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/",$new))
            {
                $new = md5(hash("haval160,4",sha1($new)));

                $qury =$db->prepare("update user set password=? where username=?;");
                $qury->bind_param("ss",$new,$_SESSION["user"]);
                $qury->execute();
                session_destroy();
                header("location:../Login/");
            }else{
                echo "The password string will start this way
                password must contain at least 1 lowercase alphabetical character
                <br> at least 1 uppercase alphabetical character
                <br> at least 1 numeric character
                <br> must be eight characters or longer";
            }
        }else{
            echo "Old Password is wrong !";
        }
    }else {
        echo "new password confirmation doesn't match";
    }
}
require "../csrfgenerator/gentoken.php";

?>
<form action="passwordchange.php" method="post">
    Old password : <input name="lastpassword" /><br>
    new password : <input name="newpassword" /><br>
    confirm new password : <input name="confirmenewpassword" /><br>
    <input type="hidden" name="token" value="<?php echo $_SESSION["token"]?>" /><br>
    <button type="submit"> save changes </button>
</form>
