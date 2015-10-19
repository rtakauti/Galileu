<?php
interface DAO{
	function query($schemaType);
	function queryAllAssoc($schemaType);
}