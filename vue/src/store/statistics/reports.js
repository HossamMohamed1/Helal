const reports = [
  {
    title: "employees.employeesByDepartment",
    chart: "employee_department",
    type: [{ text: "line", value: "line" }],
  },
  {
    title: "employees.employeesByGender",
    chart: "employee_gender",
    type: [
      { text: "donut", value: "pie" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesByHeadquarters",
    chart: "employee_location",
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "pie", value: "pie" },
      { text: "donut", value: "pie" },
    ],
  },
  {
    title: "employees.employee_nationality",
    chart: "employee_nationality",
    type: [{ text: "bar", value: "bar" }],
  },
  {
    title: "employees.employeesAccordingToTheirQualifications",
    chart: "employee_qualification",
    type: [{ text: "line", value: "line" }],
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
];

export default reports;
