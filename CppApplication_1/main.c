#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
int main ( int argc, char *argv[] )
{
/*
	int pid1,pid2;
	pid1 = fork();
	if ( pid1 == 0 )
	{
		//boite("boite1b","pid1=0");
		pid2 = fork();
		if ( pid2 == 0 )
		{
			boite("boite2","pid2=0");
		}
		else
		{			
			boite("boite3","pid2<>0");
		}
	}
	else
	{
		boite("boite4","pid1<>0");
	}
 */
    
    int pid;
    //p1
    pid = fork ();
    if (pid == 0){//p3
        pid=fork();
        if (pid==0){//p2
            printf("p2\n");
            
        }
        else{//p3
            pid=fork();
            if(pid==0){//p4
                printf("p4\n");
            }
            else{//p3
                pid=fork();
                if (pid==0){//p5
                    pid = fork();
                    if(pid==0){ //p6
                        printf("p6\n");
                    }
                    else{ //p5
                        pid = fork();
                        if(pid == 0){//p7
                            
                        }
                        else{
                            printf("p5\n");
                        }
                    }
                }
                else{ //p3
                    printf("p3\n");
                }
            }
        }
    }
    
    else{
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	return EXIT_SUCCESS;

}