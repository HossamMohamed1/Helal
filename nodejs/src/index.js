const express = require("express");
// *** ADD ***
const v1Router = require("./routes");

const app = express();
const PORT = process.env.PORT || 3000;

// *** ADD ***
app.use("/", v1Router);

app.listen(PORT, () => {
  console.log(`API is listening on port ${PORT}`);
});
