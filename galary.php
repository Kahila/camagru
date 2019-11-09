<?php
    try {
		// $conn = new mysqli("localhost", "root", "123456");
		$conn = new PDO("mysql:host=localhost;dbname=camagru", "root", "123456");
		if ($conn) echo "Connection successful <br/>";
					$query = "SELECT * FROM camagru.images";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					// $name =  ($conn->query($query));
					$count = $stmt->rowCount();
					echo "num image = " . $count . "<br/>";
					// print_r ($name->fetch_All_assoc());
					$res = $stmt->fetchAll();
					// print_r($res);
					foreach ($res as $image) {
						$ima = $image['image_name'];
						//echo "uploads/".$ima."<br>";
						echo "<html>
							<img src='uploads/$ima' legth='=30%' width='30%'></img>
						</html>
						";
					}
}catch(PDOException $ex) {
	echo "ERROR: " . $ex->getMessage() . "<br/>";
}
?>