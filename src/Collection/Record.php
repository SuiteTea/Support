<?php namespace SuiteTea\Support\Collection;

use ArrayAccess;

class Record implements ArrayAccess {
	
	/**
	 * @var array|null
	 */
    protected $data;
	
	/**
	 * Create a new response record instance.
	 *
	 * @param  array $data
	 * @return void
	 */
	public function __construct($data = array())
	{
		$this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
	}
	
	/**
	 * Return record object as an array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->data;
	}
	
	
	/**
	 * Add a piece of data to the record.
	 *
	 * @param  string|array  $key
	 * @param  mixed   $value
	 * @return \ClientLib\Api\ResponseRecord
	 */
	public function with($key, $value = null)
	{
		if (is_array($key))
		{
			$this->data = array_merge($this->data, $key);
		}
		else
		{
			$this->data[$key] = $value;
		}

		return $this;
	}
	
	/**
	 * Determine if a piece of data is bound.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->data);
	}

	/**
	 * Get a piece of bound data to the record.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->data[$key];
	}

	/**
	 * Set a piece of data on the record.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->with($key, $value);
	}

	/**
	 * Unset a piece of data from the record.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		unset($this->data[$key]);
	}
	
	/**
	 * Get a piece of data from the record.
	 *
	 * @return mixed
	 */
	public function &__get($key)
	{
		return $this->data[$key];
	}

	/**
	 * Set a piece of data on the record.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->with($key, $value);
	}
	
	/**
	 * Check if a piece of data is bound to the record.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __isset($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * Remove a piece of bound data from the record.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __unset($key)
	{
		unset($this->data[$key]);
	}
}