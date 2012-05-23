<?php

class Task
{
	public $name;
	
	protected $d;
	
	protected $w;
	
	protected $pos;
	
	protected $scheduled;
	
	protected $onTime;
	
	public function __construct($name=NULL, $d=NULL, $w=NULL)
	{
		$this->name = $name; 
		$this->d = $d; 
		$this->w = $w;
		$this->scheduled = false;
		$this->scheduled = false;
	}
	
	public function printAll()
	{
		//echo "starting to print\n";
		
		echo $this->name."\n";
		echo $this->d."\n"; 
		echo $this->w."\n<br>";
	}
	
	public function name()
	{
		return $this->name;
	}
	
	public function w()
	{
		return $this->w;
	}
	
	public function d()
	{
		return $this->d;
	}
	
	public function pos()
	{
		return $this->pos;
	}
	
	public function isOnTime()
	{
		return $this->onTime;
	}
	
	public function isScheduled()
	{
		return $this->scheduled;
	}
	
	public function schedule($pos)
	{
		$this->scheduled = true;
		$this->pos = $pos;
		if($this->d() >= $pos)
			$this->onTime = true;		
			
	}
}

