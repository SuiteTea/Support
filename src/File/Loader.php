<?php namespace SuiteTea\Support\File;

use Illuminate\Foundation\Application;
use ClassLoader;
use File;
use Exception;

class FileLoader {
	
	/**
	 * Application
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	 protected $app;
	
	/**
     * Types
     *
     * @var array
     */
	protected $types = [
		'file',
		'class'
	];
	
	/**
	 * Path Placeholder
	 *
	 * @var string
	 */
	protected $path = "";
	
	/**
	 * Recursive File Load
	 *
	 * @var bool
	 */
	protected $recursive = "";
	
	public function __construct(Application $app) 
	{
		$this->app = $app;
	}
	
	/**
	 * Register an New item in the Loader Collection
	 *
	 * @param string $type
	 * @param array $args
	 * @return mixed array|object
	 */
	public function register($type, $args, $recursive = false)
	{
		// Let's make sure a type as been supplied
		if(!is_string($type) && !in_array($type, $this->types)) {
			
			$types = $this->types;
			$last = array_pop($types);
			$use = implode(", ".$types)." or ".$last;
			
			throw new Exception("The registered type is not available as an option. use $use");
		}
		
		// Check to make sure that useful parameters have been passed
		if(empty($args)) {
			throw new Exception("Please pass an array or string of paths. The Params cannot be an empty value.");
		}
		
		$this->recursive = $recursive;
		$this->type = $type;
		$method = 'add'.ucfirst($type);
		
		$this->$method($args);
	
		$this->path = null;
		$this->recursive = false;
	}
	
	/**
	 * Temporarily Set Path for a Registration
	 *
	 * @param string $path
	 * @return string
	 */
	public function setPath($path) 
	{
		if(!File::isDirectory($path)) {
			throw new Exception("The path given does not exist");
		}
		
		$this->path = $path;
		return $path;
	}
	
	/**
	 * Load File or Group of Files
	 *
	 * @param array $params
	 * @return void
	 */
	protected function addFile($args) 
	{	
		switch($this->getCase($args)) {
			case "single": 
				$this->loadFiles([$args]);
				break;
			case "multiple":
				$this->loadFiles($args);
				break;
			case "directory":
				if(!$this->recursive) {
					$this->loadFiles(File::files($this->getPath($args)));
				}
				else {
					$this->loadFiles(File::allFiles($this->getPath($args)));
				}
				break;
		}
	}
	
	/**
	 * Load Class or Group of Classes
	 *
	 * @param array $params
	 * @return void
	 */
	protected function addClass($args)
	{		
		switch($this->getCase($args)) {
			case "single": 
				ClassLoader::load($this->getPath($args));
				break;
			case "multiple":
				$this->loadClasses($args);
				break;
			case "directory":
				ClassLoader::addDirectories($this->getPath($args));
				break;
		}
	}
	
	/**
	 * Load Multiple files to Global Namespace
	 *
	 * @param array $files
	 * @return void
	 */
	protected function loadFiles($files) 
	{	
		$this->app->booted(function() use ($files)
		{
			foreach($files as $file) {
				if (File::exists($this->getPath($file))) {
					require $file;
				}
			}
		});
	}
	
	/**
	 * Load a specific array of classes
	 *
	 * @param array $files
	 * @return void
	 */
	protected function loadClasses($files)
	{
		foreach($files as $file) {
			ClassLoader::load($this->getPath($file));
		}
	}
	
	/**
	 * Merges registered path with file path
	 *
	 * @param string $file
	 * @return void
	 */
	protected function getPath($file) 
	{
		if($this->path != null) {
			return trailingSlash($this->path).leadingSlash($file, true);
		}
		
		return $file;
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

			if(File::isFile($args)) {
				return "single";
			}
			else if(File::isDirectory($args)) {
				return "directory";
			}
			else {
				return false;
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