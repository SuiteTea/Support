<?php namespace SuiteTea\Support\File;

interface FileLoaderInterface {

    /**
     * Autoload The files in a specific folder.
     *
     * @param string $path
     */
    public function directory($path);

    /**
     * Load a specific file
     *
     * @param string $path
     */
    public function file($path);

}