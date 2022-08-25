//Open a localhost port on locahost:400
const express = require("express");
const path = require("path");

// We use the express.static middleware to serve static files from the frontend folder.
const app = express();

//Whenever we make a request to the server, we will send back a response 
app.use("/static", express.static(path.resolve(__dirname, "frontend", "static")));

// Any file gets sent to the client as a static file
app.get("/*", (_req, res) => {
    res.sendFile(path.resolve(__dirname, "frontend", "index.html"));
});

app.listen(process.env.PORT || 400 , () => console.log("Server started"));