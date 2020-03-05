FROM node:latest as frontend

WORKDIR /app

COPY . .

RUN npm config set "@fortawesome:registry" \
    https://npm.fontawesome.com/ && \
    npm config set "//npm.fontawesome.com/:_authToken" F60C4F92-E5D0-47EF-A4E7-629CEE0422FD

RUN yarn install && yarn prod
