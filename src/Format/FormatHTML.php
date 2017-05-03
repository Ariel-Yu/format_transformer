<?php

namespace Ariel\Format_Transformer\Format;

use Ariel\Format_Transformer\File\FileInterface;

class FormatHTML implements FormatInterface
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
         * Output HTML string
         * Put file content into HTML table format
         *
         * @var string
         */
        $outputHTML = "";
        
        $outputHTML .= "<tr>"."\n";
        
        /**
         * Table header
         */
        foreach ($this->file->getFileHeaderArray() as $fileHeader) {
            $outputHTML .= "\t" . "<td>" . $fileHeader . "</td>" . "\n";
        }
        
        $outputHTML .= "</tr>" . "\n";
        
        /**
         * Table Content
         */
        foreach ($this->file->getFileContentArray() as $fileRow) {
            $outputHTML .= "<tr>" . "\n";
            
            foreach ($fileRow as $fileContent) {
                $outputHTML .= "\t" . "<td>" . $fileContent . "</td>" . "\n";
            }
            
            $outputHTML .= "</tr>" . "\n";
        }

        $outputHTML = "<!DOCTYPE html>" . "\n" .
                      "<html>" . "\n" .
                      "<body>" . "\n\n" . "<table>" . "\n" . $outputHTML . "\n" . "</table>" . "\n\n" .
                      "</body>" . "\n" . "</html>";
        
        return $outputHTML;
    }
}
