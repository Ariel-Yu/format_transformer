<?php

namespace Ariel\Format_Transformer\FileTool;

/**
 * The implementation is responsible for validating file content.
 * Validation rules will be different from data sources (ex:
 * airspace, airfield, hotel ...).
 */
interface FileValidatorInterface
{
    /**
     * @return void
     */
    public function validateFile();
}
