<?php
namespace Hooloovoo\Generator\Pattern;

use Hooloovoo\Generator\Exception\LogicException;

/**
 * Class MultiFile
 */
class MultiFile implements PatternInterface
{
    const DEFAULT_FILENAME_VAR = 'fileName';

    /** @var string */
    protected $_filesPath;

    /** @var string */
    protected $_templateFile;

    /** @var bool */
    protected $_override;

    /** @var string */
    protected $_fileNameVar;

    /**
     * Patten constructor.
     * @param string $filesPath
     * @param string $templateFile
     * @param bool $override
     * @param string $fileNameVar
     */
    public function __construct(
        string $filesPath,
        string $templateFile,
        bool $override = true,
        string $fileNameVar = self::DEFAULT_FILENAME_VAR
    ) {
        $this->_filesPath = $filesPath;
        $this->_templateFile = $templateFile;
        $this->_override = $override;
        $this->_fileNameVar = $fileNameVar;
    }

    /**
     * @return string
     */
    public function getTemplateFile(): string
    {
        return $this->_templateFile;
    }

    /**
     * @param string $content
     * @param array $variables
     */
    public function writeContent(string $content, array $variables)
    {
        if (!array_key_exists($this->_fileNameVar, $variables)) {
            throw new LogicException("File name variable {$this->_fileNameVar} not set");
        }

        $fileName = $variables[$this->_fileNameVar];
        $path = "{$this->_filesPath}/$fileName";

        if ($this->_override || !is_file($path)) {
            file_put_contents($path, $content);
        }
    }

    /**
     * All files are written, nothing to do here
     */
    public function finish() {}
}