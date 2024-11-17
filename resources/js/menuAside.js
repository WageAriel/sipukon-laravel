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
  mdiBookOpenPageVariant,
  mdiSchool,
  mdiReact,
} from '@mdi/js'

export default [
  {
    route: 'dashboard',
    label: 'Dashboard',
    icon: mdiMonitor
  },
  {
    route: 'user',
    label: 'Users',
    icon: mdiAccountCircle
  },
  {
    route: 'buku',
    label: 'Books',
    icon: mdiBookOpenPageVariant
  },
  {
    route: 'prodi',
    label: 'Prodi',
    icon: mdiSchool
  },
  {
    route: 'peminjamanData',
    label: 'Peminjaman',
    icon: mdiViewList
  },
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
