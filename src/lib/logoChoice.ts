import { useSyncExternalStore } from 'react'

// Review tool for the client: three logo versions from the brand sheet, switched in the footer.
// The choice lives only in this browser (localStorage), there is no backend behind it.
export const logoVariants = [
  { id: 1, label: 'Wersja 1', ratio: 2.78, height: 54 },
  { id: 2, label: 'Wersja 2', ratio: 8.66, height: 27 },
  { id: 3, label: 'Wersja 3', ratio: 7.13, height: 30 },
] as const

export type LogoId = (typeof logoVariants)[number]['id']

const KEY = 'logo-variant'
const listeners = new Set<() => void>()

function read(): LogoId {
  try {
    const v = Number(localStorage.getItem(KEY))
    return v === 2 || v === 3 ? v : 1
  } catch {
    return 1
  }
}

let current: LogoId = read()

export function setLogo(id: LogoId) {
  current = id
  try {
    localStorage.setItem(KEY, String(id))
  } catch {
    /* storage unavailable: the choice lasts until the page is reloaded */
  }
  listeners.forEach((l) => l())
}

const subscribe = (l: () => void) => {
  listeners.add(l)
  // Keeps other open tabs of the site in step.
  const onStorage = (e: StorageEvent) => {
    if (e.key !== KEY) return
    current = read()
    l()
  }
  window.addEventListener('storage', onStorage)
  return () => {
    listeners.delete(l)
    window.removeEventListener('storage', onStorage)
  }
}

export const useLogo = () => useSyncExternalStore(subscribe, () => current)

export const logoSrc = (id: LogoId, light = false) => `${import.meta.env.BASE_URL}brand/logo-${id}${light ? '-light' : ''}.svg`
