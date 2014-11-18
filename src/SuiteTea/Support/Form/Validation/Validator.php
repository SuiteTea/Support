<?php namespace SuiteTea\Support\Form\Validation;

use Illuminate\Validation\Factory;

abstract class Validator implements ValidatorInterface {

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data key => value array
     *
     * @var Array
     */
    protected $data = array();

    /**
     * Validation messages
     *
     * @var Array
     */
    protected $messages = array();

    /**
     * Validation rules
     *
     * @var Array
     */
    protected $rules = array();
    

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Set data to validate
     *
     * @return \Impl\Service\Validation\AbstractLaravelValidator
     */
    public function with(array $input)
    {
        $this->data = $input;

        return $this;
    }

    /**
     * Validation passes or fails
     *
     * @return Boolean
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, $this->rules);
		
        if($validator->fails())
        {
            $this->messages = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Retrieve validation messages
     *
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }
    
     /**
     * Return a messageBag instance to create
     * Custom error messages
     *
     * @return array
     */
    public function getMessageBag() {
    	$validator = $this->validator->make([], []);
    	return $validator->getMessageBag();
    }

}