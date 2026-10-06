import { Link, useParams } from 'react-router-dom'
import { Accordion, PageHero, SectionHead } from '../components/Blocks'
import { CallRow, ResourceRow, StatusBadge } from '../components/Cards'
import { Icon } from '../components/Icon'
import { callFaq, callSteps, calls, resources } from '../data/content'
import { lorem } from '../data/site'
import { formatDate, img } from '../lib/format'
import NotFound from './NotFound'

export function CallsPage() {
  const current = calls.filter((c) => c.status !== 'closed')
  const closed = calls.filter((c) => c.status === 'closed')
  return (
    <>
      <PageHero title="Open Calls" lead="Funding opportunities published by the project. Each call has its own rules, deadline and documents." crumbs={[{ label: 'Open Calls' }]} />

      <section className="section">
        <div className="container">
          <SectionHead title="Current and upcoming calls" />
          <div className="callrows">
            {current.map((c) => (
              <CallRow key={c.slug} call={c} />
            ))}
          </div>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container">
          <SectionHead title="How applying works" text="The same four steps apply to every call." />
          <ol className="steps">
            {callSteps.map((s) => (
              <li key={s.title} data-reveal>
                <h3>{s.title}</h3>
                <p>{s.text}</p>
              </li>
            ))}
          </ol>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="Closed calls" text="Results and documents of finished calls stay available here." />
          <div className="callrows">
            {closed.map((c) => (
              <CallRow key={c.slug} call={c} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}

export function CallPage() {
  const { slug } = useParams()
  const call = calls.find((c) => c.slug === slug)
  if (!call) return <NotFound />
  const docs = resources.filter((r) => r.type === 'Document')
  const canApply = call.status === 'open'

  return (
    <>
      <PageHero title={call.title} lead={call.summary} crumbs={[{ label: 'Open Calls', to: '/open-calls' }, { label: call.title }]}>
        <div className="pagehero__row">
          <StatusBadge status={call.status} />
          {canApply && (
            <a className="btn btn--primary" href={call.applyUrl} target="_blank" rel="noopener noreferrer">
              Apply in the application system <Icon name="external" size={18} />
            </a>
          )}
        </div>
      </PageHero>

      <section className="section">
        <div className="container detail">
          <div className="detail__main">
            <img className="detail__img" src={img(call.image)} alt="" width={900} height={500} />
            <div className="prose">
              <h2>About the call</h2>
              <p>{lorem.p1}</p>
              <p>{lorem.p2}</p>
              <h2>Who can apply</h2>
              <ul>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco.</li>
              </ul>
              <h2>What you get</h2>
              <ul>
                <li>Funding {call.grant}.</li>
                <li>Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                <li>Excepteur sint occaecat cupidatat non proident.</li>
              </ul>
            </div>

            <h2 className="detail__h">How to apply</h2>
            <ol className="steps steps--stack">
              {callSteps.map((s) => (
                <li key={s.title}>
                  <h3>{s.title}</h3>
                  <p>{s.text}</p>
                </li>
              ))}
            </ol>

            <h2 className="detail__h">Documents</h2>
            <ul className="docs">
              {docs.map((d) => (
                <ResourceRow key={d.id} item={d} />
              ))}
            </ul>

            <h2 className="detail__h">Questions and answers</h2>
            <Accordion items={callFaq} />
          </div>

          <aside className="detail__side" aria-label="Key facts">
            <div className="sidecard">
              <h2>Key facts</h2>
              <dl>
                <div>
                  <dt>Status</dt>
                  <dd>
                    <StatusBadge status={call.status} />
                  </dd>
                </div>
                <div>
                  <dt>Opens</dt>
                  <dd>{formatDate(call.opens)}</dd>
                </div>
                <div>
                  <dt>Deadline</dt>
                  <dd>{formatDate(call.deadline)}, 17:00 CET</dd>
                </div>
                <div>
                  <dt>Total budget</dt>
                  <dd>{call.budget}</dd>
                </div>
                <div>
                  <dt>Funding</dt>
                  <dd>{call.grant}</dd>
                </div>
              </dl>
              {canApply ? (
                <a className="btn btn--primary btn--block" href={call.applyUrl} target="_blank" rel="noopener noreferrer">
                  Apply now <Icon name="external" size={18} />
                </a>
              ) : (
                <p className="note">{call.status === 'upcoming' ? 'Applications open on the date above.' : 'This call no longer accepts applications.'}</p>
              )}
              <p className="note">Applications are submitted in an external application system.</p>
            </div>
            <div className="sidecard sidecard--plain">
              <h2>Need help?</h2>
              <p>Ask the Open Calls team before you apply.</p>
              <Link className="btn btn--outline btn--sm" to="/contact">
                Contact us
              </Link>
            </div>
          </aside>
        </div>
      </section>
    </>
  )
}
