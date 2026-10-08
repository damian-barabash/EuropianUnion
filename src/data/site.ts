// Site settings and menus. In WordPress this becomes Customizer / options page + nav menus.

export const site = {
  name: 'TransBioNet',
  tagline: 'Bringing biomedical discoveries closer to investment',
  email: 'office@example.eu',
  phone: '+00 000 000 000',
  address: 'Lorem Street 12, 00-000 Ipsum City',
  grant: 'Grant Agreement No. 000000000',
  // Wording on the EU emblem: 'Funded by' or 'Co-funded by', as the grant agreement requires.
  euLabel: 'Funded by',
  // Open Calls stay hidden until the first call starts: `false` removes the home section,
  // the bar above the header and the menu links. The pages themselves keep working.
  showOpenCalls: true,
  // Shown in the bar above the header. Set `text` to '' to hide it.
  announcement: {
    text: 'Open Call 1 is open for applications until 30 November 2026.',
    linkLabel: 'See the call',
    to: '/open-calls/open-call-1',
  },
  disclaimer:
    'Funded by the European Union. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or granting authority. Neither the European Union nor the granting authority can be held responsible for them.',
  // Legal pages are the ones of InnoStars, the partner responsible for communication.
  privacyUrl: 'https://innostars.org/privacy-notice/',
  social: [
    { label: 'LinkedIn', href: '#' },
    { label: 'YouTube', href: '#' },
    { label: 'X', href: '#' },
  ],
}

// `href` marks an external page: it opens in a new tab instead of routing inside the site.
export type MenuItem = { label: string; to: string; href?: string; children?: MenuItem[] }

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
  { label: 'Privacy Notice', to: '/privacy-policy', href: site.privacyUrl },
  { label: 'Cookie policy', to: '/cookie-policy' },
  { label: 'Accessibility statement', to: '/accessibility' },
]

export const visibleMenu = (menu: MenuItem[]) => menu.filter((m) => site.showOpenCalls || m.to !== '/open-calls')

export const facts = [
  { value: '€1.96M', label: 'Total project budget' },
  { value: '7', label: 'Partners in the consortium' },
  { value: '6', label: 'Countries involved' },
  { value: '36', label: 'Months of the project' },
]

export const pillars = [
  { title: 'Project assessment', text: 'Tools to assess readiness, identify gaps and plan next steps.' },
  { title: 'Research infrastructure', text: 'An atlas connecting teams with specialist research facilities and services.' },
  { title: 'Skills and collaboration', text: 'Training, peer learning and cross-border knowledge exchange.' },
  { title: 'Open calls', text: 'Mentoring and bootcamps for selected projects, with funding for the highest-ranked.' },
]

export const intro = {
  hero: {
    title: 'Bringing biomedical discoveries closer to investment',
    text: 'TransBioNet connects researchers, start-ups and innovation support organisations across Europe to help promising drug discovery projects move towards investment readiness. Through shared assessment tools, training and access to specialist expertise and research infrastructure, we help teams identify their next steps and prepare for further development.',
  },
  support: {
    title: 'Support for early-stage drug discovery',
    text: 'Promising research needs a clear development pathway. TransBioNet helps research teams and innovation support organisations identify what a project needs to progress, access relevant expertise and prepare for further development and investment.',
  },
  pillarsTitle: 'How we support innovation',
  talk: {
    title: 'Let’s talk about TransBioNet',
    text: 'Have a question about the project, future open calls or opportunities to collaborate? Get in touch with our team using the form.',
  },
}

export const lorem = {
  short: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
  p1: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
  p2: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
  p3: 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
}
