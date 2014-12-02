<?php namespace SuiteTea\Support\Singleton;

interface SingletonInterface
{
    public function getProperties();

    public function instance();
}