import type { CSSProperties } from 'react'
import type { Partner } from '../data/content'
import { img } from '../lib/format'

// Partner logo from an uploaded file. A partner without a file yet is shown by name.
export function PartnerLogo({ partner, large = false }: { partner: Partner; large?: boolean }) {
  return (
    <span className={`plogo${large ? ' plogo--lg' : ''}`} style={{ '--s': partner.logoScale ?? 1 } as CSSProperties}>
      {partner.logo ? <img src={img(`partners/${partner.logo}`)} alt={`${partner.name} logo`} loading="lazy" /> : <span className="plogo__name">{partner.name}</span>}
    </span>
  )
}
