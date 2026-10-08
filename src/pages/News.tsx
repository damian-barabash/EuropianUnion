import { useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { PageHero, SectionHead } from '../components/Blocks'
import { PostCard } from '../components/Cards'
import { posts } from '../data/content'
import { lorem } from '../data/site'
import { formatDate, img } from '../lib/format'
import NotFound from './NotFound'

// The archive has no cut-off: "Load more" keeps adding older posts until the first one.
const PAGE = 9

export function NewsPage() {
  const [shown, setShown] = useState(PAGE)
  const list = [...posts].sort((a, b) => b.date.localeCompare(a.date))
  return (
    <>
      <PageHero title="News" lead="Updates from the project and its partners." crumbs={[{ label: 'News' }]} />
      <section className="section">
        <div className="container">
          <div className="grid grid--3">
            {list.slice(0, shown).map((p) => (
              <PostCard key={p.slug} post={p} />
            ))}
          </div>
          {list.length > shown && (
            <div className="more">
              <button className="btn btn--outline" onClick={() => setShown(shown + PAGE)}>
                Load older news
              </button>
            </div>
          )}
        </div>
      </section>
    </>
  )
}

export function PostPage() {
  const { slug } = useParams()
  const post = posts.find((p) => p.slug === slug)
  if (!post) return <NotFound />
  const related = posts.filter((p) => p.slug !== slug).slice(0, 3)
  return (
    <>
      <PageHero title={post.title} crumbs={[{ label: 'News', to: '/news' }, { label: post.title }]}>
        <p className="chips">
          <time className="chip-date" dateTime={post.date}>
            {formatDate(post.date)}
          </time>
          <span className="chip-cat">{post.category}</span>
        </p>
      </PageHero>
      <article className="section">
        <div className="container article">
          <img className="article__img" src={img(post.image)} alt="" width={1100} height={600} />
          <div className="prose">
            <p className="prose__lead">{post.excerpt}</p>
            <p>{lorem.p1}</p>
            <h2>Lorem ipsum dolor sit amet</h2>
            <p>{lorem.p2}</p>
            <blockquote>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</blockquote>
            <p>{lorem.p3}</p>
            <ul>
              <li>Nemo enim ipsam voluptatem quia voluptas sit aspernatur.</li>
              <li>Neque porro quisquam est, qui dolorem ipsum quia dolor.</li>
              <li>Quis autem vel eum iure reprehenderit qui in ea voluptate.</li>
            </ul>
            <p>{lorem.p1}</p>
          </div>
          <Link className="btn btn--outline btn--sm" to="/news">
            Back to all news
          </Link>
        </div>
      </article>
      <section className="section section--grey">
        <div className="container">
          <SectionHead title="More news" />
          <div className="grid grid--3">
            {related.map((p) => (
              <PostCard key={p.slug} post={p} />
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
