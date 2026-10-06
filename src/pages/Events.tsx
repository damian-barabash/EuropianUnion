import { Link, useParams } from 'react-router-dom'
import { PageHero, SectionHead } from '../components/Blocks'
import { EventRow } from '../components/Cards'
import { Icon } from '../components/Icon'
import { events } from '../data/content'
import { lorem } from '../data/site'
import { formatDate, img, isPast } from '../lib/format'
import NotFound from './NotFound'

export function EventsPage() {
  const upcoming = events.filter((e) => !isPast(e.date)).sort((a, b) => a.date.localeCompare(b.date))
  const past = events.filter((e) => isPast(e.date)).sort((a, b) => b.date.localeCompare(a.date))
  return (
    <>
      <PageHero title="Events" lead="Info days, workshops and conferences organised by the project or with its participation." crumbs={[{ label: 'Events' }]} />
      <section className="section">
        <div className="container">
          <SectionHead title="Upcoming events" />
          {upcoming.length ? (
            <div className="events">
              {upcoming.map((e) => (
                <EventRow key={e.slug} event={e} />
              ))}
            </div>
          ) : (
            <p className="empty">No upcoming events right now. New dates will appear here.</p>
          )}
        </div>
      </section>
      {past.length > 0 && (
        <section className="section section--grey">
          <div className="container">
            <SectionHead title="Past events" />
            <div className="events">
              {past.map((e) => (
                <EventRow key={e.slug} event={e} />
              ))}
            </div>
          </div>
        </section>
      )}
    </>
  )
}

export function EventPage() {
  const { slug } = useParams()
  const event = events.find((e) => e.slug === slug)
  if (!event) return <NotFound />
  const past = isPast(event.endDate ?? event.date)
  const when = event.endDate ? `${formatDate(event.date)} – ${formatDate(event.endDate)}` : formatDate(event.date)
  return (
    <>
      <PageHero title={event.title} lead={event.excerpt} crumbs={[{ label: 'Events', to: '/events' }, { label: event.title }]} />
      <section className="section">
        <div className="container detail">
          <div className="detail__main">
            <img className="detail__img" src={img(event.image)} alt="" width={900} height={500} />
            <div className="prose">
              <h2>About the event</h2>
              <p>{lorem.p1}</p>
              <p>{lorem.p2}</p>
              <h2>Agenda</h2>
              <ul>
                <li>09:00 — Lorem ipsum dolor sit amet</li>
                <li>10:30 — Consectetur adipiscing elit</li>
                <li>12:00 — Sed do eiusmod tempor incididunt</li>
                <li>14:00 — Ut labore et dolore magna aliqua</li>
              </ul>
            </div>
          </div>
          <aside className="detail__side">
            <div className="sidecard">
              <h2>Details</h2>
              <ul className="sidecard__list">
                <li>
                  <Icon name="calendar" /> {when}
                </li>
                <li>
                  <Icon name="clock" /> {event.time}
                </li>
                <li>
                  <Icon name="pin" /> {event.place}
                </li>
                <li>
                  <Icon name="users" /> {event.format}
                </li>
              </ul>
              {past ? (
                <p className="note">This event has already taken place.</p>
              ) : (
                event.registerUrl && (
                  <a className="btn btn--primary btn--block" href={event.registerUrl}>
                    Register for the event
                  </a>
                )
              )}
            </div>
            <Link className="btn btn--outline btn--sm" to="/events">
              All events
            </Link>
          </aside>
        </div>
      </section>
    </>
  )
}
