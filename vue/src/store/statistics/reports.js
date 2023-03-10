const reports = [
  {
    title: "employees.employeesByDepartment",
    chart: "employee_department",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesInPublicAgenciesAndAdministrations",
    chart: "employee_public_department",
    filter_able: true,
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesByGender",
    chart: "employee_gender",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employee_retirement",
    chart: "employee_retirement",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "pie", value: "pie" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employee_age",
    chart: "employee_age",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "pie", value: "pie" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.age_distribution_for_employees",
    chart: "age_distribution_for_employees",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employeesByHeadquarters",
    chart: "employee_location",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "pie", value: "pie" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employee_nationality",
    chart: "employee_nationality",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employeesAccordingToTheirQualifications",
    chart: "employee_qualification",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employeesAccordingToTheirRanks",
    chart: "employee_major",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employee_job",
    chart: "employee_job",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
      { text: "pie", value: "pie" },
    ],
  },
  {
    title: "employees.employee_experience",
    chart: "employee_experience",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.employee_major_for_years",
    chart: "employee_major_for_years",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  // employee_major_for_years

  // {
  //   title: "employees.EmployeesAccordingAttendance",
  //   chart: "employee_absence",
  //   filter_able: false,
  //   type: [
  //     { text: "area", value: "line" },
  //     { text: "spline", value: "line" },
  //     { text: "line", value: "line" },
  //
  //     { text: "bar", value: "bar" },
  //     { text: "pie", value: "pie" },
  //
  //   ],
  // },
  {
    title: "employees.department_status",
    chart: "department_status",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.department_location",
    chart: "department_location",
    filter_able: false,
    type: [
      { text: "pie", value: "pie" },
      { text: "bar", value: "bar" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.department_age",
    chart: "department_age",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "pie", value: "pie" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
  {
    title: "employees.department_less_five_employee",
    chart: "department_less_five_employee",
    filter_able: false,
    type: [
      { text: "bar", value: "bar" },
      { text: "pie", value: "pie" },
      { text: "line", value: "line" },
      { text: "spline", value: "line" },
      { text: "area", value: "line" },
    ],
  },
];

export default reports;
