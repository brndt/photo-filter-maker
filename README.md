# Simple photo filter maker

Photo filter maker developed using Clean Architecture concepts.

Technologies used: PHP 7, Symfony, RabbitMQ, Docker, Mysql, Elasticsearch Nginx, Vue

## Application execution

To start the project you need:

1. Install [Docker](https://docs.docker.com/get-docker/)
2. Clone the project `git clone git@github.com:brndt/photo-filter-maker.git`
3. [Set vm.max_map_count to at least 262144](https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html#_set_vm_max_map_count_to_at_least_262144)
4. Run the command `make build`
5. Access to the following URLs:
   * [Upload photo](http://localhost:8081/upload)
   * [Search photo](http://localhost:8081/search)