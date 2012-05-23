<?php

Class Memory
{
	protected $booked;
	
	protected $bookedBy;
	
	public function __construct($booked = false, $bookedBy = Null)
	{
		$this->booked = $booked;
		$this->bookedBy = $bookedBy;
	}
	
	public function isBooked()
	{
		return $this->booked;
	}
	
	public function isBookedBy()
	{
		return $this->bookedBy;
	}
	
	public function booking($task)
	{
		$this->bookedBy = $task;
		$this->booked = true;
	}
	
}

class Que
{
	protected $size;
	
	public $loc;
	
	public function __construct($tasks=0)
	{
		if(is_array($tasks))
		{		
			$size = count($tasks);
			
			$max = -1;
			foreach($tasks as $task)
			{
				if($task->d()>$max)
					$max = $task->d();
			}
			$max>$size ? $this->size = $max : $this->size = $size ;
		}
		else
		{
			$this->size = $tasks;
		}
		
		$this->loc = array();
		$this->assignLoc();
	}
	
	private function assignLoc()
	{
		for($i = 0;$i < $this->size;$i++)
		{
			$this->loc[$i] = new Memory();
		}
	}
	
	public function printSize($flag=true)
	{
		if($flag==true)  
		print($this->size);
		else
		return($this->size);
	}
}

