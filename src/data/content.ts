// Placeholder content shaped like the future WordPress content types:
// posts (news), events, open calls, partners, resources (documents / materials / videos), team.

export type Post = { slug: string; title: string; date: string; category: 'News' | 'Press release' | 'Article'; image: string; excerpt: string }
export type EventItem = { slug: string; title: string; date: string; endDate?: string; time: string; place: string; format: 'On-site' | 'Online' | 'Hybrid'; image: string; excerpt: string; registerUrl?: string }
export type CallStatus = 'open' | 'upcoming' | 'closed'
export type OpenCall = {
  slug: string; title: string; status: CallStatus; opens: string; deadline: string; budget: string; grant: string
  image: string; summary: string; applyUrl: string
}
export type Partner = { slug: string; name: string; short: string; country: string; type: 'University' | 'Research centre' | 'Company' | 'Public body' | 'Network'; role: 'Coordinator' | 'Partner' | 'Associated partner'; website: string; description: string }
export type Resource = { id: string; title: string; type: 'Document' | 'Deliverable' | 'Promo material' | 'Video'; date: string; format: string; size?: string; href: string }
export type Person = { name: string; role: string; org: string; image: string; quote: string }

const ex = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'

export const posts: Post[] = [
  { slug: 'lorem-ipsum-dolor-sit-amet', title: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', date: '2026-10-02', category: 'News', image: 'conference-screen.webp', excerpt: ex },
  { slug: 'sed-do-eiusmod-tempor', title: 'Sed do eiusmod tempor incididunt ut labore et dolore', date: '2026-09-18', category: 'Press release', image: 'group-discussion.webp', excerpt: ex },
  { slug: 'ut-enim-ad-minim-veniam', title: 'Ut enim ad minim veniam, quis nostrud exercitation', date: '2026-09-04', category: 'News', image: 'meeting-laptop.webp', excerpt: ex },
  { slug: 'duis-aute-irure-dolor', title: 'Duis aute irure dolor in reprehenderit in voluptate', date: '2026-08-21', category: 'Article', image: 'lab-glass.webp', excerpt: ex },
  { slug: 'excepteur-sint-occaecat', title: 'Excepteur sint occaecat cupidatat non proident', date: '2026-07-30', category: 'News', image: 'startup-pitch.webp', excerpt: ex },
  { slug: 'nemo-enim-ipsam-voluptatem', title: 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur', date: '2026-07-09', category: 'Article', image: 'students-library.webp', excerpt: ex },
  { slug: 'neque-porro-quisquam-est', title: 'Neque porro quisquam est qui dolorem ipsum', date: '2026-06-15', category: 'Press release', image: 'old-town.webp', excerpt: ex },
]

export const events: EventItem[] = [
  { slug: 'info-day-open-call-1', title: 'Info day: lorem ipsum dolor sit amet', date: '2026-10-21', time: '10:00–12:00 CET', place: 'Online', format: 'Online', image: 'microphone.webp', excerpt: ex, registerUrl: '#' },
  { slug: 'consortium-conference-2026', title: 'Annual conference: consectetur adipiscing elit', date: '2026-11-12', endDate: '2026-11-13', time: '09:00–17:00 CET', place: 'Ipsum City, Lorem Congress Centre', format: 'Hybrid', image: 'audience.webp', excerpt: ex, registerUrl: '#' },
  { slug: 'workshop-sed-do-eiusmod', title: 'Workshop: sed do eiusmod tempor incididunt', date: '2026-12-03', time: '13:00–16:00 CET', place: 'Dolor Town, Amet University', format: 'On-site', image: 'classroom.webp', excerpt: ex, registerUrl: '#' },
  { slug: 'kick-off-meeting', title: 'Kick-off meeting of the consortium', date: '2026-05-14', time: '09:30–16:00 CET', place: 'Ipsum City', format: 'On-site', image: 'team-table.webp', excerpt: ex },
]

export const calls: OpenCall[] = [
  { slug: 'open-call-1', title: 'Open Call 1: lorem ipsum dolor sit amet', status: 'open', opens: '2026-09-15', deadline: '2026-11-30', budget: '€000,000', grant: 'up to €00,000 per project', image: 'coding-pair.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
  { slug: 'open-call-2', title: 'Open Call 2: consectetur adipiscing elit', status: 'upcoming', opens: '2027-03-01', deadline: '2027-05-15', budget: '€000,000', grant: 'up to €00,000 per project', image: 'engineer-lab.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
  { slug: 'pilot-call', title: 'Pilot Call: sed do eiusmod tempor', status: 'closed', opens: '2026-04-01', deadline: '2026-06-01', budget: '€000,000', grant: 'up to €00,000 per project', image: 'desk-analysis.webp', summary: ex, applyUrl: 'https://example.eu/apply' },
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

const pd = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.'

export const partners: Partner[] = [
  { slug: 'lorem-institute', name: 'Lorem Institute of Technology', short: 'LIT', country: 'Poland', type: 'Research centre', role: 'Coordinator', website: 'https://example.eu', description: pd },
  { slug: 'ipsum-university', name: 'Ipsum University', short: 'IU', country: 'Portugal', type: 'University', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'dolor-labs', name: 'Dolor Labs', short: 'DL', country: 'Germany', type: 'Company', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'amet-foundation', name: 'Amet Innovation Foundation', short: 'AIF', country: 'Italy', type: 'Network', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'consectetur-region', name: 'Consectetur Regional Agency', short: 'CRA', country: 'Latvia', type: 'Public body', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'adipiscing-tech', name: 'Adipiscing Technologies', short: 'AT', country: 'Spain', type: 'Company', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'elit-university', name: 'Elit University of Applied Sciences', short: 'EUAS', country: 'Hungary', type: 'University', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'tempor-cluster', name: 'Tempor Cluster', short: 'TC', country: 'Belgium', type: 'Network', role: 'Associated partner', website: 'https://example.eu', description: pd },
  { slug: 'labore-research', name: 'Labore Research Centre', short: 'LRC', country: 'Romania', type: 'Research centre', role: 'Partner', website: 'https://example.eu', description: pd },
  { slug: 'magna-systems', name: 'Magna Systems', short: 'MS', country: 'Poland', type: 'Company', role: 'Associated partner', website: 'https://example.eu', description: pd },
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
