import { useEffect } from 'react'
import { useLocation } from 'react-router-dom'

// Adds `.is-in` to every `[data-reveal]` element once it scrolls into view.
// Plain IntersectionObserver, so the same markup + CSS works unchanged in a WordPress theme.
export function useReveal() {
  const { pathname } = useLocation()
  useEffect(() => {
    document.documentElement.classList.add('reveal-ready')
    const els = Array.from(document.querySelectorAll<HTMLElement>('[data-reveal]:not(.is-in)'))
    if (!('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) {
      els.forEach((el) => el.classList.add('is-in'))
      return
    }
    const io = new IntersectionObserver(
      (entries) => {
        for (const e of entries) {
          if (e.isIntersecting) {
            e.target.classList.add('is-in')
            io.unobserve(e.target)
          }
        }
      },
      { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    )
    els.forEach((el) => io.observe(el))
    return () => io.disconnect()
  })
  useEffect(() => {
    window.scrollTo(0, 0)
  }, [pathname])
}
