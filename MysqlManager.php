<?php

	header("content-type:text/html;charset=utf-8"); 
	class MysqlManager{
		var $db_handle;
		var $db_name;



		function __construct() 
		{
	       	print "构造函数\n";
	       	$this->db_name="hello";
	   	}

	   	function setDb_handle($dbhandle)
	   	{
	   		$this->db_handle = $dbhandle;
	   	}

	   	function getDb_handle()
	   	{
	   		return $this->db_handle;
	   	}

	   	function __destruct() 
	   	{
	       print "销毁 " . $this->name . "\n";
	   	}

		public function connect_database()
		{
			$dbhost = 'localhost:3306';	// mysql服务器主机地址
			$dbuser = 'root';			// mysql用户名
			$dbpass = 'xujin9527';		// mysql用户名密码
			 
			// 创建连接
			$db_handle = mysqli_connect($dbhost, $dbuser, $dbpass);
			$this->setDb_handle($db_handle);
			 
			// 检测连接
			if ($db_handle->connect_error)
			{
			    die('Could not connect: ' . mysqli_error());
			} 
			echo "连接成功";
			// 设置编码，防止中文乱码
			mysqli_query($db_handle , "set names utf8");
			$sql = 'CREATE DATABASE IF NOT EXISTS RUNOOB DEFAULT CHARSET utf8 COLLATE utf8_general_ci;';
			$retval = mysqli_query($db_handle, $sql);
			if(! $retval )
			{
			    die('创建数据库失败: ' . mysqli_error($db_handle));
			}
			echo "数据库 RUNOOB 创建成功\n";
		}


		public function close_database()
		{
			mysqli_close($this->db_handle);
		}

		public function create_table()
		{
			$sql = "CREATE TABLE IF NOT EXISTS runoob_tbl( ".
		        "runoob_id INT NOT NULL AUTO_INCREMENT, ".
		        "runoob_title VARCHAR(100) NOT NULL, ".
		        "runoob_author VARCHAR(40) NOT NULL, ".
		        "submission_date DATE, ".
		        "PRIMARY KEY ( runoob_id ))ENGINE=InnoDB DEFAULT CHARSET=utf8; ";


			mysqli_select_db( $this->db_handle, 'RUNOOB' );
			$retval = mysqli_query( $this->db_handle, $sql );
			if(! $retval )
			{
			    die('数据表创建失败: ' . mysqli_error($this->db_handle));
			}
			echo "数据表创建成功\n";
		}

		public function insert_datas()
		{
			
			$runoob_title = '学习 C++';
			$runoob_author = 'Github.COM';
			$submission_date = '2018-07-06';
			 
			$sql = "INSERT INTO runoob_tbl ".
			        "(runoob_title,runoob_author, submission_date) ".
			        "VALUES ".
			        "('$runoob_title','$runoob_author','$submission_date')";

			$retval = mysqli_query( $this->db_handle, $sql );
			if(! $retval )
			{
			  	die('无法插入数据: ' . mysqli_error($this->db_handle));
			}
			echo "数据插入成功\n";
		}
	}
?>