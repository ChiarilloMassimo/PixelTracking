<?php

namespace Pixel;

use Pixel\Controller\ImageHandlerController;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContainerBuilder
 * @package Pixel
 */
class ContainerBuilder
{
    /**
     * @var SymfonyContainerBuilder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * ContainerBuilder constructor.
     * @param array $parameters
     */
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
        $this->registerServices($this->parameters['services']);

        $this->builder->setResourceTracking(false);

        $this->builder->compile();

        return $this->builder;
    }

    /**
     * @param array $services
     * @throws \Exception
     */
    protected function registerServices(array $services)
    {
        foreach($services as $service => $options) {
            if (empty($options['class'])) {
                throw new \Exception(sprintf('Specify your class for %s', $service));
            }

            $arguments = (empty($options['arguments'])) ? [] : $options['arguments'];

            $definition = new Definition($options['class'], $arguments);
            $definition
                ->setMethodCalls((!strstr($service, 'controller')) ? [] :
                    [
                        ['setRequest', [new Reference('current_request')]
                    ]
                ])
            ;

            if (!empty($options['tags'])) {
                foreach($options['tags'] as $name => $attributes) {
                    $definition->addTag($name, (is_array($attributes)) ? $attributes : []);
                }
            }

            $this->builder->setDefinition($service, $definition);
        }
    }
}
