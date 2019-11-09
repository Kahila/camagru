<!-- data base rapper working with pdo (php data objects) -->
<!-- can be used outside of this application -->
<?php
// require_once 'config.php';
// echo "outside....";

// $name = config::get("mysql/password");
// print_r($name);
class DB{
	private static $_instance = null;
	private $_pdo,
			$_query, //the last quary parsed
			$_error = false,
			$_results,
			$_count = 0;
	//constructor
	private function __construct(){
			try{
				//connection to database
				//echo "befor trying......";
				$this->_pdo = new PDO('mysql:host='.config::get('mysql/host').';port=8080;dbname='.config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));
				//echo 'connected....';
			}catch(PDOException $e){
				//echo " caught.....";
				die($e->getMessage());
			}
		}

		public static function getInstance(){
			if (!isset(self::$_instance)){
				self::$_instance = new DB();
				//echo "in here";
			}
			return self::$_instance;
		}

		public function query($sql, $params = array()){
			$this->_error = false;//reseting the ereror
			if ($this->_query = $this->_pdo->prepare($sql)){
				$x = 1;
				if (count($params)){
					foreach ($params as $param) {
						$this->_query->bindValue($x, $param);
						$x++;
					}
					//echo $this->_query;
				}if ($this->_query->execute()){
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
					//print $this->_query->fetchAll(PDO::FETCH_OBJ);
					//$this->_count = 1;
				//echo $this->_count.".....success....x=$x.....";
				}else{
					//echo "....error...";
					$this->_error = true;
				}
			}
			//echo "here>>>>>>";
			return $this;
		}

		public function insert($table, $fields = array()){
			if (count($fields)){
				$keys = array_keys($fields);
				$values = null;
				$x = 1;

				foreach ($fields as $field) {
					$values .= '?';
					if($x < count($fields)){
						$values .= ', ';
					}
					$x++;
				}

				//die($values);
				$sql = "INSERT INTO {$table} (`" .implode('`, `', $keys) . "`) VALUES ({$values})";
				//print_r($fields);
				if (!$this->query($sql, $fields)->error()){
					//echo "success";
					return true;
				}
				echo $sql;
				return false;
			}
		}

		public function action($action, $table, $where = array()){
			//echo "outside";
			if (count($where) === 3){
				$operators = array('=', '>', '<', '>=', '<=');

				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];

				if (in_array($operator, $operators)){
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
					if (!$this->query($sql, array($value))->error()){
						return $this;
					}
				}
			}
			
			return false;
		}

		public function update($table, $id, $fields){
			$set = '';
			$x = 1;
			foreach ($fields as $name => $value) {
				$set .= "{$name} = ?" ;
				if ($x< count($fields)){
					$set .= ', ';
				}
				$x++;
			}
			// die ($set);
			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
			//echo $sql;
			if ($this->query($sql, $fields)->error()){
				return true;
			}
			return false;
		}

		public function results(){
			return $this->_results;
		}

		public function first(){
			return $this->results()[0];
		}

		public function get($table, $where){
			//echo "here";
			return $this->action('SELECT *', $table, $where);
		}

		public function delete($table, $where){
			return $this->action('DELETE', $table, $where);
		}

		public function error(){
			return $this->_error;
		}

		public function count(){
			return $this->_count;
		}
}