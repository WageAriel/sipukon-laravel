import {
  mdiAccountCircle,
  mdiMonitor,
  mdiGithub,
  mdiLock,
  mdiAlertCircle,
  mdiSquareEditOutline,
  mdiTable,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact
} from '@mdi/js'

export default [
  {
    route: 'dashboard',
    icon: mdiMonitor,
    label: 'Dashboard'
  },
  {
    to: '/data-pengguna',
    icon: mdiMonitor,
    label: 'Data Pengguna'
  },
  {
    to: 'data-buku',
    icon: mdiMonitor,
    label: 'Data Buku'
  },
  // {
  //   to: 'Data Buku',
  //   icon: mdiMonitor,
  //   label: 'Dashboard'
  // },
  // {
  //   route: 'tables',
  //   label: 'Tables',
  //   icon: mdiTable
  // },
  // {
  //   route: 'forms',
  //   label: 'Forms',
  //   icon: mdiSquareEditOutline
  // },
  // {
  //   route: 'ui',
  //   label: 'UI',
  //   icon: mdiTelevisionGuide
  // },
  // {
  //   route: 'responsive',
  //   label: 'Responsive',
  //   icon: mdiResponsive
  // },
  // {
  //   to: '/',
  //   label: 'Styles',
  //   icon: mdiPalette
  // },
  // {
  //   to: '/profile',
  //   label: 'Profile',
  //   icon: mdiAccountCircle
  // },
  // {
  //   to: '/login',
  //   label: 'Login',
  //   icon: mdiLock
  // },
  // {
  //   to: '/error',
  //   label: 'Error',
  //   icon: mdiAlertCircle
  // },
  // {
  //   label: 'Dropdown',
  //   icon: mdiViewList,
  //   menu: [
  //     {
  //       label: 'Item One'
  //     },
  //     {
  //       label: 'Item Two'
  //     }
  //   ]
  // },
  {
    href: 'https://github.com/justboil/admin-one-vue-tailwind',
    label: 'GitHub',
    icon: mdiGithub,
    target: '_blank'
  },
  {
    href: 'https://github.com/justboil/admin-one-react-tailwind',
    label: 'React version',
    icon: mdiReact,
    target: '_blank'
  }
]
