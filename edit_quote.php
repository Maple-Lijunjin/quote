<?php
/*脚本编辑名人名言*/
//定义页面标题并且包含文件
define('TITLE', 'Edit Quote');
include('templates/header.html');
print '<h2>Edit a Quotation</h2>';
//强制只有管理员才可以登录该页面
if (!is_administrator()) {
	print '<h2>Access Denied!</h2>
    <p class="error">You do not have the permission to access this page.</p>';
	include('templates/footer.html');
	exit();
}
//包含数据库连接
include('includes/mysql_con.php');
if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {//验证表单是否收到数值型的值
	//Display the entry in a form
	//定义查询
	$query = "SELECT quote, source, favorite FROM quotes WHERE quote_id={$_GET['id']}";
	if ($r = mysql_query($query, $dbc)) {//运行查询
		$row = mysql_fetch_array($r);//返回信息
		//创建表单，用htmlentities()以确保安全
		print '<form action="edit_quote.php" method="post">
		<p><label>Quote <textarea name="quote" rows="5" cols="30"> ' . htmlentities($row['quote']) . '</textarea></label></p>
		<p><label>Source <input type="text" name="source" value="' . htmlentities($row['source']) . '" /></label></p>
		<p><label>Is this a favorite? <input type="checkbox" name="favorite" value="yes"';
    //检查是否选中受欢迎复选框
			if ($row['favorite'] == 1) {
				print 'checked="checked"';
			}
    //完成表单
			print ' /></label></p>
			<input type="hidden" name="id" value="' . $_GET['id'] . '" />
			<p><input type="submit" name="submit" value="Update This Quote!" /></p>
		</form>';
	} else {//无法获取信息
		print '<p class="error">Could not retrieve the quotation because :<br/> ' . mysql_error($dbc) . '.</p><p>
		The query being run was: ' . $query . '</p>';
	}
} elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0)) {//处理表单
	//验证表单数据并确保安全；
	$problem = FALSE;
	if (!empty($_POST['quote']) && !empty($_POST['source'])) {
		//准备查询中使用的值,mysql_real_escape_string()转义 SQL 语句中使用的字符串中的特殊字符
		$quote = mysql_real_escape_string(trim(strip_tags($_POST['quote'])), $dbc);
		$source = mysql_real_escape_string(trim(strip_tags($_POST['source'])), $dbc);
		//创建favorite值
		if (isset($_POST['favorite'])) {
			$favorite = 1;
		} else {
			$favorite = 0;
		}
	} else {
		print '<p class="error">Please submit both a quotation and a source.</p>';
		$problem = TRUE;
	}
	//如果没问题则更新数据库
	if (!$problem) {
		//定义查询，$favorite是数值所以不用引号
		$query = "UPDATE quotes SET quote='quote', source='$source', favorite=$favorite WHERE quote_id={$_POST['id']}";
		if ($r = mysql_query($query, $dbc)) {
			print '<p>The quotation has been updated.</p>';
		} else {
			print '<p class="error">Could not update the quotation because:<br/>' . mysql_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
		}
	}//一切正常
} else {//没有获取id
	print '<p class="error">This page has been accessed in error.</p>';
}//结束主条件语句
mysql_close($dbc);
include('templates/footer.html');
?>
