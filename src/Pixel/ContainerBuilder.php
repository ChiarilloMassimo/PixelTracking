<?php

namespace Pixel;

use Pixel\Controller\ImageHandlerController;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;


class ContainerBuilder
{
    protected $builder;

    protected $parameters;

    public function __construct(array $parameters)
    {
        $this->builder = new SymfonyContainerBuilder();
        $this->parameters = $parameters;

        $this->builder->register('current_request', Request::class)
            ->setFactory([Request::class, 'createFromGlobals'])
        ;
    }

    /**
     * @return SymfonyContainerBuilder
     */
    public function compile()
    {
        $this->registerControllers($this->parameters['_controllers']);

        $this->builder->setResourceTracking(false);

        $this->builder->compile();

        return $this->builder;
    }

    /**
     * @param array $controllers
     */
    protected function registerControllers(array $controllers)
    {
        foreach($controllers as $name => $class) {
            $this->builder->register($name, $class)
                ->addMethodCall('setRequest', [
                    new Reference('current_request')
                ])
            ;
        }
    }
}
