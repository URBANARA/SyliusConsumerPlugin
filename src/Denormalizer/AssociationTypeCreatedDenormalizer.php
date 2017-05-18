<?php

namespace Sylake\SyliusConsumerPlugin\Denormalizer;

use Sylake\SyliusConsumerPlugin\Event\AssociationTypeCreated;

final class AssociationTypeCreatedDenormalizer extends AkeneoDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function denormalizePayload(array $payload)
    {
        return new AssociationTypeCreated($payload['code'], $payload['labels']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedMessageType()
    {
        return MessageType::ASSOCIATION_TYPE_CREATED_MESSAGE_TYPE;
    }
}
