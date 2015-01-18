<?php
namespace AppBundle\Service;

use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;

class MarkdownParserService extends MarkdownParser
{
    /**
     * @var array Enabled features
     */
    protected $features = array(
        'header' => false,
        'list' => true,
        'horizontal_rule' => false,
        'table' => false,
        'foot_note' => false,
        'fenced_code_block' => false,
        'abbreviation' => false,
        'definition_list' => false,
        'inline_link' => false, // [link text](url "optional title")
        'reference_link' => false, // [link text] [id]
        'shortcut_link' => false, // [link text]
        'images' => false,
        'html_block' => false,
        'block_quote' => true,
        'code_block' => false,
        'auto_link' => false,
        'auto_mailto' => false,
        'entities' => false,
        'no_html' => false,
    );
}