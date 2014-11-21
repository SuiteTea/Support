<?php namespace SuiteTea\Support\Collection;

use Illuminate\Support\Collection;

class Record extends Collection {

	/**
	 * Add a piece of data to the record.
	 *
	 * @param  mixed $key
	 * @param  mixed $value
	 * @return \SuiteTea\Support\Collection\Record
	 */
	public function with($key, $value = null)
	{
		if (is_string($key)) {
			$this->put($key, $value);
		}
		else {
			$this->items = $this->merge($key)->toArray();
		}

		return $this;
	}

	public function except(array $except = [])
	{
		return new static(array_except($this->items, $except));
	}

	/**
	 * Get a piece of data from the record.
	 *
	 * @return mixed
	 */
	public function &__get($key)
	{
		return $this->items[$key];
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
		$this->put($key, $value);
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