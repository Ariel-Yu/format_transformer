<?php

namespace Ariel\Format_Transformer\FileTool;

/**
 * The implementation is responsible for sorting file content
 * by desired header
 */
interface FileSorterInterface
{
    /**
     * @param string Key used to sort the file
     * @param string Order which the file will be sorted by
     */
    public function sortFile(string $sortKey, string $sortOrder);
}
