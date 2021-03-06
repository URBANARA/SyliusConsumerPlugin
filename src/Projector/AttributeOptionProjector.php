<?php

declare(strict_types=1);

namespace Sylake\SyliusConsumerPlugin\Projector;

use Psr\Log\LoggerInterface;
use Sylake\SyliusConsumerPlugin\Entity\AkeneoAttributeOption;
use Sylake\SyliusConsumerPlugin\Event\AttributeOptionUpdated;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class AttributeOptionProjector
{
    /** @var RepositoryInterface */
    private $repository;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(RepositoryInterface $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function __invoke(AttributeOptionUpdated $event): void
    {
        $this->logger->debug(sprintf(
            'Projecting attribute option with code "%s" for attribute with code "%s".',
            $event->code(),
            $event->attributeCode()
        ));

        /** @var AkeneoAttributeOption|null $akeneoAttributeOption */
        $akeneoAttributeOption = $this->repository->findOneBy(['code' => $event->code(), 'attribute' => $event->attributeCode()]);
        if (null === $akeneoAttributeOption) {
            $akeneoAttributeOption = new AkeneoAttributeOption($event->code(), $event->attributeCode(), $event->labels());
        }

        $akeneoAttributeOption->setCode($event->code());
        $akeneoAttributeOption->setAttribute($event->attributeCode());
        $akeneoAttributeOption->setLabels($event->labels());

        $this->repository->add($akeneoAttributeOption);
    }
}
