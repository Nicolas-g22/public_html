
#include <stdio.h>
#include <unistd.h>
#include <stdlib.h>
#include <string.h>
#include <pthread.h>
#include <sys/syscall.h>

char message[255];	// Zone commune

void *ma_fonction_thread(void *arg) {
    int *PtrParam=(int *) arg;
    printf("dans le thread œl'argument etait :%d\n", *PtrParam);
    printf("pid du thread : %d Tid : %ld\n", getpid(), syscall(SYS_gettid));
    sleep(3);
    strcpy(message, "Bye!");
    pthread_exit((void *)"merci pour le temps CPU");
}



int main() {
    int res;
    pthread_t un_thread;
    void *thread_result;
    int param = 32;
    
	strcpy(message,"Debian inside");
        printf("pid du programme principal : %d Tid : %ld\n", getpid(), syscall(SYS_gettid));
    
	res = pthread_create(&un_thread, NULL, ma_fonction_thread, (void *)&param);
    if (res != 0) {
        perror("Thread creation failed");
        exit(EXIT_FAILURE);
    }
    printf("attente de la fin du thread...\n");
    
	res = pthread_join(un_thread, &thread_result);
    if (res != 0) {
        perror("Thread join a foir... echoué");
        exit(EXIT_FAILURE);
    }
    printf("OK, valeur de retour du Thread join :%s\n", (char *)thread_result);
    printf("Le message est maintenant %s\n", message);
    exit(EXIT_SUCCESS);
}