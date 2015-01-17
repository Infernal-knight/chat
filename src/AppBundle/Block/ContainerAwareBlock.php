<?php

namespace AppBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService as BaseBlock;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerAwareBlock extends BaseBlock implements ContainerAwareInterface
{
    protected $container;

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}