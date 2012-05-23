<?php

class GenerateTaskController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
		include_once("/../../library/Task.php");
		include_once("/../../library/Que.php");
    }
	
	public function printAll($tasks)
	{
		foreach($tasks as $s)
		{
			$s->printAll();
		}
	}
	
	public function sortTask($tasks)
	{
		$size = count($tasks);
		$sorted = array();
		
		while(!empty($tasks))
		{
			$max = -1; $flag=0;$i=0;
			
			foreach($tasks as $task)
			{
				if($task->w()>$max)
				{
					$max = $task->w();
					$flag = $i;
				}
				$i++;
			}
			
			//echo "greatest = $max at $flag<br>";
			array_push($sorted,$tasks[$flag]);
			$tasks[$flag] = $tasks[count($tasks)-1];
			array_pop($tasks);
		}
		return $sorted;
	}

    public function indexAction()
    {
		$details = array(names=>"arpit,hey,t3,t4,t5",ds=>"4,4,2,1,2",ws=>"2,3,6,1,3");
		$details = array(names=>"t1,t2,t3,t4,t5,t6,t7",ds=>"1,1,3,3,2,2,6",ws=>"6,7,2,1,4,5,1");
		$details = array(names=>"t1,t2,t3,t4,t5,t6,t7",ds=>"4,2,4,3,1,4,6",ws=>"70,60,50,40,30,20,10");
		$details = array(names=>"t1,t2,t3,t4",ds=>"1,3,5,2",ws=>"2,4,2,3");
		$details = array(names=>"t1,t2,t3,t4,t5,t6,t7,t8,t9,t10",ds=>"1,3,5,2,9,2,7,3,2,1",ws=>"2,4,2,3,1,8,3,6,8,2");
		$details = array(names=>"t1,t2,t3,t4,t5,t6,t7",ds=>"4,2,4,3,1,4,6",ws=>"70,60,50,40,30,20,10");
		$details = $_POST;
		
		//exploode strings
		$names = explode(",", $details['names']);
		$ds = explode(",", $details['ds']);
		$ws = explode(",", $details['ws']);
		
		//generate task object
		$tasks = array();
		$i=0;
		while($names[$i])
		{
			$tasks[$i] = new Task($names[$i], $ds[$i], $ws[$i]);
			$i++;
		}

		//Tasks pre ordering
		//$this->printAll($tasks);
		$this->view->tasksUnSorted = $tasks;
		
		//sort in increasing order of weight
		$tasks = $this->sortTask($tasks);
		
		session_start();
		$_SESSION['tasks'] = serialize($tasks);
		
		//Tasks post ordering ~ Descending Weight
		//$this->printAll($tasks);
		$this->view->tasksSorted = $tasks;

		
    }


}

