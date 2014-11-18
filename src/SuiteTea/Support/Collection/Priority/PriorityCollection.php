<?php namespace SuiteTea\Support\Collection\Priority;

use Illuminate\Support\Collection;

class PriorityCollection {
	
	/**
     * Settings
     *
     * @var \Illuminate\Support\Collection
     */
	protected $collection;
	
	
	public function __construct(Collection $collection) 
	{
		$this->collection = $collection;
	}
	
	/**
	 * Register an New item in the Priority Collection
	 *
	 * @param string $key
	 * @param array $params
	 * @param int $priority
	 * @return mixed array|object
	 */
	public function register($key, $params, $priority = 50)
	{
		if (!is_string($key)) {
			throw new PriorityCollectionException("The name parameter requires a string");
		}
		
		if (!is_array($params)) {
			throw new PriorityCollectionException("The config parameter requries an array");
		}

		return $this->add($key, $params, $priority);
	}
	
	/**
	 * Remove an item from the Collection
	 *
	 * @param string $key
	 * @return void
	 */
	public function deregister($key) {
		$this->remove($key);
	}
	
	/**
	 * Build the Collection for Output
	 *
	 * @return array
	 */
	public function build() 
	{
		return $this->sortBy(function($value)
		{
			return $value['priority'];
		
		})->map(function($value, $key) 
		{	
			unset($value['priority']);
			$value['key'] = $key;
			return $value;
			
		})->toArray();
	}
	
	/**
	 * Update an item in the Collection
	 *
	 * @param string $key
	 * @param array $params
	 * @param int $priority
	 * @return mixed array|object
	 */
	public function update($key, $params, $priority = null) 
	{
		if(!$this->has($key)) {
			$this->register($key, []);
		}
		
		$get = $this->get($key);
		$update = array_merge($get, $params);
		$priority = is_numeric($priority) ? (int) $priority : $update['priority'];
		
		$this->add($key, $update, $priority);
		
		return $this->get($key);
	}
	
	/**
	 * Remove an item from the Collection
	 *
	 * @param string $key
	 * @return void
	 */
	public function remove($key) 
	{
		$this->forget($key);
	}
	
	/**
	 * Add an item in the Collection
	 *
	 * @param string $key
	 * @param array $params
	 * @param int $priority
	 * @return mixed array|object
	 */
	protected function add($key, $params, $priority) 
	{	
		$params["priority"] = $priority;
		$this->put($key, $params);
		
		return $this->get($key);
	}
	
	/**
	 * Call methods from the Collection dependency
	 *
	 * @return mixed
	 */
	public function __call($method, $arguments) 
	{
		return call_user_func_array([ $this->collection, $method ], $arguments);
	}
}