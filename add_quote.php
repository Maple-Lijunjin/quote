<?php
/*脚本添加名人名言*/
//定义页面标题并且包含页头文件
    define('title', 'Add a Quote');
    include('templates/header.html');
    print "<h2>Add a Quotation</h2>";
    //强制只有管理员才可以访问该页面
    if (!is_administrator()) {
    	print "<h2>Access Denied!</h2><p class='error'>You do not have the permission to access this page. </p>";
    	include('templates/footer.html');
    	exit();
    }
    //检查表单是否提交
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    	if (!empty($_POST['quote']) && !empty($_POST['source'])) {
    		//包含数据库连接
    		include('includes/mysql_con.php');
    		//准备查询中使用的值:mysql_real_escape_string()代表转义SQL 语句中使用的字符串中的特殊字符
    		$quote = mysql_real_escape_string(trim(strip_tags($_POST['quote'])), $dbc);
    		$source = mysql_real_escape_string(trim(strip_tags($_POST['source'])), $dbc);
    		//创建favorite值
    		if (isset($_POST['favorite'])) {
    			$favorite = 1;
    		} else {
    			$favorite = 0;
    		}
    		$query = "INSERT INTO quotes (quote, source, favorite) VALUES ('$quote', '$source', '$favorite')";
    		$r = mysql_query($query, $dbc);
    		if (mysql_affected_rows($dbc) == 1) {
    			print '<p>Your quotation has been stored.</p>';
    		} else {
    			print '<p class="error">Could not store the quote because:<br/>' . mysql_error($dbc) . '.</p><p>The query being run was :' . $query . '</p>';
    		}
    		//关闭连接
    		mysql_close($dbc);
    	} else {//没有填写名人名言
    		print '<p class="error">Please enter a quotation and a source!</p>';

    	}
    }
    
?>
<form action="add_quote.php" method="post">
	<p><label>Quote<textarea name="quote" rows="5" cols="30"></textarea></label></p>
	<p><label>Source<input type="text" name="source" /></label></p>
	<p><label>Is this a favorite? <input type="checkbox" name="favorite" value="yes" /></label></p>
	<p><input type="submit" name="submit" value="Add This Quote!" /></p>
</form>