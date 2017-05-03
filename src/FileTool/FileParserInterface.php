<?php

namespace Ariel\Format_Transformer\FileTool;

/**
 * The implementation is responsible for parsing file into header array
 * and content array in order to have a standard processing form for the
 * purpose of transforming file(s) into desired format(s) later on
 *
 * Recent format support [2017/05/03]:
 * Input: CVS
 * Output: JSON, XML, HTML
 */
interface FileParserInterface
{

    /**
     * @return void
     *
     * @throws \Exception if file path is invalid
     */
    public function parseFileArrays();
}
