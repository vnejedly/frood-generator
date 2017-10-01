<?php
namespace Hooloovoo\Generator;

use DateTime;
use Hooloovoo\Generator\Pattern\PatternInterface;

/**
 * Class Generator
 */
class Generator
{
    /** @var PatternInterface[] */
    protected $_patterns = [];

    /** @var mixed[] */
    protected $_externalVariables = [];

    /** @var ResolverInterface */
    protected $_resolver;

    /**
     * Generator constructor.
     * @param ResolverInterface $resolver
     */
    public function __construct(ResolverInterface $resolver)
    {
        $this->_resolver = $resolver;
    }

    /**
     * @param PatternInterface $patten
     */
    public function addPattern(PatternInterface $patten)
    {
        $this->_patterns[] = $patten;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setExternalVariable(string $name, $value)
    {
        $this->_externalVariables[$name] = $value;
    }

    /**
     * Run generator
     */
    public function run()
    {
        $this->setExternalVariable('generatedDateTime', new DateTime());

        foreach ($this->_resolver->yieldVariables() as $variables) {
            $this->_generateCase(array_merge($this->_externalVariables, $variables));
        }

        foreach ($this->_patterns as $pattern) {
            $pattern->finish();
        }
    }

    /**
     * @param mixed[] $variables
     */
    protected function _generateCase(array $variables)
    {
        foreach ($this->_patterns as $pattern) {
            $renderEngine = new RenderEngine($variables);
            $content = $renderEngine->render($pattern->getTemplateFile());
            $pattern->writeContent($content, $variables);
        }
    }
}