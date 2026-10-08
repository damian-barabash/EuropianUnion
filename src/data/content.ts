// Placeholder content shaped like the future WordPress content types:
// posts (news), events, open calls, partners, resources (documents / materials / videos), team.

export type Post = { slug: string; title: string; date: string; category: 'News' | 'Press release' | 'Article'; image: string; excerpt: string }
export type EventItem = { slug: string; title: string; date: string; endDate?: string; time: string; place: string; format: 'On-site' | 'Online' | 'Hybrid'; image: string; excerpt: string; registerUrl?: string; openCall?: boolean }
export type CallStatus = 'open' | 'upcoming' | 'closed'
export type OpenCall = {
  slug: string; title: string; status: CallStatus; opens: string; deadline: string; budget: string; grant: string
  image: string; summary: string; applyUrl: string
}
export type Partner = {
  slug: string; name: string; legalName: string; country: string; type: string; role: 'Coordinator' | 'Partner'; roleText: string
  // `logoScale` evens out how large the logos look next to each other (1 = default box).
  logo?: string; logoScale?: number; website?: string; linkedin?: string; description: string[]
}
export type Resource = { id: string; title: string; type: 'Document' | 'Deliverable' | 'Promo material' | 'Video'; date: string; format: string; size?: string; href: string }
export type Person = { name: string; role: string; org: string; image: string; quote: string }

const ex = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'

