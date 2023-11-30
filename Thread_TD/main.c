#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/syscall.h>
#include <pthread.h>
#include <signal.h>
/*
typedef struct {
	int v1;
	int v2;
	int v3;
}laStruct;


void *FonctionP1(void *arg) {
    // Code exécuté par le thread
    return 0;
}

void *FonctionP2(void *arg) {
    // Code exécuté par le thread
    return 0;
}

void *FonctionP3(void *arg) {
    // Code exécuté par le thread
    return 0;
}

int main() {
    pthread_t p1, p2, p3;
    
    pthread_create(&p1, NULL, FonctionP1, NULL);
    pthread_create(&p2, NULL, FonctionP2, NULL);
    pthread_create(&p3, NULL, FonctionP3, NULL);
}
*/


typedef struct {
	int v1;
	int v2;
	int v3;
}laStruct;

void* tache1(void *p_data);
void* tache2(void *p_data);
void* tache3(void *p_data);

laStruct global;

//Création du mutex
    pthread_mutex_t verrou = PTHREAD_MUTEX_INITIALIZER; 

int main(int argc, char** argv){
    int res[3];
    pthread_t T[3];
    int a[3] = {10 , 20 , 30};
    void *retour;
    global.v1 = 1;
    global.v2 = 2;
    global.v3 = 3;
    
    
      
    
    res[0] = pthread_create(&T[0], NULL, tache1, (void *)&a[0]);
    if(res[0]!=0){
        printf("Erreur de création du thread 1!");
    }
    res[0] = pthread_join(T[0], &retour);  
    
   
    res[1] = pthread_create(&T[1], NULL, tache2, (void *)&a[1]);
    if(res[1]!=0){
        printf("Erreur de création du thread 2!");
    }
    res[1] = pthread_join(T[1], &retour);
   
    res[2] = pthread_create(&T[2], NULL, tache3, (void *)&a[2]);
    if(res[2]!=0){
        printf("Erreur de création du thread 3!");
    }
    res[2] = pthread_join(T[2], &retour);
    
    
    //fin du main
    
    

    printf("V1 = %d\nV2 = %d\nV3 = %d\n", global.v1, global.v2, global.v3);
    printf("fin de la tache main");
    
    return(EXIT_SUCCESS);
}

void* tache1(void *p_data){
    int tid = 0;
    tid = syscall(SYS_gettid);
    printf("Je suis T1 TID = %d\n", tid);
    
    pthread_mutex_lock(&verrou);
    global.v1 = *(int *)p_data;
    global.v2 = *(int *)p_data;
    global.v3 = *(int *)p_data;
    pthread_mutex_unlock(&verrou);
}

void* tache2(void *p_data){
    int tid = 0;
    tid = syscall(SYS_gettid);
    printf("Je suis T2 TID = %d\n", tid);
    
    pthread_mutex_lock(&verrou);
    global.v1 = *(int *)p_data;
    global.v2 = *(int *)p_data;
    global.v3 = *(int *)p_data;
    pthread_mutex_unlock(&verrou);
    
}

void* tache3(void *p_data){
    int tid = 0;
    tid = syscall(SYS_gettid);
    printf("Je suis T3 TID = %d\n", tid);
    
    pthread_mutex_lock(&verrou);
    global.v1 = *(int *)p_data;
    global.v2 = *(int *)p_data;
    global.v3 = *(int *)p_data;
    pthread_mutex_unlock(&verrou);
}
