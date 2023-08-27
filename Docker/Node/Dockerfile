FROM node:18

ARG UID=1000
ARG GID=1000

RUN apt-get -y update

ADD --chown=node:node ./Docker/Node/entrypoint.sh /home/node/bin/entrypoint.sh
RUN chmod +x /home/node/bin/entrypoint.sh

USER node

WORKDIR /home/node/app

CMD ["/home/node/bin/entrypoint.sh"]