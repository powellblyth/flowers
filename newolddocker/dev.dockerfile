FROM 535789953418.dkr.ecr.eu-west-1.amazonaws.com/elasticstage-base:latest
WORKDIR /var/www
COPY --from=composer:1.9 /usr/bin/composer /usr/bin/composer
ARG CODEBUILD_SOURCE_VERSION
ENV BUGSNAG_APP_VERSION=$CODEBUILD_SOURCE_VERSION
