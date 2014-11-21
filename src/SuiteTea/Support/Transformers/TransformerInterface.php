<?php namespace SuiteTea\Support\Transformers;

interface TransformerInterface {

	/**
	 * Static Transform Method
	 *
	 * @var array $data
	 * @return array
	 */
	public static function transform(array $data = []);
	
}