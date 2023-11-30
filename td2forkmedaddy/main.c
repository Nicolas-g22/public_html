#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <signal.h>
#include <errno.h>
#include <string.h>
int main(int argc, char *argv[]) {
int sigusr1_count = 0;

void traitement(int signum) {
    if (signum == SIGUSR1) {
        int pid1 = getpid();
        printf("P1 (PID : %d) a reçu un signal SIGUSR1\n", pid1);
    }
}

    /*
        int pid1, pid2;
        int cpt = 0;
        pid1 = fork();
        if (pid1 == 0) {
            cpt++;
            pid2 = fork();
            if (pid2 == 0) {
                cpt++;
                printf("dans petit fils cpt=%d a l'adresse %p\n", cpt, &cpt);
            } else {
            
                printf("dans fils cpt=%d a l'adresse %p\n", cpt, &cpt);
            }
        } else {
        
            printf("dans pere cpt=%d a l'adresse %p\n", cpt, &cpt);
        }
     */

/*
    char buffer[255];
    int pid1, pid2;
    pid1 = fork();
    if (pid1 == 0) {
        snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
        boite("boite1", buffer);
        pid2 = fork();
        if (pid2 == 0) {
            snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
            boite("boite2", buffer);
        } else {
            snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
            boite("boite3", buffer);
        }
    } else {
        snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
        boite("boite4", buffer);
    }
*/
    
/*
    int pid1, pid2, pid3;
    char buffer[255];
        pid1 = fork();
        if (pid1 == 0) {
            snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
            pid2 = fork();
            sleep(2);
            if (pid2 == 0) {
                snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
                pid3 = fork();           
                sleep (4);
                if (pid3 ==0){
                    snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
                    int pid = wait(NULL);
                }
                
                else{
                    snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
                }
                
            } 
            else {
                snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
                
            }
        } 
        
        else {
        
            snprintf(buffer, 255, "mon pid est %d, le pid de mon pere est %d", getpid(), getppid());
        }
*/
    






    int pid1, pid2, pid3;
    pid1 = getpid();

    
    pid2 = fork();

    if (pid2 == -1) {
        perror("Erreur lors de la création de P2");
        exit(1);
    } else if (pid2 == 0) {
        
        sleep(1); 
        printf("P2 envoie un signal SIGUSR1 à P1 (PID : %d)\n", pid1);
        kill(pid1, SIGUSR1);
        exit(0);
    }

    
    pid3 = fork();

    if (pid3 == -1) {
        perror("Erreur");
        exit(1);
    } else if (pid3 == 0) {
       
        sleep(1); 
        printf("P3 envoie un signal SIGUSR1 à P1 (PID : %d)\n", pid1);
        kill(pid1, SIGUSR1);
        exit(0);
    }

   
    signal(SIGUSR1, traitement); 
    printf("P1 (PID : %d) attend des signaux SIGUSR1 de P2 et P3...\n", pid1);

    int sig_count = 0;
    while (sig_count < 2) {
        pause(); 
    }

    printf("P1 (PID : %d) a reçu 2 signaux SIGUSR1 de P2 et P3.\n", pid1);

    
    wait(NULL);
    wait(NULL);








    
    
    
    return EXIT_SUCCESS;
}