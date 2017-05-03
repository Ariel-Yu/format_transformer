<?php

namespace Ariel\Format_Transformer\Format;

/**
 * The implementation is responsible for outputting file into
 * desired format
 */
interface FormatInterface
{
    /**
     * @return string File in the desired format
     */
    public function getRequiredFormat(): string;
}
