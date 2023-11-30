<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    
    <xsl:template match="biblio">
        <html>
            <head>
                
                <link href="biblio.css" rel="stylesheet" type="text/css"/>
            
            
            </head>
            <body>
                <xsl:apply-templates />
            </body>
        </html>
    </xsl:template>
    
    
    
    <xsl:template match="allee">
        <h1 class="allee">Allée <xsl:value-of select="@numero"/> </h1>
              
        <xsl:apply-templates />
    </xsl:template>
    
    <xsl:template match="rayon">
        <p class="rayon">Rayon
            <xsl:value-of select="@numero"/>
        </p>
        <table>
            <tr>
                <th>Catégorie</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Numéro</th>
            </tr>            
            <xsl:apply-templates />
        </table>
    </xsl:template>
    
    <xsl:template match="ouvrage">
        <tr>
            <td class="type">
                <xsl:value-of select="@type"/>
            </td>
            <xsl:apply-templates />
        </tr>
    </xsl:template>
            
    <xsl:template match="nomouvrage">
        <td class="titre">
            <xsl:value-of select="."/>
        </td>
    </xsl:template>
            
            
            
    <xsl:template match="auteur">
        <td class="auteur">
            <xsl:value-of select="."/>
                    
        </td>
        <xsl:if test="../numouvrage = false()">
            <td class="null" ></td>
        </xsl:if>
    </xsl:template>
                
                
                
    <xsl:template match="numouvrage">    
        <td class="numouvrage">   
            <xsl:value-of select="."/>
                    
        </td>
    </xsl:template>    
    

</xsl:stylesheet>
