FROM hyperf/hyperf:8.4-alpine-v3.21-swoole-slim

ARG USER
ARG GROUP
ENV USER $USER
ENV GROUP $GROUP

RUN if [ -z "`getent group $GROUP`"]; then \
    addgroup -g 1000 -S $GROUP ; \
fi

RUN if [ -z "`getent passwd $USER`"]; then \
    adduser -u 1000 -D -S -G $USER -h /app -g $GROUP $USER \
    && addgroup $USER bin \
    && addgroup $USER daemon \
    && addgroup $USER sys \
    && addgroup $USER adm \
    && addgroup $USER disk ; \
fi

COPY ./docker/php/scripts/ /

RUN chmod +x /docker-entrypoint.sh && chmod +x /usr/local/bin/composer

EXPOSE 9501 9502

ENTRYPOINT ["sh", "-c", "/docker-entrypoint.sh"]