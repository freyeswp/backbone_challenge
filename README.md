# Solución

1. Descargar la base de datos de códigos postales en formato XLS
2. Convertir a formato JSON el archivo XLS y formatear
3. Incluir en el storage del proyecto el JSON file con los códigos postales `\json\zip_codes.json`
4. Crear el controlador `ZipCodesController`
5. Crear la función show
6. Dentro de la función show:
   - Obtener la data dentro de `zip_codes.json`
   - Se realiza una consulta para buscar todas las coincidencias del `zip_code` solicitado en la petición
   - Se recorren los resultados obtenidos de las consultas para obtener un array de `settlements`
   - Se declara un array para sustituir los caracteres especiales
   - Se genera un array para la estructura en la respuesta solicitada
   - Se genera la respuesta y el estatus de la respuesta
   - Todo lo anterior dentro de un `try - catch` para atrapar posibles errores
7. Se genera la ruta dentro del archivo api.php
     
