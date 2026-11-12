import { NavLink } from 'react-router-dom';
import { ChevronIcon } from '../icons/ChevronIcon';

const pageItems = [
  'All Authors',
  'Author Profile',
  'About Us',
  'FAQs',
  '404 page',
];

const menuClass: Record<string, string> = {
  Home: 'header-menu-parent',
  Shop: 'header-menu-parent',
  Vendor: 'header-menu-parent',
  Pages: 'header-menu-parent header-menu-pages',
  Blog: 'header-menu-parent',
  Contact: 'header-menu-parent',
};

type MenuItem = {
  label: string;
  to?: string;
  caret: boolean;
};

const menu: MenuItem[] = [
  { label: 'Home', to: '/', caret: false },
  { label: 'Shop', caret: false },
  { label: 'Vendor', caret: false },
  { label: 'Pages', caret: true },
  { label: 'Blog', caret: false },
  { label: 'Contact', caret: false },
];

function MenuLink({ item }: { item: MenuItem }) {
  const caret = item.caret ? <ChevronIcon /> : null;

  if (item.to) {
    return (
      <NavLink
        to={item.to}
        end
        className={({ isActive }) =>
          isActive ? 'text-accent' : 'text-ink hover:text-accent'
        }
      >
        <span>{item.label}</span>
        {caret}
      </NavLink>
    );
  }

  return (
    <a
      href="#menu"
      className="text-ink hover:text-accent"
      onClick={(event) => event.preventDefault()}
    >
      <span>{item.label}</span>
      {caret}
    </a>
  );
}

function NavItem({ item }: { item: MenuItem }) {
  return (
    <li className={menuClass[item.label]}>
      <MenuLink item={item} />
      {item.label === 'Pages' ? (
        <ul className="header-pages-menu">
          {pageItems.map((label) => (
            <li key={label}>
              <a href="#pages" onClick={(event) => event.preventDefault()}>
                <span>{label}</span>
              </a>
            </li>
          ))}
        </ul>
      ) : null}
    </li>
  );
}

export function Navigation() {
  return (
    <nav className="border-b border-border bg-background" aria-label="Main">
      <div className="px-[30px]">
        <ul className="header-menu mx-auto flex max-w-[1480px] items-center justify-center">
          {menu.map((item) => (
            <NavItem key={item.label} item={item} />
          ))}
        </ul>
      </div>
    </nav>
  );
}
