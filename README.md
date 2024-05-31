
# Mapas Culturais

**Iniciativa Cívica de Criação de Ferramentas de Gestão Cultural**

Mapas Culturais é uma plataforma colaborativa que reúne informações sobre agentes, espaços, eventos e projetos culturais. Ela fornece ao poder público uma radiografia da área de cultura e ao cidadão um mapa de espaços e eventos culturais da região.

## Comandos Docker
https://hub.docker.com/r/softagon/mapasculturais 
### Construção da Imagem Docker

Para construir a imagem Docker, execute o seguinte comando no diretório raiz do projeto:

```bash
docker build -t mapacultural:latest -f docker/Dockerfile .
```

### Executar com Docker Compose

Para iniciar os serviços usando Docker Compose, execute:

```bash
docker-compose up
```



## Apoio da Softagon

A Softagon apoia o projeto Mapas Culturais como uma iniciativa open-source, disponibilizando um contêiner de fácil instalação para promover a gestão cultural de forma acessível e colaborativa. Para mais informações, visite o repositório oficial no GitHub: [Mapas Culturais](https://github.com/mapasculturais/mapasculturais).

## Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está licenciado sob a [ AGPL-3.0 license](LICENSE).
