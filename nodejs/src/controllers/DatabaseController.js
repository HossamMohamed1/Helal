const oracledb = require("oracledb");
const readFromDatabase = async (req, res) => {
  //   res.send({ message: "Welcome" });
  let connection;
  try {
    connection = await oracledb.getConnection({
      user: "wakeb",
      password: "Wakeb@1230",
      connectionString: "172.20.0.151:1521/eservice",
    });

    result = await connection.execute(`select * from dep`, [], {
      resultSet: true,
      outFormat: oracledb.OUT_FORMAT_OBJECT,
    });

    const rs = result.resultSet;
    let row;

    let out = [];

    while ((row = await rs.getRow())) {
      if (row.DONE) console.log(row.DESCRIPTION, "is done");
      else console.log(row.DESCRIPTION, "is NOT done");
    }

    await rs.close();

    res.send({
      message: "Successfully connected to Oracle Database",
      res: out,
    });
  } catch (error) {
    console.error(error);
    res.send({
      message: "error in orcale connection",
      error: error?.message ?? error,
    });
  }
};

module.exports = { readFromDatabase };
