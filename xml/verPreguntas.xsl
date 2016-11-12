<?xml version="1.0"?>

<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
    <head>
      <title>verPreguntasXSL</title>
    </head>
    <body>
      <div id='page-wrap'>
          <table border="1">
            <tr bgcolor="#9acd32">
              <th>TEMATICA</th>
              <th>COMPLEJIDAD</th>
              <th>ENUNCIADO</th>
            </tr>
            <xsl:for-each select="assessmentItems/assessmentItem">
              <tr>
                <td><xsl:value-of select="@subject"/></td>
                <td><xsl:value-of select="@complexity"/></td>
                <td><xsl:value-of select="itemBody/p"/></td>
              </tr>
            </xsl:for-each>
        </table>
        <a href="../php/verPreguntas.php"> Atras </a>
      </div>
    </body>
  </html>
</xsl:template>

</xsl:stylesheet>
