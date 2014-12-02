<?php namespace SuiteTea\Support\Presenter;

interface PresenterInterface {

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     */
    public function presenter();

}