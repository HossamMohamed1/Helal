const reports = [
  {
    title: "employees.employeesByDepartment",
    chart: "employee_department",
    type: ["line"],
  },
  {
    title: "employees.employeesByGender",
    chart: "employee_gender",
    type: ["donut", "pie"],
  },
  {
    title: "employees.employeesByHeadquarters",
    chart: "employee_location",
    type: ["bar", "line", "pie"],
  },
  {
    title: "employees.employee_nationality",
    chart: "employee_nationality",
    type: ["bar"],
  },
  {
    title: "employees.employeesAccordingToTheirQualifications",
    chart: "employee_qualification",
    type: ["line"],
  },
  {
    title: "employees.employeesAccordingToTheirRanks",
    chart: "employee_major",
    type: ["line"],
  },
  {
    title: "employees.employee_job",
    chart: "employee_job",
    type: ["line"],
  },
  // {
  //   title: "employees.EmployeesAccordingAttendance",
  //   chart: "employee_absence",
  //   type: ["pie"],
  // },
  {
    title: "employees.department_status",
    chart: "department_status",
    type: ["bar"],
  },
  {
    title: "employees.department_location",
    chart: "department_location",
    type: ["bar"],
  },
];

export default reports;
