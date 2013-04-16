<?php
class Bootstrap extends Cizgi_Bootstrap
{
	function __construct()
	{
		parent::__construct(new Cizgi_URLDispatcher());
	}
}