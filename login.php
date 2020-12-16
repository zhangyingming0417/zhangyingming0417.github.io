
	<head>
		<meta charset="utf-8">
		<title></title>
		<style>
		.login-container{
			background-color: #2b4b6b;
			height: 100%;
		}
		.login_box{
			width: 450px;
			height: 300px;
			background-color:#99CCCC;
			
			border-radius: 3px;
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%,-50%);
		
		}
			.avatar_box{
				height: 130px;
				width: 130px;
				border:1px solid #eee;
				border-radius:50%;
				padding: 10px;
				box-shadow: 0 0 10px #ddd;
				position: absolute;
				left: 50%;
				transform: translate(-50%,-50%);
				background-color: #FFFFFF;
			}
			img{
					width: 100%;
					height: 100%;
					border-radius:50%;
					background-color: #EEEEEE;
				}
				.form{
					position: absolute;
					top: 30%;
					left: 25%;
				
				
				}
				input{
					
                border: 1px solid #ccc; 
                padding: 7px 0px;
                border-radius: 3px; 
                padding-left:5px; 
            
				}
				.btn1{
					border:1px solid #99CCFF ;
					
					border-radius: 3px;
					 height: 35px;
					 width: 50px;
					 
					 font-weight: bold;
					position: absolute;
					 background-color: #99CCFF;
					  top: 90%;
					left: 20%;
				}
					
				.btn2{
					border:1px solid #99CCFF ;
					
					border-radius: 3px;
					 height: 35px;
					 width: 50px;
					 
					 font-weight: bold;
					position: absolute;
					 background-color: #99CCFF;
					 top: 90%; 
					right: 10%;
				}
				.font{
					font-size: 1rem;
					font-weight: bold;
				}
		</style>
		
	</head>
	<body>
	
  <div class="login-container">
 <div class="login_box">
	 <!-- 头像-->
	 <div class="avatar_box">
		 <img src="./images/座椅.jpg" alt="" />
		     
	 </div>
	 <div class="form">
	 	<form action="" method="post">
	 				<table >
	 					
	 					<tr>
	 						<td class="font">负责人</td>
	 						<td><input type="text" name="username"  /></td>
	 					</tr>
	 					<tr>
	 						<td class="font" >账&nbsp;&nbsp;&nbsp;号</td>
	 						<td><input type="text" name="userid" />
	 					<tr>
	 						<td class="font" >密&nbsp;&nbsp;&nbsp;码</td>
	 						<td><input type="password" name="password" /></td>
	 					</tr>
						<tr>
							<td colspan="2" >
								<div class="btn ">
								<input type="submit" name="sub" value="登录"  class="btn1"/>
								<input type="reset" name="res" value="重置"   class="btn2"/>
								</div>
							</td>
								
						</tr>
	 		
	 		</table>
	 	</form>
	 	
	 </div>
 </div>
  <!-- 登录表单-->

 

  </div>
<?php
header("Content-type:text/html;charset=UTF-8");
session_start();
$username=@$_POST['username'];						
$userid=@$_POST['userid'];
$password=@$_POST['password'];						

function loadinfo()
{
	$user_array=array();
	$filename='info.txt';						
	$fp=fopen($filename,"r");						
	$i=0;
	while($line=fgets($fp,1024))					
	{
		list($user,$userid,$pwd)=explode('|',$line);				
		$user1=trim($user);						
		$userid1=trim($userid);
		$pwd1=trim($pwd);						
		$user_array[$i]=array($user1,$userid1,$pwd1);			
		$i++;
	}
	fclose($fp);
	return $user_array;	
						
}
$user_array=loadinfo();	
	print_r($user_array);
if(isset($_POST['sub']))										
{
	
	if(!in_array(array($username,$userid,$password),$user_array))
		echo "<script>alert('负责人、账号或密码错误!请重新输入!');location='login.php';</script>";
	else
	{
		foreach($user_array AS $value)				
		{
			list($user,$id,$pwd)=$value;
			if($user==$username&&$pwd==$password&&$id=$userid)
			{
			
				$_SESSION['username']=$username; 
				$_SESSION['password']=$password;
				header("Location:index.php"); 
				echo "<br>";
			}
		}
	}
}
?>
 




	</body>




