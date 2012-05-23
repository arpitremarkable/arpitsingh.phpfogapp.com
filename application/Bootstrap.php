<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	function _initAutoload()
	{
		 Zend_Loader_Autoloader::getInstance()->registerNamespace('Me_');
	}
}

