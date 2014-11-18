<?php namespace SuiteTea\Support\Collection\Priority;

use Illuminate\Support\Collection;

class PriorityCollectionFactory {
	
	public static function create() 
	{
		return new PriorityCollection(new Collection());
	}
}