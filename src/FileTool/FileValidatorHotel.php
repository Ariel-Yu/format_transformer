<?php

namespace Ariel\Format_Transformer\FileTool;

use Ariel\Format_Transformer\File\FileInterface;
use Ariel\Format_Transformer\Utility\UrlValidatorUtility;

class FileValidatorHotel implements FileValidatorInterface
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
     * Note: Invalid data will be removed from the file.
     */
    public function validateFile()
    {
        /**
         * Store file content that will be validated
         *
         * @var array
         */
        $validatedFileArray = array();
        
        /**
         * Keep track of invalid data and reset the key of array validatedFileArray
         *
         * @var int
         */
        $countInvalid = 0;
        
        $validatedFileArray = $this->file->getFileContentArray();
        
        foreach ($validatedFileArray as $fileRowKey => &$fileRowValue) {
            foreach ($fileRowValue as $fileContentKey => &$fileContentValue) {
                if ($fileContentKey == 0) {
                    /**
                     * Hotel name
                     *
                     * Rule: A hotel name must contain only UTF-8 characters
                     */
                    $encoding = mb_detect_encoding($fileContentValue, "UTF-8", true);
                    
                    if ($encoding != "UTF-8") {
                        $countInvalid++;
                        
                        unset($validatedFileArray[$fileRowKey]);
                        break;
                    }
                } elseif ($fileContentKey == 2) {
                    /**
                     * Hotel stars
                     *
                     * Rule: A hotel rating must be between 0 - 5 as a number
                     */
                    if (($fileContentValue >= 0) && ($fileContentValue <= 5)) {
                        /**
                         * Force hotel rating to be a number
                         */
                        $fileContentValue = (int)$fileContentValue;
                    } else {
                        $countInvalid++;
                        
                        unset($validatedFileArray[$fileRowKey]);
                        break;
                    }
                } elseif ($fileContentKey == 5) {
                    /**
                     * Hotel uri
                     * Rule: A hotel URL must be valid
                     */
                    if (UrlValidatorUtility::validateUrl($fileContentValue) === false) {
                        $countInvalid++;
                        
                        unset($validatedFileArray[$fileRowKey]);
                        break;
                    }
                }
            }
        }
        
        $validatedFileArray = array_values($validatedFileArray);
        $this->file->setFileContentArray($validatedFileArray);
    }
}
