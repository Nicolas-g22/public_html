/* 
 *              Prog1
 * File:   main.c
 * Author: 
 *
 * Created on 3 octobre 2023, 15:20
 *  
 */

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/shm.h>
#include <sys/sem.h>
#include <string.h>
#include <errno.h>
#include <wait.h>
#include <signal.h>
#include "zone.h"


int main(int argc, char** argv) {
    key_t clef;
    // declaration des variables necessaires


    //creation de la zone mémoire partagée
    system("touch /tmp/1234");
    clef = ftok("/tmp/1234", 1234); // generation d'une clef

    //     Creation du segment de memoire partagee avec des permission en 0600

    // attribution adresse virtuelle du segment en lecture/ecriture

    // duplication de processus

    // P2 est le processus fils
    // algo de P2
    // dans une boucle infini
    //      si flagProg2 de la memoire partagee est à 1
    //          flagProg2 de la memoire partagee prend la valeur 0
    //          afficher le contenu du champ message de la memoire partagee
    //      finsi
    //      attendre 1 seconde
    //fin boucle
    
    //P1 est le processus pere
    // algo de P1
    // faire
    //      demander a l'utilisateur de saisir une chaine de caractere
    //      tant que flagProg1 de la memoire partagee est à 1
    //          afficher un message d'attente
    //          attendre 1 seconde
    //      fin tant que
    //      copier le message saisi par l'utilisateur dans le champs message de la memoire partagee
    //      flagProg1 de la memoire partagee prend la valeur 1
    // tant que le message saisi par l'utilisateur n'est pas "fin"
    // envoyer SIGTERM au processus fils
    // attendre la fin du processus fils

    return (EXIT_SUCCESS);
}

