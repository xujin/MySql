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
		public function query_datas()
		{
			$conn = $this->db_handle;
			mysqli_query($conn, "set name utf8");
			// $sql = 'SELECT runoob_id,runoob_title,runoob_author,submission_date FROM runoob_tbl';
			// 读取 runoob_author 为 RUNOOB.COM 的数据
			$sql = 'SELECT runoob_id, runoob_title, 
			        runoob_author, submission_date
			        FROM runoob_tbl
			        WHERE runoob_author="RUNOOB.COM"';
			mysqli_select_db( $conn, 'RUNOOB' );
			$retval = mysqli_query( $conn, $sql );
			if(! $retval )
			{
			    die('无法读取数据: ' . mysqli_error($conn));
			}
			
			// while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			// while($row = mysqli_fetch_assoc($retval))
			// {
			//     echo "\n {$row['runoob_id']} {$row['runoob_title']}  {$row['runoob_author']}  {$row['submission_date']}";
			// }


			while($row = mysqli_fetch_array($retval, MYSQLI_NUM))
			{
			    echo "\n {$row['0']} {$row['1']}  {$row['2']}  {$row['3']}";
			}
			echo "\n";
			// 释放内存

			mysqli_free_result($retval);

		}
		public function sql_set()
		{
			$sql = 'UPDATE runoob_tbl
		        SET runoob_title="Python 教程"
		        WHERE runoob_id=6';
		    $sql = 'DELETE FROM runoob_tbl WHERE runoob_id=3';

		    // runoob_tbl 表中读取 runoob_author 字段中以 COM 为结尾的的所有记录：
		    $sql = 'SELECT runoob_id, runoob_title, 
		        runoob_author, submission_date
		        FROM runoob_tbl
		        WHERE runoob_author LIKE "%COM"';

		    // 查询后的数据按 submission_date 字段的降序排列后返回
		    $sql = 'SELECT runoob_id, runoob_title, 
		        runoob_author, submission_date
		        FROM runoob_tbl
		        ORDER BY  submission_date ASC';

		    // 将数据表按名字进行分组，并统计每个人有多少条记录
		    $sql = 'SELECT name, COUNT(*) FROM   employee_tbl GROUP BY name';
		}
	}
?>