<?php
/***
* ZERO™ Library is a vanilla, evolving collection for developing solutions using web technology
* Originator → Anthony Osawere - @iamodao - www.osawere.com | AO™ © 2022 | Apache License
* ============================================================================================
* SpetX ~ SPET Utility • VERSION » alpha-0.0.7 ***/

class SpetX {
	private $tags = array();
	private $content;





	//*----------- CONSTRUCT -----------*//
	public function __construct($file=''){
		if(!empty($file)){
			$this->content = $this->content($file);
		}
	}




	//*----------- SET CONTENT -----------*//
	public function setContent($content=''){
		if(!empty($content)){
			$this->content = $content;
		}
	}





	//*----------- CONTENT -----------*//
	public function content($file){
		if(is_file($file)){
			return file_get_contents($file);
		}
		else {
			exit('Unavailable File: ['.$file.']');
		}
	}





	//*----------- TAG -----------*//
	public function Tag($name, $value){
		$this->tags[$name] = $value;
		return true;
	}





	//*----------- TAGS -----------*//
	public function Tags($tags){
		if(is_array($tags)){
			foreach($tags as $name => $value){
				$this->Tag($name, $value);
			}
		}
		return true;
	}





	//*----------- SWAP TAG -----------*//
	private function swapTag(){
		foreach ($this->tags as $name => $value) {
			$this->content = str_replace('{'.$name.'}', $value, $this->content);
		}
		return true;
	}





	//*----------- DISPLAY -----------*//
	public function display($file=''){
		if(!empty($file)){$this->content = $this->content($file);}
		if(empty($this->content)){
			//TODO: Error - Content Required
		}
		$this->swapTag();
		echo $this->content;
		return;
	}





	//*----------- RENDER -----------*//
	public function render($file='', &$data=''){
		if(!empty($file) && file_exists($file)){
			$spet = $this;
			require $file;
		}
		return;
	}




	//*----------- OUTPUT -----------*//
	public function output($content=''){
		$this->setContent($content);
		$this->swapTag();
		echo $this->content;
		return;
	}

} /*** End Of ~SpetX ***/