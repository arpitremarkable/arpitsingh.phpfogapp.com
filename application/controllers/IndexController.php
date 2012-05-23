<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		include_once("/../../library/Task.php");
		include_once("/../../library/Que.php");
    }

    public function indexAction()
    {
    }

}







