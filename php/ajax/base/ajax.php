<?php

//Interface definition defining an ajax class
interface ajax {
	function run();					//Run method should be the entry point.
	function executeMethod();			//This is where we check for which method to run.
	function _isInvalidMethod();			//Checks if a method should not ever be called by executeMethod().
}