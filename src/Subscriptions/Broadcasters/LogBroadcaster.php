<?php

namespace Nuwave\Lighthouse\Subscriptions\Broadcasters;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Nuwave\Lighthouse\Subscriptions\Subscriber;
use Nuwave\Lighthouse\Subscriptions\Contracts\Broadcaster;

class LogBroadcaster implements Broadcaster
{
    /**
     * The user-defined configuration options.
     *
     * @var mixed[]
     */
    protected $config = [];

    /**
     * A map from channel names to data.
     *
     * @var mixed
     */
    protected $broadcasts = [];

    /**
     * @param  array  $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Authorize subscription request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function authorized(Request $request): JsonResponse
    {
        return response()->json(['message' => 'ok'], 200);
    }

    /**
     * Handle unauthorized subscription request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function unauthorized(Request $request): JsonResponse
    {
        return response()->json(['error' => 'unauthorized'], 403);
    }

    /**
     * Handle subscription web hook.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function hook(Request $request): JsonResponse
    {
        return response()->json(['message' => 'okay']);
    }

    /**
     * Send data to subscriber.
     *
     * @param  Subscriber  $subscriber
     * @param  array  $data
     */
    public function broadcast(Subscriber $subscriber, array $data)
    {
        $this->broadcasts[$subscriber->channel] = $data;
    }

    /**
     * Get the data that is being broadcast.
     *
     * @param  string|null  $key
     * @return array|null
     */
    public function broadcasts(?string $key = null): ?array
    {
        return $key
            ? Arr::get($this->broadcasts, $key)
            : $this->broadcasts;
    }

    /**
     * Get configuration options.
     *
     * @return mixed[]
     */
    public function config(): array
    {
        return $this->config;
    }
}
