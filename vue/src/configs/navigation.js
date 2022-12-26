const menus = {
  // main navigation - side menu
  menu: [
    {
      text: "",
      key: "",
      items: [
        {
          icon: "mdi-view-dashboard-outline",
          key: "menu.dashboard",
          text: "Dashboard",
          link: "/dashboard/analytics"
        }
      ]
    },
    {
      text: "",
      key: "",
      items: [
        {
          icon: "mdi-file-cog-outline",
          key: "menu.reports",
          items: [
            {
              key: "menu.employees",
              link: "/reports/employees"
            },
            {
              key: "menu.permits",
              link: "/reports/permits"
            },
            {
              key: "menu.complaints",
              link: "/reports/complaints"
            }
          ]
        },
        {
          icon: "mdi-account-multiple-outline",
          key: "menu.usersManagement",
          items: [
            {
              key: "menu.users",
              link: "/users/list"
            },
            {
              key: "menu.roles",
              link: "/roles/list"
            }
          ]
        },
        {
          icon: "mdi-cog-outline",
          key: "menu.settings",
          items: [
            {
              key: "menu.general",
              link: "/settings/information"
            },
            {
              key: "menu.mailTemplate",
              link: "/settings/mail-template"
            },
            {
              key: "menu.mailServer",
              link: "/settings/mail-server"
            },
            {
              key: "menu.sms",
              link: "/settings/sms"
            }
          ]
        }
      ]
    }
  ]
};

export default menus;
