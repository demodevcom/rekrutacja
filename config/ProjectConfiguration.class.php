<?php


# FROZEN_SF_LIB_DIR: /var/www/production/sfweb/www/cache/symfony-for-release/1.2.7/lib

require_once dirname(__FILE__) . '/../lib/symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload :: register();

class ProjectConfiguration extends sfProjectConfiguration {
	public function setup() {
		// for compatibility / remove and enable only the plugins you want
		//$this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin'));
		$this->enableAllPluginsExcept(array (
			'sfPropelPlugin',
			'sfCompat10Plugin'
		));
		//załadowanie util'a
		require_once sfConfig::get('sf_lib_dir').'/ext/util/util.php';
		require_once sfConfig::get('sf_lib_dir').'/ext/util/html.php';
		//dla eZComponents
		//set_include_path(sfConfig::get('sf_lib_dir') . '/ext/ezcomponents/');
		//require_once sfConfig::get('sf_lib_dir'). '/ext/ezcomponents/Base/src/base.php';
		//rejestracja autoloada
		require_once sfConfig::get('sf_lib_dir') . '/ext/my.autoload.php';
		spl_autoload_register('MyAutoload::autoload');  			
	}
}