<?php

namespace Ariel\Format_Transformer\FileTool;

use Ariel\Format_Transformer\File\FileInterface;

class FileSorter implements FileSorterInterface
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
    
    public function sortFile(string $sortKey, string $sortOrder)
    {
        /**
         * Store file content that will be sorted
         *
         * @var array
         */
        $sortedArray = array();
        
        /**
         * Store file content that is used as pivot to
         * sort the entire array
         *
         * @var array
         */
        $sortingArray = array();

        $sortedArray = $this->file->getFileContentArray();
        
        foreach ($this->file->getFileHeaderArray() as $key => $value) {
            if ($value === $sortKey) {
                $sortKey = $key;
            }
        }
        
        foreach ($sortedArray as $fileRow) {
            foreach ($fileRow as $key => $fileContent) {
                if ($key == $sortKey) {
                    $sortingArray[] = $fileContent;
                }
            }
        }
        
        if ($sortOrder == "ASC") {
            array_multisort($sortingArray, SORT_ASC, $sortedArray);
        } elseif ($sortOrder == "DESC") {
            array_multisort($sortingArray, SORT_DESC, $sortedArray);
        }
        
        $this->file->setFileContentArray($sortedArray);
    }
}
