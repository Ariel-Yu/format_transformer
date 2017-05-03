<?php

namespace Ariel\Format_Transformer\File;

/**
 * Represents a single file
 */
class SimpleFile implements FileInterface
{
    /**
     * Full path name of the file
     *
     * @var string
     */
    public $filePath;
    
    /**
     * A 1-dimensional array
     * Store file headers ex: ["name", "address", "stars", "contact", "phone", "uri"]
     *
     * @var array
     */
    private $fileHeadersArray = array();
    
    /**
     * A 2-dimensional array
     * Store file content ex: [126]["ED-R118 Pirmasens", "Restricted", "0", "GND", "3300", "MSL"]
     *
     * @var array
     */
    private $fileContentArray = array();
    
    /**
     * @param string $filePath Full path name of the file
     *
     * @return void
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFileHeaderArray(): array
    {
        return $this->fileHeadersArray;
    }
    
    public function getFileContentArray(): array
    {
        return $this->fileContentArray;
    }
    
    public function setFileHeaderArray(array $fileHeadersArray)
    {
        $this->fileHeadersArray = $fileHeadersArray;
    }
    
    public function setFileContentArray(array $fileContentArray)
    {
        $this->fileContentArray = $fileContentArray;
    }
}
