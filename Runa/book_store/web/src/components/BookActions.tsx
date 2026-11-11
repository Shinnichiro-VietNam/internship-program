import { CardeyeIcon } from './icons/CardeyeIcon';
import { CartIcon } from './icons/CartIcon';
import { HeartIcon } from './icons/HeartIcon';

const actions = [
  { label: 'Wishlist', icon: HeartIcon },
  { label: 'Quick view', icon: CardeyeIcon },
  { label: 'Add to cart', icon: CartIcon },
];

export function BookActions() {
  return (
    <div className="absolute bottom-[12px] right-3 flex flex-col gap-2 transition-opacity opacity-0 duration-300 ease group-hover:opacity-100 group-focus-within:opacity-100">
      {actions.map(({ label, icon: Icon }) => (
        <button
          key={label}
          type="button"
          className="flex items-center justify-center w-[36px] h-[36px] p-0 border-0 rounded-full bg-white tex-action shadow-[0_4px_16px_rgba(0,0,0,0.12)] hover:text-white hover:bg-accent "
          aria-label={label}
          onClick={(event) => event.preventDefault()}
        >
          <Icon />
        </button>
      ))}
    </div>
  );
}
