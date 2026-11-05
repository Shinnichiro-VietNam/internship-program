import { NavLink } from 'react-router-dom';
import { ChevronIcon } from '../icons/ChevronIcon';

const homeVersions = Array.from({ length: 8 }, (_, index) => {
  const number = String(index + 1).padStart(2, '0');
  return { number, label: `Home v${index + 1}` };
});

const shopColumns = [
  {
    title: 'shop list',
    items: [
      'Shop - 4 Columns',
      'Shop - 5 Columns',
      'Shop - Sidebar',
      'Shop - Listview',
      'Shop - Categories Style 01',
      'Shop - Categories Style 02',
    ],
  },
  {
    title: 'Product',
    items: [
      'Boxed Style',
      'Full Style',
      'Product Sidebar',
      'Bought Together',
      'Product Countdown',
      'Grouped Product',
    ],
  },
];

const vendorItems = ['Dokan – Storelist', 'Dokan – Vendor Store'];

const pageItems = ['All Authors', 'Author Profile', 'About Us', 'FAQs', '404 page'];

const blogItems = ['Blog Standard', 'Blog Grid', 'Single Blog'];

const menuClass: Record<string, string> = {
  Home: 'header-menu-parent header-menu-home',
  Shop: 'header-menu-parent header-menu-shop',
  Vendor: 'header-menu-parent header-menu-vendor',
  Pages: 'header-menu-parent header-menu-pages',
  Blog: 'header-menu-parent header-menu-blog',
  Contact: 'header-menu-parent header-menu-contact',
};

const menu: { label: string; to?: string; caret: boolean }[] = [
  { label: 'Home', to: '/', caret: true },
  { label: 'Shop', caret: true },
  { label: 'Vendor', caret: true },
  { label: 'Pages', caret: true },
  { label: 'Blog', caret: true },
  { label: 'Contact', caret: false },
];

export function Navigation() {
  return (
    <nav className="border-b border-border bg-background" aria-label="Main">
      <div className="px-[30px]">
        <ul className="header-menu mx-auto flex max-w-[1290px] items-center justify-center">
          {menu.map((item) => (
            <li
              key={item.label}
              className={menuClass[item.label]}
            >
              {item.to ? (
                <NavLink
                  to={item.to}
                  end
                  className={({ isActive }) =>
                    isActive ? 'text-accent' : 'text-ink hover:text-accent'
                  }
                >
                  <span>{item.label}</span>
                  {item.caret ? <ChevronIcon /> : null}
                </NavLink>
              ) : (
                <a
                  href="#menu"
                  className="text-ink hover:text-accent"
                  onClick={(event) => event.preventDefault()}
                >
                  <span>{item.label}</span>
                  {item.caret ? <ChevronIcon /> : null}
                </a>
              )}
              {item.label === 'Home' ? (
                <ul className="header-home-menu">
                  {homeVersions.map((version) => (
                    <li key={version.number}>
                      <a href="#home" onClick={(event) => event.preventDefault()}>
                        <span>
                          <span>{version.number}</span>
                          {` – ${version.label}`}
                        </span>
                      </a>
                    </li>
                  ))}
                </ul>
              ) : null}
              {item.label === 'Vendor' ? (
                <ul className="header-vendor-menu">
                  {vendorItems.map((label) => (
                    <li key={label}>
                      <a href="#vendor" onClick={(event) => event.preventDefault()}>
                        <span>{label}</span>
                      </a>
                    </li>
                  ))}
                </ul>
              ) : null}
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
              {item.label === 'Blog' ? (
                <ul className="header-blog-menu">
                  {blogItems.map((label) => (
                    <li key={label}>
                      <a href="#blog" onClick={(event) => event.preventDefault()}>
                        <span>{label}</span>
                      </a>
                    </li>
                  ))}
                </ul>
              ) : null}
              {item.label === 'Shop' ? (
                <div className="header-shop-menu">
                  <div className="header-shop-panel">
                    {shopColumns.map((column, index) => (
                      <div
                        key={column.title}
                        className={
                          index === 0 ? 'header-shop-col header-shop-list' : 'header-shop-col'
                        }
                      >
                        <p className="header-shop-label">{column.title}</p>
                        <ul>
                          {column.items.map((label) => (
                            <li key={label}>
                              <a href="#shop" onClick={(event) => event.preventDefault()}>
                                {label}
                              </a>
                            </li>
                          ))}
                        </ul>
                      </div>
                    ))}
                    <div className="header-shop-banner">
                      <p className="header-shop-offer">Best Offer</p>
                      <p className="header-shop-save">save $15</p>
                      <p className="header-shop-note">on selected items</p>
                      <a
                        href="#shop"
                        className="header-shop-more"
                        onClick={(event) => event.preventDefault()}
                      >
                        See More
                        <ChevronIcon />
                      </a>
                      <span className="header-shop-book" aria-hidden="true" />
                    </div>
                  </div>
                </div>
              ) : null}
            </li>
          ))}
        </ul>
      </div>
    </nav>
  );
}
