FROM node:18

WORKDIR /src

COPY index.js .

RUN npm init -y && npm install express ioredis

CMD ["node", "index.js"]
