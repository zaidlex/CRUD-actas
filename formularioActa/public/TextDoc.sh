#!/bin/bash
#Para poder ejecutar el script 
#Ir a etc/sudoers y agregar al final.
#www-data ALL=(ALL) NOPASSWD: /home/zruiz/formularioActa/public/ArchivoGuardar.sh


#Parametros
#directorio     nombre del documento con extension(.doc,docx)	nombre del documento 
#$1		$2						$3

dirDoc=$1$2
txt=$1$3"txt"

#crea un txt del texto del doc (no lo elimina)
export HOME=/tmp/ && libreoffice --headless --convert-to "txt:Text (encoded):UTF8" $dirDoc --outdir $1

#elimina los espacios de mas y los tabuladores
sed -i 's/^ *//; s/ *$//; /^$/d; /^\s*$/d; s/^\t*//; s/\t*$//;' $txt

#obtiene el texto del .txt
texto=`cat $txt |sed ':a;N;$!ba;s/\n/ /g' `
rm $txt

echo $texto

