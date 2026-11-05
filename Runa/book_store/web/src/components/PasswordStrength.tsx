type Level = 'short' | 'bad' | 'good' | 'strong';

const label: Record<Level, string> = {
  short: 'Very weak',
  bad: 'Weak',
  good: 'Medium',
  strong: 'Strong',
};

const strengthHint =
  'Hint: The password should be at least twelve characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).';

function levelOf(password: string): Level | null {
  if (password.length === 0) return null;
  if (password.length < 8) return 'short';

  let kinds = 0;
  if (/[a-z]/.test(password)) kinds += 1;
  if (/[A-Z]/.test(password)) kinds += 1;
  if (/\d/.test(password)) kinds += 1;
  if (/[^A-Za-z0-9]/.test(password)) kinds += 1;

  if (password.length >= 12 && kinds >= 3) return 'strong';
  if (kinds >= 2) return 'good';
  return 'bad';
}

function StrengthFace({ level }: { level: Level }) {
  const mouth =
    level === 'bad' || level === 'short'
      ? 'M6 12c1.2-1.4 2.6-1.4 4 0'
      : level === 'strong'
        ? 'M5 10.5c1.2 2.2 4.8 2.2 6 0'
        : 'M5.5 11.2h5';

  return (
    <svg
      className="password-strength-face"
      viewBox="0 0 16 16"
      aria-hidden="true"
    >
      <circle
        cx="8"
        cy="8"
        r="6.2"
        fill="none"
        stroke="currentColor"
        strokeWidth="1.2"
      />
      <circle cx="6" cy="6.5" r="0.7" fill="currentColor" />
      <circle cx="10" cy="6.5" r="0.7" fill="currentColor" />
      <path
        d={mouth}
        fill="none"
        stroke="currentColor"
        strokeWidth="1.2"
        strokeLinecap="round"
      />
    </svg>
  );
}

export function PasswordStrength({ password }: { password: string }) {
  const level = levelOf(password);
  if (!level) return null;

  if (level === 'short') {
    return (
      <div className="password-strength-block">
        <p className="password-strength short" aria-live="polite">
          Very weak - Please enter a stronger password.
          <StrengthFace level="short" />
        </p>
        <p className="password-strength-hint">{strengthHint}</p>
      </div>
    );
  }

  return (
    <p className={`password-strength ${level}`} aria-live="polite">
      {label[level]}
      <StrengthFace level={level} />
    </p>
  );
}
