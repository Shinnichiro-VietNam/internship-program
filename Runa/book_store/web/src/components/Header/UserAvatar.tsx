const looks = [
  { bg: '#F6D5C3', skin: '#F3C1A5', hair: '#2C211C', shirt: '#E25B4C', blush: '#E89A88' },
  { bg: '#D7E6F5', skin: '#E8B896', hair: '#4A3428', shirt: '#3D6B8A', blush: '#D98978' },
  { bg: '#F8E7C9', skin: '#F6D0B5', hair: '#1F1A17', shirt: '#C45C4A', blush: '#EFB0A0' },
  { bg: '#E7D8F3', skin: '#D9A57E', hair: '#3B2418', shirt: '#6B4C7A', blush: '#C98974' },
  { bg: '#D9EFE4', skin: '#F2C4A6', hair: '#5C3A28', shirt: '#2F6F56', blush: '#E7A494' },
];

function hashName(name: string): number {
  let hash = 0;
  for (const char of name) {
    hash = (hash * 31 + char.charCodeAt(0)) >>> 0;
  }
  return hash;
}

function Hair({ style, color }: { style: number; color: string }) {
  return (
    <>
      <ellipse cx="32" cy="20" rx="15" ry="13" fill={color} />
      {style === 1 ? (
        <>
          <rect x="17" y="22" width="8" height="20" rx="4" fill={color} />
          <rect x="39" y="22" width="8" height="20" rx="4" fill={color} />
        </>
      ) : null}
      {style === 2 ? <ellipse cx="21" cy="22" rx="8" ry="11" fill={color} /> : null}
    </>
  );
}

export function UserAvatar({ name }: { name: string }) {
  const hash = hashName(name);
  const look = looks[hash % looks.length];
  const hairStyle = hash % 3;

  return (
    <span className="inline-flex h-8 w-8 shrink-0 overflow-hidden rounded-full" aria-hidden="true">
      <svg viewBox="0 0 64 64" width="32" height="32">
        <rect width="64" height="64" fill={look.bg} />
        <path d="M8 66c2-16 12-22 24-22s22 6 24 22Z" fill={look.shirt} />
        <rect x="27" y="40" width="10" height="12" rx="4" fill={look.skin} />
        <Hair style={hairStyle} color={look.hair} />
        <circle cx="32" cy="30" r="13" fill={look.skin} />
        <ellipse cx="24.5" cy="33" rx="2.4" ry="1.3" fill={look.blush} opacity="0.7" />
        <ellipse cx="39.5" cy="33" rx="2.4" ry="1.3" fill={look.blush} opacity="0.7" />
        <circle cx="27" cy="29.5" r="1.35" fill="#3A2A24" />
        <circle cx="37" cy="29.5" r="1.35" fill="#3A2A24" />
        <path
          d="M28.2 34.2c1.2 1.5 6.4 1.5 7.6 0"
          fill="none"
          stroke="#C47B6A"
          strokeWidth="1.2"
          strokeLinecap="round"
        />
      </svg>
    </span>
  );
}
