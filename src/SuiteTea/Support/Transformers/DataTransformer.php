<?php namespace SuiteTea\Support\Transformers;

use Illuminate\Support\Collection;

abstract class DataTransformer implements TransformerInterface {

	/**
	 * Collection
	 *
	 * @var \Illuminate\Support\Collection
	 */
	protected $collection;

	/**
	 * Create a new Data Transformer.
	 *
	 * @param  array  $items
	 */
	public function __construct(array $items = array())
	{
		$this->collection = new Collection($items);
		$this->init();
	}

	/**
	 * Return the collection instance.
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function getCollection()
	{
		return $this->collection;
	}

	/**
	 * Initialization function run on construct
	 */
	abstract protected function init();


	/**
	 * Call methods from the collection
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array([$this->collection,$method],$arguments);
	}

}