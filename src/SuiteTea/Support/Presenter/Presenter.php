<?php namespace SuiteTea\Support\Presenter;

abstract class Presenter extends \SuiteTea\Support\Collection\Record {

    public function fill(array $attributes)
    {
        $this->items = $attributes;
    }

    /**
     * Allow for property-style retrieval
     *
     * @param $property
     * @return mixed
     */
    public function &__get($key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }

        return parent::__get($key);
    }

    public function toArray()
    {
        $self = $this;
        return array_map(function($v) use ($self) {
            return $self->$v;
        }, array_keys($this->items));
    }

}