# rendimiento_final

1. docker-compose up -d
2. sudo chmod 777 -R backend/public/uploads/
3. acceder a las páginas
- http://localhost:8081/upload
- http://localhost:8081/search

**Rendimiento**

Se ha hecho un análisis del rendimiento del proyecto tanto al nivel del frontend como del backend.

En la parte del backend se ha utilizado el Blackfire con el que se ha observado el end point GET /search. Como se puede ver en los screenshots, la herramienta no ha detectado los problemas en cuanto al rendimiento. Los dos consejos propuestos se refieren a que el framwork no debe realizar el tracking de los recursos y usar el 'debug mode' si la aplicación está en el modo de producción.

![alt text](/backend/public/perfomance_images/blackfire1.png)

Las clases que están relacionadas con el end point del GET /search no tienen problemas con el rendimiento

![alt text](/backend/public/perfomance_images/blackfire2.png)

Con respeto a la parte del frontend, se ha utilizado la herramienta Lighthouse que ha detectado dos problemas:

![alt text](/backend/public/perfomance_images/lighthouse1.png)

Dado que se utiliza la librería Vuetify del Vue, no ha sido posible usar los plugins como 'purgecss' dado que no pueden leer los selectores dentro de los componentes que provienen de Vuetify.

En cuanto al sugundo problema de 'Preload key requests', para resolverlo se ha utilizado la librería 'preload-webpack-plugin'.

![alt text](/backend/public/perfomance_images/lighthouse2.png)
