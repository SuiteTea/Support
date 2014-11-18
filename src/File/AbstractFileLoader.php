<?php namespace SuiteTea\Support\File;

abstract class AbstractFileLoader implements FileLoaderInterface {

    /**
     * Loader
     *
     * @var \SuiteTea\Support\File\FileLoader
     */
    protected $loader;

    /**
     * Constructor
     *
     * @param \SuiteTea\Support\File\FileLoader
     */
    public function __construct(FileLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Autoload The files in a specific folder.
     *
     * @param string $path
     */
    public function directory($path, $recursive = true)
    {
        if(\File::isDirectory($path)) {
            $this->loader->register($path, $recursive);
        }
    }

    /**
     * Load a specific file
     *
     * @param string $path
     */
    public function file($path)
    {
        if(\File::exists($path)) {
            $this->loader->register($path);
        }
    }

}