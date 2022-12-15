export default [{
  path: '/settings/general',
  name: 'settings-general',
  component: () => import(/* webpackChunkName: "settings-general" */ '@/pages/settings/general/InformationPage.vue')
}, {
  path: '/settings/information',
  name: 'settings-information',
  component: () => import(/* webpackChunkName: "settings-information */ '@/pages/settings/general/InformationPage.vue')
}, {
  path: '/settings/properties',
  name: 'settings-properties',
  component: () => import(/* webpackChunkName: "settings-properties" */ '@/pages/settings/general/PropertiesPage.vue')
}, {
  path: '/settings/notifications',
  name: 'settings-notifications',
  component: () => import(/* webpackChunkName: "settings-notifications" */ '@/pages/settings/general/NotificationsPage.vue')
}, {
  path: '/settings/theme',
  name: 'settings-theme',
  component: () => import(/* webpackChunkName: "settings-colors */ '@/pages/settings/general/ThemePage.vue')
}, {
  path: '/settings/mail-template',
  name: 'settings-mail-template',
  component: () => import(/* webpackChunkName: "settings-mail-template */ '@/pages/settings/mail/MailTemplatePage.vue')
}, {
  path: '/settings/mail-server',
  name: 'settings-mail-server',
  component: () => import(/* webpackChunkName: "settings-mail */ '@/pages/settings/mail/MailServerPage.vue')
}, {
  path: '/settings/sms',
  name: 'settings-sms',
  component: () => import(/* webpackChunkName: "settings-sms */ '@/pages/settings/sms/SMSPage.vue')
}]
