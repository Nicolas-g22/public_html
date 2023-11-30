
// P3 affiche le contenu de la zone partagée

#include <sys/types.h> 
#include <sys/shm.h> 
#include <sys/ipc.h> 
#include <errno.h> 
#include <time.h> 
#include <unistd.h> 
#include <stdlib.h> 
#include <stdio.h>
#include <string.h>
#include "mem.h"



int main(int argc, char *argv[])
{
        int id ;
        key_t clef;
        typeZoneMem *zone;
        clef = ftok("/tmp/bidon",1234);  // generation d'une clef
        // Création du segment mémoire partagée
        // de la taille de la structure typeZoneMem
        // en lecture/ecriture pour le proprio
        id = shmget(clef, sizeof(typeZoneMem), IPC_CREAT | 0600);
        if (id == -1){
            
            if(errno != EEXIST){
                printf("pb shmget : %s\n", strerror(errno));
                exit(errno);
            }
        }
        zone = shmat(id, NULL, SHM_RDONLY);
        if(zone == (void *)-1 ){
            printf("pb shmat : %s\n", strerror(errno));
            exit(errno);
        }
        
        
        while(1==1){
            sleep(2);
            printf("pression : %d temperature %.2f ordre : %c\n", zone->press, zone->temp, zone->ordre);
        }
}

