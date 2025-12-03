const express = require("express");
const Redis = require("ioredis");

const app = express();
app.use(express.json());

const redis = new Redis({
  host: "redis",
  port: 6379
});



app.listen(8081, () => {
  console.log("SPX trigger listening on 8081");
});
