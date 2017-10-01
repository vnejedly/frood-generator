<?php
namespace Hooloovoo\Generator\Pattern;

/**
 * Interface PatternInterface
 */
interface PatternInterface
{
    /**
     * @return string
     */
    public function getTemplateFile(): string ;

    /**
     * @param string $content
     * @param array $variables
     */
    public function writeContent(string $content, array $variables) ;

    /**
     * Implement the necessary things to do after writing all cases
     */
    public function finish();
}