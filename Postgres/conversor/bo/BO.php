<?php
interface BO{
	
	function arrayHomolog();
	function arrayDev();
	function arrayHomolgAll();
	function arrayDevAll();
	function diff_homolog_devQuery();
	function intersect_homolog_devQuery();
	function diff_dev_homologQuery();
	
}