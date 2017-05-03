<?php

namespace Ariel\Format_Transformer\Format;

use Ariel\Format_Transformer\File\FileInterface;

class FormatJSON implements FormatInterface
{
    /**
     * A simple file object
     *
     * @var Ariel\Format_Transformer\File\FileInterface
     */
    private $file;
    
    /**
     * @param Ariel\Format_Transformer\File\FileInterface $file
     *
     * @return void
     */
    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }
    
    public function getRequiredFormat(): string
    {
        /**
         * Stores file content in JSON format
         *
         * @var array
         */
        $fileJSON = array();
        
        foreach ($this->file->getFileContentArray() as $fileRow) {
            $fileJSON[] = array_combine($this->file->getFileHeaderArray(), $fileRow);
        }
        
        /**
         * Encode into pretty JSON formatting
         */
        $outputJSON = json_encode($fileJSON, JSON_PRETTY_PRINT);
        
        return $outputJSON;
    }
}
