#!/bin/bash

#
pdfsandwich -rgb -nthreads 12 -lang spa -o sandwich.pdf oficial.pdf #2&>1 /dev/null
#

#
soffice --headless --convert-to pdf original.doc #2&>1 /dev/null

pdftk original.pdf burst output original_%02d.pdf

pdftotext original_01.pdf - | tr ' ' '\n' | tr -d '+\"!|.,()”:\234' | sort | uniq > words.txt

convert -density 300 original.doc -type Grayscale -compress lzw -background white +matte -depth 8 tiff.pdf #2&>1 /dev/null

pdftk tiff.pdf burst output original_%02d.pdf

convert -density 300 original_01.pdf -type Grayscale -compress lzw -background white +matte -depth 8 tiff_01.tif #2&>1 /dev/null

tesseract -l spa --user-words words.txt tiff_01.tif stdout out hocr > original_01.hocr #2&>1 /dev/null

pdftk oficial.pdf burst output oficial_%02d.pdf

convert -density 300 oficial_01.pdf -type Grayscale -compress lzw -background white +matte -depth 8 oficial_01.tif #2&>1 /dev/null

hocr2pdf -i oficial_01.tif -o unificada.pdf < original_01.hocr
#

#chown esolchaga.esolchaga *
