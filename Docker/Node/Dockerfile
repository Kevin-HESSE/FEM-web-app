FROM node:18

ARG UID=1000
ARG GID=1000

RUN apt-get -y update

USER node

WORKDIR /home/node/app

CMD ["yarn", "watch"]