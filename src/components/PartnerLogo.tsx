import type { CSSProperties, ReactNode } from 'react'
import type { Partner } from '../data/content'

// Invented logos for the placeholder partners, so the partner blocks look the way they will
// with real ones. On WordPress each partner simply gets an uploaded logo file instead.
type Brand = {
  color: string
  mark: ReactNode
  name: { text: string; weight?: number }[]
  sub?: string
  serif?: boolean
  italic?: boolean
  tracking?: string
}

const brands: Record<string, Brand> = {
  'lorem-institute': {
    color: '#12336b',
    mark: (
      <>
        <rect x="6" y="26" width="8" height="16" />
        <rect x="20" y="16" width="8" height="26" />
        <rect x="34" y="6" width="8" height="36" />
      </>
    ),
    name: [{ text: 'LIT', weight: 800 }],
    sub: 'Lorem Institute of Technology',
    tracking: '0.04em',
  },
  'ipsum-university': {
    color: '#7a1f2b',
    mark: (
      <>
        <path d="M8 6h32v22L24 42 8 28z" fill="none" stroke="currentColor" strokeWidth="3" />
        <path d="M16 16h16M16 23h16" fill="none" stroke="currentColor" strokeWidth="3" />
      </>
    ),
    name: [{ text: 'IPSUM', weight: 400 }],
    sub: 'UNIVERSITY · 1871',
    serif: true,
    tracking: '0.14em',
  },
  'dolor-labs': {
    color: '#0e8f8f',
    mark: (
      <>
        <polygon points="24,4 41,14 41,34 24,44 7,34 7,14" fill="none" stroke="currentColor" strokeWidth="3.500" />
        <polygon points="24,16 31,20 31,28 24,32 17,28 17,20" />
      </>
    ),
    name: [
      { text: 'dolor', weight: 700 },
      { text: 'labs', weight: 300 },
    ],
    tracking: '-0.02em',
  },
  'amet-foundation': {
    color: '#e2571e',
    mark: (
      <>
        <rect x="6" y="6" width="16" height="16" />
        <rect x="26" y="6" width="16" height="16" opacity="0.5" />
        <rect x="26" y="26" width="16" height="16" />
        <rect x="6" y="26" width="16" height="16" opacity="0.5" />
      </>
    ),
    name: [{ text: 'amet', weight: 700 }],
    sub: 'Innovation Foundation',
    tracking: '-0.03em',
  },
  'consectetur-region': {
    color: '#2e7d4f',
    mark: (
      <>
        <polygon points="24,6 42,20 42,27 24,13 6,27 6,20" />
        <polygon points="24,15 42,29 42,36 24,22 6,36 6,29" opacity="0.65" />
        <polygon points="24,24 42,38 42,45 24,31 6,45 6,38" opacity="0.35" />
      </>
    ),
    name: [{ text: 'Consectetur', weight: 600 }],
    sub: 'Regional Agency',
  },
  'adipiscing-tech': {
    color: '#5b3fd6',
    mark: (
      <>
        <polygon points="6,42 16,6 23,6 13,42" />
        <polygon points="19,42 29,6 36,6 26,42" opacity="0.55" />
      </>
    ),
    name: [{ text: 'adipiscing', weight: 500 }],
    sub: 'technologies',
    tracking: '-0.01em',
  },
  'elit-university': {
    color: '#1f3a8a',
    mark: (
      <>
        <rect x="8" y="6" width="8" height="36" />
        <rect x="8" y="6" width="32" height="8" />
        <rect x="8" y="20" width="24" height="8" />
        <rect x="8" y="34" width="32" height="8" />
      </>
    ),
    name: [{ text: 'ELIT', weight: 700 }],
    sub: 'University of Applied Sciences',
    tracking: '0.08em',
  },
  'tempor-cluster': {
    color: '#b4236e',
    mark: (
      <>
        <circle cx="24" cy="24" r="6.500" />
        <circle cx="10" cy="11" r="4.500" opacity="0.55" />
        <circle cx="38" cy="11" r="4.500" opacity="0.55" />
        <circle cx="10" cy="37" r="4.500" opacity="0.55" />
        <circle cx="38" cy="37" r="4.500" opacity="0.55" />
      </>
    ),
    name: [
      { text: 'tempor', weight: 300 },
      { text: 'cluster', weight: 700 },
    ],
  },
  'labore-research': {
    color: '#3d4a5c',
    mark: (
      <>
        <polygon points="24,6 43,42 5,42" fill="none" stroke="currentColor" strokeWidth="3.500" />
        <path d="M15 32h18" fill="none" stroke="currentColor" strokeWidth="3.500" />
      </>
    ),
    name: [{ text: 'LABORE', weight: 300 }],
    sub: 'RESEARCH CENTRE',
    tracking: '0.2em',
  },
  'magna-systems': {
    color: '#c8102e',
    mark: <polygon points="6,42 6,6 15,6 24,24 33,6 42,6 42,42 34,42 34,22 24,40 14,22 14,42" />,
    name: [{ text: 'MAGNA', weight: 800 }],
    sub: 'SYSTEMS',
    italic: true,
    tracking: '0.02em',
  },
}

export function PartnerLogo({ partner, large = false }: { partner: Partner; large?: boolean }) {
  const b = brands[partner.slug]
  if (!b) {
    return (
      <span className={`plogo${large ? ' plogo--lg' : ''}`} aria-hidden="true">
        <span className="plogo__name">{partner.short}</span>
      </span>
    )
  }
  const cls = ['plogo', large && 'plogo--lg', b.serif && 'plogo--serif', b.italic && 'plogo--italic'].filter(Boolean).join(' ')
  return (
    <span className={cls} style={{ '--brand': b.color, '--tracking': b.tracking ?? '0' } as CSSProperties} aria-hidden="true">
      <svg className="plogo__mark" viewBox="0 0 48 48" fill="currentColor">
        {b.mark}
      </svg>
      <span className="plogo__text">
        <span className="plogo__name">
          {b.name.map((n) => (
            <span key={n.text} style={{ fontWeight: n.weight }}>
              {n.text}
            </span>
          ))}
        </span>
        {b.sub && <span className="plogo__sub">{b.sub}</span>}
      </span>
    </span>
  )
}
