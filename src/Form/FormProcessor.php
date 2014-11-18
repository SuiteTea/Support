<?php namespace SuiteTea\Support\Form;

use SuiteTea\Support\Form\Validation\Validator;
use SuiteTea\Support\Transformers\TransformerInterface as Transformer;

abstract class FormProcessor implements FormProcessorInterface {
	
	/**
	 * Validator Instance
	 *
	 * @var \SuiteTea\Support\Form\Validation\Validator
	 */
	protected $validator;
	
	/**
	 * Holds form input data
	 *
	 * @var array
	 */
	protected $data;
	
	/**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array();
    
    /**
	 * Request Transformer Instance
	 *
	 * @var 
	 */
	protected $transformer;
	
	/**
	 * Public Constructor
	 * 
	 * @return void
	 */
	public function __construct(Validator $validator,Transformer $transformer)
	{
		$this->validator = $validator;
		$this->transformer = $transformer;
	}
	 
	/**
	 * Validate Form Data
	 *
	 * @var array $data
	 * @return boolean
	 */
	public function isValid(array $data)
	{	
		if(!$this->validator->with(array_dot($data))->passes()) {
			$this->messages = $this->validator->messages();
			return false;
		}
		
		$this->data = $data;	
		return true;
	}
	
	/**
	 * Update Form Data
	 *
	 * @var array $data
	 * @return $data
	 */
	public function setData(array $data)
	{
		$this->data = $data;
		
		return $this;
	}
	
	public function setRelationship($id, $rid) {}
	
	/**
	 * Get the Form Errors
	 *
	 * @return array
	 */
	public function messages()
	{
		return $this->messages;	
	}
	
	/**
	 * Transform data to return
	 * to the API
	 *
	 * @var array $data
	 * @return array
	 */
	protected function process(array $data)
	{
		return $this->transformer->transform($data);
	}
}