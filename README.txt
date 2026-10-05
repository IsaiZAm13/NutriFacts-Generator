NutriCatalog - Generador

1. Copia esta carpeta dentro de C:\xampp\htdocs\NutriCatalog\
2. Abre http://localhost/NutriCatalog/
3. Para guardar etiquetas, XAMPP/Apache debe tener permisos de escritura sobre esta carpeta.
4. Los PDF se guardan en etiquetas/ y los registros en labels.json.
5. La funcion original downloadPDF() se conserva sin modificar.
6. El boton nuevo usa html2canvas y un generador PDF independiente para evitar el error de canvas tainted por foreignObject.
