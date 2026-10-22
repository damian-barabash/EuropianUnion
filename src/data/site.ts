// Site settings and menus. In WordPress this becomes Customizer / options page + nav menus.

import { partners } from './content'

export const site = {
  name: 'TransBioNet',
  tagline: 'Bringing biomedical discoveries closer to investment',
  email: 'info@transbionet.eu',
  grant: 'Grant Agreement No. 101291691',
  // Wording on the EU emblem: 'Funded by' or 'Co-funded by', as the grant agreement requires.
  euLabel: 'Funded by',
  // Sections hidden until there is content (client's request, 22.10.2026). `false` removes the home
  // section, the menu and footer links and the buttons leading there; the pages themselves keep working.
  showOpenCalls: false,
  showEvents: false,
  showPlatform: false,
  // Bar above the header. Kept for later: shown only when `show` is true and Open Calls are visible.
  announcement: {
    show: false,
    text: 'Open Call 1 is open for applications until 30 November 2026.',
    linkLabel: 'See the call',
    to: '/open-calls/open-call-1',
  },
  disclaimer:
    'This project has received funding from the European Union’s Horizon Europe research and innovation programme under grant agreement No. 101291691. Views and opinions expressed are however those of the author(s) only and do not necessarily reflect those of the European Union or European Research Executive Agency (REA). Neither the European Union nor the granting authority can be held responsible for them.',
  // Legal pages are the ones of InnoStars, the partner responsible for communication.
  privacyUrl: 'https://innostars.org/privacy-notice/',
  // An empty `href` shows the name without a link (the YouTube and X channels are not set up yet).
  // TODO: the project's LinkedIn address from the client.
  social: [
    { label: 'LinkedIn', href: '' },
    { label: 'YouTube', href: '' },
    { label: 'X', href: '' },
  ],
}

// `href` marks an external page: it opens in a new tab instead of routing inside the site.
export type MenuItem = { label: string; to: string; href?: string; children?: MenuItem[] }

export const mainMenu: MenuItem[] = [
  { label: 'About', to: '/about' },
  { label: 'Open Calls', to: '/open-calls' },
  {
    // Partner names as a drop-down (request from a partner, October 2026). Built from the partner list.
    label: 'Partners',
    to: '/partners',
    children: [{ label: 'All partners', to: '/partners' }, ...partners.map((p) => ({ label: p.name, to: `/partners/${p.slug}` }))],
  },
  site.showEvents
    ? {
        label: 'News & Events',
        to: '/news',
        children: [
          { label: 'News', to: '/news' },
          { label: 'Events', to: '/events' },
        ],
      }
    : { label: 'News', to: '/news' },
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

const hiddenPaths = [!site.showOpenCalls && '/open-calls', !site.showEvents && '/events', !site.showPlatform && '/digital-platform']

export const visibleMenu = (menu: MenuItem[]) => menu.filter((m) => !hiddenPaths.includes(m.to))

export const facts = [
  { value: '€1.96M', label: 'Total project budget' },
  { value: '7', label: 'Partners in the consortium' },
  { value: '6', label: 'Countries involved' },
  { value: '36', label: 'Months of the project' },
]

export const pillars = [
  { title: 'Project assessment', text: 'Shared tools to support more standardised evaluations of early-stage drug discovery projects.' },
  { title: 'Research infrastructure', text: 'An atlas mapping research infrastructures and services relevant to biomedical translation across Europe.' },
  { title: 'Skills and collaboration', text: 'Training, peer learning and cross-border secondments to strengthen skills and knowledge exchange among intermediaries.' },
  { title: 'Open calls', text: 'Mentoring and bootcamps for selected projects, with validation funding planned for the highest-ranked.' },
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
  about: {
    lead: 'TransBioNet, a new initiative funded by the European Union’s Horizon Europe programme, has been launched to help promising biomedical research across Europe progress towards investment readiness. The nearly €2 million project brings together seven partners from six countries to establish the first pan-European network of knowledge valorisation intermediaries fully dedicated to drug discovery and biomedical innovation.',
    title: 'From biomedical research to investment readiness',
    text: [
      'In drug discovery, the gap between laboratory discoveries and marketable therapies is particularly difficult to overcome. According to the European Federation of Pharmaceutical Industries and Associations (EFPIA), bringing a new medicine to market takes on average more than 10 years, with research and development costs often exceeding €3 billion and success rates as low as just one to two compounds for every 10,000 tested. Amid growing competition, Europe’s share of global commercial drug trials fell by 10 percentage points between 2013 and 2023.',
      'TransBioNet aims to establish the first pan-European network of knowledge valorisation intermediaries fully dedicated to drug discovery and biomedical innovation.',
      'Coordinated by Associação AccelBio in Portugal, the project will address this translation gap through shared assessment tools, training, cross-border collaboration and two Open Calls supporting early-stage drug discovery projects.',
    ],
  },
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
