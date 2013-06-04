<?php

class TextParser
{
    /**
     * @var string marker of block begin
     */
    public $startBlock = '[*';
    /**
     * @var string marker of block end
     */
    public $endBlock = '*]';
    /**
     * @var array of allowed widgets
     */
    public $replacements;

    public function __construct($replacements = array())
    {
        $this->replacements = is_array($replacements) ? $replacements : array();
    }

    /**
     * Content parser
     * Use $this->decodeWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function decode($text)
    {
        $text = $this->_processReplace($text);
        return $text;
    }

    protected function _processReplace($text)
    {
        foreach ($this->replacements as $alias => $replacement) {
            $patterns[] = $this->startBlock . $alias . $this->endBlock;
            $replacements[] = $replacement;
        }
        return str_replace($patterns, $replacements, $text);
    }
}