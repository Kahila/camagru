<?php
class User{
	private $_db;
	private $_data, $_sessionName;
	private $_isLoggedIn, $_cookieName;

	public function __construct($user = null){
		$this->_sessionName = config::get('session/session_name');
		$this->_cookieName = config::get('remember/cookie_name');
		$this->_db = DB::getInstance();

		if (!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);

				if($this->find($user)){
					$this->_isLoggedIn = true;
				}else{
					//logged out
				}
			}
		}else{
			$this->find($user);
		}
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

	public function update($fields= array(), $id = null){
		if (!$id && $this->isLoggedIn()){
			$id = $this->data()->id;
		}
		if(!$this->_db->update('users', $id, $fields)){
			//throw new Exception('unable to update please retry later.');
		}
	}

	public function create($fields){
		// print_r($fields);
		if (!$this->_db->insert('users', $fields)){
			throw new Exception('Account was not created.');
		}
	}

	public function upload_image($fields = array()){
		if (!$this->_db->insert('images', $fields)){
			throw new Exception('failed to upload image.');
		}
	}

	public function upload_comment($fields = array()){
		if (!$this->_db->insert('comments', $fields)){
			throw new Exception('failed to comment.');
		}
	}

	public function logout(){
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
		Session::delete($this->_sessionName);
		cookie::delete($this->_cookieName);
	}

	public function find($user = null){
		if($user){
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $user));

			if ($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function data(){
		return $this->_data;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function login($username = null, $password = null, $remember = false){
		if(!$username && !$password && $this->exists()){
			Session::put($this->_sessionName, $this->data()->id);
		}else{
			$user = $this->find($username);
			// print_r($this->_data);
			if ($user){
				if($this->data()->password === hash::make($password, $this->data()->salt)){
					Session::put($this->_sessionName, $this->data()->id);
					if ($remember){
						$Hash = hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if (!$hashCheck->count()){
							$this->_db->insert('users_session' ,array(
								'user_id' => $this->data()->id,
								'hash' =>$Hash
							));
							//redirect::go_to('register.php');
						}else{
							$Hash = $hashCheck->first()->hash;
						}

						cookie::put($this->_cookieName, $Hash, config::get('remember/cookie_expiry'));
					}
					return true;
				}
			}
		}
		return false;
	}
}