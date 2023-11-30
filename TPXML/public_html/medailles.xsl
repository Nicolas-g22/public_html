<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <head>
                <style>
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                <h1>Classement des médailles olympiques</h1>
                <table>
                    <tr>
                        <th>Pays</th>
                        <th>Or</th>
                        <th>Argent</th>
                        <th>Bronze</th>
                        <th>Total</th>
                    </tr>
                    <xsl:for-each select="JeuxOlympiques/Classement/Pays">
                        <tr>
                            <td><xsl:value-of select="Nom"/></td>
                            <td><xsl:value-of select="Medaille[@typeDeMedaille='or']"/></td>
                            <td><xsl:value-of select="Medaille[@typeDeMedaille='argent']"/></td>
                            <td><xsl:value-of select="Medaille[@typeDeMedaille='bronze']"/></td>
                            <td><xsl:value-of select="TotalMedailles"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
