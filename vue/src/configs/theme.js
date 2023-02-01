export default {
  // global theme for the app
  globalTheme: 'light', // light | dark

  // side menu theme, use global theme or custom
  menuTheme: 'global', // global | light | dark

  // toolbar theme, use global theme or custom
  toolbarTheme: 'global', // global | light | dark

  // show toolbar detached from top
  isToolbarDetached: false,

  // wrap pages content with a max-width
  isContentBoxed: false,

  // application is right to left
  isRTL: true,

  // dark theme colors
  dark: {
    background: '#05090c',
    surface: '#111b27',
    primary: '#1e8e49',
    secondary: '#829099',
    accent: '#82B1FF',
    error: '#FF5252',
    info: '#2196F3',
    success: '#4CAF50',
    warning: '#FFC107'
  },

  // light theme colors
  light: {
    background: '#ffffff',
    surface: '#f2f5f8',
    primary: '#ED1C24',
    secondary: '#c9a1a1',
    accent: '#048ba8',
    error: '#ef476f',
    info: '#2196F3',
    success: '#06d6a0',
    warning: '#ffd166'
  }
}
