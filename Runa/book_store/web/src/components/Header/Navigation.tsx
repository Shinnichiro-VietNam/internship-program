import { NavLink } from 'react-router-dom';
import { ChevronIcon } from '../icons/ChevronIcon';

const pageItems = [
  'All Authors',
  'Author Profile',
  'About Us',
  'FAQs',
  '404 page',
];

type MenuId = 'home' | 'shop' | 'vendor' | 'pages' | 'blog' | 'contact';

const menuClass: Record<MenuId, string> = {
  home: 'header-menu-parent',
  shop: 'header-menu-parent',
  vendor: 'header-menu-parent',
  pages: 'header-menu-parent header-menu-pages',
  blog: 'header-menu-parent',
  contact: 'header-menu-parent',
};

type MenuItem = {
  id: MenuId;
  label: string;
  to?: string;
  caret: boolean;
};

const menu: MenuItem[] = [
  { id: 'home', label: 'Home', to: '/', caret: false },
  { id: 'shop', label: 'Shop', caret: false },
  { id: 'vendor', label: 'Vendor', caret: false },
  { id: 'pages', label: 'Pages', caret: true },
  { id: 'blog', label: 'Blog', caret: false },
  { id: 'contact', label: 'Contact', caret: false },
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
    <li className={menuClass[item.id]}>
      <MenuLink item={item} />
      {item.id === 'pages' ? (
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
            <NavItem key={item.id} item={item} />
          ))}
        </ul>
      </div>
    </nav>
  );
}
