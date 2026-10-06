// Site settings and menus. In WordPress this becomes Customizer / options page + nav menus.

export const site = {
  name: 'Atria',
  tagline: 'Lorem ipsum dolor sit amet consectetur',
  email: 'office@example.eu',
  phone: '+00 000 000 000',
  address: 'Lorem Street 12, 00-000 Ipsum City',
  grant: 'Grant Agreement No. 000000000',
  // Shown in the bar above the header. Set `text` to '' to hide it.
  announcement: {
    text: 'Open Call 1 is open for applications until 30 November 2026.',
    linkLabel: 'See the call',
    to: '/open-calls/open-call-1',
  },
  disclaimer:
    'Co-funded by the European Union. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or the granting authority. Neither the European Union nor the granting authority can be held responsible for them.',
  social: [
    { label: 'LinkedIn', href: '#' },
    { label: 'YouTube', href: '#' },
    { label: 'X', href: '#' },
  ],
}

export type MenuItem = { label: string; to: string; children?: MenuItem[] }

export const mainMenu: MenuItem[] = [
  { label: 'About', to: '/about' },
  { label: 'Open Calls', to: '/open-calls' },
  { label: 'Partners', to: '/partners' },
  {
    label: 'News & Events',
    to: '/news',
    children: [
      { label: 'News', to: '/news' },
      { label: 'Events', to: '/events' },
    ],
  },
  { label: 'Resources', to: '/resources' },
  { label: 'Digital Platform', to: '/digital-platform' },
  { label: 'Contact', to: '/contact' },
]

export const footerMenu: MenuItem[] = [
  { label: 'About the project', to: '/about' },
  { label: 'Open Calls', to: '/open-calls' },
  { label: 'Partners', to: '/partners' },
  { label: 'News', to: '/news' },
  { label: 'Events', to: '/events' },
  { label: 'Resources', to: '/resources' },
  { label: 'Digital Platform', to: '/digital-platform' },
  { label: 'Contact', to: '/contact' },
]

export const legalMenu: MenuItem[] = [
  { label: 'Privacy policy', to: '/privacy-policy' },
  { label: 'Cookie policy', to: '/cookie-policy' },
  { label: 'Accessibility statement', to: '/accessibility' },
]

export const facts = [
  { value: '€0.0M', label: 'Total project budget' },
  { value: '00', label: 'Partners in the consortium' },
  { value: '0', label: 'Countries involved' },
  { value: '36', label: 'Months of the project' },
]

export const pillars = [
  { title: 'Lorem ipsum dolor', text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.' },
  { title: 'Sit amet consectetur', text: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.' },
  { title: 'Adipiscing elit sed', text: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla.' },
  { title: 'Eiusmod tempor', text: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.' },
]

export const lorem = {
  short: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
  p1: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
  p2: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
  p3: 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
}
