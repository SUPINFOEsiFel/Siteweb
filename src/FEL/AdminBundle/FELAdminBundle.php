<?php

namespace FEL\AdminBundle;

use FEL\AdminBundle\DependencyInjection\Security\Factory\MeteorFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FELAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new MeteorFactory());
    }
}
