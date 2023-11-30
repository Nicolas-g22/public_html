/* 
 *              Prog2
 * File:   main.c
 * Author: Guillier Nicolas
 *
 * Created on 4 octobre 2023, 14:30
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
    typePartage *data = NULL;
    int pid1, pid2;
    int taille = sizeof(typePartage);
    char buffer[255];
    //creation de la zone mémoire partagée
    system("touch /tmp/1234");
    if ((clef = ftok("/tmp/1234", 1234) == -1)){ // generation d'une clef
        perror(ftok);
        exit(2);
    } 
    
    //     Creation du segment de memoire partagee avec des permission en 0600
    int id = shmget(clef, taille, IPC_CREAT | 0600);
    if(id == -1){
        printf("Pb avec le shmget : %s\n", strerror(errno));
        exit(errno);
    }
    // attribution adresse virtuelle du segment en lecture/ecriture
    data = (typePartage *) shmat(id, NULL, SHM_W);
    if (data == (void *)-1)
    {
        printf("Pb avec le shmat : %s\n",strerror(errno));
        exit(errno);
    }
    
    // duplication de processus
    pid2 = getpid();
    // P2 est le processus fils
    pid2 = fork();
    // algo de P2
    if(pid2 == -1){
        perror("Erreur lors de la création de P2");
        exit(1);
    }
    else if (pid2 == 0){
        do{ // dans une boucle infini   
            //si flagProg2 de la memoire partagee est à 1
            if(data->flagProg2 == 1){
                 //flagProg2 de la memoire partagee prend la valeur 0
                data->flagProg2 = 0;
                //afficher le contenu du champ message de la memoire partagee
                printf("%s\n", data->message);
                //finsi
            }
            //attendre 1 seconde
            sleep(1000);
        // fin boucle
        }while(1); 
    }
    
    
    //P1 est le processus pere
    pid1 = fork();
    // algo de P1
    if(pid1 == -1){
        perror("Erreur lors de la création de P2");
        exit(1);
    }
    else if (pid1 == 0){
        // faire
        do{
            //demander a l'utilisateur de saisir une chaine de caractere
            printf("Prog 1 : message :");
            scanf("%s", &buffer);
            printf("\n");
            //tant que flagProg1 de la memoire partagee est à 1
            while(data->flagProg1 == 1){
                //afficher un message d'attente
                printf("wait...");    
                //attendre 1 seconde
                sleep(1000);
            } //fin tant que
            
            //copier le message saisi par l'utilisateur dans le champs message de la memoire partagee        
            strcpy(data->message, buffer);
            //flagProg1 de la memoire partagee prend la valeur 1
            data->flagProg1 = 1;
        
        }while(strcmp(buffer,"fin" )); // tant que le message saisi par l'utilisateur n'est pas "fin"
        // envoyer SIGTERM au processus fils
        kill(pid2, SIGTERM);
        // attendre la fin du processus fils
        wait(pid2);
    }
    return (EXIT_SUCCESS);
}