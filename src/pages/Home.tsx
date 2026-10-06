import { Link } from 'react-router-dom'
import { ContactBlock, SectionHead } from '../components/Blocks'
import { CallRow, EventRow, PostCard } from '../components/Cards'
import { PartnerLogo } from '../components/PartnerLogo'
import { calls, events, partners, posts } from '../data/content'
import { facts, lorem, pillars, site } from '../data/site'
import { img, isPast } from '../lib/format'

export default function Home() {
  const upcoming = events.filter((e) => !isPast(e.date)).slice(0, 3)

  return (
    <>
      <section className="hero">
        <div className="hero__text">
          <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h1>
          <p>{lorem.short}</p>
          <div className="hero__actions">
            <Link to="/open-calls" className="btn btn--primary">
              See Open Calls
            </Link>
            <Link to="/about" className="btn btn--outline">
              About the project
            </Link>
          </div>
        </div>
        <div className="hero__media">
          <img src={img('hero-workshop.webp')} alt="Project team during a workshop" width={900} height={700} fetchPriority="high" />
        </div>
      </section>

      <section className="factsband">
        <div className="container">
          <dl className="facts">
            {facts.map((f) => (
              <div key={f.label}>
                <dt>{f.label}</dt>
                <dd>{f.value}</dd>
              </div>
            ))}
          </dl>
        </div>
      </section>

      <section className="bleed">
        <div className="bleed__media">
          <img src={img('team-table.webp')} alt="Consortium members at a working meeting" loading="lazy" width={900} height={700} />
        </div>
        <div className="bleed__panel bleed__panel--tint">
          <div data-reveal>
            <h2>What {site.name} does</h2>
            <p>{lorem.p1}</p>
            <Link className="btn btn--outline" to="/about">
              More about the project
            </Link>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <ul className="columns">
            {pillars.map((p) => (
              <li key={p.title} data-reveal>
                <h3>{p.title}</h3>
                <p>{p.text}</p>
              </li>
            ))}
          </ul>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container">
          <SectionHead title="Open Calls" text="Funding opportunities for organisations that want to work with the project." action={{ label: 'All Open Calls', to: '/open-calls' }} />
          <div className="callrows">
            {calls.map((c) => (
              <CallRow key={c.slug} call={c} />
            ))}
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="News" />
          <div className="grid grid--3">
            {posts.slice(0, 3).map((p) => (
              <PostCard key={p.slug} post={p} />
            ))}
          </div>
          <div className="more">
            <Link to="/news" className="btn btn--primary">
              Read all news
            </Link>
          </div>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container darkgrid">
          <div className="darkgrid__head" data-reveal>
            <h2>Upcoming events</h2>
            <p>Info days, workshops and conferences organised by the project or with its participation.</p>
            <Link to="/events" className="btn btn--outline-light">
              All events
            </Link>
          </div>
          {upcoming.length ? (
            <div className="events">
              {upcoming.map((e) => (
                <EventRow key={e.slug} event={e} />
              ))}
            </div>
          ) : (
            <p className="empty">
              No upcoming events right now. See <Link to="/events">past events</Link>.
            </p>
          )}
        </div>
      </section>

      <section className="bleed bleed--flip">
        <div className="bleed__media">
          <img src={img('coding-pair.webp')} alt="Two people working on the platform" loading="lazy" width={900} height={700} />
        </div>
        <div className="bleed__panel bleed__panel--tint">
          <div data-reveal>
            <h2>Digital Platform</h2>
            <p>{lorem.short}</p>
            <Link to="/digital-platform" className="btn btn--outline">
              Explore the platform
            </Link>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="Partners" text={`${partners.length} organisations from across Europe work together in the consortium.`} action={{ label: 'All partners', to: '/partners' }} />
          <ul className="logos" data-reveal>
            {partners.map((p) => (
              <li key={p.slug}>
                <Link to={`/partners/${p.slug}`} aria-label={p.name} title={p.name}>
                  <PartnerLogo partner={p} />
                </Link>
              </li>
            ))}
          </ul>
        </div>
      </section>

      <ContactBlock />
    </>
  )
}
