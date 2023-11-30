/* 
 * File:   zone.h
 * Author: Guillier Nicolas
 *
 * Created on 4 octobre 2023, 14:30
 */

#ifndef ZONE_H
#define ZONE_H
#define TAILLE_MAX_MESSAGE 255

#ifdef __cplusplus
extern "C" {
#endif

 typedef struct {
        char message[TAILLE_MAX_MESSAGE];
        unsigned short int flagProg1;
        unsigned short int flagProg2;        
    } typePartage;


#ifdef __cplusplus
}
#endif

#endif /* ZONE_H */

