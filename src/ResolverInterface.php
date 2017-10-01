<?php
namespace Hooloovoo\Generator;

/**
 * Interface ResolverInterface
 */
interface ResolverInterface
{
    /**
     * @return \Generator
     */
    public function yieldVariables() : \Generator;
}