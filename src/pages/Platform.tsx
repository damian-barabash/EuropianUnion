import { Link } from 'react-router-dom'
import { PageHero, SectionHead } from '../components/Blocks'
import { Icon } from '../components/Icon'
import { lorem } from '../data/site'
import { img } from '../lib/format'

const features = [
  { title: 'Matchmaking', text: 'Find partners, experts and organisations working on similar topics.' },
  { title: 'Knowledge base', text: 'Guides, reports and training materials collected in one place.' },
  { title: 'Community', text: 'Groups and discussions for the organisations involved in the project.' },
  { title: 'Opportunities', text: 'Calls, events and services from across the ecosystem.' },
]

const stages = [
  { title: 'Concept and requirements', state: 'Done' },
  { title: 'Platform development', state: 'In progress' },
  { title: 'Pilot with partners', state: 'Planned' },
  { title: 'Public launch', state: 'Planned' },
]

export default function Platform() {
  return (
    <>
      <PageHero title="Digital Platform" lead="An online space that will connect the organisations, knowledge and opportunities created by the project." crumbs={[{ label: 'Digital Platform' }]}>
        <div className="pagehero__row">
          <span className="status status--upcoming">In development</span>
          {/* When the platform is live this becomes a link to it. */}
          <button className="btn btn--primary" disabled>
            Open the platform <Icon name="external" size={18} />
          </button>
        </div>
      </PageHero>

      <section className="section">
        <div className="container media">
          <img className="media__img" src={img('coding-pair.webp')} alt="Two people working on the platform" width={700} height={500} loading="lazy" data-reveal />
          <div data-reveal>
            <h2>What the platform will be</h2>
            <p>{lorem.p1}</p>
            <p>{lorem.p2}</p>
          </div>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container">
          <SectionHead title="Planned features" />
          <ul className="columns">
            {features.map((f) => (
              <li key={f.title} data-reveal>
                <h3>{f.title}</h3>
                <p>{f.text}</p>
              </li>
            ))}
          </ul>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="Where we are now" />
          <ol className="timeline">
            {stages.map((s) => (
              <li key={s.title} data-reveal className={s.state === 'Planned' ? 'is-planned' : ''}>
                <span className="timeline__period">{s.state}</span>
                <h3>{s.title}</h3>
              </li>
            ))}
          </ol>
          <p className="note note--center">
            Want to hear when the platform opens? <Link to="/contact">Leave us a message</Link>.
          </p>
        </div>
      </section>
    </>
  )
}
