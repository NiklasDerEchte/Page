<?php

namespace Niklas;

use Niklas\Parser;

class Page
{
    private static $INSTANCE = null;
    private $mTemplate;
    private $mContentFlag;
    private $mParser;

    public function __construct($tmp = "{{CONTENT}}", $contentFlag = "{{CONTENT}}") {
        $this->mTemplate = $tmp;
        $this->mContentFlag = $contentFlag;
        $this->mParser = new Parser();
    }

    public function add($tmp) {
        if($this->mParser !== null && $this->mParser instanceof Parser) {
            $this->mParser->raw($tmp);
            $this->mTemplate = $this->mParser->getTemplate();
        }
    }

    public function parser():Parser {
        return $this->mParser = new Parser($this->mTemplate, $this->mContentFlag);
    }

    public static function INIT(self $instance) {
        self::$INSTANCE = $instance;
    }

    public static function GET() :self {
        if(self::$INSTANCE === null) {
            throw new \Exception("Page is null, call Page::INIT() first !");
        }
        return self::$INSTANCE;
    }
}