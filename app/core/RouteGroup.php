<?php

namespace app\core;

/**
 * Class RouteGroup
 *
 * Manages grouped route attributes like prefix and middleware.
 * Used internally by the Route class to apply shared settings.
 */
class RouteGroup
{
    /** @var array Stack of route prefixes (e.g., '/admin') */
    protected static array $prefixStack = [];

    /** @var array Stack of middleware arrays */
    protected static array $middlewareStack = [];

    /**
     * Starts a route group with given attributes (prefix, middleware).
     *
     * @param array $attributes
     */
    public static function start(array $attributes): void
    {
        self::$prefixStack[] = $attributes['prefix'] ?? '';
        self::$middlewareStack[] = (array) ($attributes['middleware'] ?? []);
    }

    /**
     * Ends the current route group and pops prefix/middleware.
     */
    public static function end()
    {
        array_pop(self::$prefixStack);
        array_pop(self::$middlewareStack);
    }

    /**
     * Returns the current full prefix by combining stacked prefixes.
     *
     * @return string
     */
    public static function getPrefix(): string
    {
        return implode('', self::$prefixStack);
    }

    /**
     * Returns a merged list of all middlewares from the stack.
     *
     * @return array
     */
    public static function getMiddlewares(): array
    {
        return array_merge(...self::$middlewareStack);
    }
}
