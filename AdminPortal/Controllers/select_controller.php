<?php
	class DBController 
	{
		//   private $host = "localhost";
		//   private $user = "root";
		//   private $password = "";
		//   private $database = "db_prime_it";

		  private $host = "localhost";
		  private $user = "mvbqglsbvy_user_prime_it";
		  private $password = "Au?KxTK4aK2t3P^L";
		  private $database = "mvbqglsbvy_db_prime_it";
		  private $conn;

		function __construct() 
		{
			$this->conn = $this->connectDB();
		  }

		  function connectDB() 
		{
			$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
			return $conn;
		  }

		function runQuery($query) 
		{
			$result = mysqli_query($this->conn,$query);
			while($row=mysqli_fetch_assoc($result)) 
			{
				$resultset[] = $row;
			}   
			if(!empty($resultset))
			return $resultset;
		  }
	}

?>
