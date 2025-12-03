const express = require("express");
const Redis = require("ioredis");

const app = express();
app.use(express.json());

const redis = new Redis({
  host: "redis",
  port: 6379
});

app.post("/trigger", handleAlerts);

async function handleAlerts(req, res) {
    try {
        console.log("Alert received:", JSON.stringify(req.body));

        for (const alert of req.body.alerts || []) {
            const route = alert.labels?.route || "unknown";

            console.log("Enabling SPX for:", route);

            await redis.setex(`spx:${route}`, 60, "1");
        }

        res.sendStatus(200);
    } catch (e) {
        console.error(e);
        res.sendStatus(500);
    }
}



app.listen(8081, () => {
  console.log("SPX trigger listening on 8081");
});