export const posts: Post[] = [
  { slug: 'lorem-ipsum-dolor-sit-amet', title: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', date: '2026-10-02', category: 'News', image: 'lab-pipette.webp', excerpt: ex },
  { slug: 'sed-do-eiusmod-tempor', title: 'Sed do eiusmod tempor incididunt ut labore et dolore', date: '2026-09-18', category: 'Press release', image: 'conference-audience.webp', excerpt: ex },
  { slug: 'ut-enim-ad-minim-veniam', title: 'Ut enim ad minim veniam, quis nostrud exercitation', date: '2026-09-04', category: 'News', image: 'microscope.webp', excerpt: ex },
  { slug: 'duis-aute-irure-dolor', title: 'Duis aute irure dolor in reprehenderit in voluptate', date: '2026-08-21', category: 'Article', image: 'lab-tubes.webp', excerpt: ex },
  { slug: 'excepteur-sint-occaecat', title: 'Excepteur sint occaecat cupidatat non proident', date: '2026-07-30', category: 'News', image: 'lab-meeting.webp', excerpt: ex },
  { slug: 'nemo-enim-ipsam-voluptatem', title: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur', date: '2026-07-09', category: 'Article', image: 'molecule.webp', excerpt: ex },
  { slug: 'neque-porro-quisquam-est', title: 'Neque porro quisquam est qui dolorem ipsum', date: '2026-06-15', category: 'Press release', image: 'well-plate.webp', excerpt: ex },
]

export const events: EventItem[] = [
  { slug: 'info-day-open-call-1', title: 'Info day: lorem ipsum dolor sit amet', date: '2026-10-21', time: '10:00–12:00 CET', place: 'Online', format: 'Online', image: 'conference-blue.webp', excerpt: ex, registerUrl: '#', openCall: true },
  { slug: 'consortium-conference-2026', title: 'Annual conference: consectetur adipiscing elit', date: '2026-11-12', endDate: '2026-11-13', time: '09:00–17:00 CET', place: 'Ipsum City, Lorem Congress Centre', format: 'Hybrid', image: 'conference-audience.webp', excerpt: ex, registerUrl: '#' },
  { slug: 'workshop-sed-do-eiusmod', title: 'Workshop: sed do eiusmod tempor incididunt', date: '2026-12-03', time: '13:00–16:00 CET', place: 'Dolor Town, Amet University', format: 'On-site', image: 'lab-workshop.webp', excerpt: ex, registerUrl: '#' },
  { slug: 'kick-off-meeting', title: 'Kick-off meeting of the consortium', date: '2026-05-14', time: '09:30–16:00 CET', place: 'Ipsum City', format: 'On-site', image: 'lab-team-tablet.webp', excerpt: ex },
]

export const calls: OpenCall[] = [
  { slug: 'open-call-1', title: 'Open Call 1: lorem ipsum dolor sit amet', status: 'open', opens: '2026-09-15', deadline: '2026-11-30', budget: '€000,000', grant: 'up to €00,000 per project', image: 'lab-microscope-work.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
  { slug: 'open-call-2', title: 'Open Call 2: consectetur adipiscing elit', status: 'upcoming', opens: '2027-03-01', deadline: '2027-05-15', budget: '€000,000', grant: 'up to €00,000 per project', image: 'lab-microscope-sample.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
  { slug: 'pilot-call', title: 'Pilot Call: sed do eiusmod tempor', status: 'closed', opens: '2026-04-01', deadline: '2026-06-01', budget: '€000,000', grant: 'up to €00,000 per project', image: 'lab-laptop.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
]

export const callSteps = [
  { title: 'Read the call text', text: 'Download the call text and the guide for applicants. Check the eligibility criteria.' },
  { title: 'Prepare your proposal', text: 'Fill in the proposal template and the budget table. Lorem ipsum dolor sit amet.' },
  { title: 'Apply in the external system', text: 'Submit the proposal and annexes through the application system before the deadline.' },
  { title: 'Evaluation and results', text: 'Independent experts evaluate the proposals. Applicants are informed by e-mail.' },
]

export const callFaq = [
  { q: 'Who can apply?', a: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' },
  { q: 'How much funding can one project receive?', a: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' },
  { q: 'Can one organisation submit more than one proposal?', a: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.' },
  { q: 'In which language should the proposal be written?', a: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' },
  { q: 'Where can I ask questions about the call?', a: 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.' },
]

// Consortium partners in alphabetical order. Data: partners' communication sheet (October 2026).
// Danish Life Science Cluster and LithuaniaBIO have not sent their description and links yet,
// Danish Life Science Cluster has not sent a logo.
export const partners: Partner[] = [
  {
    slug: 'accelbio', name: 'AccelBio', legalName: 'Associação AccelBio', country: 'Portugal', type: 'Collaborative laboratory', role: 'Coordinator',
    roleText: 'Coordinates TransBioNet and leads the assessment toolkit, training academy and selection of open call projects.',
    logo: 'accelbio.webp', website: 'https://accelbio.pt/', linkedin: 'https://www.linkedin.com/company/colab-accelbio/',
    description: [
      'AccelBio is a private non-profit association recognized as a Collaborative Laboratory (CoLAB) by the Portuguese Foundation for Science and Technology.',
      'Based at Biocant Park, in Cantanhede, Portugal, it capitalizes on innovative research from academia and startups, identifying biological targets and platforms with potential to generate new drug candidates. AccelBio provides industry-standard drug discovery capabilities, from target validation to pre-clinical proof of concept, de-risking assets until they are ready for out-licensing or new spin-off companies. AccelBio plays a major role in strengthening Portugal’s biomedical innovation ecosystem, bringing local and international partners together.',
    ],
  },
  {
    slug: 'biocant-park', name: 'Biocant Park', legalName: 'Biocant Park, S.A.', country: 'Portugal', type: 'Biotechnology park', role: 'Partner',
    roleText: 'Leads the European Infrastructure Atlas, mapping specialist research facilities and services for drug discovery.',
    logo: 'biocant-park.webp', logoScale: 1.05, website: 'https://www.biocant.pt/', linkedin: 'https://www.linkedin.com/company/biocant-park/',
    description: [
      'Biocant Park is a Science and Technology Park specialized in biotechnology, located in Cantanhede. It promotes scientific and technological innovation by supporting high-potential companies and projects in the life sciences sector. The park provides state-of-the-art dedicated infrastructures, advanced laboratories, and specialized technological platforms designed to support R&D and innovation in biotechnology. Through scientific support, consultancy, technology transfer, and access to funding, Biocant Park connects academia, industry, and entrepreneurs to drive bio-innovation.',
    ],
  },
  {
    slug: 'danish-life-science-cluster', name: 'Danish Life Science Cluster', legalName: 'Foreningen Danish Life Science Cluster', country: 'Denmark', type: 'Life sciences cluster', role: 'Partner',
    roleText: 'Co-leads policy and ecosystem mapping and stakeholder consultations, connecting the project with Danish expertise and research services.',
    description: [],
  },
  {
    slug: 'eatris', name: 'EATRIS', legalName: 'EATRIS ERIC', country: 'Netherlands', type: 'European research infrastructure', role: 'Partner',
    roleText: 'Leads the Digital Platform and Community of Practice, bringing together assessment tools, infrastructure information and learning resources.',
    logo: 'eatris.webp', logoScale: 0.8, website: 'https://eatris.eu', linkedin: 'https://www.linkedin.com/company/eatris-eric',
    description: [
      'EATRIS is the European infrastructure for translational medicine. We bring together resources and services for research communities to translate scientific discoveries into benefits for patients.',
      'We are a non-profit organisation that provides access to a vast array of expertise and facilities from over 175 top-tier academic centres across Europe. We focus on improving and optimising preclinical and early clinical development of drugs, vaccines and diagnostics, and overcome barriers to health innovation.',
      'Our research infrastructure offers a broad range of research services for both academia and industry across various research fields. In addition, we work with public funding agencies, charities and policy makers with tailored actions to help improve the translational research and innovation ecosystem.',
    ],
  },
  {
    slug: 'eit-health-innostars', name: 'EIT Health InnoStars', legalName: 'EIT Health InnoStars e.V.', country: 'Hungary', type: 'Life sciences cluster', role: 'Partner',
    roleText: 'Leads communication, dissemination, open call administration and development of the TransBioNet Charter.',
    logo: 'innostars.webp', website: 'https://www.innostars.org', linkedin: 'https://www.linkedin.com/company/innostars/',
    description: [
      'InnoStars is an independent non-profit association focused on health innovation in Europe.',
      'It brings together an ecosystem of partners and innovators across Europe, with a focus on regions with moderate innovation capacity. InnoStars has established a network of partner institutions and supported numerous start-ups. Through various innovation programmes and projects, it has contributed to the development and launch of products, services, and jobs across the healthcare value chain. Its mission is to strengthen regional innovation ecosystems, foster entrepreneurship and collaboration, and help bridge healthcare innovation gaps, enabling people to live longer and healthier lives.',
    ],
  },
  {
    slug: 'hlsc', name: 'Health & Life Sciences Cluster (HLSC)', legalName: 'Biotehnologichen i Zdraven Klaster', country: 'Bulgaria', type: 'Life sciences cluster', role: 'Partner',
    roleText: 'Co-leads policy and ecosystem mapping and stakeholder consultations, contributing to training and shared tools.',
    logo: 'hlsc.webp', logoScale: 1.3, website: 'https://www.biocluster.bg/', linkedin: 'https://www.linkedin.com/company/lifesciencesbulgaria/',
    description: [
      'HLSC (Health & Life Sciences Cluster, Bulgaria) is Bulgaria’s national life-sciences cluster, bringing together universities, research centres, hospitals, startups, technology-transfer organisations, SMEs and established companies across biotechnology, health, personalised medicine and digital health. HLSC connects science, industry and policy, helping innovators access funding, develop cross-border partnerships, validate solutions and engage with European and international networks.',
      'The cluster has practical experience in building inclusive innovation ecosystems through European projects including TransBioNet, OHAMR, C3BG, INNAXE, PRECISEU, VELES, ENACT and BIO-RED. Its work spans biotechnology, health-data ecosystems, personalised medicine, capacity building, technology transfer and the strengthening of innovation in Widening countries.',
      'Within TransBioNet, HLSC co-leads inclusive policy analysis and contributes to ensuring that Widening-country ecosystems are represented in project activities and recommendations. It also supports training, open calls, stakeholder engagement, communication and dissemination. Through its established links with public authorities, academia, healthcare providers and industry, HLSC serves as a first point of contact for organisations in Bulgaria and South-East Europe seeking collaboration, specialised support and pathways to transform research into market-ready biomedical innovation.',
    ],
  },
  {
    slug: 'lithuaniabio', name: 'LithuaniaBIO', legalName: 'Asociacija LithuaniaBIO', country: 'Lithuania', type: 'Life sciences and biotechnology association', role: 'Partner',
    roleText: 'Leads cross-border secondments and knowledge exchange, connecting Lithuanian innovators and research services with the European network.',
    logo: 'lithuaniabio.webp',
    description: [],
  },
]

export const resources: Resource[] = [
  { id: 'r1', title: 'Project factsheet', type: 'Promo material', date: '2026-09-20', format: 'PDF', size: '1.2 MB', href: '#' },
  { id: 'r2', title: 'D1.1 Lorem ipsum dolor sit amet report', type: 'Deliverable', date: '2026-09-01', format: 'PDF', size: '3.4 MB', href: '#' },
  { id: 'r3', title: 'Open Call 1: call text', type: 'Document', date: '2026-09-15', format: 'PDF', size: '860 KB', href: '#' },
  { id: 'r4', title: 'Open Call 1: guide for applicants', type: 'Document', date: '2026-09-15', format: 'PDF', size: '1.1 MB', href: '#' },
  { id: 'r5', title: 'Open Call 1: budget table template', type: 'Document', date: '2026-09-15', format: 'XLSX', size: '120 KB', href: '#' },
  { id: 'r6', title: 'Project presentation', type: 'Promo material', date: '2026-07-10', format: 'PPTX', size: '8.9 MB', href: '#' },
  { id: 'r7', title: 'Logo pack and visual identity guide', type: 'Promo material', date: '2026-06-30', format: 'ZIP', size: '14 MB', href: '#' },
  { id: 'r8', title: 'D2.1 Consectetur adipiscing elit analysis', type: 'Deliverable', date: '2026-06-12', format: 'PDF', size: '2.7 MB', href: '#' },
  { id: 'r9', title: 'Project introduction video', type: 'Video', date: '2026-06-01', format: 'Video', href: '#' },
  { id: 'r10', title: 'Info day recording', type: 'Video', date: '2026-05-20', format: 'Video', href: '#' },
]

export const team: Person[] = [
  { name: 'Anna Lorem', role: 'Project Coordinator', org: 'Lorem Institute of Technology', image: 'person-3.webp', quote: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.' },
  { name: 'Marco Ipsum', role: 'Technical Lead', org: 'Dolor Labs', image: 'person-4.webp', quote: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.' },
  { name: 'Sofia Dolor', role: 'Open Calls Manager', org: 'Amet Innovation Foundation', image: 'person-5.webp', quote: 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' },
  { name: 'Peter Amet', role: 'Communication Lead', org: 'Ipsum University', image: 'person-2.webp', quote: 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.' },
  { name: 'Eva Elit', role: 'Research Lead', org: 'Elit University of Applied Sciences', image: 'person-1.webp', quote: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.' },
  { name: 'Julia Tempor', role: 'Ecosystem Manager', org: 'Tempor Cluster', image: 'person-6.webp', quote: 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.' },
]

export const timeline = [
  { period: 'Month 1–6', title: 'Lorem ipsum dolor', text: 'Sit amet consectetur adipiscing elit, sed do eiusmod tempor.' },
  { period: 'Month 7–12', title: 'First Open Call', text: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco.' },
  { period: 'Month 13–24', title: 'Pilots and support', text: 'Duis aute irure dolor in reprehenderit in voluptate velit.' },
  { period: 'Month 25–36', title: 'Scaling and results', text: 'Excepteur sint occaecat cupidatat non proident sunt in culpa.' },
]

export const workPackages = [
  { code: 'WP1', title: 'Project management and coordination' },
  { code: 'WP2', title: 'Lorem ipsum dolor sit amet' },
  { code: 'WP3', title: 'Open Calls and cascade funding' },
  { code: 'WP4', title: 'Digital Platform' },
  { code: 'WP5', title: 'Pilots and validation' },
  { code: 'WP6', title: 'Communication, dissemination and exploitation' },
]
