<?php

declare(strict_types=1);

namespace Spiral\Messenger\Config;

use Spiral\Core\Container\Autowire;
use Spiral\Core\InjectableConfig;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;

/**
 * @psalm-type Middleware = class-string<MiddlewareInterface>|MiddlewareInterface|Autowire<MiddlewareInterface>
 */
final class MessengerConfig extends InjectableConfig
{
    public const CONFIG = 'messenger';

    /**
     * @var array{
     *     defaultPipeline: ?string,
     *     pipelineAliases: array<non-empty-string, non-empty-string>,
     *     stampsHistorySize: positive-int,
     *     middlewares: Middleware[],
     *     routerMiddlewares: Middleware[],
     *     senders: array{
     *      map: array<non-empty-string, non-empty-string|class-string<SenderInterface>>,
     *     }
     * }
     */
    protected array $config = [
        'defaultPipeline' => null,
        'pipelineAliases' => [],
        'stampsHistorySize' => 10,
        'middlewares' => [],
        'routerMiddlewares' => [],
        'senders' => [
            'map' => [],
        ],
    ];

    /**
     * Middleware are used to process messages in a default bus.
     *
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->config['middlewares'] ?? [];
    }

    /**
     * Router middlewares are used to process messages before they are routed to the correct bus.
     * This is useful when you want to apply middlewares to messages, for example to route them to the correct bus by adding a BusNameStamp.
     *
     * @return Middleware[]
     */
    public function getRouterMiddlewares(): array
    {
        return $this->config['routerMiddlewares'] ?? [];
    }

    /**
     * Get the default pipeline name. (It can be an alias or a real pipeline name)
     *
     * @return non-empty-string|null
     */
    public function getDefaultPipeline(): ?string
    {
        return $this->config['defaultPipeline'];
    }

    /**
     * Get pipeline aliases.
     *
     * @return array<non-empty-string, non-empty-string>
     */
    public function getPipelineAliases(): array
    {
        return $this->config['pipelineAliases'];
    }

    public function getStampsHistorySize(): int
    {
        return $this->config['stampsHistorySize'];
    }

    /**
     * @return array<string, string[]>
     */
    public function getSendersMap(): array
    {
        return $this->config['senders']['map'] ?? [];
    }
}
