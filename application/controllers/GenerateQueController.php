<?php

class GenerateQueController extends Zend_Controller_Action
{
	private $session;

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
	
	public function printQue($que)
	{
		echo "<br>name		d		w		isOnTime";
		$locs = $que->loc;
		foreach($locs as $q)
		{
			$bookedBy = $q->isBookedBy();
			try{
			if(!isset($bookedBy))
				throw new Exception('Division by zero.');
			else
				echo "<br>".$bookedBy->name()."		".$bookedBy->d(),"		".$bookedBy->w()."		".$bookedBy->isOnTime();
			} catch(Exception $e)
			{
				echo "<br>no task";
			}
		}
	}
	
	public function generateTasksFrom($que)
	{
		$tasks = array();
		$i = 0;
		$locs = $que->loc;
		foreach($locs as $q)
		{
			$bookedBy = $q->isBookedBy();
			try{
			if(!isset($bookedBy))
				throw new Exception('Division by zero.');
			else
				$tasks[$i++]=$bookedBy;
			} catch(Exception $e)
			{
			}
		}
		return $tasks;
	}
	
	public function sortTasksAsc($tasks)
	{
		$size = count($tasks);
		$sorted = array();
		
		while(!empty($tasks))
		{
			$max = -1; $flag=0;$i=0;
			
			foreach($tasks as $task)
			{
				if($task->d()>$max)
				{
					$max = $task->d();
					$flag = $i;
				}
				$i++;
			}
			
			//echo "greatest = $max at $flag<br>";
			array_push($sorted,$tasks[$flag]);
			$tasks[$flag] = $tasks[count($tasks)-1];
			array_pop($tasks);
		}
		return array_reverse($sorted);
	}
	
	public function generatePendingTasks($tasks)
	{
		$retTasks = array();
		foreach($tasks as $task)
		{
			if(!$task->isOnTime())
				array_push($retTasks, $task);
		}
		
		return $retTasks;
	}
	
	public function indexAction()
    {
		session_start();
		
		//receiving tasks
		$tasks = unserialize($_SESSION['tasks']);
		//initializing que
		$que = new Que($tasks);
		$qSize = $que->printSize(false);		$this->view->qSize = $qSize;
		$tSize = count($tasks);				$this->view->tSize = $tSize;
		
		//scheduling independant sets for possible ontime tasks
		$tPtr = 0;
		$qPtr = 0;
		
		$shift = 1;;
		while($tPtr < $tSize)
		{
			if(!$tasks[$tPtr]->isScheduled())
			{	
				$qPtr = $tasks[$tPtr]->d() - $shift;
				if($qPtr < 0)
				{
					$tPtr++;
					$shift = 1;
					continue;
				}
				if(!$que->loc[$qPtr]->isBooked())
				{
					$pos = $qPtr+1;
					//echo "loc $pos is free......booking for {$tasks[$tPtr]->name()}<br>";
					$que->loc[$qPtr]->booking($tasks[$tPtr]);
					$tasks[$tPtr]->schedule($pos);
				}
				else
				{
					$shift++;
					continue;
				}
			}
			$tPtr++;
			$shift = 1;
		}
		
		//echo "<br />";
		//echo "<br />OnTIME TASK<br />";
		//$this->printQue($que);
		$this->view->onTimeQue = $que;
		
		//sorting non-scheduled task in ascending order of their time
		$pendingTasks = $this->generatePendingTasks($tasks);		$this->view->pendingTasks = $pendingTasks;
		//echo "<br />";
		//echo "<br />PENDING TASK<br />";
		//$this->printAll($pendingTasks);
		//sorting Unscheduled task list in ascending order of deadline
		$pendingTasksSorted = $this->sortTasksAsc($pendingTasks);
		//echo "<br />";
		//echo "<br />PENDING TASK SORTED<br />";
		//$this->printAll($pendingTasksSorted);
		$this->view->pendingTasksSorted = $pendingTasksSorted;
		
		//scheduling pending tasks
		$tPtr = 0;
		$qPtr = 0;
		$pendingTasks = $pendingTasksSorted; //renaming
		
		 $qSize = $que->printSize(false);
		 $tSize = count($pendingTasks);
		
		$shift = 0;
		while($tPtr < $tSize)
		{
			if(!$pendingTasks[$tPtr]->isScheduled())
			{	
				$qPtr = $pendingTasks[$tPtr]->d() + $shift;
				if(!$que->loc[$qPtr]->isBooked())
				{
					$pos = $qPtr+1;
					//echo "loc $pos is free......booking for {$pendingTasks[$tPtr]->name()}<br>";
					$que->loc[$qPtr]->booking($pendingTasks[$tPtr]);
					$pendingTasks[$tPtr]->schedule($pos);
				}
				else
				{
					$shift++;
					continue;
				}
			}
			$tPtr++;
			$shift = 0;
		}
		
		//echo "<br />";
		//echo "<br />OffTIME TASK<br />";
		//$this->printQue($que);
		$this->view->finalQue = $que;
		
		return;
    }
}


