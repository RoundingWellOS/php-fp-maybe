<?php

namespace PhpFp\Maybe;

use PhpFp\Maybe\Constructor\Just;
use PhpFp\Maybe\Constructor\Nothing;
/**
 * An OO-looking implementation of Maybe in PHP.
 */
abstract class Maybe
{
    /**
     * Construct a new Just instance with a value.
     * @param mixed $x The value to be wrapped.
     * @return A new Just-constructed value.
     */
    public static final function just($x)
    {
        return new Just($x);
    }
    /**
     * Construct a new Nothing instance.
     * @return A new Nothing-constructed value.
     */
    public static final function nothing()
    {
        return new Nothing();
    }
    /**
     * Similar to `of` or `just`, save the fact that
     * `null` values are mapped to `Nothing` instead.
     * Useful for converting nullable functions to
     * safer Maybe-returning functions.
     * @param mixed $x The value to be wrapped.
     * @return A new Maybe-wrapped value.
     */
    public static final function fromNullable($x)
    {
        return isset($x) ? Maybe::just($x) : Maybe::nothing();
    }
    /**
     * Applicative constructor for Maybe.
     * @param mixed $x The value to be wrapped.
     * @return A new Just-constructed value.
     */
    public static final function of($x)
    {
        return self::just($x);
    }
    /**
     * Application, derived with chain.
     * @param Maybe $that The wrapped parameter.
     * @return Maybe The wrapped result.
     */
    public abstract function ap(Maybe $that);
    /**
     * Semigroup concatenation of two Maybe values.
     * @param Maybe $that Inner types must match!
     * @return Maybe The concatenated value.
     * @todo Make friendly with primitives.
     */
    public abstract function concat(Maybe $that);
    /**
     * PHP implemenattion of Haskell Maybe's >>=.
     * @param callable $f a -> Maybe b
     * @return Maybe The result of the function.
     */
    public abstract function chain(callable $f);
    /**
     * Check whether two Maybe values be equal.
     * @param Maybe $that Inner types should match!
     * @return bool
     * @todo Make this compatible with setoid inner values.
     */
    public abstract function equals(Maybe $that);
    /**
     * Fork this Maybe, with a default for Nothing.
     * @param mixed $default In case of Nothing.
     * @return mixed Whatever the Maybe's inner type is.
     */
    public abstract function fork($default);
    /**
     * Functor map, derived from chain.
     * @param callable $f The mapping function.
     * @return Maybe The outer structure is preserved.
     */
    public abstract function map(callable $f);
    /**
     * Left fold / reduction for Maybe.
     * @param callable $f The folding function.
     * @param mixed $x The accumulator value.
     * @return mixed The $x type and $f return type.
     */
    public abstract function reduce(callable $f, $x);
}