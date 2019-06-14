<?php

namespace Niklas;

class Parser
{
    private $mContent;
    private $mContentFlag;
    private $mNode;

    public function __construct($content = "{{CONTENT}}") {
        $this->mContentFlag = "{{CONTENT}}";
        $this->mContent = $content;
        $this->mNode = new Node();
    }

    public function add($tag):self {
        $this->create();
        $this->mNode->isElement = false;
        $this->mNode->tag = $tag;
        return $this;
    }

    public function content(Parser $parser) : self {
        $this->create();
        $cont = $parser->render();
        $cont = $cont . $this->mContentFlag;
        $this->mContent = str_replace($this->mContentFlag, $cont, $this->mContent);
        return $this;
    }

    public function el($tag):self {
        $this->create();
        $this->mNode->isElement = true;
        $this->mNode->tag = $tag;
        return $this;
    }

    public function raw($html) :self {
        $this->mContent = str_replace($this->mContentFlag, $html, $this->mContent);
        return $this;
    }

    public function properties($properties):self {
        $this->mNode->properties = $properties;
        return $this;
    }

    public function getContent(): String {
        return $this->mContent;
    }

    public function text($message):self {
        $this->mNode->text = $message;
        return $this;
    }

    private function create(){
        if(strlen($this->mNode->tag) > 0) {
            $curContent = $this->mContentFlag;
            $prop = $this->parseProperties($this->mNode->properties);
            if(strlen($prop) > 0) {
                $prop = " " . $prop;
            }
            if($this->mNode->isElement) {
                $curContent = "<" . $this->mNode->tag . $prop . ">" . $this->mNode->text . "</" . $this->mNode->tag . ">" . $this->mContentFlag;
            } else {
                $curContent = "<" . $this->mNode->tag . $prop . ">" . $this->mNode->text . " " . $this->mContentFlag . "</" . $this->mNode->tag . ">";
            }
            $this->mContent = str_replace($this->mContentFlag, $curContent, $this->mContent);
        }
        $this->mNode = new Node();
    }

    public function out() {
        $this->create();
        echo str_replace($this->mContentFlag, "", $this->mContent);
    }

    public function render() : String {
        $this->create();
        return str_replace($this->mContentFlag, "", $this->mContent);
    }

    private function parseProperties($properties): String {
        $prop = "";
        foreach ($properties as $key => $value) {
            $prop = $prop . $key . "='" . $value . "' ";
        }
        return $prop;
    }

}