<?php

namespace Ariel\Format_Transformer\FileTool;

use Ariel\Format_Transformer\File\FileInterface;

class FileParserCSV implements FileParserInterface
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

    /**
     * Parse input file and put into header and content arrays
     */
    public function parseFileArrays()
    {
        /**
         * Corresponding array to file header
         *
         * @var array
         */
        $fileHeader = array();
        
        /**
         * Corresponding array to file content
         *
         * @var array
         */
        $fileContent = array();

        if (($fileRows = fopen($this->file->filePath, 'r')) !== false) {
            $fileHeader = fgetcsv($fileRows);

            while (($fileRow = fgetcsv($fileRows)) !== false) {
                $fileContent[] = $fileRow;
            }
            
            $this->file->setFileHeaderArray($fileHeader);
            $this->file->setFileContentArray($fileContent);
            
            fclose($fileRows);
        } else {
            throw new \Exception("Input file " . $this->file->filePath . " is invalid!\n");
        }
    }
}
