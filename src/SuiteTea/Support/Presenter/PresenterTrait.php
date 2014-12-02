<?php namespace SuiteTea\Support\Presenter;

trait PresenterTrait
{
    use \SuiteTea\Support\Singleton\SingletonTrait {
        instance as private;
    }

    protected $presenter = 'SuiteTea\Support\Presenter\Presenter';

    public function getSingletonProperty()
    {
        return $this->presenter;
    }

    public function presenter()
    {
        return $this->instance();
    }
}