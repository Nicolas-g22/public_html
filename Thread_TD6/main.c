//Inclusions
#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/syscall.h>
#include <pthread.h>
#include <signal.h>
#include <time.h> 
#include <errno.h> 
#include <sys/ipc.h> 
#include <sys/shm.h>

//Création de la structure
typedef struct {
	float temp;
	int press;
	char ordre;
}laStruct;

//Définition des fonctions
void *FonctionP1(void *p_data);
void *FonctionP2(void *p_data);
void *FonctionP3(void *p_data);
int randomI();
float randomF();

//Initialisation d'une variable laStruct
laStruct global;

//Création du mutex
pthread_mutex_t verrou = PTHREAD_MUTEX_INITIALIZER; 

//Processus principal
int main(int argc, char** argv) {
    int id;
    //Création de la clé
    key_t cle;    
    if(cle = ftok("/tmp/bidon", 1234) == -1){
        perror("ftok");
        exit(2);
    }
    
    //Création mémoire partagé
    int ret = shmget(cle, sizeof(laStruct), IPC_CREAT | 0600);
    
    //Obtenir l'adresse de la mémoire partagée
    global = shmat(id, NULL, SHM_W);
        
    //Création des 3 thread
    pthread_t P[3];
    
    //Initialisation des variables de la structure
    global.temp = randomF();
    global.press = randomI();
    
    //Création d'un indice
    int i;
    
    //Création d'une variable de retour
    void *retour;
    
    //Création de variables 
    int res[3];
    
    int x = 0;
    
    //Bouclage du programme
    do{
    
        //Thread P1
        res[0] = pthread_create(&P[0], NULL, FonctionP1, (void *)&x);
        if(res[0]!=0){
            printf("Erreur de création du thread P1!");
        }
        res[0] = pthread_join(P[0], &retour);  

        //Thread P2
        res[1] = pthread_create(&P[1], NULL, FonctionP2, (void *)&x);
        if(res[1]!=0){
            printf("Erreur de création du thread P2!");
        }
        res[1] = pthread_join(P[1], &retour);

        //Thread P3
        res[2] = pthread_create(&P[2], NULL, FonctionP3, (void *)&x);
        if(res[2]!=0){
            printf("Erreur de création du thread P3!");
        }
        res[2] = pthread_join(P[2], &retour);
        
        
        
        
        
        i++;
    }while(i<10);
    
    
    
    return (EXIT_SUCCESS); // Fin du processus principal
}

//Fonctions
void *FonctionP1(void *p_data){
    
    
}

void *FonctionP2(void *p_data){
    
    
    
}

void *FonctionP3(void *p_data){
    
    
    
}

int randomI(){ // Fonction random int
	return ((int)100.0*(rand()/(RAND_MAX+0.1))); 
}

float randomF(){ // Fonction random float 
	return ((float)100.0*(rand()/(RAND_MAX+0.1))); 
}