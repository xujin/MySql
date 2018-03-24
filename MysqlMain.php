<?php
	include_once ('MysqlManager.php');

	function test_database()
	{
		$mysqlmanager = new MysqlManager();
		$mysqlmanager->connect_database();
		$mysqlmanager->create_table();
		$mysqlmanager->query_datas();
		$mysqlmanager->close_database();

	}


	test_database();
	
?>