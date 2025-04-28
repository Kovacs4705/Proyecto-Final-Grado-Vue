# Proyecto-Final-Grado-Vue

Kale Connecting Worlds - Proyecto Final de Grado compuesto por David Kovacs y Alejandro Solar Ruiz

Entregables: Documentación en formato presentación para el día de la defensa. Debe ser explicativa del funcionamiento de la aplicación web, relaciones de base de datos, paleta de colores, objetivos. Indicar las posibles mejoras a futuro para implementar en el proyecto, analisis de datos, estadísticas, ampliaciones... Modelo entidad – relación correspondiente a la base de datos.

Código de la aplicación web que cumpla las siguientes funcionalidades y requisitos: El código deberá estar debidamente comentado e indentado, de modo que facilite su lectura y comprensión.

FRONT-END: Tecnologías de desarrollo: • HTML • JAVASCRIPT • CSS

Se debe obtener la información relativa a los productos, actividades, información y otro contenido de la página desde la base de datos, esto permitirá su modificación sin necesidad de cambiar el código, mientras que la información recogida en la barra de navegación, footer o elementos principales de la aplicación web deberán recogerse directamente desde su directorio local para minimizar las peticiones al servidor de base de datos.

La Web contendrá un apartado que permita tanto registrarse como iniciar sesión desde cualquiera de sus partes. El registro y acceso se realizará mediante un formulario que deberá validar que los datos introducidos tienen un formato correcto antes de enviarlos al servidor. La contraseña en el formulario de registro se ha de verificar mediante dos entradas de texto para evitar la creación de contraseñas erroneas.

Los estilos podrán realizarse mediante el empleo de la biblioteca de Bootstrap o en un archivo de estilos en CSS pero en cualquier caso deberá ser adaptativa para al menos dos tamaños de pantalla, permitir un modo de alto contraste y letras grandes o al menos algún mecanismo que facilite la accesibilidad a la aplicación.

De igual forma deberá presentar al menos una animación por ejemplo tras el envío del formulario de registro, al identificarse o en cualquier otro apartado o elementos de la aplicación Deben existir mínimo tres modelos de acceso a la página. • Invitado (usuarios sin registrar) con acceso limitado.

• Usuario registrado con acceso a todos los elementos de la Web excepto a los elementos de administración. • Administrador con acceso a todos los elementos de la Web incluidos los elementos de administración. La parte de administración debe presentar una forma sencilla de interactuar con los datos que se muestren al resto de usuarios, así como una comprobación del tipo y valor de los datos para que no se puedan introducir datos erroneos.

BACK-END: Tecnologías de desarrollo: • PHP • SQL

Desde la página del administrador se deberán poder modificar los datos que se encuentren en la base y que presente la web y deberá poder gestionar los usuarios.

Se debe comprobar que el usuario existe en la base de datos al iniciar sesión, y en el caso de que se este registrando debe consultarse si no existe el mismo DNI, correo electrónico o nombre de usuario. Así como verfificar que el formato de los datos es correcto antes de incluirlos en la base de datos. El registro y acceso se realizará mediante un formulario que deberá validar que los datos introducidos tienen un formato correcto antes de enviarlos al servidor, así como una comprobación del tipo y valor de los datos para que no se puedan introducir datos erroneos.

La conexión a la base de datos deberá realizarse desde un archivo independiente al resto, que se utilice con una llamada dentro de cada archivo.
