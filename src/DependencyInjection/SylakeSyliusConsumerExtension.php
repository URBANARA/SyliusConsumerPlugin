<?php

declare(strict_types=1);

namespace Sylake\SyliusConsumerPlugin\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SylakeSyliusConsumerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        $container->setParameter(
            'sylake_sylius_consumer.denormalizer.product.name_attribute',
            $config['denormalizer']['product']['name_attribute']
        );
        $container->setParameter(
            'sylake_sylius_consumer.denormalizer.product.description_attribute',
            $config['denormalizer']['product']['description_attribute']
        );
        $container->setParameter(
            'sylake_sylius_consumer.denormalizer.product.price_attribute',
            $config['denormalizer']['product']['price_attribute']
        );
        $container->setParameter(
            'sylake_sylius_consumer.denormalizer.product.image_attribute',
            $config['denormalizer']['product']['image_attribute']
        );
    }
}
