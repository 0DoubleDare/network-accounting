FROM ubuntu:latest
LABEL authors="nikita"

ENTRYPOINT ["top", "-b"]

#TODO: Если не лень будет напишу докер контейнер для сайта