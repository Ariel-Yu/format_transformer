# Format_Transformer
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

$formatTransformer::transform();
```	

## Supported input file format

- cvs

## Supported output file format

- JSON
- XML
- HTML

## Configuration JSON

1. input
   - name: input file name
   - path: input file directory
   
2. output
   - name: output file name
   - path: output file directory
   
3. format
   - format: desired output file format
   - root: (only for XML format) root name  
   - element: (only for XML format) element name
   
4. validate
   - validate: if file content needs to be validated (true/false)
   - class: class for validation
   
5. sort
   - header: header in the file used to sort file content
   - order: sorting order
   
## Format_Transformer extensible

   1. input file format
   2. validator for validating different content
   3. output file format
