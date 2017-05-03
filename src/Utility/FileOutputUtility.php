<?php

namespace Ariel\Format_Transformer\Utility;

/**
 * This class is responsible for outputting the input file string
 * with desired format into a file
 */
class FileOutputUtility
{
    /**
     * @param string $outputString String needs to be output
     * @param string $outputPath Full path name of output file
     *
     * @throws \Exception if fail outputting file
     */
    public static function outputFile(string $outputString, string $outputPath)
    {
        $handle = fopen($outputPath, "w");
                
        if (fwrite($handle, $outputString) === false) {
            throw new \Exception("Fail to output file '" . $outputPath . "'!\n");
        }
        
        fclose($handle);
    }
}
