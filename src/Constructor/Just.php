<?php

namespace PhpFp\Maybe\Constructor;

use PhpFp\Maybe\Maybe;
/**
 * An OO-looking implementation of the Just constructor in PHP.
 */
final class Just extends Maybe
{
    /**
     * Application, derived with chain.
     * @param Maybe $that The wrapped parameter.
     * @return Maybe The wrapped result.
     */
    public function ap(Maybe $that)
    {
        return $this->chain(function ($f) use($that) {
            return $that->map($f);
        });
    }
    /**
     * Semigroup concatenation of two Maybe values.
     * @param Maybe $that Inner types must match!
     * @return Maybe The concatenated value.
     * @todo Make friendly with primitives.
     */
    public function concat(Maybe $that)
    {
        if ($that instanceof Nothing) {
            return $this;
        }
        return Maybe::of($this->value->concat($that->fork(null)));
    }
    /**
     * PHP implemenattion of Haskell Maybe's >>=.
     * @param callable $f a -> Maybe b
     * @return Maybe The result of the function.
     */
    public function chain(callable $f)
    {
        return $f($this->value);
    }
    /**
     * Check whether two Maybe values be equal.
     * @param Maybe $that Inner types should match!
     * @return bool
     * @todo Make this compatible with setoid inner values.
     */
    public function equals(Maybe $that)
    {
        return $that instanceof Just && $this->value->equals($that->fork(null));
    }
    /**
     * Fork this Maybe, with a default for Nothing.
     * @param mixed $default In case of Nothing.
     * @return mixed Whatever the Maybe's inner type is.
     */
    public function fork($_)
    {
        return $this->value;
    }
    /**
     * Functor map, derived from chain.
     * @param callable $f The mapping function.
     * @return Maybe The outer structure is preserved.
     */
    public function map(callable $f)
    {
        return $this->chain(function ($a) use($f) {
            return Maybe::of($f($a));
        });
    }
    /**
     * Fold for the Just constructor.
     * @param callable $f The folding function.
     * @param mixed $x The accumulator value.
     * @return mixed The $x type and $f return type.
     */
    public function reduce(callable $f, $x)
    {
        return $f($x, $this->value);
    }
    /**
     * The inner value for this Maybe.
     * @var mixed
     */
    private $value = null;
    /**
     * Create a Maybe::just instance.
     * Don't construct this with a null!
     * @param mixed $x The value to wrap.
     */
    protected function __construct($value)
    {
        $this->value = $value;
    }
}