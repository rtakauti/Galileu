<?php
interface IDAO{
	function query($schemaType);
	function queryAllAssoc($schemaType);
}