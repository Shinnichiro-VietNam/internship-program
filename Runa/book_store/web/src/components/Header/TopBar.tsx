import { FacebookIcon } from '../icons/FacebookIcon';
import { InstagramIcon } from '../icons/InstagramIcon';
import { PhoneIcon } from '../icons/PhoneIcon';
import { PinterestIcon } from '../icons/PinterestIcon';
import { TwitterIcon } from '../icons/TwitterIcon';

const socials = [
  { label: 'Facebook', icon: FacebookIcon },
  { label: 'Twitter', icon: TwitterIcon },
  { label: 'Instagram', icon: InstagramIcon },
  { label: 'Pinterest', icon: PinterestIcon },
  // Add link -> if needed
];

export function TopBar() {
  return (
    <div className="bg-dark text-white">
      <div className="px-[30px]">
        <div className="mx-auto flex h-11 max-w-[1290px] items-center justify-between">
          <div className="flex min-w-0 items-center">
            <a
              href="#store"
              className="mr-[33px] shrink-0 text-[12px] font-semibold underline hover:text-accent"
              onClick={(event) => event.preventDefault()} //No link to store -> event stop
            >
              Find a Book Store
            </a>
            <a
              href="#phone"
              className="inline-flex shrink-0 items-center gap-1.5 text-[12px] font-semibold text-white hover:text-accent"
              onClick={(event) => event.preventDefault()} //No Link to phone -> event stop and no shrink
            >
              <span className="text-accent">
                <PhoneIcon />
              </span>
              +1 840 - 841 25 69
            </a>
          </div>
          <div className="flex shrink-0 items-center gap-[6px]">
            {socials.map(({ label, icon: Icon }) => (
              <a
                key={label}
                href="#social"
                aria-label={label}
                className="text-white hover:text-accent"
                onClick={(event) => event.preventDefault()} // No link to social -> event stop
              >
                <Icon />
              </a>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
