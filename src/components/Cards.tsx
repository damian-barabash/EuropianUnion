import { Link } from 'react-router-dom'
import type { CallStatus, EventItem, OpenCall, Partner, Post, Resource } from '../data/content'
import { dateParts, formatDate, img } from '../lib/format'
import { Icon } from './Icon'
import { PartnerLogo } from './PartnerLogo'

export function PostCard({ post }: { post: Post }) {
  return (
    <article className="post" data-reveal>
      <div className="post__media">
        <img src={img(post.image)} alt="" loading="lazy" width={700} height={470} />
        <span className="post__cat">{post.category}</span>
      </div>
      <div className="post__body">
        <time className="post__date" dateTime={post.date}>
          {formatDate(post.date)}
        </time>
        <h3>
          <Link to={`/news/${post.slug}`}>{post.title}</Link>
        </h3>
        <p className="post__excerpt">{post.excerpt}</p>
      </div>
      <div className="post__foot" aria-hidden="true">
        <span>Read more</span>
        <span className="post__arrow">
          <Icon name="arrow" size={18} />
        </span>
      </div>
    </article>
  )
}

export function EventRow({ event }: { event: EventItem }) {
  const d = dateParts(event.date)
  return (
    <article className="event" data-reveal>
      <time className="event__date" dateTime={event.date}>
        <span className="event__day">{d.day}</span>
        <span className="event__month">
          {d.month} {d.year}
        </span>
      </time>
      <div className="event__body">
        <span className="event__format">{event.format}</span>
        <h3>
          <Link to={`/events/${event.slug}`}>{event.title}</Link>
        </h3>
        <ul className="facts-inline">
          <li>{event.time}</li>
          <li>{event.place}</li>
        </ul>
      </div>
      <span className="event__arrow" aria-hidden="true">
        <Icon name="arrow" />
      </span>
    </article>
  )
}

const statusLabel: Record<CallStatus, string> = { open: 'Open', upcoming: 'Opens soon', closed: 'Closed' }

export function StatusBadge({ status }: { status: CallStatus }) {
  return <span className={`status status--${status}`}>{statusLabel[status]}</span>
}

const DAY = 86_400_000
const at = (iso: string) => new Date(iso + 'T23:59:59').getTime()

export function CallRow({ call }: { call: OpenCall }) {
  const isOpen = call.status === 'open'
  const now = Date.now()
  const daysLeft = Math.max(0, Math.ceil((at(call.deadline) - now) / DAY))
  const progress = Math.min(100, Math.max(4, ((now - at(call.opens)) / (at(call.deadline) - at(call.opens))) * 100))

  return (
    <article className={`callp callp--${call.status}`} data-reveal>
      <div className="callp__top">
        <StatusBadge status={call.status} />
        {isOpen && (
          <p className="callp__left">
            <strong>{daysLeft}</strong> days left to apply
          </p>
        )}
      </div>

      <div className="callp__main">
        <h3>
          <Link to={`/open-calls/${call.slug}`}>{call.title}</Link>
        </h3>
        <p>{call.summary}</p>
      </div>

      <dl className="callp__facts">
        <div>
          <dt>{call.status === 'upcoming' ? 'Opens' : 'Deadline'}</dt>
          <dd>{formatDate(call.status === 'upcoming' ? call.opens : call.deadline)}</dd>
        </div>
        <div>
          <dt>Funding</dt>
          <dd>{call.grant}</dd>
        </div>
        {isOpen && (
          <div>
            <dt>Total budget</dt>
            <dd>{call.budget}</dd>
          </div>
        )}
      </dl>

      {isOpen && (
        <div className="callp__bar" role="img" aria-label={`Application window: ${formatDate(call.opens)} to ${formatDate(call.deadline)}`}>
          <span style={{ width: `${progress}%` }} />
        </div>
      )}

      <div className="callp__foot" aria-hidden="true">
        <span>Call details</span>
        <span className="callp__arrow">
          <Icon name="arrow" />
        </span>
      </div>
    </article>
  )
}

export function PartnerCard({ partner }: { partner: Partner }) {
  return (
    <article className="partner" data-reveal>
      <div className="partner__logo">
        <PartnerLogo partner={partner} large />
      </div>
      <div className="partner__body">
        <h3>
          <Link to={`/partners/${partner.slug}`}>{partner.name}</Link>
        </h3>
        <p className="partner__meta">
          {partner.country} · {partner.type}
        </p>
        {partner.role !== 'Partner' && <span className="partner__role">{partner.role}</span>}
      </div>
    </article>
  )
}

export function ResourceRow({ item }: { item: Resource }) {
  const isVideo = item.type === 'Video'
  return (
    <li className="doc">
      <div className="doc__body">
        <a href={item.href}>{item.title}</a>
        <p className="doc__meta">
          <span>{item.type}</span>
          <time dateTime={item.date}>{formatDate(item.date)}</time>
          {item.size && (
            <span>
              {item.format}, {item.size}
            </span>
          )}
        </p>
      </div>
      <a className="btn btn--outline btn--sm doc__action" href={item.href} aria-label={`${isVideo ? 'Watch' : 'Download'}: ${item.title}`}>
        <Icon name={isVideo ? 'play' : 'download'} size={18} />
        {isVideo ? 'Watch' : 'Download'}
      </a>
    </li>
  )
}
