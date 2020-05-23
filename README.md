# Format-Transformer
Author: Ariel (En-Tzu) Yu
Amendment Date: 2017/05/01

Programming Language: PHP

## Initialization

The suggested initialization method is via [composer] (https://getcomposer.org/):

``` sh
composer update
```

## Usage

Transform input file into desired format:

``` php
$formatTransformer = new FormatTransformer();

$formatTransformer::formatTransform();
```	

## Supported input file format

- cvs

## Supported output file format

- JSON
- XML
- HTML

## Configuration JSON

1. input
   - path: input file directory
   
2. output
   - path: output file directory
   - format: desired file output format
   
3. validate
   - validate: if file content needs to be validated (true/false)
   - name: name of the validator, usually is the name of the file (singular)
   
4. sort
   - header: header in the file used to sort the file content
   - order: sorting order
   
5. XML   
   - root: root name  
   - element: element name
   
## Format_Transformer extensible

   1. input file format
   2. validator for validating different data content
   3. output file format
