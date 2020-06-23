FROM node:latest

# set working directory
WORKDIR /var/www/html/frontend

ENV PATH /var/www/html/frontend/node_modules/.bin:$PATH

COPY package.json ./

RUN npm install
RUN npm install -g @vue/cli
RUN npm install -g @vue/cli-service

# start app
CMD ["npm", "run", "serve"]
