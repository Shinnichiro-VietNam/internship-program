import type { ComponentType } from 'react';
import { Link } from 'react-router-dom';
import footerLogo from '../assets/icons/logo.svg';
import paymentMarks from '../assets/images/footer_img.png';
import { FooterFacebookIcon } from './icons/FooterFacebookIcon';
import { InstagramIcon } from './icons/InstagramIcon';
import { PinterestIcon } from './icons/PinterestIcon';
import { TwitterIcon } from './icons/TwitterIcon';

const socials: { label: string; icon: ComponentType }[] = [
  { label: 'Facebook', icon: FooterFacebookIcon },
  { label: 'Twitter', icon: TwitterIcon },
  { label: 'Instagram', icon: InstagramIcon },
  { label: 'Pinterest', icon: PinterestIcon },
];

const columns = [
  {
    title: 'Explore',
    items: ['About us', 'Sitemap', 'Bookmarks', 'Sign in/Join'],
  },
  {
    title: 'Our Service',
    items: [
      'Help Center',
      'Returns',
      'Product Recalls',
      'Accessibility',
      'Contact Us',
      'Store Pickup',
    ],
  },
  {
    title: 'Categories',
    items: ['Action', 'Comedy', 'Drama', 'Horror', 'Kids'],
  },
];

function stop(event: { preventDefault: () => void }) {
  event.preventDefault();
}

export function Footer() {
  return (
    <footer className="bg-dark text-white">
      <div className="px-[30px] pt-20 pb-[70px] max-[767px]:px-[15px] max-[767px]:pt-[60px] max-[767px]:pb-[50px]">
        <div className="footer-columns mx-auto max-w-[1290px]">
          <div className="footer-brand">
            <Link to="/" className="mb-[35px] inline-flex">
              <img
                src={footerLogo}
                alt="Bookory"
                className="h-auto w-[150px]"
              />
            </Link>
            <p className="mb-5 text-lighter">
              1418 River Drive, Suite 35
              <br />
              Cottonhall, CA 9622
            </p>
            <a href="#map" className="footer-map" onClick={stop}>
              show on map
            </a>
            <div className="footer-social flex items-center gap-[9px]">
              {socials.map(({ label, icon: Icon }) => (
                <a
                  key={label}
                  href="#social"
                  aria-label={label}
                  className="text-lighter hover:text-accent"
                  onClick={stop}
                >
                  <Icon />
                </a>
              ))}
            </div>
          </div>

          <div className="footer-help">
            <h2 className="footer-heading mb-5">Need Help</h2>
            <p className="footer-phone mb-[35px]">+(84) - 1800 - 4635</p>
            <p className="text-lighter">
              Monday – Friday: 9:00-20:00
              <br />
              Saturday: 11:00 – 15:00
            </p>
            <p className="footer-mail">contact@example.com</p>
          </div>

          {columns.map(({ title, items }) => (
            <div key={title} className="footer-col">
              <h2 className="footer-heading">{title}</h2>
              <ul className="footer-links">
                {items.map((item) => (
                  <li key={item}>
                    {item === 'Sign in/Join' ? (
                      <Link to="/login">{item}</Link>
                    ) : (
                      <a href="#footer" onClick={stop}>
                        {item}
                      </a>
                    )}
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>

      <div className="border-t border-border px-[30px] py-[45px] max-[767px]:px-[15px] max-[767px]:py-[25px]">
        <div className="mx-auto flex max-w-[1290px] items-center justify-between gap-4 max-[767px]:flex-col max-[767px]:items-start">
          <p>
            © 2026{' '}
            <a
              href="#bookory"
              className="text-accent hover:text-primary-hover"
              onClick={stop}
            >
              Bookory
            </a>
            . Designed by{' '}
            <a
              href="#pavothemes"
              className="text-accent hover:text-primary-hover"
              onClick={stop}
            >
              Pavothemes
            </a>
          </p>
          <img src={paymentMarks} alt="" className="h-[26px] w-auto" />
        </div>
      </div>
    </footer>
  );
}
