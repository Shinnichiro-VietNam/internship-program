import { useState } from 'react';
import { CardeyeIcon } from '../icons/CardeyeIcon';
import { CartIcon } from '../icons/CartIcon';
import { HeartIcon } from '../icons/HeartIcon';

const actions = [
  { label: 'Wishlist', icon: HeartIcon },
  { label: 'Quick view', icon: CardeyeIcon },
  { label: 'Add to cart', icon: CartIcon },
];

export function BookActions() {
  const [wishlistLoading, setWishlistLoading] = useState(false);
  return (
    <div className="absolute bottom-3 right-3 flex flex-col gap-2 transition-opacity opacity-0 duration-300 ease group-hover:opacity-100 group-focus-within:opacity-100">
      {actions.map(({ label, icon: Icon }) => (
        <button
          key={label}
          type="button"
          className="flex items-center justify-center w-9 h-9 p-0 border-0 rounded-full bg-white tex-action shadow-[0_4px_16px_rgba(0,0,0,0.12)] hover:text-white hover:bg-accent "
          aria-label={label}
          onClick={(event) => {
            event.preventDefault();
            event.stopPropagation();
            if (label !== 'Wishlist' || wishlistLoading) return;
            setWishlistLoading(true);
            window.setTimeout(() => {
              setWishlistLoading(false);
            }, 1000);
          }}
        >
          <span className="relative inline-flex items-center justify-center">
            <Icon />
            {label === 'Wishlist' && wishlistLoading ? (
              <span className="loader" aria-hidden="true" />
            ) : null}
          </span>
        </button>
      ))}
    </div>
  );
}
