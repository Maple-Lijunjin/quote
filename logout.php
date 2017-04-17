<?php
//登出页面，会删除cookie
//如果cookie存在，则删除
    if (isset($_COOKIE['Samuel'])) {
    	setcookie('Samuel', FALSE, time() - 300);
    }
    //定义页面标题并且包含页头文件
    define('TITLE', 'Logout');
    include('templates/header.html');
    //打印一条消息
    print "<p>You are now Logged out!</p>";
    //包含页脚文件
    include('templates/footer.html');
?>