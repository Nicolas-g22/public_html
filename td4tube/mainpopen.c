#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>
#include <unistd.h>
#include <sys/wait.h>
#define MAXBUFF 255
int main()
{
    int pid1, pid2;
    int status;
    int descTube[2];
    
    const char chaine[255];
    char buffer [255] = "";
    
    int nbOctets = 0;
    
    pid1 = getpid();
    
    if(pipe(descTube)== 0){
        printf("descripteur de tube lecture %d \n", descTube[0]);
        printf("descripteur de tube ecriture %d \n", descTube[1]);
        pid2 = fork();
    }
    
    if(pid2 == 0){
        printf("Je suis le fils\n");
        
        nbOctets = read(descTube[0], buffer, 255);
        printf("Octets lus: %d %s\n", nbOctets, buffer);
    }
    else{
        printf("Je suis le processeur père\n");
        sleep(1);
        nbOctets = write(descTube[0], chaine, strlen(chaine));
        
    }
    
    
    return 0;
}
