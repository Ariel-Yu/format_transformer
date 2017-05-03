<?php

namespace Ariel\Format_Transformer;

use Ariel\Format_Transformer\File\SimpleFile;

use Ariel\Format_Transformer\FileTool\FileParserCSV;
use Ariel\Format_Transformer\FileTool\FileValidatorHotel;
use Ariel\Format_Transformer\FileTool\FileSorter;

use Ariel\Format_Transformer\Format\FormatJSON;
use Ariel\Format_Transformer\Format\FormatXML;
use Ariel\Format_Transformer\Format\FormatHTML;

use Ariel\Format_Transformer\Utility\FileOutputUtility;

/**
 * This class is the public portal to use Format_Transformer
 */
class FormatTransformer
{
    /**
     * Full path name of the configuration file
     *
     * @var string
     */
    public static $config = __DIR__ . '/../config.json';
    
    /**
     * @throws \Exception if input file format is not supported
     * @throws \Exception if validator is not supported
     * @throws \Exception if output file format is not supported
     */
    public static function formatTransform()
    {
        /**
         * Store content of the configuration file
         *
         * @var array
         */
        $configArray = array();
        
        if ($configArray = json_decode($configJSON = file_get_contents(self::$config), true)) {
            /**
             * The root path
             *
             * @var string
             */
            $rootPath = dirname(__DIR__);

            /**
             * The root namespace
             *
             * @var string
             */
            $rootNamespace = __NAMESPACE__;

            /**
             * The input file path
             *
             * @var string
             */
            $inputPath = $configArray['input'][0]['path'];

            /**
             * Whether or not validating the input file(s)
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $validate = $configArray['validate'][0]['validate'];

            /**
             * The name(s) of the validator(s)
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $validatorName = $configArray['validate'][0]['name'];

            /**
             * Sort the input file(s) according to the header(s)
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $sortHeader = $configArray['sort'][0]['header'];

            /**
             * The sorting order(s)
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $sortOrder = $configArray['sort'][0]['order'];

            /**
             * The output file path
             *
             * @var string
             */
            $outputPath = $configArray['output'][0]['path'];

            /**
             * The output file format(s)
             *
             * @var array
             */
            $formats = $configArray['output'][0]['format'];

            /**
             * The root name of XML format
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $XMLRoot = $configArray['XML'][0]['root'];

            /**
             * The element name of XML format
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $XMLElement = $configArray['XML'][0]['element'];

            /**
             * Store names of all input files
             *
             * As the order of the files in the folder sorted ascendingly
             *
             * @var array
             */
            $inputNames = array_values(array_diff(
                scandir($rootPath . '\\' . $inputPath),
                array('.', '..')
            ));
            
            foreach ($inputNames as $key => $inputName) {
                /**
                 * @var Ariel\Format_Transformer\File\FileInterface
                 */
                $file = new SimpleFile($rootPath . '\\' . $inputPath . $inputName);

                $fileExtension = pathinfo($inputName, PATHINFO_EXTENSION);
                
                /**
                 * Parse the input file
                 */
                $fileParserName = $rootNamespace . '\FileTool\FileParser' . strtoupper($fileExtension);
                
                if (class_exists($fileParserName)) {
                    /**
                     * @var Ariel\Format_Transformer\FileTool\FileParserInterface
                     */
                    $fileParser = new $fileParserName($file);
                    $fileParser->parseFileArrays();
                } else {
                    throw new \Exception("Not supported input file format " .
                                            strtoupper($fileExtension) . "!\n");
                }
                
                /**
                 * Validate the input file
                 */
                if ($validate[$key] === "true") {
                    $validatorClass = $rootNamespace . '\FileTool\FileValidator' . $validatorName[$key];

                    if (class_exists($validatorClass)) {
                        /**
                         * @var Ariel\Format_Transformer\FileTool\FileValidatorInterface
                         */
                        $fileValidator = new $validatorClass($file);
                        $fileValidator->validateFile();
                    } else {
                        throw new \Exception("Not supported validator " . $validatorName[$key] . "!\n");
                    }
                }
                
                /**
                 * Sort the input file
                 *
                 * @var Ariel\Format_Transformer\FileTool\FileSorterInterface
                 */
                $fileSorter = new FileSorter($file);
                $fileSorter->sortFile($sortHeader[$key], $sortOrder[$key]);
                
                /**
                 * Convert the input file(s) to the desired format(s)
                 */
                $outputString = "";

                $outputName = substr($inputName, 0, strpos($inputName, "."));

                foreach ($formats as $format) {
                    $outputFormat = $rootNamespace . '\Format\Format' . strtoupper($format);

                    if (class_exists($outputFormat)) {
                        /**
                         * @var Ariel\Format_Transformer\Format\FormatInterface
                         */
                        if ($format != 'XML') {
                            $outputFormat = new $outputFormat($file);
                        } else {
                            $outputFormat = new $outputFormat($file, $XMLRoot[$key], $XMLElement[$key]);
                        }

                        $outputString = $outputFormat->getRequiredFormat();
                                                
                        /**
                         * @var Ariel\Format_Transformer\Utility\FileOutputUtility
                         */
                        $fileOutputUtility = new FileOutputUtility();
                        $fileOutputUtility::outputFile(
                            $outputString,
                            $rootPath . '\\' . $outputPath . $outputName. '.' . $format
                        );
                    } else {
                        throw new \Exception("Not supported output file format " . strtoupper($format));
                    }
                }
            }
        } else {
            throw new \Exception("Configuration file " . self::$config . " is invalid!\n");
        }
    }
}
