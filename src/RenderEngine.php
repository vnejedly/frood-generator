<?php
namespace Hooloovoo\Generator;

/**
 * Class RenderEngine
 */
class RenderEngine
{
    /** @var mixed[] */
    protected $_variables = [];

    /**
     * RenderEngine constructor.
     * @param mixed[] $variables
     */
    public function __construct(array $variables = [])
    {
        $this->_variables = $variables;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariable(string $name, $value)
    {
        $this->_variables[$name] = $value;
    }

    /**
     * @param string $templateFile
     * @return string
     */
    public function render(string $templateFile) : string
    {
        foreach ($this->_variables as $name => $value) {
            ${$name} = $value;
        }

        $templateCode = file_get_contents($templateFile);
        $templateCode = $this->_sanitizeTagLines($templateCode);

        ob_start();
        eval("?>" . $templateCode . "<?php ");
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * @param string $templateCode
     * @return string
     */
    protected function _sanitizeTagLines(string $templateCode) : string
    {
        $lines = explode("\n", $templateCode);

        array_walk($lines, function(&$line) {
            if (preg_match('/\<\?php/', $line)) {
                $line = ltrim($line);
            } elseif (preg_match('/\?\>$/', $line)) {
                $line = "$line\n";
            }
        });

        return implode("\n", $lines);
    }

    /**
     * @param mixed[] $traversedArray
     * @param string $delimiter
     * @return string
     */
    protected function _delimit(array &$traversedArray, string $delimiter) : string
    {
        if (false === next($traversedArray)) {
            return '';
        }

        return $delimiter;
    }
}