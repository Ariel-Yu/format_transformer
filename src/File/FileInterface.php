<?php

namespace Ariel\Format_Transformer\File;

/**
 * Represents a single file
 */
interface FileInterface
{
    /**
     * @return array File header
     */
    public function getFileHeaderArray(): array;
    
    /**
     * @return array File content
     */
    public function getFileContentArray(): array;

    /**
     * @param array $fileHeadersArray File header
     *
     * @return void
     */
    public function setFileHeaderArray(array $fileHeadersArray);
    
    /**
     * @param array $fileContentArray File content
     *
     * @return void
     */
    public function setFileContentArray(array $fileContentArray);
}
