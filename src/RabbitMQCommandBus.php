<?php

declare(strict_types=1);

namespace Oscmarb\RabbitMQCommandBus;

use Oscmarb\Ddd\Domain\Command\Command;
use Oscmarb\Ddd\Domain\Command\CommandBus;
use Oscmarb\RabbitMQ\RabbitMQConnection;
use Oscmarb\RabbitMQ\RabbitMQRoutingConfig;
use Oscmarb\RabbitMQ\RoutedRabbitMQPublisher;

final class RabbitMQCommandBus implements CommandBus
{
    private RoutedRabbitMQPublisher $publisher;

    public function __construct(RabbitMQConnection $connection, RabbitMQRoutingConfig $routingConfig)
    {
        $this->publisher = new RoutedRabbitMQPublisher($connection, $routingConfig);
    }

    public function handle(Command $command): void
    {
        $this->publisher->publish($command);
    }

    public function handleMultiple(Command ...$commands): void
    {
        foreach ($commands as $command) {
            $this->handle($command);
        }
    }
}