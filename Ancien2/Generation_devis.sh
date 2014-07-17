#!/bin/bash
cd ;
cd /home/aneva/Documents/STAGE_imosoweb/Installation_git ;

if [ $# != 13 ]; then
echo "Le nombre d'arguments de la fonction doit être de 12. Vérifiez.";
exit 0;
fi



file="variables.tex"

nomouSocieteduclient=$1
prenomclient=$2
prixht=$5
civilite=$3
dateemission=$4
acompte=$6
adresssebien=$7
codepostalebien=$8
villedubien=$9
surface=$10
tyepbien=$11
objet=$12
tva=$13

prixttc=$((($prixht*$tva)/100+$prixht));

compilateurlatex="pdflatex -no-file-line-error ";

if [$prenomclient=""];
then pdfname=Devis_$nomouSocieteduclient.pdf
else pdfname=Devis_$nomouSocieteduclient$prenomclient.pdf
fi

echo "\newcommand{\numeroclient}{$numclient}" > /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\nomclient}{$nomouSocieteduclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prenom}{$prenomclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\civilite}{$civilite}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

echo "\newcommand{\objet}{$objet}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\idDevi}{$idbien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixht}{$prixht}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\dateemission}{$dateemission}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixttc}{$prixttc}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

echo "\newcommand{\adressebien}{$adresssebien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\codepostalebien}{$codepostalebien}">> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\villebien}{$villedubien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\acompte}{$acompte}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixmoinsacompte}{$prixmoinsacompte}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

$compilateurlatex Devis_template.tex;
mv Devis_template.pdf $pdfname;
evince $pdfname;

rm Devis_template.log;
rm Devis_template.aux;
rm Devis_template.dvi;
 
		 echo "fait"

