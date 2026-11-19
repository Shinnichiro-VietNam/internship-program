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
