<?php
//函数检查用户是否为管理员
//接受两个可选参数
//返回一个布尔类型
function is_administrator($name = 'Samuel', $value = 'Clemens') {
	//检查cookie是否存在以及cookie值
	if (isset($_COOKIE[$name]) && ($_COOKIE[$name] == 'Clemens')) {
		return true;
	} else {
		return false;
	}
}
?>