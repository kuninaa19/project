<?php
session_start();
session_destroy();
unset($_COOKIE["chat"]);
setcookie('chat', null, -1, '/');
if (isset($_COOKIE["id"]) || isset($_COOKIE["nickname"])) {
    unset($_COOKIE["id"]);
    unset($_COOKIE["nickname"]);
    setcookie('id', null, -1, '/');
    setcookie('nickname', null, -1, '/');

}
?>
<meta http-equiv="refresh" content="0;url=../index.php"/>