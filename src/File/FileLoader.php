<?php namespace SuiteTea\Support\File;

use Illuminate\Foundation\Application;
use File;

class FileLoader {
	
	/**
	 * Laravels Application Instance
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	protected $app;

	protected $file;
	
	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->file = $app['files'];
	}
	
	/**
	 * Register an New item in the Loader Collection
	 *
	 * @param array $args
	 * @return mixed array|object
	 */
	public function register($args, $recursive = false)
	{
		switch($this->getCase($args)) {
			case "single":
				$this->loadFiles((array) $args);
				break;
			case "multiple":
				$this->loadFiles($args);
				break;
			case "directory":
				if(!$recursive) {
					$this->loadFiles($this->file->files($args));
				}
				else {
					$this->loadFiles($this->file->allFiles($args));
				}
				break;
		}
	}
	
	/**
	 * Load Multiple files to Global Namespace
	 *
	 * @param array $files
	 * @return void
	 */
	private function loadFiles($files)
	{	
		$this->app->booted(function() use ($files)
		{
			foreach($files as $file) {
				require $file;
			}
		});
	}

	/**
	 * Determins how the Add method will function
	 *
	 * @param string | array $args
	 * @return bool | string
	 */
	private function getCase($args) 
	{
		if(is_array($args)) {
			return 'multiple';
		}
		else if(is_string($args)) {

			if($this->file->isFile($args)) {
				return "single";
			}
			else if($this->file->isDirectory($args)) {
				return "directory";
			}

		}
	}
	
	/** 
	 * Adds trailing slash
	 *  
	 * @param string $string
	 * @param bool	$remove
	 * @return string
	 */
	protected function trailingSlash($string, $remove = false) 
	{
		$add = $remove ? "" : "/";
		return rtrim($string, '/') . $add;
	}
	 
	/** 
	 * Adds leading slash
	 *  
	 * @param string $string
	 * @param bool $remove
	 * @return string
	 */
	protected function leadingSlash($string, $remove = false) 
	{
		$add = $remove ? "" : "/";
		$string = ltrim($string, '/');

		return $add . $string;
	}
	
	/** 
	 * Adds leading & trailing slash
	 *  
	 * @param string $string
	 * @param bool $remove
	 * @return string
	 */
	protected function slashBoth($string, $remove = false) 
	{
		return $this->leadingSlash($this->trailingSlash($string, $remove), $remove);
	}
}