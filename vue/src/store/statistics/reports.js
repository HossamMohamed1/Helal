const reports = [
  {
    title: "employees.employeesByDepartment",
    chart: "employee_department",
    type: [
      { text: "column", value: "bar" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
      { text: "donut", value: "pie" },
    ],
  },
  {
    title: "employees.employeesByGender",
    chart: "employee_gender",
    type: [
      { text: "column", value: "bar" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesByHeadquarters",
    chart: "employee_location",
    type: [
      { text: "column", value: "bar" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employee_nationality",
    chart: "employee_nationality",
    type: [
      { text: "column", value: "bar" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesAccordingToTheirQualifications",
    chart: "employee_qualification",
    type: [
      { text: "column", value: "bar" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesAccordingToTheirRanks",
    chart: "employee_major",
    type: [{ text: "line", value: "line" }],
  },
  {
    title: "employees.employee_job",
    chart: "employee_job",
    type: [{ text: "line", value: "line" }],
  },
  {
    title: "employees.employee_age",
    chart: "employee_age",
    type: [
      { text: "column", value: "bar" },
      { text: "line", value: "line" },
    ],
  },
  // {
  //   title: "employees.EmployeesAccordingAttendance",
  //   chart: "employee_absence",
  //   type: ["pie"],
  // },
  {
    title: "employees.department_status",
    chart: "department_status",
    type: [{ text: "bar", value: "line" }],
  },
  {
    title: "employees.department_location",
    chart: "department_location",
    type: [{ text: "bar", value: "bar" }],
  },
  // {
  //   title: "employees.department_age",
  //   chart: "department_age",
  //   type: [
  //     { text: "bar", value: "bar" },
  //     { text: "line", value: "line" },
  //   ],
  // },
];

export default reports;
