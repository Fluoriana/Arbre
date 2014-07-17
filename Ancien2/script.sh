#!/bin/bash

if [ $# != 0 ]; then
echo "Le nombre d'argument ne doit pas être différent de zéro.";
exit 0;
fi

set $(ls); 

file="variables.tex"
newprez="Pomme"
regexprez="^.newcommand..president"
	
	oldprez=`grep "$regexprez" $file`;



	if [ "$oldprez" != "" ];
		then 
		sed -i 's/Bonjour/echo '$newprez'/' script #sed affiche les modfications dans le terminal mais le fichier d'origine reste intacte||||sed-i n'affiche rien mais applique le résulat directrment su le fichier
		oldprez=`echo "$oldprez" | cut -d'}' -f2 | cut -c "2-$(( ${#oldprez} + 1 ))"`;
		oldprez=$(echo "$oldprez" | sed 's#\\#\\\\#g'); #on échappe les caractères
		echo $oldprez;
		
		temp=`cat $file | sed "0,\#${oldprez}#s##${newprez}#"` 

		echo "$temp" > $file
		echo "fait"
	fi
#echo '$oldprez'

		
#Definition des variables dépendant des arguments
varspath="$squelettedir/inputs/vars.tex"
compilateurlatex="pdflatex -no-file-line-error -halt-on-error";
#--------------------------------------------------------------------------------------------------------------------------------------------#
#--------------------------------------------------------------------------------------------------------------------------------------------#
#Fin du traitement et de l'interface ici
# On passe aux actions à effectuer
echo "Application des actions demandées..."
case $option in
	N)			
		# Nom du document 
		cvtname=`echo "CVT ETU $nom $prenom"| tr ' ' _`

		echo "\newcommand{\prenomadherent}{$prenom}" >> $varspath
		echo "\newcommand{\nomadherent}{$nom}" >> $varspath
		echo "\newcommand{\dateversion}{$dateversion}" >> $varspath
		
		ref=${cvtname//_/\\_\{\}} # substitution de chaines par bash permettant d'éviter un appel à tr ou à sed
		echo "\newcommand{\cvtadhref}{$ref}" >> $varspath

		echo "\newcommand{\adresseadherent}{" >> $varspath
		echo "$adressel1\\\\" >> $varspath
		echo "$adressel2\\\\" >> $varspath
		if [[ "$adressel3" != "" ]]; then
			echo "$adressel3\\\\" >> $varspath
			if [[ "$adressel4" != "" ]]; then
				echo "$adressel4\\\\" >> $varspath
				if [[ "$adressel5" != "" ]]; then
					echo "$adressel5\\\\" >> $varspath
				fi
			fi
		fi
		echo "}" >> $varspath
		
		echo "\renewcommand{\destinealimpression}{$imprimable}" >> $varspath 

		pdfname="$cvtname.pdf"
		compile;
				
		if [[ "$showpdf" == "oui" ]]; then
			$visionneusepdf $pdfname;
		fi
		;;


compile () {
	echo "--- Lancement de la phase de compilation ---"
	dir_save=$(pwd)
	cd $squelettedir;

	#head enlève la dernière ligne car on supprime le fichier cité par la suite
	$compilateurlatex cvtadh.tex | tail -n15 | head -n14; #On laisse la 1e compilation s'afficher en partie, pour des raisons de facilité de débug
	$compilateurlatex cvtadh.tex | tail -n2 | head -n1; # on vérifie aussi que la 2e compilation s'est bien passée, avec moins de verbosité cependant, car ici on ne fait que vérifier.

	source="cvtadh.pdf"
	if [[ ! -e $source ]]; then
		echo
		echo "/!\ Erreur en sortie de compilation: le fichier attendu ($squelettedir/$source) n'existe pas."
		echo "Veuillez regarder les lignes générées par \"$compilateurlatex\" pour obtenir plus d'informations."
		exit 
	fi

	dest="../$this_script_relative_dir/$pdfname"
	dest_dir=$(dirname $dest)
	if [[ ! -d $dest_dir ]] || [[ "$dest_dir" == "/" ]]; then
		echo "/!\ Erreur lors du déplacement du fichier: celui-ci ($squelettedir/$source) existe bel et bien mais son répertoire de destination ($dest_dir) n'existe pas ou est protégé en écriture."
		exit 
	fi

	mv $source $dest;

	rm *.log; #efface deux fichiers créés par pdflatex mais inutiles à notre niveau. Cf note précédente sur head.
	cd $dir_save;
	echo "--- Fin de la phase de compilation ---"

	if [[ "$imprimable" != "oui" ]]; then
		echo
		printf '\033[1;34m' #colore le texte
		echo "N'oubliez pas l'option -i si vous voulez rendre le document imprimable sur du papier à en-tête."
		printf '\033[0m' #on remet la couleur standart
	fi
	cd $dir_save
}

