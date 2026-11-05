const fieldLabel: Record<string, string> = {
  name: 'Full name',
  email: 'Email address',
  password: 'Password',
  password_confirmation: 'Confirm password',
};

function noticeText(field: string, message: string): string {
  if (field === 'email' && message === 'Invalid email') {
    return 'Please provide a valid email address.';
  }
  if (message === 'Required') {
    return `${fieldLabel[field] ?? field} is required.`;
  }
  if (message === 'At least 8 characters') {
    return 'Please enter at least 8 characters.';
  }
  if (message === 'Passwords must match') {
    return 'Passwords do not match.';
  }
  return message;
}

export function formErrorMessages(
  errors: Record<string, string | undefined>,
  submitCount: number,
  formError: string | null,
): string[] {
  const messages: string[] = [];
  if (submitCount > 0) {
    for (const [field, message] of Object.entries(errors)) {
      if (message) messages.push(noticeText(field, message));
    }
  }
  if (formError) messages.push(formError);
  return messages;
}

export function FormError({ messages }: { messages: string[] }) {
  if (messages.length === 0) return null;

  return (
    <ul className="form-error" role="alert">
      {messages.map((message) => (
        <li key={message}>
          <strong>Error:</strong> {message}
        </li>
      ))}
    </ul>
  );
}
