<?php
//页面用于用户登录
//使用默认值定义两个变量
    $loggedin = false;
    $error = false;
//检查表单好是否已经提交
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	//处理表单
    	if (!empty($_POST['email']) && !empty($_POST['password'])) {
    		if ((strtolower($_POST['email']) == 'me@example.com') && ($_POST['password'] == 'testpass')) {
    			//创建cookie,3600代表一个小时之后cookie消失，用户想要重新登陆
    			setcookie('Samuel', 'Clemens', time() + 3600);
    			//标识已经登陆
    			$loggedin = true;
    		} else {//不相等
    			$error = 'The submitted email address and password do not match those o file!';
    		}
    	} else {//表单未填写完整
    		$error = 'Please make sure you enter both an email and a password!';
    	}
    }
    //设置页面标题且包含页头文件
    define('TITLE', 'Login');
    include('templates/header.html');
    //在出现错误的时候打印错误信息
    if ($error) {
    	print "<p class='color: red;'>" . $error . "</p>";
    }
    //检查用户是否已经登录，如果没有登录则显示表单
    if ($loggedin) {
    	print "<p>You are now logged in!</p>";
    } else {
    	print '<h2>Login Form</h2>
    	<form action="login.php" method="post">
    		<p><label>Email Address <input type="text" name="email" /></label></p>
    		<p><label>Password <input type="password" name="password" /></label></p>
    		<p><input type="submit" name="submit" value="Log in!"></p>
    	</form>';
    }
    include('templates/footer.html');//包含页脚文件
?>
