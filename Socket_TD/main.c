

#include <stdio.h>
#include <stdlib.h>

typedef struct{
	unsigned char jour;
	unsigned char mois;
	unsigned short int annee;
	char jourDeLaSemaine[10];	// le jour en toute lettre
}datePerso;

int main(int argc, char** argv) {
    int sock;
    struct sockaddr_in infoServer;
    int valeurEnvois;
    
    //Socket
    sock=socket(PF_INET,SOCK_DGRAM_IPPROTO_)
    
    
    return (EXIT_SUCCESS);
}

