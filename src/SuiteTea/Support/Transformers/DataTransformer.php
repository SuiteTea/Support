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
	 * Transformer Constructor
	 */
	public function __construct(Collection $collection)
	{
		$this->collection = $collection;
		
		$this->init();
	}
	
	/**
	 * Initialization function run on construct
	 */
	abstract protected function init();
	
	/**
	 * Transform Method
	 *
	 * @var array $data
	 * @return array
	 */
	abstract public function transform($data);
}