#!/bin/bash

if [ $# != 19 ]; then
echo "Le nombre d'arguments de la fonction doit être de 19. Vérifiez.";
exit 0;
fi

#cd /home/aneva/Documents/STAGE_imosoweb/Installation_git ;

file="variables.tex"

nomouSocieteduclient=$1
prenomclient=$2
numclient="on verra"
addresseclient=$3
cpclient=$4
ville=$5
mail=$6
idbien=$7
prixht=$8
tva=$9
dateemission=$10
prixcarre=$11
#remise ordre à vérifier
remise=$12
#demander si il y aura des frais forfaitaires ou pas
fraisforfaitaires=$13
adresssebien=$14
codepostalebien=$15
villedubien=$16
surface=$17
tyepbien=$18
objet=$19

prixttc=($prixht*$tva)/100+$prixht;

compilateurlatex="pdflatex -no-file-line-error ";

if [$prenomclient=""];
then pdfname=$nomouSocieteduclient.pdf
else pdfname=$nomouSocieteduclien_$prenomclient.pdf
fi

echo "\newcommand{\numeroclient}{$numclient}" > /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\nomclient}{$nomouSocieteduclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prenom}{$prenomclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\adresseclient}{$addresseclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\codepostaleclient}{$cpclient}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\villeclient}{$ville}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\emailclient}{$mail}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

echo "\newcommand{\objet}{$objet}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\idbien}{$idbien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixht}{$prixht}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\tva}{$tva}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\dateemission}{$dateemission}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixcarre}{$prixcarre}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\remise}{$remise}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\fraisdedossier}{$fraisforfaitaires}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\prixttc}{$prixttc}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

echo "\newcommand{\adressebien}{$adresssebien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\codepostalebien}{$codepostalebien}">> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\villebien}{$villedubien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\surface}{$surface}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex
echo "\newcommand{\typebien}{$tyepbien}" >> /home/aneva/Documents/STAGE_imosoweb/Installation_git/variables.tex

$compilateurlatex Facture_template.tex;
mv Facture_template.pdf $pdfname;
evince $pdfname;
 
		 echo "fait"

