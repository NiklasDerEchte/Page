<?php

namespace Niklas;

use Niklas\Parser;

class Page
{
    private static $INSTANCE = null;
    private $mTemplate;
    public function __construct($tmp) {
        $this->mTemplate = $tmp;
    }

    public function parser():Parser {
        return new Parser($this->mTemplate);
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