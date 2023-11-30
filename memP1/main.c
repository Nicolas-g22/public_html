
// P1 met a jour temperature te pression dans la zone partagee

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

float randomF(){ 
	return ((float)100.0*(rand()/(RAND_MAX+0.1))); 
} 

int randomI(){ 
	return ((int)100.0*(rand()/(RAND_MAX+0.1))); 
}

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
                printf("pb shmget : %s\n",strerror(errno));
                exit(errno);
            }
        }
        zone = shmat(id, NULL, SHM_W);
        if(zone == (void *)-1 ){
            printf("pb shmat : %s\n",strerror(errno));
            exit(errno);
        }
        while(1==1){
            zone->press=randomI();
            zone->temp=randomF();
            sleep(2);
            printf("pression : %d temperature %.2f\n", zone->press, zone->temp);
        }
}

