<?php
class MyAutoload {
	static public function autoload($className) {
		$directorys = array (
			sfConfig :: get('sf_lib_dir') . '/ext/validation/',
			sfConfig :: get('sf_lib_dir') . '/ext/util/',
			//sfConfig :: get('sf_lib_dir') . '/ext/ezcomponents/',
			sfConfig :: get('sf_lib_dir') . '/ext/validators/',			
			'./'
		);
		//ezcBase :: autoload( $className );
		foreach ($directorys as $directory) {
			//see if the file exsists
			if (file_exists($directory . $className . '.php')) {
				require_once ($directory . $className . '.php');			
				//only require the class once, so quit after to save effort (if you got more, then name them something else
				return true;
			}		
			/*if (file_exists($directory . $className . '.class.php')) {
				require_once ($directory . $className . '.class.php');			
				//only require the class once, so quit after to save effort (if you got more, then name them something else
				return true;
			}*/		
		}	
	}
}