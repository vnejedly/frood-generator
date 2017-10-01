<?php
namespace Hooloovoo\Generator\Pattern;

/**
 * Class SingleFile
 */
class SingleFile implements PatternInterface
{
    /** @var string */
    protected $contentPlaceholder = '{{{_content_}}}';

    /** @var string */
    protected $outputFile;

    /** @var string */
    protected $itemsEnvelopeFile;

    /** @var string */
    protected $itemTemplateFile;

    /** @var string */
    protected $content = '';

    /**
     * SingleFile constructor.
     *
     * @param string $outputFile
     * @param string $itemsEnvelopeFile
     * @param string $itemTemplateFile
     */
    public function __construct(
        string $outputFile,
        string $itemsEnvelopeFile,
        string $itemTemplateFile
    ) {
        $this->outputFile = $outputFile;
        $this->itemsEnvelopeFile = $itemsEnvelopeFile;
        $this->itemTemplateFile = $itemTemplateFile;
    }

    /**
     * @param string $placeholder
     */
    public function setContentPlaceholder(string $placeholder)
    {
        $this->contentPlaceholder = $placeholder;
    }

    /**
     * @return string
     */
    public function getTemplateFile(): string
    {
        return $this->itemTemplateFile;
    }

    /**
     * @param string $content
     * @param array $variables
     */
    public function writeContent(string $content, array $variables)
    {
        $this->content .= $content;
    }

    /**
     * Writes the output file
     */
    public function finish()
    {
        if (is_file($this->outputFile)) {
            unlink($this->outputFile);
        }

        $envelope = file_get_contents($this->itemsEnvelopeFile);
        $content = str_replace($this->contentPlaceholder, $this->content, $envelope);
        file_put_contents($this->outputFile, $content);
    }
}