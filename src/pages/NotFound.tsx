import { Link } from 'react-router-dom'

export default function NotFound() {
  return (
    <section className="section notfound">
      <div className="container">
        <h1>Page not found</h1>
        <p>The page may have been moved or the address is wrong.</p>
        <Link className="btn btn--primary" to="/">
          Go to the home page
        </Link>
      </div>
    </section>
  )
}
