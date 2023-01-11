import i18n from "@/plugins/vue-i18n";
const reports = [
  {
    title: i18n.t("employees.employeesByGender"),
    chart: "employee_gender",
    type: "pie",
  },
  {
    title: i18n.t("employees.employeesByGender"),
    chart: "employee_location",
    type: "line",
  },
];

export default reports;
