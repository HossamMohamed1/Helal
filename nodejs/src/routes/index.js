const express = require("express");
const router = express.Router();

const { readFromDatabase } = require("../controllers/DatabaseController");
router.route("/").get(readFromDatabase);

module.exports = router;
