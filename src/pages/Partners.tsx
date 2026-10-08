import { Link, useParams } from 'react-router-dom'
import { PageHero } from '../components/Blocks'
import { PartnerCard } from '../components/Cards'
import { PartnerLogo } from '../components/PartnerLogo'
import { Icon } from '../components/Icon'
import { partners } from '../data/content'
import NotFound from './NotFound'

export function PartnersPage() {
  const countries = new Set(partners.map((p) => p.country)).size
  return (
    <>
      <PageHero title="Partners" lead={`${partners.length} organisations from ${countries} countries form the project consortium.`} crumbs={[{ label: 'Partners' }]} />
      <section className="section">
        <div className="container">
          <div className="grid grid--4">
            {partners.map((p) => (
              <PartnerCard key={p.slug} partner={p} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}

export function PartnerPage() {
  const { slug } = useParams()
  const partner = partners.find((p) => p.slug === slug)
  if (!partner) return <NotFound />
  return (
    <>
      <PageHero title={partner.name} crumbs={[{ label: 'Partners', to: '/partners' }, { label: partner.name }]} />
      <section className="section">
        <div className="container detail">
          <div className="detail__main prose">
            {partner.description.length > 0 && (
              <>
                <h2>About the organisation</h2>
                {partner.description.map((d) => (
                  <p key={d}>{d}</p>
                ))}
              </>
            )}
            <h2>Role in the project</h2>
            <p>{partner.roleText}</p>
          </div>
          <aside className="detail__side">
            <div className="sidecard">
              <PartnerLogo partner={partner} large />
              <dl>
                <div>
                  <dt>Legal name</dt>
                  <dd>{partner.legalName}</dd>
                </div>
                <div>
                  <dt>Country</dt>
                  <dd>{partner.country}</dd>
                </div>
                <div>
                  <dt>Type</dt>
                  <dd>{partner.type}</dd>
                </div>
                <div>
                  <dt>Role</dt>
                  <dd>{partner.role}</dd>
                </div>
              </dl>
              {partner.website && (
                <a className="btn btn--outline btn--block" href={partner.website} target="_blank" rel="noopener noreferrer">
                  Visit website <Icon name="external" size={18} />
                </a>
              )}
              {partner.linkedin && (
                <a className="btn btn--outline btn--block" href={partner.linkedin} target="_blank" rel="noopener noreferrer">
                  LinkedIn <Icon name="external" size={18} />
                </a>
              )}
            </div>
            <Link className="btn btn--outline btn--sm" to="/partners">
              All partners
            </Link>
          </aside>
        </div>
      </section>
    </>
  )
}
