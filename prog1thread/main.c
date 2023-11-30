/*      prog1thread
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
#include <pthread.h>
#include "zone.h"


typedef struct {
    int descripteurTube;
    typePartage *partage;

} typeIds;

// ressource partagee par les 3 threads
int theend;

void *thread_lecture(void *arg) {
    int descripteurTubeEcriture = ((typeIds*) arg)->descripteurTube;
    typePartage *part = ((typeIds*) arg)->partage;
    char msg[TAILLE_MAX_MESSAGE];
    int fin;

    fin = theend;

    while (fin == 0) {
        if (part->flagProg2 == 1) {
            part->flagProg2 = 0;
            // copier le contenu du champs message de la memoire partagee dans msg
            strcpy(msg ,((typePartage*)arg)->message);
            // ecrire msg dans le tube via descripteurTubeEcriture
            
        }
        
        sleep(1);
        
        fin = theend;
    }
    pthread_exit((void *) NULL);
}

void *thread_affichage(void *arg) {
    
    int descripteurTubeLecture;
    char msg[TAILLE_MAX_MESSAGE];
    int fin;
    // mettre la valeur du descripteur de lecture du tube transmis par arg
    // dans la variable descripteurTubeLecture
    strcpy(descripteurTubeLecture, arg);
    
    
    fin = theend;
    // tant que fin vaut 0
    while(fin == 0){
    //      lire le message dans le descripteur de lecture du tube et le stocker dans msg
        strcpy(msg, descripteurTubeLecture);
    //      afficher msg
        printf("%s", msg);
    //      fin prend la valeur de theend
        fin = theend;
    //fin tant que
    }

    pthread_exit((void *) NULL);
}

void *thread_redaction(void *arg) {
    typePartage *part;
    char msg[TAILLE_MAX_MESSAGE];    
    int fl1;
    // mettre la valeur du pointeur vers la zone de memoire partagee transmis par arg
    // dans la variable part
    strcpy(*part, *arg);
    
    do {
        // demander a l'utilisateur de saisir une chaine de caractere
        printf("Saisissez une chaine de caractere : ");
        // et la stocker dans msg
        scanf("%s", msg);
        printf("\n");


        fl1 = part->flagProg1;

        while (fl1 == 1) {
            printf("il reste des messages non lus. Tentative de mise à jour dans 1 seconde\n");
            sleep(1);

            fl1 = part->flagProg1;

        }
        // copier le message saisi par l'utilisateur dans le champs message de la memoire partagee
        strcpy(part, msg);
        
        part->flagProg1 = 1;


    } while (strcmp(msg, "fin") != 0); // tant que msg n'est pas egal à "fin"
    
    theend = 1;

    pthread_exit((void *) NULL);
}

int main(int argc, char** argv) {
    key_t clef;
    int id;
    typePartage *partage;    
    typeIds param;
    int res;
    // declaration des variables necessaires    
   
    
    // init de la zone commune aux thread
    theend = 0;

    
    system("touch /tmp/1234");
    clef = ftok("/tmp/1234", 1234); // generation d'une clef
    
    // Creation du segment de memoire partagee avec des permission en 0600
    int id = shmget(clef, sizeof(typePartage), IPC_CREAT | 0600);
    if(id == -1){
        printf("Pb avec le shmget : %s\n", strerror(errno));
        exit(errno);
    }
    // attribution adresse virtuelle du segment en lecture/ecriture
    partage = (typePartage *) shmat(id, NULL, SHM_W);
    if (partage == (void *)-1)
    {
        printf("Pb avec le shmat : %s\n",strerror(errno));
        exit(errno);
    }
    
    // creation du tube


        // assignation de la valeur du descripteur d'ecriture du tube
        // dans le champ descripteurTube de param

        // assignation de la valeur du pointeur vers la zone de memoire partagee
        // dans le champ partage de param

        // creation du thread ecouteur avec en parametre l'adresse de param


        // creation du thread afficheur avec en parametre l'adresse du descripteur 
        // de lecture du tube


        // creation du thread redacteur avec en parametre partage 
        // (qui est la variable de type pointeur sur la zone de memoire partagee

        
        // attente de la fin du thread ecouteur
        // attente de la fin du thread afficheur
        // attente de la fin du thread redacteur
    

    return (EXIT_SUCCESS);
}


