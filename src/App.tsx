import { BrowserRouter, Route, Routes } from 'react-router-dom'
import { Layout } from './components/Layout'
import About from './pages/About'
import { CallPage, CallsPage } from './pages/Calls'
import Contact from './pages/Contact'
import { EventPage, EventsPage } from './pages/Events'
import Home from './pages/Home'
import Legal from './pages/Legal'
import { NewsPage, PostPage } from './pages/News'
import NotFound from './pages/NotFound'
import { PartnerPage, PartnersPage } from './pages/Partners'
import Platform from './pages/Platform'
import Resources from './pages/Resources'

export default function App() {
  return (
    <BrowserRouter basename={import.meta.env.BASE_URL.replace(/\/$/, '')}>
      <Routes>
        <Route element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="about" element={<About />} />
          <Route path="open-calls" element={<CallsPage />} />
          <Route path="open-calls/:slug" element={<CallPage />} />
          <Route path="partners" element={<PartnersPage />} />
          <Route path="partners/:slug" element={<PartnerPage />} />
          <Route path="news" element={<NewsPage />} />
          <Route path="news/:slug" element={<PostPage />} />
          <Route path="events" element={<EventsPage />} />
          <Route path="events/:slug" element={<EventPage />} />
          <Route path="resources" element={<Resources />} />
          <Route path="digital-platform" element={<Platform />} />
          <Route path="contact" element={<Contact />} />
          <Route path="privacy-policy" element={<Legal title="Privacy policy" />} />
          <Route path="cookie-policy" element={<Legal title="Cookie policy" />} />
          <Route path="accessibility" element={<Legal title="Accessibility statement" />} />
          <Route path="*" element={<NotFound />} />
        </Route>
      </Routes>
    </BrowserRouter>
  )
}
