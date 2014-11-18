<?php namespace SuiteTea\Support\Form;

interface FormProcessorInterface {
	 
	/**
	 * Validate Form Data
	 *
	 * @var array $data
	 * @return boolean
	 */
	public function isValid(array $data);
	 
	/**
	 * Get the Form Messages
	 *
	 * @return array
	 */
	public function messages();
}