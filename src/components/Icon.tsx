const paths: Record<string, React.ReactNode> = {
  arrow: <path d="M5 12h14m-6-6 6 6-6 6" />,
  external: <path d="M14 5h5v5m0-5-8 8M10 6H6a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4" />,
  download: <path d="M12 4v11m0 0-4-4m4 4 4-4M5 19h14" />,
  calendar: <path d="M7 3v3m10-3v3M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />,
  pin: <path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.500C5 14.900 12 21 12 21Zm0-9a2.500 2.500 0 1 0 0-5 2.500 2.500 0 0 0 0 5Z" />,
  clock: <path d="M12 7v5l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />,
  menu: <path d="M4 7h16M4 12h16M4 17h16" />,
  close: <path d="m6 6 12 12M18 6 6 18" />,
  chevron: <path d="m6 9 6 6 6-6" />,
  play: <path d="M9 7.500v9l7-4.500-7-4.500Z" />,
  file: <path d="M14 3H7a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7l-4-4Zm0 0v4h4M9 13h6M9 17h6" />,
  mail: <path d="M4 6h16a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1Zm0 1 8 6 8-6" />,
  phone: <path d="M6 3h3l2 5-2.500 1.500a11 11 0 0 0 6 6L16 13l5 2v3a2 2 0 0 1-2 2A16 16 0 0 1 4 5a2 2 0 0 1 2-2Z" />,
  spark: <path d="M12 3v4m0 10v4M3 12h4m10 0h4M6 6l2.500 2.500m7 7L18 18M18 6l-2.500 2.500m-7 7L6 18" />,
  network: <path d="M12 8a2.500 2.500 0 1 0 0-5 2.500 2.500 0 0 0 0 5Zm-7 13a2.500 2.500 0 1 0 0-5 2.500 2.500 0 0 0 0 5Zm14 0a2.500 2.500 0 1 0 0-5 2.500 2.500 0 0 0 0 5ZM12 8v4m0 0-5.500 4.500M12 12l5.500 4.500" />,
  growth: <path d="M4 19h16M6 15l4-4 3 3 6-7m0 0h-4m4 0v4" />,
  shield: <path d="M12 3 5 6v5.500c0 4.300 2.900 7.700 7 9.500 4.100-1.800 7-5.200 7-9.500V6l-7-3Zm-3 9 2.200 2.200L15 10.500" />,
  check: <path d="m5 12.500 4.500 4.500L19 7.500" />,
  globe: <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm-9-9h18M12 3c2.500 2.700 3.500 5.700 3.500 9s-1 6.300-3.500 9c-2.500-2.700-3.500-5.700-3.500-9s1-6.300 3.500-9Z" />,
  users: <path d="M9 11a3.500 3.500 0 1 0 0-7 3.500 3.500 0 0 0 0 7Zm-6 9c0-3.300 2.700-6 6-6s6 2.700 6 6m1-9.500a3 3 0 1 0-1-5.800M17 14c2.400.500 4 2.800 4 6" />,
}

export function Icon({ name, size = 20 }: { name: string; size?: number }) {
  return (
    <svg className="icon" width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.7" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
      {paths[name]}
    </svg>
  )
}
