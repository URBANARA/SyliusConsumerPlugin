<?php

declare(strict_types=1);

namespace Sylake\SyliusConsumerPlugin\Denormalizer;

use Interop\Amqp\AmqpMessage;
use SyliusLabs\RabbitMqSimpleBusBundle\Denormalizer\DenormalizationFailedException;
use SyliusLabs\RabbitMqSimpleBusBundle\Denormalizer\DenormalizerInterface;

abstract class AkeneoDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    final public function supports(AmqpMessage $message): bool
    {
        try {
            $this->denormalize($message);
        } catch (DenormalizationFailedException $exception) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    final public function denormalize(AmqpMessage $message)
    {
        $body = json_decode($message->getBody(), true);

        if (null === $body) {
            throw new DenormalizationFailedException('Message body is not valid JSON.');
        }

        if (!isset($body['payload'], $body['type'])) {
            throw new DenormalizationFailedException('Message body does not have payload or type.');
        }

        if ($this->getSupportedMessageType() !== $body['type']) {
            throw new DenormalizationFailedException('Message type is not supported.');
        }

        return $this->denormalizePayload($body['payload']);
    }

    /**
     * @param array $payload
     *
     * @return object
     *
     * @throws DenormalizationFailedException
     */
    abstract protected function denormalizePayload(array $payload);

    /**
     * @return string
     */
    abstract protected function getSupportedMessageType(): string;
}
