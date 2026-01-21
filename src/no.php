<?php // minimal lowlevel underlying api

	//function unss($txt) { return preg_replace('/[^a-zA-Z0-9]+/', '_', $txt); } // no lowercase
	function unss($txt) { return preg_replace('/[^a-z0-9]+/', '_', strtolower($txt)); } // only lowercase
	
	function npre($txt, $pre = 'data/', $iferror = FALSE) { if (substr($txt, 0, strlen($pre)) == $pre) return substr($txt, strlen($pre)); else return $iferror; }
	function nsux($txt, $ext = '.data', $iferror = FALSE) { if (substr($txt, -strlen($ext)) == $ext) return substr($txt, 0, -strlen($ext)); else return $iferror; }

	// on this level, tables and indexes eq folders, rows and index entries eq files and data can be serialized both on native/json/other encodings
	function encc($txt) { return json_encode($txt); }
	function decc($txt) { return json_decode($txt); } 
	
	function demo() {
		
		// example: get all entries for users table, ascending order
		echo("\n\nEXAMPLE: GET ALL ROW ENTRIES\n---------------------------------\n");
		$userfns = glob('users/*.user');
		
		// example: get all entries for users table email field index, descending order
		echo("\n\nEXAMPLE: GET ALL INDEX ENTRIES\n---------------------------------\n");
		$emailfns = glob('users/*.email', GLOB_NOSORT);
		
		// example: get all fields for the row for a particular $username
		echo("\n\nEXAMPLE: GET ROW DATA FOR A PARTICULAR USER ENTRY\n---------------------------------\n");
		$username = npre(nsux($userfns[0], '.user'), 'users/');
		var_export($username); echo("\n\n");
		$user_data = decc(file_get_contents('users/' . unss($username) . '.user'));
		var_export($user_data);
		
		// example: list all rows for users table, by creation date
		echo("\n\nEXAMPLE: GET ALL ROWS DATA FOR USERS TABLE\n---------------------------------\n");
		$userfns = glob('users/*.user');
		foreach ($userfns as $userfn) {
			$user_data = decc(file_get_contents('users/' . npre(nsux($userfn, '.user'), 'users/') . '.user'));  
			var_export($user_data);
		}
		
		// example: retrieve an user by $email
		echo("\n\nEXAMPLE: GET A ROW DATA BY ITS EMAIL USING INDEX\n---------------------------------\n");
		//$email = 'your@email.com';
		//$index_data = decc(file_get_contents('users/' . unss($email) . '.email'));
		//$primary_key = $index_data['p'];
		//$user_data = decc(file_get_contents('users/' . unss($primary_key) . '.user'));
		//var_export($user_data);
		
		// example: insert/update a row
		echo("\n\nEXAMPLE: INSERT OR UPDATE A ROW IN THE TABLE\n---------------------------------\n");
		//$p = 'yourusername'; $email = 'your@email.com';
		//file_put_contents('users/' . unss($p) . '.user', encc(array('username' => $p, 'email' => $email, 'otrodato' => '...'))); // write row
		//file_put_contents('users/' . unss($email) . '.email', encc(array('p' => $p))); // write index
		
		// example: delete an entry and its index email entry
		echo("\n\nEXAMPLE: REMOVE THE PREVIOUS ENTRY FROM THE TABLE\n---------------------------------\n");
		//$primary_key = 'yourusername'; $email = 'your@email.com';  
		//unlink('users/' . unss($primary_key) . '.user');
		//unlink('users/' . unss($email) . '.email');
		
	} demo();