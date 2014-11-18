<?php namespace SuiteTea\Support\Form\Validation;

interface ValidatorInterface {
	
	/**
     * Add data to validation against
     *
     * @param array
     * @return \ClientLib\Service\Validation\ValidationInterface  $this
     */
    public function with(array $input);

    /**
     * Test if validation passes
     *
     * @return boolean
     */
    public function passes();

    /**
     * Retrieve validation messages
     *
     * @return array
     */
    public function messages();
	
}