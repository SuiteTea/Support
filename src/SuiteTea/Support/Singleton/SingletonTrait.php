<?php namespace SuiteTea\Support\Singleton;

trait SingletonTrait
{
    /**
     * Singleton instance
     *
     * @var mixed
     */
    protected $instance;

    /**
     * @return $this
     */
    public function getProperties()
    {
        return $this;
    }

    public function getSingletonProperty()
    {
        return $this->singleton;
    }

    /**
     * @return mixed
     * @throws SingletonException
     */
    public function instance()
    {
        $singleton = $this->getSingletonProperty();

        if (!$singleton) {
            throw new SingletonException('Please set the $singleton property to your presenter path.');
        }
        else if(!class_exists($singleton)) {
            throw new SingletonException("The class $singleton does not exist");
        }

        if (!$this->instance) {
            $this->instance = new $singleton($this->getProperties());
        }

        return $this->instance;
    }

}