<?php

namespace Ariel\Format_Transformer\Format;

use Ariel\Format_Transformer\File\FileInterface;

class FormatXML implements FormatInterface
{
    /**
     * A simple file object
     *
     * @var Ariel\Format_Transformer\File\FileInterface
     */
    private $file;
    
    /**
     * XML Root name, wraps whole file content
     *
     * @var string
     */
    private $rootName;
    
    /**
     * XML Element name, wraps each file content row
     *
     * @var string
     */
    private $elementName;
        
    /**
     * @param Ariel\Format_Transformer\File\FileInterface $file
     * @param string $rootName
     * @param string $elementName
     *
     * @return void
     */
    public function __construct(FileInterface $file, string $rootName, string $elementName)
    {
        $this->file = $file;
        $this->rootName = $rootName;
        $this->elementName = $elementName;
    }
    
    public function getRequiredFormat(): string
    {
        /**
         * Corresponding array to file header
         *
         * @var array
         */
        $fileHeadersArray = array();
        
        /**
         * Create a new dom document with pretty formatting
         *
         * @var /DomDocument
         */
        $doc = new \DomDocument();
        
        $doc->formatOutput = true;

        /**
         * Add a root node to the document
         */
        $root = $doc->createElement($this->rootName);
        $root = $doc->appendChild($root);
        
        $fileHeadersArray = $this->file->getFileHeaderArray();
        
        foreach ($this->file->getFileContentArray() as $fileRow) {
            $container = $doc->createElement($this->elementName);
            
            foreach ($fileRow as $key => $fileContent) {
                $fileHeader = $fileHeadersArray[$key];
                
                $child = $doc->createElement($fileHeader);
                $child = $container->appendChild($child);
                $value = $doc->createTextNode($fileContent);
                $value = $child->appendChild($value);
            }

            $root->appendChild($container);
        }
        
        $outputXML = $doc->saveXML();
        
        return $outputXML;
    }
}
