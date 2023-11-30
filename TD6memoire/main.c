#include <sys/types.h> 
#include <sys/shm.h> 
#include <sys/ipc.h> 
#include <errno.h> 
#include <time.h> 
#include <unistd.h> 
#include <stdlib.h> 
#include <stdio.h>
#include <string.h>
#include "zone.h"

float randomF(){ 
	return ((float)100.0*(rand()/(RAND_MAX+0.1))); 
} 

int randomI(){ 
	return ((int)100.0*(rand()/(RAND_MAX+0.1))); 
}



int main(int argc, char** argv) {
    
    typeDonnees *data = NULL;
    key_t key;
    int id;
    
    if ((key = ftok("/tmp/bidon",1234))== -1){
            perror("ftok");
            exit(2);
        }
    
    id = shmget(key, sizeof(typeDonnees), IPC_CREAT | 0600);
    if (id==-1)
    {
        printf("pb avec shmget : %s \n",strerror(errno));
        exit(errno);
    }

    data = (typeDonnees *) shmat(id, NULL, SHM_W);
    if (data == (void *)-1)
    {
        printf("pb avec shmat : %s \n",strerror(errno));
        exit(errno);
    }
    
    while (1){
        data->press = randomI();
        data->temp = randomF();
        /*printf("pression = %2d, temperature = %2.2f, ordre = %c\n",data->press,data->temp,data->ordre);*/
        sleep(2);
    }

    
    
    return (EXIT_SUCCESS);
}

