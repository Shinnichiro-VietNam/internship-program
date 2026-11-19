import { Button } from './Button';

type ErrorStateProps = {
  message: string;
  onRetry: () => void;
};

export function ErrorState({ message, onRetry }: ErrorStateProps) {
  return (
    <div className="rounded-2xl bg-neutral-100 px-6 py-10 text-center">
      <p className="text-red-600">{message}</p>
      <Button type="button" className="mt-4" onClick={onRetry}>
        Retry
      </Button>
    </div>
  );
}
