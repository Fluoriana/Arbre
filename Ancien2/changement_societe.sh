#newprez="Flit"
#regexprez="^.newcommand..president"
pdflatex -no-file-line-error Facture_template.tex;
evince Facture_template.pdf;

#-------------------------CHANGEMENT DE D'ADRESSE DE L'ENTREPRISE-------------------------#
#	oldprez=`grep "$regexprez" $file`;mo



#	if [ "$oldprez" != "" ];
#		then 
#		oldprez=`echo "$oldprez" | cut -d'}' -f2 | cut -c "2-$(( ${#oldprez} + 1 ))"`;
#echo $oldprez;
#echo $newprez;

#		sed -i 's/'$oldprez'/'$newprez'/' script #sed affiche les modfications dans le terminal mais le fichier d'origine reste intacte||||sed-i n'affiche rien mais applique le résulat directrment su le fichier
#sed remplace toutes les occurrences de $oldprez dans le script par $newprez
		
#		oldprez=$(echo "$oldprez" | sed 's#\\#\\\\#g'); #on échappe les caractères
		
		
#		temp=`cat $file | sed "0,\#${oldprez}#s##${newprez}#"` 

#		echo "$temp" > $file
#---------------------------------------------------#
